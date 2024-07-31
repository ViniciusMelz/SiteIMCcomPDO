<?php
include "funcoesBanco.php";
$conexao = conectarBanco();
$arrayAcimaMedia = acimaMedia($conexao);
$arrayAbaixoMedia = abaixoMedia($conexao);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <script type="text/javascript" src="../js/script.js"></script>
    <title>IDADES - Médias</title>
</head>

<body>
    <header>
        <h4><img src="../assets/logoOMS.png" alt=""></h4>
        <p id="subtexto">Dados idade - OMS IFsul</p>
    </header>
    <div class="wrapper-idade">
        <div class="menuIdades">
            <a href="dadosIdadeExtremos.php"><button class="botao">Idades - Extremos</button></a>
            <a href="dadosIdadeMedias.php"><button class="botao">Idades - Médias</button></a>
            <a href="dadosIdadeIMC.php"><button class="botao">Idades - IMC</button></a>
            <a href="../html/menu.html"><button class="botao">Voltar ao Menu</button></a>
        </div>

        <div id="divConteudoIdadeMedia">
            <div class="containerIdadesMedias" id="tamanhoMinTabelaIdadesMedias">
                <h1 id="labelIdadesMedias"></h1>
                <div id="DivAbaixoMedia">
                    <table class="tabela">
                        <tr>
                            <th>Nome<br>Completo</th>
                            <th>Idade</th>
                        </tr>
                        <?php
                        foreach ($arrayAbaixoMedia as $id => $dados) {
                            $contador = 0;
                            echo '<tr>';
                            foreach ($dados as $caracteristicas => $valor) {
                                if ($contador == 0) {
                                    $nome = $valor;
                                    echo '<td>' . ucwords($nome) . '</td>';
                                } else {
                                    echo '<td>' . $valor . '</td>';
                                }
                                ++$contador;
                            }
                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>

                <div id="DivAcimaMedia">
                    <table class="tabela">
                        <tr>
                            <th>Nome<br>Completo</th>
                            <th>Idade</th>
                        </tr>
                        <?php
                        foreach ($arrayAcimaMedia as $id => $dados) {
                            $contador = 0;
                            echo '<tr>';
                            foreach ($dados as $caracteristicas => $valor) {
                                if ($contador == 0) {
                                    $nome = $valor;
                                    echo '<td>' . ucwords($nome) . '</td>';
                                } else {
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
            <div>
                <div class="cardIdadesMedias">
                    <?php mediaIdades($conexao) ?>
                </div>
                <div class="cardIdadesMedias">
                    <?php echo "<h1>Existem ".quantidadeAcimaMedia($conexao)." pessoas acima da média.</h1>" ?>
                    <button class="botao" type="button" onclick="mostraAcimaIdade();">Visualizar</button>
                </div>
                <div class="cardIdadesMedias">
                <?php echo "<h1>Existem ".quantidadeAbaixoMedia($conexao)." pessoas abaixo da média.</h1>" ?>
                    <button class="botao" type="button" onclick="mostraAbaixoIdade();">Visualizar</button>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>Créditos: Johnny Becker e Vinicius Melz - IFsul Venancio Aires - 2024</p>
    </footer>
</body>

</html>