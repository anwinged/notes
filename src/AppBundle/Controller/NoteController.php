<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use AppBundle\Service\NoteService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/notes")
 */
class NoteController extends Controller
{
    /**
     * @Route("/", name="note_index")
     * @Method({"GET"})
     */
    public function indexAction(NoteService $noteService)
    {
        $notes = $noteService->allForUser();

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get('serializer');
        $jsonString = $serializer->serialize($notes, 'json');

        return JsonResponse::fromJsonString($jsonString);
    }

    /**
     * @Route("/{id}", name="note_view", requirements={"id": "\d+"})
     * @Method({"GET"})
     *
     * @ParamConverter("note")
     */
    public function viewAction(Note $note)
    {
        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get('serializer');
        $jsonString = $serializer->serialize($note, 'json');

        return JsonResponse::fromJsonString($jsonString);
    }

    /**
     * @Route("/", name="note_create")
     * @Method({"POST"})
     */
    public function createAction(Request $request, NoteService $noteService)
    {
        $source = $request->request->get('source');
        if ($source === null) {
            throw new HttpException(400);
        }

        $note = $noteService->create($source);

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get('serializer');
        $jsonString = $serializer->serialize($note, 'json');

        return JsonResponse::fromJsonString($jsonString, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="note_update", requirements={"id": "\d+"})
     * @Method({"PUT"})
     *
     * @ParamConverter("note")
     */
    public function updateAction(Request $request, NoteService $noteService, Note $note)
    {
        $source = $request->request->get('source');
        if ($source === null) {
            throw new HttpException(400);
        }

        $updated = $noteService->update($note, $source);

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get('serializer');
        $jsonString = $serializer->serialize($updated, 'json');

        return JsonResponse::fromJsonString($jsonString, Response::HTTP_OK);
    }
}
