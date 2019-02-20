<?php

  class Sql extends PDO {
    
    private $connection;

    public function __construct() {
      $this->connection = new PDO("mysql:host=localhost; dbname=dbphp7", "root", "");
    }

    public function setParams($statement, $parameters = array()) {
      foreach ($parameters as $key => $value) {
        $this->setParam($statement, $key, $value);
      }
    }

    public function setParam($statement, $key, $value) {
      $statement->bindParam($key, $value);
    }

    public function query($rawQuery, $params = array()) {
      $stmt = $this->connection->prepare($rawQuery);

      $this->setParams($stmt, $params);

      $stmt->execute();

      return $stmt;
    }

    public function select($rawQuery, $params = array()) {
      $stmt = $this->query($rawQuery, $params);

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }

?>