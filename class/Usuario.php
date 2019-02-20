<?php

  class Usuario {
    private $id_user;
    private $desc_login;
    private $desc_pass;
    private $dt_register;

    public function getIdUser() {
      return $this->id_user;
    }

    public function setIdUser($id_user) {
      $this->id_user = $id_user;
    }

    public function getDescLogin() {
      return $this->desc_login;
    }

    public function setDescLogin($desc_login) {
      $this->desc_login = $desc_login;
    }

    public function getDescPass() {
      return $this->desc_pass;
    }

    public function setDescPass($desc_pass) {
      $this->desc_pass = $desc_pass;
    }

    public function getDtRegister() {
      return $this->dt_register;
    }

    public function setDtRegister($dt_register) {
      $this->dt_register = $dt_register;
    }

    public function loadById($id) {
      $sql = new Sql();

      $results = $sql->select("SELECT * FROM tb_users WHERE id_user = :ID", array(
        ":ID" => $id
      ));

      if (count($results[0]) > 0) {
        $row = $results[0];

        $this->setIdUser($row["id_user"]);
        $this->setDescLogin($row["desc_login"]);
        $this->setDescPass($row["desc_pass"]);
        $this->setDtRegister(new DateTime($row["dt_register"]));
      }
    }

    public static function getList() {
      $sql = new Sql();

      return $sql->select("SELECT * FROM tb_users ORDER BY desc_login");
    }

    public static function search($desc_login) {
      $sql = new Sql();

      return $sql->select("SELECT * FROM tb_users WHERE desc_login like :SEARCH ORDER BY desc_login", array(
        ":SEARCH" => "%$desc_login%"
      ));
    }

    public function login($login, $pass) {
      $sql = new Sql();

      $results = $sql->select("SELECT * FROM tb_users WHERE desc_login = :LOGIN AND desc_pass = :PASS", array(
        ":LOGIN" => $login,
        ":PASS" => $pass
      ));

      if (count($results[0]) > 0) {
        $row = $results[0];

        $this->setIdUser($row["id_user"]);
        $this->setDescLogin($row["desc_login"]);
        $this->setDescPass($row["desc_pass"]);
        $this->setDtRegister(new DateTime($row["dt_register"]));
      } else {
        throw new Exception("Login e/ou senha inválidos!");
      }
    }

    public function __toString() {
      return json_encode(array(
        "id_user" => $this->getIdUser(),
        "desc_login" => $this->getDescLogin(),
        "desc_pass" => $this->getDescPass(),
        "dt_register" => $this->getDtRegister()->format("d/m/Y")
      ));
    }
  }

?>