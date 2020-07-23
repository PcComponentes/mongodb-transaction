<?php
declare(strict_types=1);

namespace PcComponentes\Transaction\Driver\MongoDB;

use MongoDB\Driver\Session;

final class Client extends \MongoDB\Client
{
    private Session $session;

    public function __construct(
        string $uri = 'mongodb://127.0.0.1/',
        array $uriOptions = [],
        array $driverOptions = []
    ) {
        parent::__construct($uri, $uriOptions, $driverOptions);

        $this->session = $this->startSession();
    }

    public function selectDatabase($databaseName, array $options = []): Database
    {
        $options += ['typeMap' => $this->getTypeMap()];

        return new Database($this->getManager(), $databaseName, $this->session, $options);
    }

    public function beginTransaction($options = []): void
    {
        $this->session->startTransaction($options);
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
