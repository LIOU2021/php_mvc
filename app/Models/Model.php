<?php

namespace App\Models;

use Exception;
use mysqli_sql_exception;
use PDO;
use PDOException;

class Model
{
    private $className;
    private $query;

    final public function __construct()
    {
        $class = get_class($this);
        $class = explode("\\", $class);
        $ln = count($class);
        $class = strtolower($class[$ln - 1]);
        $this->className = $class;
    }

    /**
     * 獲取model對應table的名稱
     */
    public function getModelName()
    {
        return $this->className;
    }

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

    /**
     * input sql query
     * 
     */
    public function query(string $query)
    {
        $this->query .= $query;
    }

    /**
     * get current query string
     * 
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * execute query
     * 
     */
    public function exec()
    {
        $pdo = $this->make();

        if ($this->query) {
            $sql = $this->query;
        } else {
            helpReturn(501, get_caller_info());
        }


        $stmt = $pdo->prepare($sql);
        $stmt->execute();


        try {
            $rs =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (
            Exception $e
        ) {
            $rs = null;
            // dd(123);
            // dd($e->getMessage());
        }




        $pdo = null;
        return $rs ?? null;
    }

    /**
     * all model data
     */
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

    /**
     * find model data by id
     * 
     */
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
            helpReturn(500, "your id : $id");
        }

        return $rs;
    }
}
