<?php
declare(strict_types=1);

namespace PcComponentes\Transaction\Driver\MongoDB;

use MongoDB\Driver\Manager;
use MongoDB\Driver\Session;

final class Database extends \MongoDB\Database
{
    private Session $session;

    public function __construct(Manager $manager, $databaseName, Session $session, array $options = [])
    {
        parent::__construct($manager, $databaseName, $options);

        $this->session = $session;
    }

    public function selectCollection($collectionName, array $options = []): Collection
    {
        $options += [
            'readConcern' => $this->getReadConcern(),
            'readPreference' => $this->getReadPreference(),
            'typeMap' => $this->getTypeMap(),
            'writeConcern' => $this->getWriteConcern(),
        ];

        return new Collection($this->getManager(), $this->getDatabaseName(), $collectionName, $this->session, $options);
    }
}
