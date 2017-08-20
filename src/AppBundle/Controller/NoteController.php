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
        $data = [
            [
                'id' => 1,
                'title' => 'First',
                'source' => "# First\nSome text",
                'html' => $markdownService->convert("# First\nSome text"),
            ],
            [
                'id' => 2,
                'title' => 'Second',
                'source' => "# Second\nAnother text",
                'html' => $markdownService->convert("# Second\nAnother text"),
            ],
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/{id}", name="note_view", requirements={"id": "\d+"})
     * @Method({"GET"})
     */
    public function viewAction(Request $request, MarkdownService $markdownService, int $id)
    {
        $data = [
            'id' => $id,
            'title' => 'First',
            'source' => "# First\n\nSome text",
            'html' => $markdownService->convert("# First\n\nSome text"),
        ];

        return new JsonResponse($data);
    }

    /**
     * @Route("/", name="note_create")
     * @Method({"POST"})
     */
    public function createAction(Request $request, MarkdownService $markdownService)
    {
        $source = $request->request->get('source');

        $note = new Note();
        $note->setSource($source);
        $note->setHtml($markdownService->convert($source));
        $note->setCreatedAt(new \DateTime());
        $note->setUpdatedAt(new \DateTime());

        $em = $this->getDoctrine()->getManagerForClass(Note::class);
        $em->persist($note);
        $em->flush();

        return new JsonResponse(['result' => 'success']);
    }
}
