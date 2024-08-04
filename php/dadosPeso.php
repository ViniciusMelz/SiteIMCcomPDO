<?php
include "funcoesBanco.php";
$conexao = conectarBanco();
$array = imcForaDoNormal($conexao);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Dados sobre peso</title>
</head>

<body>
    <header>
        <h4><img src="../assets/logoOMS.png" alt=""></h4>
        <p id="subtexto">Formulário online - OMS IFsul</p>
    </header>
    <div class="wrapper-tabela" id="flexdirectionRow">
        <div class="container-tabela">
            <table class="tabela">
                <tr>
                    <th>Nome<br>Completo</th>
                    <th>Peso<br>(Kg)</th>
                    <th>Classificação</th>
                </tr>
                <?php
                foreach ($array as $id => $dados) {
                    $contador = 0;
                    echo '<tr>';
                    foreach ($dados as $caracteristicas => $valor) {
                        if ($contador == 0) {
                            echo '<td>' . ucwords($valor) . '</td>';
                        } else if($contador == 1) {
                            echo '<td>'. number_format($valor,2,',','') . '</td>';
                        }
                         else {
                            echo '<td>' . $valor . '</td>';
                        }
                        ++$contador;
                    }
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
        <div>
            <div class="card_info" id="div_infoAjuste">
                <?php
                    pesoMedio($conexao);
                ?>
            </div>
            <div class="card_info">
                <?php
                    menorPeso($conexao);
                ?>
            </div>
            <div class="card_info">
                <?php
                    maisPeso($conexao);
                ?>
            </div>
            <div class="card_info">
                <a href="../html/menu.html"><Button class="botao" id="botao_ajusteTamanho">Voltar ao Menu</Button></a>
            </div>
        </div>
    </div>
    <footer>
        <p>Créditos: Johnny Becker e Vinicius Melz - IFsul Venancio Aires - 2024</p>
    </footer>
</body>

</html>