<?php

namespace AppBundle\Command;

use AppBundle\Service\NoteService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NoteReparserCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:reparse')
            ->setDescription('Reparse all notes');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var NoteService $noteService */
        $noteService = $this->getContainer()->get(NoteService::class);
        $noteService->reparseAllNotes();

        $output->writeln('Done.');
    }
}
