<?php

declare(strict_types=1);

namespace AppBundle\Service;

use AppBundle\Entity\Note;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class NoteService
{
    private $markdownService;

    private $userService;

    private $registry;

    public function __construct(
        MarkdownService $markdownService,
        UserService $userService,
        RegistryInterface $registry
    ) {
        $this->markdownService = $markdownService;
        $this->userService = $userService;
        $this->registry = $registry;
    }

    /**
     * @return Note[]
     */
    public function getActiveNotes(): array
    {
        $user = $this->userService->getUser();
        $repository = $this->registry->getRepository('AppBundle:Note');

        return $repository->findBy([
            'user' => $user,
            'archived' => false,
        ]);
    }

    /**
     * @param Note $blank
     *
     * @return Note
     */
    public function create(Note $blank): Note
    {
        $user = $this->userService->getUser();
        $blank->setUser($user);

        $this->parseMarkdown($blank);

        $blank->setCreatedAt(new \DateTime());
        $blank->setUpdatedAt(new \DateTime());

        $em = $this->registry->getManagerForClass(Note::class);
        $em->persist($blank);
        $em->flush();

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

        $em = $this->registry->getManagerForClass(Note::class);
        $em->persist($note);
        $em->flush();

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

        $em = $this->registry->getManagerForClass(Note::class);
        $em->persist($note);
        $em->flush();

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

        $em = $this->registry->getManagerForClass(Note::class);
        $em->persist($note);
        $em->flush();

        return $note;
    }

    public function reparseAllNotes()
    {
        $em = $this->registry->getManagerForClass(Note::class);
        $rep = $this->registry->getRepository('AppBundle:Note');
        $notes = $rep->findAll();
        foreach ($notes as $note) {
            $this->parseMarkdown($note);
            $em->persist($note);
        }

        $em->flush();
    }

    private function parseMarkdown(Note $note)
    {
        $result = $this->markdownService->convert($note->getSource());

        $note->setTitle($result->getTitle());
        $note->setShort($result->getShort());
        $note->setHtml($result->getFull());
    }
}
