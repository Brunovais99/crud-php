<?php
require 'config.php';

$usuario = [];
$id = filter_input(INPUT_GET, 'id');

if($id) {
    $sql = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $sql->bindValue(':id', $id);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location:index.php");
        exit;
    }
} else {
    header("Location:index.php");
}
?>

<h1>Editar Usuário</h1>
<form method="POST" action="editar_action.php">
    <input type="hidden" name="id" value="<?=$usuario['id'];?>">
    <label>
        Nome: <input type="text" name="nome" value="<?=$usuario['nome'];?>">
    </label>
    <label>
        Email: <input type="text" name="email" value="<?=$usuario['email'];?>">
    </label>
    <input type="submit" value="Atualizar">
</form>