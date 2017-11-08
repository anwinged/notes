<?php

declare(strict_types=1);

namespace AppBundle\Service;

use BackupManager\Compressors;
use BackupManager\Config\Config;
use BackupManager\Databases;
use BackupManager\Filesystems;
use BackupManager\Manager;

final class BackupService
{
    private const DATABASE = 'db';

    /**
     * @var string
     */
    private $environment;

    /**
     * @var Manager
     */
    private $manager;

    public function __construct(
        $environment,
        $workDirectory,
        $databaseName,
        $databaseHost,
        $databasePort,
        $databaseUser,
        $databasePassword,
        $dropboxToken
    ) {
        $this->environment = $environment;

        $storageCongig = [
            'local' => [
                'type' => 'Local',
                'root' => $workDirectory,
            ],
            'dropbox' => [
                'type' => 'Dropbox',
                'token' => $dropboxToken,
                'app' => 'vakhrushev_notes_backup',
                'root' => '/',
            ],
        ];

        $databaseConfig = [
            self::DATABASE => [
                'type' => 'mysql',
                'host' => $databaseHost,
                'port' => $databasePort,
                'user' => $databaseUser,
                'pass' => $databasePassword,
                'database' => $databaseName,
                'singleTransaction' => false,
            ],
        ];

        $filesystems = new Filesystems\FilesystemProvider(new Config($storageCongig));
        $filesystems->add(new Filesystems\LocalFilesystem());
        $filesystems->add(new Filesystems\DropboxFilesystem());

        $databases = new Databases\DatabaseProvider(new Config($databaseConfig));
        $databases->add(new Databases\MysqlDatabase());

        $compressors = new Compressors\CompressorProvider();
        $compressors->add(new Compressors\GzipCompressor());

        $this->manager = new Manager($filesystems, $databases, $compressors);
    }

    public function backup(?string $filename = null)
    {
        if ($filename === null) {
            $filename = $this->getDefaultFileName();
        }

        $destinations = [
            new Filesystems\Destination('dropbox', $filename),
        ];

        /* @noinspection PhpUnhandledExceptionInspection */
        $this->manager
            ->makeBackup()
            ->run(self::DATABASE, $destinations, 'gzip')
        ;
    }

    public function restore(string $filename)
    {
        /* @noinspection PhpUnhandledExceptionInspection */
        $this->manager
            ->makeRestore()
            ->run('dropbox', $filename, self::DATABASE, 'gzip')
        ;
    }

    private function getDefaultFileName(): string
    {
        return sprintf(
            'backup_%s_%s.sql',
            $this->environment,
            (new \DateTime())->format('YmdHis')
        );
    }
}
