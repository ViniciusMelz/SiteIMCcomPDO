<?php
    include("funcoesBanco.php");
    $id = $_GET['containerId'];
    $nome = $_GET['containerNome'];
    $sobrenome = $_GET['containerSobrenome'];
    $idade = $_GET['containerIdade'];
    $peso = $_GET['containerPeso'];
    $altura = $_GET['containerAltura'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Atualização de Dados</title>
</head>
<body>
    <header>
        <h4><img src="../assets/logoOMS.png" alt=""></h4>
        <p id="subtexto">Formulário online - OMS IFsul</p>
    </header>
    <div class="wrapper-form">
        <form class="form-dados" action="../php/processarUpdate.php" method="post">
            <h1>Editar Dados</h1>
            <input type="hidden" name="containerId" required value="<?php echo $id?>">
            <label>Nome:</label>
            <input type="text" name="containerNome" required value="<?php echo $nome?>">
            <label>Sobrenome:</label>
            <input type="text" name="containerSobrenome" required value="<?php echo $sobrenome?>">
            <label>Idade:</label>
            <input type="number" name="containerIdade" required value="<?php echo $idade?>">
            <label>Peso:</label>
            <input type="number" name="containerPeso" required value="<?php echo $peso?>">
            <label>Altura:</label>
            <input type="number" name="containerAltura" step="0.01" required value="<?php echo $altura?>">
            <input type="submit" value="Atualizar Dados">
        </form>
    </div>
    <footer>
        <p>Créditos: Johnny Becker e Vinicius Melz - IFsul Venancio Aires - 2024</p>
    </footer>
</body>
</html>