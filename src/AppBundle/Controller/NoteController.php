<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Service\MarkdownService;

class NoteController extends Controller
{
    /**
     * @Route("/notes", name="note_index")
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
     * @Route("/notes/{id}", name="note_view", requirements={"id": "\d+"})
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
}
