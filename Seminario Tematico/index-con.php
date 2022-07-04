<?php
require_once 'config-conces.php';
$p = new Conces("seminario","localhost","root","");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Concesionaria</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php

    if(isset($_POST['nome']))//verifica se usuario clicou no botao casdastrar ou atualizar
    {     
        //Editar dados 
      if ( isset($_GET['id_up']) && !empty($_GET['id_up']))
        {
            $id_upd = addslashes($_GET['id_up']);
            $nome = addslashes($_POST['nome']);
            $endereco = addslashes($_POST['endereco']);
            $contato  = addslashes($_POST['contato']);

            if (!empty($nome) && !empty($endereco) && !empty($contato)) 
            {
                //Editar ou Atualizar
                $p-> atualizarDados($id_upd, $nome, $endereco, $contato);
                header("location: index-con.php");
            }
            else 
            {
                ?>
                <div class="aviso">
                    <img src="aviso.png">
                    <h4> Preencha todos os campos!<h4>
                </div>               
                <?php
            }
        }

            else  // Cadastrar dados 
            { 
             
                $nome = addslashes($_POST['nome']);
                $endereco = addslashes($_POST['endereco']);
                $contato  = addslashes($_POST['contato']);
                if (!empty($nome) && !empty($endereco) && !empty($contato)) 
                {
                    //cadastrar
                    if (!$p-> cadastrarConces($nome, $endereco, $contato))
                    {
                    ?>                
                        <div class="aviso">
                            <img src="aviso.png">
                            <h4> Esse usuario já esta cadastrado! <h4>
                        </div>               
                    <?php                   
                    }
                }
                else 
                {
                    ?>
                    <div class="aviso">
                        <img src="aviso.png">
                        <h4> Preencha todos os campos! <h4>
                    </div>               
                   <?php
                }
           }
        }
    
    ?>

    <!-- // Chama dados de registro -->
    <?php
        if(isset($_GET['id_up']))//verifica se editar foi clicado
        {
            $id_update = addslashes($_GET['id_up']);
            $res = $p->buscarDadosConces($id_update);
        }
    ?>

    <!-- // Interface de Cadastro -->
    <section id="esquerda">
    <form method="POST" >
        <h2>Cadastro de Concesionaria</h2>
        <label for="nome">Nome</label>
        <input type="text" class="inputClass" name="nome" id="nome" placeholder="Insira o Nome"
        value="<?php if (isset($res)) {echo $res['nome'];}?>"
        ></input>
        <label for="endereco">Endereço</label>
        <input type="text" class="inputClass" name="endereco" id="endereco" placeholder="Insira o Endereço"
        value="<?php if (isset($res)) {echo $res['endereco'];}?>"
        ></input>
        <label for="contato">Contato</label>
        <input type="text" class="inputClass" name="contato" id="contato" placeholder="Telefone para Contato"
        value="<?php if (isset($res)) {echo $res['contato'];}?>"
        ></input>
        <input type="submit" class="cadastrar" 
        value="<?php if(isset($res)) {echo "Atualizar";} else{echo "Cadastrar";} ?>">
    </form>

    <br><br><br><br><br><br><br><br><br>
    
    <a class="navegar" href="index-cli.php"><<<< VOLTAR</a>

    <!-- // Tabela de registro  -->
    </section>
    <section  id="direita">
        <table>
            <tr id="titulo">
                <td>nome</td>
                <td>Endereço</td>
                <td colspan="2">Contato</td>
            </tr>
        <?php

            // Chamada pra busca de dados
            $dados = $p ->buscarDados();
            if(count($dados) > 0) //existe registros
            {
                for($i=0; $i < count($dados); $i++)
                {
                    echo "<tr>";
                    foreach($dados[$i] as $k => $v)
                    {
                        if ($k != "id")
                        {
                            echo "<td>".$v."</td>";
                        }
                    }    
        ?>
            <td>
                <a  id="editar"  href="index-con.php?id_up=<?php echo $dados[$i]['id']; ?>">Editar</a>
                <a  id="deletar" href="index-con.php?id=<?php echo $dados[$i]['id']; ?>">Deletar</a>
            </td>
                    <?php                
                        echo "</tr>";
                }                             
                    }
                    else //banco vazio
                    {
                    ?>
                </table>               
                    <div class="aviso">     
                        <h4> Ainda não há usuarios cadastrados! </h4>
                    </div>         
                   <?php
                    }
                   ?>
            </section>    
         </body>
    </html>
<?php
            // Chama Exclusão
            if(isset($_GET['id']))
            {
                $id_user = addslashes($_GET['id']);
                $p->  excluirConces($id_user);
                header("location: index-con.php");
            }

?>




