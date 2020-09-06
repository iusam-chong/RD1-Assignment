<?php

class Dbh {
    private $host = "localhost";
    private $user = "root";
    private $pwd = "";
    private $dbName = "weather";

    protected function connect() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
        $pdo = new PDO($dsn, $this->user, $this->pwd);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }

    protected function select($query,$param) {
        $stmt = $this->connect()->prepare($query);
        $stmt->execute($param);

        $result = $stmt->fetch();
        return $result;
    }

    # Query insert or delete can be use 
    protected function insert($query) {
        $stmt = $this->connect()->prepare($query);
        $stmt->execute();
    }

    protected function selectAll($query,$param) {
        $stmt = $this->connect()->prepare($query);
        $stmt->execute($param);

        $result = $stmt->fetchAll();
        return $result;
    }
}

?>