<?php

declare(strict_types=1);

namespace AppBundle\Command;

use AppBundle\Repository\NoteRepository;
use AppBundle\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchReindexCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:search:reindex')
            ->setDescription('Hello PhpStorm')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var SearchService $searcher */
        $searcher = $this->getContainer()->get(SearchService::class);

        /** @var NoteRepository $noteRepo */
        $noteRepo = $this->getContainer()->get(NoteRepository::class);
        $notes = $noteRepo->getActiveNotes();

        $searcher->reindexAll($notes);
    }
}
