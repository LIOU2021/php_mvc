<?php

namespace App\Models;

use PDO;
use PDOException;

class Model
{
    private $className;

    public function __construct()
    {
        $class = get_class($this);
        $class = explode("\\", $class);
        $ln = count($class);
        $class = strtolower($class[$ln - 1]);
        $this->className = $class;
    }

    // public function getClassName()
    // {
    //     return $this->className;
    // }

    /**
     * connect DB
     * 
     */
    public function make()
    {
        return $this->connect(DATABASE, DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS);
    }

    /**
     * connect DB method
     * 
     */
    public function connect($dbms, $host, $dbPort, $dbName, $user, $pass)
    {
        $dsn = "$dbms:host=$host;port=$dbPort;dbname=$dbName";

        try {
            $conn = new PDO($dsn, $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function all()
    {
        $pdo = $this->make();

        $sql = "select * from $this->className";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $rs =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pdo = null;
        return $rs;
    }

    public function find($id)
    {
        $pdo = $this->make();

        $sql = "select * from $this->className where id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $rs = $stmt->fetch(PDO::FETCH_ASSOC);

        $pdo = null;

        if (!$rs) {
            echo helpReturn(500,"your id : $id");
            exit();
        }

        return $rs;
    }
}
