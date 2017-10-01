<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
    /**
     * @Route("/profile/")
     * @Method("GET")
     */
    public function indexAction()
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException();
        }

        return View::create([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
        ]);
    }
}
