<?php
include "funcoesBanco.php";
$conexao = conectarBanco();
$array = nomeIMCs($conexao);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
                ['Abaixo do Peso', <?php echo quantidadeAbaixoDoPeso($conexao); ?>],
                ['Normal', <?php echo quantidadeNormal($conexao); ?>],
                ['Sobrepeso', <?php echo quantidadeSobrepeso($conexao); ?>],
                ['Obesidade Grau I', <?php echo quantidadeObesidadeGrau1($conexao); ?>],
                ['Obesidade Grau II', <?php echo quantidadeObesidadeGrau2($conexao); ?>],
                ['Obesidade Grau III', <?php echo quantidadeObesidadeGrau3($conexao); ?>]
            ]);

            var options = {
                'title': 'Percentuais dos Graus de Obesidade',
                'width': 600,
                'height': 400,
                'fontSize': 18
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Dados Sobre IMC</title>
</head>

<body>
    <header>
        <h4><img src="../assets/logoOMS.png" alt=""></h4>
        <p id="subtexto">Dados - Índice de Massa Corporal</p>
    </header>
    <div class="wrapper-tabela" id="flexdirectionRow">
        <div class="container-tabela">
            <table class="tabela">
                <tr>
                    <th>Nome<br>Completo</th>
                    <th>IMC</th>
                    <th>Grau de<br>Obesidade</th>
                </tr>
                <?php
                foreach ($array as $id => $dados) {
                    $contador = 0;
                    echo '<tr>';
                    foreach ($dados as $caracteristicas => $valor) {
                        if ($contador == 0) {
                            $nome = $valor;
                            echo '<td>' . ucwords($nome) . '</td>';
                        } else if ($contador == 1) {
                            $imc = $valor;
                            echo '<td>' . number_format($valor,2,',','') . '</td>';
                            $classificacao = tipoCategoriaIMC($imc);
                            echo '<td>' . $classificacao . '</td>';
                        }
                        ++$contador;
                    }
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
        <div>
            <div id="div_grafico">
                <div id="chart_div"></div>
            </div>
            <div class="card_info">
                <?php
                    echo "A média do IMC Geral é " . number_format(round(mediaIMC($conexao),2), 2, ',', ' ')."!";
                ?>
            </div>
            <div class="card_info">
                <a href="../html/menu.html"><Button class="botao" id="botao_ajusteTamanho">Voltar ao Menu</Button></a>
            </div>
        </div>
    </div>
    <footer>
        <p>Créditos: Johnny Becker e Vinicius Melz - IFSul Venancio Aires - 2024</p>
    </footer>
</body>

</html>