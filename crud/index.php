<?php 
    require_once 'class_user.php';
    //-------------dbname----host-----usuario--senha
    $u = new User("crud", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if(isset($_POST['nome'])){
            $nome = addslashes($_POST['nome']);
            $email = addslashes($_POST['email']);
            $telefone = addslashes($_POST['telefone']);
            if (!empty($nome) && !empty($email) && !empty($telefone)) {
                //cadastrar
                if(!$u -> registerUser($nome, $email, $telefone)){
                    echo "Email já cadastrado!";
                } 
            } else {
                echo "Preencha todos os campos";
            }
        }

    ?>

    <?php 
        //so vai realizar o comando se existir o id_up
        if(isset($_GET['id_up'])){
            $id_update = addslashes($_GET['id_up']);
            $res = $u -> fetchDataUser($id_update);

        }
    ?>
    <section id="esquerda">
        <form method="post">
            <h1>Cadastrar usuário</h1>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];} ?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php if(isset($res)){echo $res['email'];} ?>">

            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" value="<?php if(isset($res)){echo $res['telefone'];} ?>">

            <input type="submit" value="<?php if(isset($res)){echo "Atualizar";} else { echo "Cadastrar";} ?>">
        </form>
    </section>
    <section id="direita">
        <table>
            <tr id="titulo">
                <td>Nome</td>
                <td>Email</td>
                <td colspan="2">Telefone</td>
            </tr>
        <?php
            $data = $u -> fetchData();
            //verificar se a variavel esta vazia
            if (count($data) > 0) {
                for ($i=0; $i < count($data) ; $i++) { 
                    echo "<tr>"; //abre a linha antes do foreach
                    //a cada cilco uma coluna
                    foreach ($data[$i] as $key => $value) {
                        //se nao for a coluna id
                        if ($key != "id") {
                           echo "<td>".$value."</td>"; //colunas
                        }
                    }
        ?>  
            <td>
                <a href="index.php?id_up=<?php echo $data[$i]['id'];?>">Editar</a>
             
                <a href="index.php?id=<?php echo $data[$i]['id'];?>">Excluir</a> 
            </td> 
            
        <?php
        
            echo "</tr>"; //fecha a linha depois do foreach
            }
        } else { 
            //o banco esta vazio
            echo "Ainda não há usuários cadastrados";
        }
        ?>
        </table>
    </section>
</body>
</html>

<?php 
    //excluir: se a variavel existe 
    if (isset($_GET['id'])) {
        $id_user = addslashes($_GET['id']);
        $u -> deleteUser($id_user);
        header("location: index.php");//atualiza a pagina
    }
?>