<?php

declare(strict_types=1);

namespace AppBundle\Repository;

use AppBundle\Entity\Note;
use Doctrine\ORM\EntityRepository;

class NoteRepository extends EntityRepository
{
    public function persist(Note $note)
    {
        $em = $this->getEntityManager();
        $em->persist($note);
        $em->flush($note);
    }

    /**
     * @return Note[]
     */
    public function getActiveNotes(): array
    {
        return $this->findBy(['archived' => false]);
    }
}
