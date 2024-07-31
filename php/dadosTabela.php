<?php
    include("funcoesBanco.php");
    $array = select();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../style/style.css"  async>
    <script type="text/javascript" src="../js/script.js"></script>  
    <title>Tabela Pessoas</title>
</head>
<body>
    <header>
        <h4><img src="../assets/logoOMS.png" alt=""></h4>
        <p id="subtexto">Tabela de Dados - OMS IFsul</p>
    </header>
    <div class="wrapper-tabela">
        <div class="container-tabela">
            <table class="tabela">
                <tr>
                    <th>ID</th>
                    <th>Nome <br>Completo</th>
                    <th>Idade <br>(Anos)</th>
                    <th>Peso <br>(Kg)</th>
                    <th>Altura <br>(M)</th>
                </tr>
                <?php
                    foreach ($array as $id => $dados) {
                        echo '<tr>';
                        echo '<td>'.$id.'</td>';
                        $contador = 0;
                        foreach ($dados as $caracteristicas => $valor) {
                            if($contador == 0){
                                $nome = $valor;
                            }else if($contador == 1){
                                $sobrenome = $valor;
                                echo '<td>'.ucwords($nome." ".$valor).'</td>';
                            }else if($contador == 2){
                                $idade = $valor;
                                echo '<td>'.$valor.'</td>';
                            }else if($contador == 3){
                                $peso = $valor;
                                echo '<td>'.number_format($valor,2,',','').'</td>';
                            }else if($contador == 4){
                                $altura = $valor;
                                echo '<td>'.number_format($valor,2,',','').'</td>';
                            }
                            ++$contador;
                        }
                        echo '<td><a class="botao-delete" href="deletar.php?containerDelete='.$id.'"><span class="material-symbols-outlined">delete</span></a></td>';
                        echo '<td><a class="botao-edit" href="formUpdate.php?containerId='.$id.'&
                                                        containerNome='.$nome.'&
                                                        containerSobrenome='.$sobrenome.'&
                                                        containerIdade='.$idade.'&
                                                        containerPeso='.$peso.'&
                                                        containerAltura='.$altura.'"><span class="material-symbols-outlined">
                                                        edit_note
                                                        </span></a></td>';
                        echo '</tr>';
                    }
                ?>
            </table>
            
            <a href="../html/menu.html"><Button class="botao">Voltar ao Menu</Button></a>
        </div>
    </div>
    <footer>
        <p>Créditos: Johnny Becker e Vinicius Melz - IFSul Venancio Aires - 2024</p>
    </footer>
</body>
</html>