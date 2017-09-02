<?php

declare(strict_types=1);

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserService
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if (!($user instanceof User)) {
            throw new \RuntimeException(sprintf(
                'User must be User class object, "%s" given',
                get_class($user)
            ));
        }

        return $user;
    }
}
