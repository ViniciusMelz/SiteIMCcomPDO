<?php
include "funcoesBanco.php";
$conexao = conectarBanco();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>IDADES - Extremos</title>
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
        <div class="rowIdadesExtremos">
            <div class="cardIdadesExtremos">
                <?php pessoaMaisVelhaeIdade($conexao); ?>
            </div>
            <div class="cardIdadesExtremos">
                <?php pessoaMaisNovaIdadeeAltura($conexao); ?>
            </div>
        </div>
    </div>
    <footer>
        <p>Créditos: Johnny Becker e Vinicius Melz - IFsul Venancio Aires - 2024</p>
    </footer>
</body>

</html>