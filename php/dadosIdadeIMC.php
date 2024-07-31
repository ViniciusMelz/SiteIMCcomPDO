<?php
include "funcoesBanco.php";
$conexao = conectarBanco();
$arrayMaiorIdade = imc3MaiorIdade($conexao);
$arrayMenorIdade = imc5MenorIdade($conexao);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>IDADES - IMC</title>
</head>

<body>
    <header>
        <h4><img src="../assets/logoOMS.png" alt=""></h4>
        <p id="subtexto">Dados idade - OMS IFsul</p>
    </header>
    <div class="wrapper-idade" id="displayColumn">
        <div class="menuIdades">
            <a href="dadosIdadeExtremos.php"><button class="botao">Idades - Extremos</button></a>
            <a href="dadosIdadeMedias.php"><button class="botao">Idades - Médias</button></a>
            <a href="dadosIdadeIMC.php"><button class="botao">Idades - IMC</button></a>
            <a href="../html/menu.html"><button class="botao">Voltar ao Menu</button></a>
        </div>

        <div id="divConteudoTabelasIMC">
            <div class="divTabelasIMC">
                <h1>3 Pessoas mais velhas e seus respectivos IMCs</h1>
                <table class="tabela">
                    <tr>
                        <th>Nome<br>Completo</th>
                        <th>IMC</th>
                        <th>Idade</th>
                    </tr>
                    <?php
                    foreach ($arrayMaiorIdade as $id => $dados) {
                        $contador = 0;
                        echo '<tr>';
                        foreach ($dados as $caracteristicas => $valor) {
                            if ($contador == 0) {
                                $nome = $valor;
                                echo '<td>' . ucwords($nome) . '</td>';
                            } else if ($contador == 1) {
                                $imc = $valor;
                                echo '<td>' . number_format($valor, 2, ',', '') . '</td>';
                            }else{
                                echo '<td>' . $valor . '</td>';
                            }
                            ++$contador;
                        }
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
            <div class="divTabelasIMC">
                <h1>5 Pessoas mais novas e seus respectivos IMCs</h1>
                <table class="tabela">
                    <tr>
                        <th>Nome<br>Completo</th>
                        <th>IMC</th>
                        <th>Idade</th>
                    </tr>
                    <?php
                    foreach ($arrayMenorIdade as $id => $dados) {
                        $contador = 0;
                        echo '<tr>';
                        foreach ($dados as $caracteristicas => $valor) {
                            if ($contador == 0) {
                                $nome = $valor;
                                echo '<td>' . ucwords($nome) . '</td>';
                            } else if ($contador == 1) {
                                $imc = $valor;
                                echo '<td>' . number_format($valor, 2, ',', '') . '</td>';
                            }else{
                                echo '<td>' . $valor . '</td>';
                            }
                            ++$contador;
                        }
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <footer>
        <p>Créditos: Johnny Becker e Vinicius Melz - IFsul Venancio Aires - 2024</p>
    </footer>
</body>

</html>