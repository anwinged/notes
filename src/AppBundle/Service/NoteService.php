<?php

declare(strict_types=1);

namespace AppBundle\Service;

use AppBundle\Entity\Note;
use AppBundle\Repository\NoteRepository;

class NoteService
{
    private $noteRepository;

    private $markdownService;

    private $searchService;

    public function __construct(
        NoteRepository $noteRepository,
        MarkdownService $markdownService,
        SearchService $searchService
    ) {
        $this->noteRepository = $noteRepository;
        $this->markdownService = $markdownService;
        $this->searchService = $searchService;
    }

    /**
     * @return Note[]
     */
    public function getActiveNotes(): array
    {
        return $this->noteRepository->getActiveNotes();
    }

    /**
     * @param Note $blank
     *
     * @return Note
     */
    public function create(Note $blank): Note
    {
        $this->parseMarkdown($blank);

        $blank->setCreatedAt(new \DateTime());
        $blank->setUpdatedAt(new \DateTime());

        $this->noteRepository->persist($blank);
        $this->searchService->index($blank);

        return $blank;
    }

    /**
     * @param Note $note
     *
     * @return Note
     */
    public function update(Note $note): Note
    {
        $this->parseMarkdown($note);

        $note->setUpdatedAt(new \DateTime());

        $this->noteRepository->persist($note);
        $this->searchService->index($note);

        return $note;
    }

    /**
     * @param Note $note
     *
     * @return Note
     */
    public function archive(Note $note): Note
    {
        $note->setArchived(true);
        $note->setUpdatedAt(new \DateTime());

        $this->noteRepository->persist($note);
        $this->searchService->remove($note);

        return $note;
    }

    /**
     * @param Note $note
     *
     * @return Note
     */
    public function restore(Note $note): Note
    {
        $note->setArchived(false);
        $note->setUpdatedAt(new \DateTime());

        $this->noteRepository->persist($note);
        $this->searchService->index($note);

        return $note;
    }

    /**
     * @param string $text
     * @param int    $limit
     *
     * @return Note[]
     */
    public function search(string $text, int $limit): array
    {
        $ids = $this->searchService->search($text, $limit);
        $notes = $this->noteRepository->findBy(['id' => $ids]);

        $sortIds = array_flip($ids);
        usort($notes, function (Note $a, Note $b) use ($sortIds) {
            return $sortIds[$a->getId()] <=> $sortIds[$b->getId()];
        });

        return $notes;
    }

    public function reparseAllNotes()
    {
        $notes = $this->noteRepository->findAll();
        foreach ($notes as $note) {
            $this->parseMarkdown($note);
            $this->noteRepository->persist($note);
            $this->searchService->index($note);
        }
    }

    private function parseMarkdown(Note $note)
    {
        $result = $this->markdownService->convert($note->getSource());

        $note->setTitle($result->getTitle());
        $note->setShort($result->getShort());
        $note->setHtml($result->getFull());
    }
}
