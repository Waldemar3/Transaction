<?php 

abstract class Table
{
    protected $table;
    protected $pdo;

    function __construct(\PDO $pdo) {

        $this->pdo = $pdo;

        $this->table = strtolower(end(explode('\\', static::class)));

        $this->pdo->exec(
            "create table if not exists ". $this->table ." (
                ". static::migrate() ."
            ) DEFAULT CHARSET=utf8;"
        );
    }
    
    abstract protected function migrate(): string;
}