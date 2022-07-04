<?php

Class Usuario {

//6 funcoes
//Conecxao com o banco
    private $pdo;

    public function __construct($dbname, $host, $user, $senha)
    {
        try{
            $this -> pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
        }
        catch (PDOException $e) 
        {
            echo "Erro com banco de dados: ".$e-> getMessage();
            exit();
        }
        catch (Exception $e) 
        {
            echo "Erro generico: ".$e-> getMessage();
        }   
    }

//Pega dados e coloca a direita
    public function buscarDados()
    {
        $res = array();
        $cmd = $this-> pdo->query("SELECT * FROM clientes
        ORDER BY nome ");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

//Funcao de cadastrar usuarios
    public function cadastrarUsuarios($login, $senha, $nome)
    {
        //Antes de cadastrar deve-se verificar se esse cadastro ja existe
        $cmd = $this->pdo->prepare("SELECT id FROM clientes WHERE login = :l");
        $cmd->bindValue(":l", $login);
        $cmd->execute();
        if($cmd->rowCount() > 0)//email ja existe no banco
        {
            return false;
        } 
        else //nao foi cadastrado 
        {
            $cmd = $this->pdo->prepare("INSERT INTO clientes ( login, senha, nome) 
                                        VALUES (:l, :s, :n)");
            $cmd->bindValue(":l",$login);
            $cmd->bindValue(":s",$senha);
            $cmd->bindValue(":n",$nome);
            $cmd->execute();
            return true;
        }
    }

    public function excluirUsuario($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM clientes WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd ->execute();

    }

    //Buscar dados de um usuario especifico
    public function buscarDadosUsuario($id)
    {
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM clientes WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }


    //Atualizar os dados no banco de dados
    public function atualizarDados($id, $login, $senha, $nome)
    {
                
        $cmd =$this->pdo->prepare("UPDATE clientes SET login = :l, senha = :s, nome = :n WHERE id = :id");
        $cmd->bindValue(":l", $login);
        $cmd->bindValue(":s",$senha);
        $cmd->bindValue(":n",$nome);
        $cmd->bindValue(":id",$id);
        $cmd->execute();
   
   }


}


?>