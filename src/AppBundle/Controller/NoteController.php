<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Service\MarkdownService;
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
    public function indexAction(Request $request, MarkdownService $markdownService)
    {
        $rep = $this->getDoctrine()->getRepository('AppBundle:Note');
        $notes = $rep->findAll();

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get('serializer');

        $jsonString = $serializer->serialize($notes, 'json');

        return JsonResponse::fromJsonString($jsonString);
    }

    /**
     * @Route("/{id}", name="note_view", requirements={"id": "\d+"})
     * @Method({"GET"})
     */
    public function viewAction(Request $request, int $id)
    {
        $rep = $this->getDoctrine()->getRepository('AppBundle:Note');
        $note = $rep->find($id);

        if ($note === null) {
            throw $this->createNotFoundException();
        }

        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get('serializer');
        $jsonString = $serializer->serialize($note, 'json');

        return JsonResponse::fromJsonString($jsonString);
    }

    /**
     * @Route("/", name="note_create")
     * @Method({"POST"})
     */
    public function createAction(Request $request, MarkdownService $markdownService)
    {
        $source = $request->request->get('source');
        if ($source === null) {
            throw new HttpException(400);
        }

        $note = new Note();
        $note->setSource($source);
        $note->setHtml($markdownService->convert($source));
        $note->setCreatedAt(new \DateTime());
        $note->setUpdatedAt(new \DateTime());

        $em = $this->getDoctrine()->getManagerForClass(Note::class);
        $em->persist($note);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="note_update", requirements={"id": "\d+"})
     * @Method({"PUT"})
     */
    public function updateAction(Request $request, int $id)
    {
        $source = $request->request->get('source');
        if ($source === null) {
            throw new HttpException(400);
        }

        $rep = $this->getDoctrine()->getRepository('AppBundle:Note');
        $note = $rep->find($id);
        if ($note === null) {
            throw $this->createNotFoundException();
        }

        $markdownService = $this->container->get(MarkdownService::class);

        $note->setSource($source);
        $note->setHtml($markdownService->convert($source));
        $note->setUpdatedAt(new \DateTime());

        $em = $this->getDoctrine()->getManagerForClass(Note::class);
        $em->persist($note);
        $em->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
