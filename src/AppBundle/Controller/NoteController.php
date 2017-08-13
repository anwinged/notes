<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class NoteController extends Controller
{
    /**
     * @Route("/notes", name="note_index")
     */
    public function indexAction(Request $request)
    {
        $data = [
            [
                'id' => 1,
                'title' => 'First',
                'html' => '<h1>Hello!</h1>'
            ],
            [
                'id' => 2,
                'title' => 'Second',
                'html' => '<h1>Good bye!</h1>'
            ],
        ];

        return new JsonResponse($data);
    }
}
