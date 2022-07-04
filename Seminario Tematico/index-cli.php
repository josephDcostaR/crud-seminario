<?php
require_once 'config-cliente.php';
$p = new Usuario("seminariotematico","localhost","root","");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Clientes</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <?php

    if(isset($_POST['login']))//verifica se usuario clicou no botao casdastrar ou atualizar
    {     
        //Editar dados ou Atualização
      if ( isset($_GET['id_up']) && !empty($_GET['id_up']))
        {
            $id_upd = addslashes($_GET['id_up']);
            $login = addslashes($_POST['login']);
            $senha = addslashes($_POST['senha']);
            $nome  = addslashes($_POST['nome']);

            if (!empty($login) && !empty($senha) && !empty($nome)) 
            {
                //Editar ou Atualizar
                $p-> atualizarDados($id_upd, $login, $senha, $nome);
                header("location: index-cli.php");
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
             
                $login = addslashes($_POST['login']);
                $senha = addslashes($_POST['senha']);
                $nome  = addslashes($_POST['nome']);
                if (!empty($login) && !empty($senha) && !empty($nome)) 
                {
                    //cadastrar
                    if (!$p-> cadastrarUsuarios($login, $senha, $nome))
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
            $id_update1 = addslashes($_GET['id_up']);
            $res = $p->buscarDadosUsuario($id_update1);
        }
    ?>

    <!-- // Interface de Cadastro -->
    <section id="esquerda">
    <form method="POST" >
        <h2>Cadastro de Clientes</h2>
        <label for="login">Login</label>
        <input type="email" class="inputClass" name="login" id="login" placeholder="Digite seu Email"
        value="<?php if (isset($res)) {echo $res['login'];}?>"
        ></input>
        <label for="senha">Senha</label>
        <input type="password" class="inputClass" name="senha" id="senha" placeholder="Digite uma Senha"
        value="<?php if (isset($res)) {echo $res['senha'];}?>"
        ></input>
        <label for="nome">Nome</label>
        <input type="text" class="inputClass" name="nome" id="nome" placeholder="Digite seu Nome"
        value="<?php if (isset($res)) {echo $res['nome'];}?>"
        ></input>
        <input type="submit" class="cadastrar"
        value="<?php if(isset($res)) {echo "Atualizar";} else{echo "Cadastrar";} ?>"> 
    </form>
    
    <br><br><br><br><br><br><br><br><br>

    <a class="navegar" href="index-car.php">>>> AVANÇAR</a>

    <!-- // Tabela de registro  -->
    </section>
    <section  id="direita">
        <table>
            <tr id="titulo">
                <td>Login</td>
                <td>Senha</td>
                <td colspan="2">Nome</td>
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
                <a id="editar" href="index-cli.php?id_up=<?php echo $dados[$i]['id']; ?>">Editar</a>
                <a id="deletar" href="index-cli.php?id=<?php echo $dados[$i]['id']; ?>">Deletar</a>
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
                $p->  excluirUsuario($id_user);
                header("location: index-cli.php");
            }

?>




