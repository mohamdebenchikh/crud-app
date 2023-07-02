<?php

namespace App\Core;

class Database
{
    private $connection;
    private $fetchMode;
    private $className;
    private $orderByColumn;
    private $orderByDirection;
    private $perPage;

    public function __construct()
    {

        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";

        try {
            $this->connection = new \PDO($dsn, DB_USER, DB_PASS);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        } catch (\PDOException $e) {
            throw new \Exception("Failed to connect to the database: " . $e->getMessage());
        }

        // Set default fetch mode to associative array
        $this->fetchMode = \PDO::FETCH_ASSOC;
        $this->className = null;
        $this->orderByColumn = null;
        $this->orderByDirection = 'ASC';
        $this->perPage = null;
    }

    public function disconnect()
    {
        $this->connection = null;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderByColumn = $column;
        $this->orderByDirection = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
    }

    public function paginate($perPage)
    {
        $this->perPage = max(1, intval($perPage));
    }

    public function setFetchMode($fetchMode, $className = null)
    {
        $this->fetchMode = $fetchMode;
        $this->className = $className;
    }

    public function create($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $query = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

        $statement = $this->connection->prepare($query);
        $statement->execute($data);

        return $this->connection->lastInsertId();
    }

    public function update($table, $data, $conditions)
    {
        $placeholders = "";
        foreach ($data as $key => $value) {
            $placeholders .= "{$key} = :{$key}, ";
        }
        $placeholders = rtrim($placeholders, ", ");

        $query = "UPDATE {$table} SET {$placeholders} WHERE {$conditions}";

        $statement = $this->connection->prepare($query);
        $statement->execute($data);

        return $statement->rowCount();
    }

    public function select($table, $columns = "*", $conditions = "", $params = [])
    {
        $query = "SELECT {$columns} FROM {$table}";

        if ($conditions !== "") {
            $query .= " WHERE {$conditions}";
        }

        if ($this->orderByColumn !== null) {
            $query .= " ORDER BY {$this->orderByColumn} {$this->orderByDirection}";
        }

        $statement = $this->connection->prepare($query);
        $statement->execute($params);

        if ($this->className !== null) {
            $statement->setFetchMode($this->fetchMode, $this->className);
        } else {
            $statement->setFetchMode($this->fetchMode);
        }

        // Check if pagination is enabled
        if ($this->perPage !== null) {
            $results = $statement->fetchAll();
            $total = count($results);
            $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
            $lastPage = ceil($total / $this->perPage);
            $currentPage = min($currentPage, $lastPage);

            // Slice the results to get the current page's data
            $startIndex = ($currentPage - 1) * $this->perPage;
            $results = array_slice($results, $startIndex, $this->perPage);

            // Add pagination data to the results
            $paginationData = [
                'total' => $total,
                'per_page' => $this->perPage,
                'current_page' => $currentPage,
                'last_page' => $lastPage,
                'next_page_url' => $currentPage < $lastPage ? "?page=" . ($currentPage + 1) : null,
                'prev_page_url' => $currentPage > 1 ? "?page=" . ($currentPage - 1) : null,
            ];

            return ['data' => $results, 'pagination' => $paginationData];
        }

        return $statement->fetchAll();
    }

    public function delete($table, $conditions, $params = [])
    {
        $query = "DELETE FROM {$table} WHERE {$conditions}";

        $statement = $this->connection->prepare($query);
        $statement->execute($params);

        return $statement->rowCount();
    }

    public function findById($table, $id, $columns = "*")
    {
        $query = "SELECT {$columns} FROM {$table} WHERE id = :id";

        $statement = $this->connection->prepare($query);
        $statement->execute(['id' => $id]);

        if ($this->className !== null) {
            $statement->setFetchMode($this->fetchMode, $this->className);
        } else {
            $statement->setFetchMode($this->fetchMode);
        }

        return $statement->fetch();
    }
}
