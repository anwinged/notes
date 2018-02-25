<?php

declare(strict_types=1);

namespace AppBundle\Service;

use AppBundle\Entity\Note;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use S2\Rose\Entity\Indexable;
use S2\Rose\Entity\Query;
use S2\Rose\Finder;
use S2\Rose\Indexer;
use S2\Rose\Stemmer\PorterStemmerRussian;
use S2\Rose\Storage\Database\PdoStorage;

class SearchService
{
    use LoggerAwareTrait;

    private $storage;

    private $stemmer;

    private $indexer;

    public function __construct(string $host, string $database, string $port, string $user, string $password)
    {
        $pdo = new \PDO("mysql:host={$host}:{$port};dbname={$database};charset=utf8", $user, $password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->storage = new PdoStorage($pdo, 'rose_');
        $this->stemmer = new PorterStemmerRussian();
        $this->indexer = new Indexer($this->storage, $this->stemmer);

        $this->logger = new NullLogger();
    }

    public function index(Note $note): void
    {
        $this->indexNote($note);
    }

    public function search(string $text, int $limit): array
    {
        $query = new Query($text);
//        $query->setLimit($limit);
//        $query->setOffset(0);

        $finder = new Finder($this->storage, $this->stemmer);
        $resultSet = $finder->find($query);

        $result = [];
        foreach ($resultSet->getItems() as $id => $item) {
            $result[] = $id;
        }

        return $result;
    }

    public function remove(Note $note): void
    {
        $this->indexer->removeById($note->getId());
    }

    public function reindexAll(array $notes): void
    {
        $this->logger->info('Erase search index');

        $this->storage->erase();

        foreach ($notes as $note) {
            $this->indexNote($note);
        }
    }

    private function indexNote(Note $note): void
    {
        $this->logger->info('Index note {id}', ['id' => $note->getId()]);

        $this->indexer->index(new Indexable(
            (string) $note->getId(),
            $note->getTitle(),
            $note->getSource()
        ));
    }
}
