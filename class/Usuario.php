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
        
        $this->setData($results[0]);
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
        $this->setData($results[0]);

      } else {
        throw new Exception("Login e/ou senha inválidos!");
      }
    }

    public function setData($data) {
      $this->setIdUser($data["id_user"]);
      $this->setDescLogin($data["desc_login"]);
      $this->setDescPass($data["desc_pass"]);
      $this->setDtRegister(new DateTime($data["dt_register"]));
    }

    public function insert() {
      $sql = new Sql();

      $results = $sql->select("CALL sp_users_insert(:LOGIN, :PASS)", array(
        ":LOGIN" => $this->getDescLogin(),
        ":PASS" => $this->getDescPass()
      ));

      if (count($results) > 0) {
        $this->setData($results[0]);
      }
    }

    public function update($login, $pass) {

      $this->setDescLogin($login);
      $this->setDescPass($pass);

      $sql = new Sql();

      $sql->query("UPDATE tb_users SET desc_login = :LOGIN, desc_pass = :PASS WHERE id_user :ID", array(
        ":LOGIN" => $this->getDescLogin(),
        ":PASS" => $this->getDescPass(),
        ":ID" => $this->getIdUser()
      ));
    }

    public function delete() {
      $sql = new Sql();

      $sql->query("DELETE FROM tb_users WHERE id_user = :ID", array(
        ":ID" => $this->getIdUser()
      ));

      $this->setIdUser(0);
      $this->setDescLogin("");
      $this->setDescPass("");
      $this->setDtRegister(new DateTime());
    }

    public function __construct($login = "", $pass = "") {
      $this->setDescLogin($login);
      $this->setDescPass($pass);
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