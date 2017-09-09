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
        $html = $this->markdownService->convert($blank->getSource());

        $blank->setUser($user);
        $blank->setHtml($html);
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
        $html = $this->markdownService->convert($note->getSource());

        $note->setHtml($html);
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

        $em = $this->registry->getManagerForClass(Note::class);
        $em->persist($note);
        $em->flush();

        return $note;
    }
}
