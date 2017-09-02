<?php

declare(strict_types=1);

namespace AppBundle\Service;

use AppBundle\Entity\Note;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NoteService
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
    public function allForUser(): array
    {
        $user = $this->userService->getUser();
        $repository = $this->registry->getRepository('AppBundle:Note');

        return $repository->findBy(['user' => $user]);
    }

    /**
     * @param string $markdownSource
     *
     * @return Note
     */
    public function create(string $markdownSource): Note
    {
        $user = $this->userService->getUser();
        $html = $this->markdownService->convert($markdownSource);

        $note = new Note();
        $note->setUser($user);
        $note->setSource($markdownSource);
        $note->setHtml($html);
        $note->setCreatedAt(new \DateTime());
        $note->setUpdatedAt(new \DateTime());

        $em = $this->registry->getManagerForClass(Note::class);
        $em->persist($note);
        $em->flush();

        return $note;
    }

    /**
     * @param Note   $note
     * @param string $source
     *
     * @return Note
     */
    public function update(Note $note, string $source): Note
    {
        $html = $this->markdownService->convert($source);

        $note->setSource($source);
        $note->setHtml($html);
        $note->setUpdatedAt(new \DateTime());

        $em = $this->registry->getManagerForClass(Note::class);
        $em->persist($note);
        $em->flush();

        return $note;
    }
}
