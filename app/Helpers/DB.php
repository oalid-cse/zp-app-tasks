<?php

namespace OalidCse\Helpers;

use mysqli;

require_once DIRECTORY.'/config.php';

class DB
{
    private $connection;
    private $table;
    private $selectConditions = [];

    public function __construct()
    {
        $this->connection = $this->connectDB();
    }

    public function connectDB()
    {
        $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
        if ($conn->connect_error) {
            throw new \Exception("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    public function table($table): self
    {
        $this->table = $table;
        return $this;
    }

    public function create($data): int
    {
        try {
            $data = $this->sanitizeInputData($data);
            $query = $this->getCreateQuery($data);
            $this->connection->query($query);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $this->connection->insert_id;
    }

    public function getCreateQuery($data): string
    {
        $columns = implode(', ', array_keys($data));
        $values = implode("', '", array_values($data));
        $query = "INSERT INTO $this->table ($columns) VALUES ('$values')";
        return $query;
    }

    public function read($id): array
    {
        $query = "SELECT * FROM $this->table WHERE id = $id";
        $result = $this->connection->query($query);
        return $result->fetch_assoc();
    }

    public function update($id, $data) : int
    {
        $data = $this->sanitizeInputData($data);
        $query = $this->getUpdateQuery($id, $data);
        $this->connection->query($query);

        return $this->connection->affected_rows;
    }

    public function getUpdateQuery($id, $data): string
    {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key = '$value', ";
        }
        $set = rtrim($set, ', ');
        $query = "UPDATE $this->table SET $set WHERE id = $id";
        return $query;
    }

    public function delete($id): int
    {
        $query = "DELETE FROM $this->table WHERE id = $id";
        $this->connection->query($query);

        return $this->connection->affected_rows;
    }

    public function all(): array
    {
        $query = "SELECT * FROM $this->table";
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function where($array)
    {
        $this->selectConditions = $array;
        return $this;
    }

    public function get()
    {
        $query = $this->getSelectQuery();
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSelectQuery(): string
    {
        $where = '';
        foreach ($this->selectConditions as $key => $value) {
            $where .= "$key = '$value' AND ";
        }
        $where = rtrim($where, ' AND ');
        $query = "SELECT * FROM $this->table WHERE $where";
        return $query;
    }

    public function sanitizeInputData($data): array
    {
        $sanitizedData = [];
        foreach ($data as $key => $value) {
            $sanitizedData[$key] = $this->connection->real_escape_string($value);
        }
        return $sanitizedData;
    }

    public function conn(): mysqli
    {
        return $this->connection;
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}
