<?php

Class Carros {

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
        $cmd = $this-> pdo->query("SELECT * FROM carros   
        ORDER BY marca ");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

//Funcao de cadastrar usuarios
    public function cadastrarCarro($marca, $placa, $preco)
    {
        //Antes de cadastrar deve-se verificar se esse cadastro ja existe
        $cmd = $this->pdo->prepare("SELECT id FROM carros WHERE marca = :m");
        $cmd->bindValue(":m", $marca);
        $cmd->execute();
        if($cmd->rowCount() > 0)//email ja existe no banco
        {
            return false;
        } 
        else //nao foi cadastrado 
        {
            $cmd = $this->pdo->prepare("INSERT INTO carros ( marca, placa, preco) 
                                        VALUES (:m, :p, :r)");
            $cmd->bindValue(":m",$marca);
            $cmd->bindValue(":p",$placa);
            $cmd->bindValue(":r",$preco);
            $cmd->execute();
            return true;
        }
    }

    public function excluirCarro($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM carros WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd ->execute();

    }

    //Buscar dados de um usuario especifico
    public function buscarDadosCarro($id)
    {
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM carros WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }


    //Atualizar os dados no banco de dados
    public function atualizarDados($id, $marca, $placa, $preco)
    {
                
        $cmd =$this->pdo->prepare("UPDATE carros SET marca = :m, placa = :p, preco = :r WHERE id = :id");
        $cmd->bindValue(":m", $marca);
        $cmd->bindValue(":p",$placa);
        $cmd->bindValue(":r",$preco);
        $cmd->bindValue(":id",$id);
        $cmd->execute();
   
   }


}

?>