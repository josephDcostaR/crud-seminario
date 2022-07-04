<?php

Class Conces {

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
        $cmd = $this-> pdo->query("SELECT * FROM concessionarias  
        ORDER BY nome ");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

//Funcao de cadastrar usuarios
    public function cadastrarConces($nome, $endereco, $contato)
    {
        //Antes de cadastrar deve-se verificar se esse cadastro ja existe
        $cmd = $this->pdo->prepare("SELECT id FROM concessionarias WHERE nome = :n");
        $cmd->bindValue(":n", $nome);
        $cmd->execute();
        if($cmd->rowCount() > 0)//email ja existe no banco
        {
            return false;
        } 
        else //nao foi cadastrado 
        {
            $cmd = $this->pdo->prepare("INSERT INTO concessionarias (nome, endereco, contato) 
                                        VALUES (:n, :e, :c)");
            $cmd->bindValue(":n",$nome);
            $cmd->bindValue(":e",$endereco);
            $cmd->bindValue(":c",$contato);
            $cmd->execute();
            return true;
        }
    }

    public function excluirConces($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM concessionarias WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd ->execute();

    }

    //Buscar dados de um usuario especifico
    public function buscarDadosConces($id)
    {
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM concessionarias WHERE id = :id");
        $cmd->bindValue(":id",$id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }


    //Atualizar os dados no banco de dados
    public function atualizarDados($id, $nome, $endereco, $contato)
    {
                
        $cmd =$this->pdo->prepare("UPDATE concessionarias SET nome = :n, endereco = :e, contato = :c WHERE id = :id");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":e",$endereco);
        $cmd->bindValue(":c",$contato);
        $cmd->bindValue(":id",$id);
        $cmd->execute();
   
   }


}

?>