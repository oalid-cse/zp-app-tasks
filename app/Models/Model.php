<?php

namespace OalidCse\Models;

use OalidCse\Helpers\DB;

require_once DIRECTORY.'/app/Helpers/DB.php';

class Model
{
    protected $table;
    protected $db;
    public function __construct(string $table)
    {
        $this->table = $table;
        $this->db = new DB();
    }

    public function store($data): array
    {
        // Create a record in the database
        $insertedID = $this->db->table($this->table)->create($data);
        return $this->read($insertedID);
    }

    public function read($id): array
    {
        // Read a record from the database
        return $this->db->table($this->table)->read($id);
    }

    public function update($id, $data): array
    {
        // Update a record in the database
        $this->db->table($this->table)->update($id, $data);
        return $this->read($id);
    }

    public function delete($id): void
    {
        // Delete a record from the database
        $this->db->table($this->table)->delete($id);
    }

    public function all(): array
    {
        // Get all records from the database
        return $this->db->table($this->table)->all();
    }
}
