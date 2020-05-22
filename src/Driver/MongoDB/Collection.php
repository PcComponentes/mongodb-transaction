<?php
declare(strict_types=1);

namespace PcComponentes\Transaction\Driver\MongoDB;

use MongoDB\Driver\Manager;
use MongoDB\Driver\Session;

final class Collection extends \MongoDB\Collection
{
    private Session $session;

    public function __construct(
        Manager $manager,
        $databaseName,
        $collectionName,
        Session $session,
        array $options = []
    ) {
        parent::__construct(
            $manager,
            $databaseName,
            $collectionName,
            $options
        );

        $this->session = $session;
    }

    private function addSession(array $options): array
    {
        if (false === isset($options['session'])) {
            $options['session'] = $this->session;
        }

        return $options;
    }

    public function bulkWrite(array $operations, array $options = [])
    {
        return parent::bulkWrite($operations, $this->addSession($options));
    }

    public function createIndex($key, array $options = [])
    {
        return parent::createIndex($key, $this->addSession($options));
    }

    public function createIndexes(array $indexes, array $options = [])
    {
        return parent::createIndexes($indexes, $this->addSession($options));
    }

    public function deleteMany($filter, array $options = [])
    {
        return parent::deleteMany($filter, $this->addSession($options));
    }

    public function deleteOne($filter, array $options = [])
    {
        return parent::deleteOne($filter, $this->addSession($options));
    }

    public function drop(array $options = [])
    {
        return parent::drop($this->addSession($options));
    }

    public function dropIndex($indexName, array $options = [])
    {
        return parent::dropIndex($indexName, $this->addSession($options));
    }

    public function dropIndexes(array $options = [])
    {
        return parent::dropIndexes($this->addSession($options));
    }

    public function findOneAndDelete($filter, array $options = [])
    {
        return parent::findOneAndDelete($filter, $this->addSession($options));
    }

    public function findOneAndReplace($filter, $replacement, array $options = [])
    {
        return parent::findOneAndReplace($filter, $replacement, $this->addSession($options));
    }

    public function findOneAndUpdate($filter, $update, array $options = [])
    {
        return parent::findOneAndUpdate($filter, $update, $this->addSession($options));
    }

    public function insertMany(array $documents, array $options = [])
    {
        return parent::insertMany($documents, $this->addSession($options));
    }

    public function insertOne($document, array $options = [])
    {
        return parent::insertOne($document, $this->addSession($options));
    }

    public function replaceOne($filter, $replacement, array $options = [])
    {
        return parent::replaceOne($filter, $replacement, $this->addSession($options));
    }

    public function updateMany($filter, $update, array $options = [])
    {
        return parent::updateMany($filter, $update, $this->addSession($options));
    }

    public function updateOne($filter, $update, array $options = [])
    {
        return parent::updateOne($filter, $update, $this->addSession($options));
    }
}
