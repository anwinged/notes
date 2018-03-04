<?php

declare(strict_types=1);

namespace AppBundle\Service;

use BackupManager\Compressors;
use BackupManager\Config\Config;
use BackupManager\Databases;
use BackupManager\Filesystems;
use BackupManager\Manager;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class BackupService
{
    use LoggerAwareTrait;

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

        $storageConfig = [
            'local' => [
                'type' => 'Local',
                'root' => $workDirectory,
            ],
            'dropbox' => [
                'type' => 'dropboxv2',
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

        $filesystems = new Filesystems\FilesystemProvider(new Config($storageConfig));
        $filesystems->add(new Filesystems\LocalFilesystem());
        $filesystems->add(new Filesystems\DropboxV2Filesystem());

        $databases = new Databases\DatabaseProvider(new Config($databaseConfig));
        $databases->add(new Databases\MysqlDatabase());

        $compressors = new Compressors\CompressorProvider();
        $compressors->add(new Compressors\GzipCompressor());

        $this->manager = new Manager($filesystems, $databases, $compressors);

        $this->logger = new NullLogger();
    }

    public function backup(?string $filename = null): void
    {
        if ($filename === null) {
            $filename = $this->getDefaultFileName();
        }

        $destinations = [
            new Filesystems\Destination('dropbox', $filename),
        ];

        $this->logger->info('Backup database "{database}" to "{destination}"', [
            'database' => self::DATABASE,
            'destination' => $filename,
        ]);

        /* @noinspection PhpUnhandledExceptionInspection */
        $this->manager
            ->makeBackup()
            ->run(self::DATABASE, $destinations, 'gzip')
        ;
    }

    public function restore(string $filename): void
    {
        $this->logger->info('Restore database "{database}" from "{target}"', [
            'database' => self::DATABASE,
            'target' => $filename,
        ]);

        /* @noinspection PhpUnhandledExceptionInspection */
        $this->manager
            ->makeRestore()
            ->run('dropbox', $filename, self::DATABASE, 'gzip')
        ;
    }

    private function getDefaultFileName(): string
    {
        return sprintf(
            'backup__%s__%s.sql',
            $this->environment,
            (new \DateTime())->format('Y-m-d_H-i-s')
        );
    }
}
