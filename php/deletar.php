<?php
    include("funcoesBanco.php");
    $id = $_GET['containerDelete'];
    delete($id);
    $new_url = "dadosTabela.php";
    header('Location: '.$new_url);
    die();
