<?php
    include("funcoesBanco.php");
    $nome = $_POST['containerNome'];
    $sobrenome = $_POST['containerSobrenome'];
    $idade = $_POST['containerIdade'];
    $peso = $_POST['containerPeso'];
    $altura = $_POST['containerAltura'];
    insert($nome, $sobrenome, $idade, $peso, $altura);
    $new_url = "../html/indexForm.html";
    header('Location: '.$new_url);
    die();
