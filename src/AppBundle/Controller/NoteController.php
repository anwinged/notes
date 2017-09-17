<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use AppBundle\Service\NoteService;
use AppBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/notes")
 */
class NoteController extends Controller
{
    /**
     * @Route("/", name="note_index")
     * @Method("GET")
     */
    public function indexAction(NoteService $noteService)
    {
        return $noteService->getActiveNotes();
    }

    /**
     * @Route("/{id}", name="note_view", requirements={"id": "\d+"})
     * @Method("GET")
     *
     * @ParamConverter("note")
     * @Security("is_granted('ACCESS', note)")
     */
    public function viewAction(Note $note)
    {
        return $note;
    }

    /**
     * @Route("/", name="note_create")
     * @Method("POST")
     */
    public function createAction(Request $request, NoteService $noteService)
    {
        $content = $request->getContent();
        $serializer = $this->get('serializer');

        /** @var Note $blank */
        $blank = $serializer->deserialize($content, Note::class, 'json', [
            'groups' => ['setup'],
        ]);

        $validator = $this->get('validator');
        $violations = $validator->validate($blank);

        if (count($violations) > 0) {
            return View::create($violations, Response::HTTP_BAD_REQUEST);
        }

        $note = $noteService->create($blank);

        return View::create($note, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="note_update", requirements={"id": "\d+"})
     * @Method("PUT")
     *
     * @ParamConverter("note")
     * @Security("is_granted('ACCESS', note)")
     */
    public function updateAction(Request $request, NoteService $noteService, Note $note)
    {
        $content = $request->getContent();
        $serializer = $this->get('serializer');

        /** @var Note $blank */
        $blank = $serializer->deserialize($content, Note::class, 'json', [
            'object_to_populate' => $note,
            'groups' => ['setup'],
        ]);

        $validator = $this->get('validator');
        $violations = $validator->validate($blank);

        if (count($violations) > 0) {
            return View::create($violations, Response::HTTP_BAD_REQUEST);
        }

        return $noteService->update($blank);
    }

    /**
     * @Route("/{id}/archive", name="note_archive", requirements={"id": "\d+"})
     * @Method("POST")
     *
     * @ParamConverter("note")
     * @Security("is_granted('ACCESS', note)")
     */
    public function archiveAction(NoteService $noteService, Note $note)
    {
        $note = $noteService->archive($note);

        return View::create($note, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}/restore", name="note_restore", requirements={"id": "\d+"})
     * @Method("POST")
     *
     * @ParamConverter("note")
     * @Security("is_granted('ACCESS', note)")
     */
    public function restoreAction(NoteService $noteService, Note $note)
    {
        $note = $noteService->restore($note);

        return View::create($note, Response::HTTP_OK);
    }
}
