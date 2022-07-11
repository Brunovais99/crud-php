<?php
require 'config.php';

$nome = filter_input(INPUT_POST, 'nome');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if($nome && $email) {

    $sql = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $sql->bindValue(':email', $email);
    $sql->execute();

    if ($sql->rowCount() === 0) { //se nao tiver nenhum email cadastrado
        
        $sql = $pdo->prepare("INSERT INTO users (nome, email) VALUES (:nome, :email)");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':email', $email);
        $sql->execute();
        
        header("Location:index.php");
        exit; //sai do if
        
    } else {
        header("Location:cadastrar.php");
    }
} else {
    header("Location:cadastrar.php");
}
