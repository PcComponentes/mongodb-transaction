# MongoDB Transaction

## The problem
The way to use transactions in **MongoDB** differs from a typical relational database connection (MySQL, PostgreSQL, etc).

In MongoDB a session is generated and all operations must be associated to that **session**.

That means that for any write anywhere in the code you would have to send the **session associated with the transaction** to MongoDB.

## The solution
It has been extended the **Client**, **Collection** and **Database** classes.
Can generate a session and pass it to each class to control transactions from the beginning.

## Usage
Instead of instantiating the original `\MongoDB\Client`, instantiate the `PcComponentes\Transaction\Driver\MongoDB\Client` class.

```php
<?php

$client = new PcComponentes\Transaction\Driver\MongoDB\Client($uri);

try {
    $client->beginTransaction();
    //...
    $client->commit();
} catch (\Throwable $exception) {
    $client->rollBack();
}
```

Or you can use **Transaction Middleware**:

```php
<?php

$middleware = new PcComponentes\Transaction\SymfonyMessenger\TransactionMiddleware(
    new PcComponentes\Transaction\Driver\MongoDB\MongoDBTransactionalConnection(
        new PcComponentes\Transaction\Driver\MongoDB\Client($uri)
    )
);
```
