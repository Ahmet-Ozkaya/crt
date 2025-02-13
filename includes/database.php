<?php
require_once 'config.php';

class Database
{
    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetch($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data)
    {
        $keys = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($keys) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
        return $this->connection->lastInsertId();
    }

    public function update($table, $data, $condition)
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }
        $set = implode(", ", $set);
        $sql = "UPDATE $table SET $set WHERE $condition";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
    }

    public function delete($table, $condition)
    {
        $sql = "DELETE FROM $table WHERE $condition";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }

    public function close()
    {
        $this->connection = null;
    }
}
