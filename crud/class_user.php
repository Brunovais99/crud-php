<?php

    Class User {

        private $pdo;
        
        //conexao com o banco de dados
        public function __construct($dbname, $host, $user, $password){
            try {
                $this -> pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $password);
            } catch (\Throwable $th) {
                echo "Erro com o banco de dados: ".$th -> getMessage();
            }
        }

        //buscar dados e exibir na tabela
        public function fetchData() {
            $res = array();
            $cmd = $this -> pdo -> query("SELECT * FROM user ORDER BY nome");
            $res = $cmd -> fetchAll(PDO::FETCH_ASSOC); //trasnsforma as info do $cmd em array
            return $res;
        }

        //cadastrar usuario no banco de dados
        public function registerUser($nome, $email, $telefone){
            //antes de cadastrar, verificar se ja tem cadastro
            $cmd = $this -> pdo -> prepare("SELECT * FROM user WHERE email = :e");
            $cmd -> bindValue(":e", $email);
            $cmd -> execute();
            if ($cmd -> rowCount() > 0) //se for maior que 0 ja existe cadastro 
            {
                return false;
            } else {
                $cmd = $this -> pdo -> prepare("INSERT INTO user (nome, email, telefone) VALUES (:n, :e, :t)");
                $cmd -> bindValue(":n", $nome);
                $cmd -> bindValue(":e", $email);
                $cmd -> bindValue(":t", $telefone);
                $cmd -> execute();
                return true;
            }
        } 

        public function deleteUser($id){
            $cmd = $this -> pdo -> prepare("DELETE FROM user WHERE id = :id");
            $cmd -> bindValue(":id", $id);
            $cmd -> execute();
        }


        //buscar os dados de um usuario especifio
        public function fetchDataUser($id){
            $res = array();//caso nao venha do bd ela fica vazia
            $cmd = $this -> pdo -> prepare("SELECT * FROM user WHERE id = :id");
            $cmd -> bindValue(":id", $id);
            $cmd -> execute();

            $res = $cmd->fetch(PDO::FETCH_ASSOC);
            return $res;
        }

        //atualizar dados no banco de dados
        public function updateData(){

        }
    }

    