<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use AppBundle\Service\NoteService;
use AppBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
        return View::create($noteService->getActiveNotes(), [
            'status_code' => Response::HTTP_OK,
            'state' => 'preview',
            'groups' => ['preview'],
        ]);
    }

    /**
     * @Route("/search", name="note_search")
     * @Method("GET")
     *
     * @param Request     $request
     * @param NoteService $noteService
     *
     * @return View
     */
    public function searchAction(Request $request, NoteService $noteService)
    {
        $text = $request->get('q');
        $limit = ((int) $request->get('limit')) ?: 5;

        return View::create($noteService->search($text, $limit), [
            'status_code' => Response::HTTP_OK,
            'state' => 'preview',
            'groups' => ['preview'],
        ]);
    }

    /**
     * @Route("/{id}", name="note_view", requirements={"id": "\d+"})
     * @Method("GET")
     *
     * @ParamConverter("note")
     */
    public function viewAction(Note $note)
    {
        return View::create($note, [
            'status_code' => Response::HTTP_OK,
            'state' => 'full',
            'groups' => ['full'],
        ]);
    }

    /**
     * @Route("/", name="note_create")
     * @Method("POST")
     */
    public function createAction(Request $request, NoteService $noteService)
    {
        $content = $request->getContent();
        $serializer = $this->get('serializer');

        if (!($serializer instanceof Serializer)) {
            throw new \InvalidArgumentException();
        }

        /** @var Note $blank */
        $blank = $serializer->deserialize($content, Note::class, 'json', [
            'groups' => ['setup'],
        ]);

        $validator = $this->get('validator');
        if (!($validator instanceof ValidatorInterface)) {
            throw new \InvalidArgumentException();
        }

        $violations = $validator->validate($blank);
        if (count($violations) > 0) {
            return $this->responseWithViolations($violations);
        }

        $note = $noteService->create($blank);

        return View::create($note, [
            'status_code' => Response::HTTP_CREATED,
            'state' => 'full',
            'groups' => ['full'],
        ]);
    }

    /**
     * @Route("/{id}", name="note_update", requirements={"id": "\d+"})
     * @Method("PUT")
     *
     * @ParamConverter("note")
     */
    public function updateAction(Request $request, NoteService $noteService, Note $note)
    {
        $content = $request->getContent();
        $serializer = $this->get('serializer');

        if (!($serializer instanceof Serializer)) {
            throw new \InvalidArgumentException();
        }

        /** @var Note $blank */
        $blank = $serializer->deserialize($content, Note::class, 'json', [
            'object_to_populate' => $note,
            'groups' => ['setup'],
        ]);

        $validator = $this->get('validator');
        if (!($validator instanceof ValidatorInterface)) {
            throw new \InvalidArgumentException();
        }

        $violations = $validator->validate($blank);
        if (count($violations) > 0) {
            return $this->responseWithViolations($violations);
        }

        return View::create($noteService->update($blank), [
            'status_code' => Response::HTTP_OK,
            'state' => 'full',
            'groups' => ['full'],
        ]);
    }

    /**
     * @Route("/{id}/archive", name="note_archive", requirements={"id": "\d+"})
     * @Method("POST")
     *
     * @ParamConverter("note")
     */
    public function archiveAction(NoteService $noteService, Note $note)
    {
        $note = $noteService->archive($note);

        return View::create($note, [
            'status_code' => Response::HTTP_OK,
            'state' => 'full',
            'groups' => ['full'],
        ]);
    }

    /**
     * @Route("/{id}/restore", name="note_restore", requirements={"id": "\d+"})
     * @Method("POST")
     *
     * @ParamConverter("note")
     */
    public function restoreAction(NoteService $noteService, Note $note)
    {
        $note = $noteService->restore($note);

        return View::create($note, [
            'status_code' => Response::HTTP_OK,
            'state' => 'full',
            'groups' => ['full'],
        ]);
    }

    /**
     * @param ConstraintViolationListInterface $violations
     *
     * @return View
     */
    private function responseWithViolations(ConstraintViolationListInterface $violations): View
    {
        return View::create($violations, [
            'status_code' => Response::HTTP_BAD_REQUEST,
        ]);
    }
}
