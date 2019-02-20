<?php

  require_once("config.php");

  //$sql = new Sql();

  //$usuario = new Usuario();

  //$usuario->loadById(1);
  //echo $usuario;

  //$lista = Usuario::getList();

  //echo json_encode($lista);

  // carrega uma lista de usuarios buscando pelo login
  //$search = Usuario::search("l");

  //echo json_encode($search);

  // carregando um usuario por seu login e senha

  $usuario = new Usuario();

  $usuario->login("magsa", "3211123");

  echo $usuario;
?>