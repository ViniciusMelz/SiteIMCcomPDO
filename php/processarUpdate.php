<?php
    include("funcoesBanco.php");
    $id = $_POST['containerId'];
    $nome = $_POST['containerNome'];
    $sobrenome = $_POST['containerSobrenome'];
    $idade = $_POST['containerIdade'];
    $peso = $_POST['containerPeso'];
    $altura = $_POST['containerAltura'];
    update($id, $nome, $sobrenome, $idade, $peso, $altura);
    $new_url = "dadosTabela.php";
    header('Location: '.$new_url);
    die();