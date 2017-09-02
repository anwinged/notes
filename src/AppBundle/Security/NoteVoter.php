<?php

declare(strict_types=1);

namespace AppBundle\Security;

use AppBundle\Entity\Note;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class NoteVoter extends Voter
{
    const ACCESS = 'access';

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        return strtolower($attribute) === self::ACCESS && $subject instanceof Note;
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!($user instanceof User)) {
            return false;
        }

        /** @var Note $note */
        $note = $subject;

        return $note->getUser()->getId() === $user->getId();
    }
}
