<?php
declare(strict_types=1);

namespace PcComponentes\Transaction\Driver\MongoDB;

use PcComponentes\Transaction\Driver\TransactionalConnection;

final class MongoDBTransactionalConnection implements TransactionalConnection
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function beginTransaction(): void
    {
        $this->client->beginTransaction();
    }

    public function commit(): void
    {
        $this->client->commit();
    }

    public function rollBack(): void
    {
        $this->client->rollBack();
    }
}
