<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        /** @var User $user */
        $user = $this->getUser();
        $username = $user->getUsername();

        return $this->render('default/index.html.twig', [
            'data' => [
                'username' => $username,
            ],
        ]);
    }
}
