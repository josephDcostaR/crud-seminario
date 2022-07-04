<?php
require_once 'config-carro.php';
$p = new Carros("seminario","localhost","root","");
?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro de Carros</title>
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <?php

        if(isset($_POST['marca']))//verifica se usuario clicou no botao casdastrar ou atualizar
        {     
            //Editar dados 
        if ( isset($_GET['id_up']) && !empty($_GET['id_up']))
            {
                $id_upd = addslashes($_GET['id_up']);
                $marca = addslashes($_POST['marca']);
                $placa = addslashes($_POST['placa']);
                $preco  = addslashes($_POST['preco']);

                if (!empty($marca) && !empty($placa) && !empty($preco)) 
                {
                    //Editar ou Atualizar
                    $p-> atualizarDados($id_upd, $marca, $placa, $preco);
                    header("location: index-car.php");
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
                
                    $marca = addslashes($_POST['marca']);
                    $placa = addslashes($_POST['placa']);
                    $preco  = addslashes($_POST['preco']);
                    if (!empty($marca) && !empty($placa) && !empty($preco)) 
                    {
                        //cadastrar
                        if (!$p-> cadastrarCarro($marca, $placa, $preco))
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
                $res = $p->buscarDadosCarro($id_update);
            }
        ?>

        <!-- // Interface de Cadastro -->
        <section id="esquerda">
        <form method="POST" >
            <h2>Cadastro de Carros</h2>
            <label for="marca">Marca</label>
            <input type="text" class="inputClass" name="marca" id="marca" placeholder="Insira a Marca"
            value="<?php if (isset($res)) {echo $res['marca'];}?>"
            ></input>
            <label for="placa">Placa</label>
            <input type="text" class="inputClass" name="placa" id="placa" placeholder="Insira a Placa"
            value="<?php if (isset($res)) {echo $res['placa'];}?>"
            ></input>
            <label for="preco">Preço</label>
            <input type="text" class="inputClass" name="preco" id="preco" placeholder="Valor Total"
            value="<?php if (isset($res)) {echo $res['preco'];}?>"
            ></input>
            <input type="submit" class="cadastrar"
            value="<?php if(isset($res)) {echo "Atualizar";} else{echo "Cadastrar";} ?>">
        </form>

        <br><br><br><br><br><br><br><br><br>
        
        <a id="navegar1" href="index-cli.php"><<< VOLTAR</a>
        
        <a id="navegar2" href="index-con.php">>>> AVANÇAR</a>
        
        <!-- // Tabela de registro  -->
        </section>
        <section  id="direita">
            <table>
                <tr id="titulo">
                    <td>Marca</td>
                    <td>Placa</td>
                    <td colspan="2">Preço</td>
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
                    <a  id="editar"  href="index-car.php?id_up=<?php echo $dados[$i]['id']; ?>">Editar</a>
                    <a  id="deletar" href="index-car.php?id=<?php echo $dados[$i]['id']; ?>">Deletar</a>
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
                    $p->  excluirCarro($id_user);
                    header("location: index-car.php");
                }

    ?>




