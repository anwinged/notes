<?php

declare(strict_types=1);

namespace AppBundle\Command;

use AppBundle\Service\BackupService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BackupDatabaseCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:database:backup')
        ;

        $this
            ->addOption('restore', null, InputOption::VALUE_NONE, '')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, '', null)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getOption('name') ?: null;
        $isRestoring = (bool) $input->getOption('restore');

        /** @var BackupService $service */
        $service = $this->getContainer()->get(BackupService::class);

        if ($isRestoring) {
            if ($name === null) {
                throw new \InvalidArgumentException('Name must be set for restoring');
            }
            $service->restore($name);
        } else {
            $service->backup($name);
        }
    }
}
