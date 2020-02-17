<?php
declare(strict_types=1);

namespace PcComponentes\Transaction\Driver\MongoDB;

use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\Session;
use MongoDB\Driver\WriteConcern;

final class Client extends \MongoDB\Client
{
    private Session $session;

    public function __construct(string $uri, array $uriOptions = [], array $driverOptions = [])
    {
        parent::__construct($uri, $uriOptions, $driverOptions);

        $this->session = $this->startSession(
            $this->defaultTransactionOptions()
        );
    }

    public function selectDatabase($databaseName, array $options = []): Database
    {
        $options += ['typeMap' => $this->getTypeMap()];

        return new Database($this->getManager(), $databaseName, $this->session, $options);
    }

    private function defaultTransactionOptions(): array
    {
        return [
            'readConcern' => new ReadConcern('local'),
            'writeConcern' => new WriteConcern(WriteConcern::MAJORITY),
        ];
    }

    public function beginTransaction(): void
    {
        $this->session->startTransaction(
            $this->defaultTransactionOptions()
        );
    }

    public function commit(): void
    {
        $this->session->commitTransaction();
    }

    public function rollBack(): void
    {
        $this->session->abortTransaction();
    }
}
