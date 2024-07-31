<?php
function conectarBanco(): mysqli
{
    $localServidor = "localhost";
    $usuario = "root";
    $senha = "";
    $nomeBanco = "pessoasIMC";

    $conexao = mysqli_connect($localServidor, $usuario, $senha, $nomeBanco, 3307);
    return $conexao;
}

//INSERT
function insert(String $nome, String $sobrenome, int $idade, float $peso, float $altura): void
{
    $conexao = conectarBanco();
    date_default_timezone_set("America/Sao_Paulo");
    $comandoSQL = "insert into pessoas (nome, sobrenome, idade, peso, altura) values ('" . $nome . "','" . $sobrenome . "'," . $idade . "," . $peso . "," . $altura . ")";
    $retornoBanco = mysqli_query($conexao, $comandoSQL) or die(mysqli_error($conexao));
    mysqli_close($conexao);
    file_put_contents("../operacoes_bd.txt", file_get_contents("../operacoes_bd.txt") . "
INSERT:" . "
NOME: " . $nome . "
SOBRENOME: " . $sobrenome . "
IDADE: " . $idade . "
PESO: " . $peso . "
ALTURA: " . $altura . "
QUERY: " . $comandoSQL . "
DATA E HORA: " . $agora = date('d/m/Y H:i') . "
");
}

//DELETE
function delete(int $id): void
{
    $conexao = conectarBanco();
    date_default_timezone_set("America/Sao_Paulo");
    //SELECT PARA COLOCAR OS DADOS NA LOG
    $comandoSQLConsulta = "select * from pessoas where id_pessoa=" . $id;
    $retornoBancoConsulta = mysqli_query($conexao, $comandoSQLConsulta) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoConsulta)) {
        $nome = $row[1];
        $sobrenome = $row[2];
        $idade = $row[3];
        $peso = $row[4];
        $altura = $row[5];
    }
    //QUERY DO DELETE
    $comandoSQL = "delete from pessoas where id_pessoa=" . $id;
    $retornoBanco = mysqli_query($conexao, $comandoSQL) or die(mysqli_error($conexao));
    mysqli_close($conexao);
    file_put_contents("../operacoes_bd.txt", file_get_contents("../operacoes_bd.txt") . "
DELETE:" . "
ID: " . $id . "
NOME: " . $nome . "
SOBRENOME: " . $sobrenome . "
IDADE: " . $idade . "
PESO: " . $peso . "
ALTURA: " . $altura . "
QUERY: " . $comandoSQL . "
DATA E HORA: " . $agora = date('d/m/Y H:i') . "
");
}

//UPDATE
function update(int $id, String $nome, String $sobrenome, int $idade, float $peso, float $altura): void
{
    $conexao = conectarBanco();
    date_default_timezone_set("America/Sao_Paulo");
    //SELECT PARA COLOCAR OS DADOS NA LOG
    $comandoSQLConsulta = "select * from pessoas where id_pessoa=" . $id;
    $retornoBancoConsulta = mysqli_query($conexao, $comandoSQLConsulta) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoConsulta)) {
        $nomeAntigo = $row[1];
        $sobrenomeAntigo = $row[2];
        $idadeAntigo = $row[3];
        $pesoAntigo = $row[4];
        $alturaAntigo = $row[5];
    }
    $comandoSQL = "update pessoas set nome='" . $nome . "', sobrenome='" . $sobrenome . "', idade=" . $idade . ", peso=" . $peso . ", altura=" . $altura . " where id_pessoa=" . $id;
    $retornoBanco = mysqli_query($conexao, $comandoSQL) or die(mysqli_error($conexao));
    mysqli_close($conexao);
    file_put_contents("../operacoes_bd.txt", file_get_contents("../operacoes_bd.txt") . "
UPDATE:" . "
DADOS ANTIGOS:" . "
ID ANTIGO: " . $id . "
NOME ANTIGO: " . $nomeAntigo . "
SOBRENOME ANTIGO: " . $sobrenomeAntigo . "
IDADE ANTIGO: " . $idadeAntigo . "
PESO ANTIGO: " . $pesoAntigo . "
ALTURA ANTIGO: " . $alturaAntigo . "
DADOS ATUALIZADOS:" . "
ID: " . $id . "
NOME: " . $nome . "
SOBRENOME: " . $sobrenome . "
IDADE: " . $idade . "
PESO: " . $peso . "
ALTURA: " . $altura . "
QUERY: " . $comandoSQL . "
DATA E HORA: " . $agora = date('d/m/Y H:i') . "
");
}

//SELECT
function select(): array
{
    $arrayAux = array();
    $conexao = conectarBanco();
    $comandoSQL = "select * from pessoas";
    $retornoBanco = mysqli_query($conexao, $comandoSQL) or die(mysqli_error($conexao));
    if (mysqli_num_rows($retornoBanco) > 0) {
        while ($registro = mysqli_fetch_array($retornoBanco)) {
            $arrayAux[$registro['id_pessoa']] = array(
                'nome' => $registro['nome'],
                'sobrenome' => $registro['sobrenome'],
                'idade' => $registro['idade'],
                'peso' => $registro['peso'],
                'altura' => $registro['altura']
            );
        }
    }
    return $arrayAux;
}

//Funções Peso
//Pega o maior peso
function maisPeso(mysqli $auxconexao): void
{
    $comandoSQLPessoaMaisPeso = "SELECT peso FROM pessoas ORDER BY peso DESC LIMIT 1";
    $retornoBancoMaisPeso = mysqli_query($auxconexao, $comandoSQLPessoaMaisPeso) or die(mysqli_error($auxconexao));
    while ($row = mysqli_fetch_array($retornoBancoMaisPeso)) {
        echo "A pessoa mais pesada registrada tem " . number_format(round($row[0], 2), 2, ',', ' ') . " Kg";
    }
}

//Pega o menor peso
function menorPeso(mysqli $auxconexao): void
{
    $comandoSQLPessoaMaisLeve = "SELECT peso FROM pessoas ORDER BY peso LIMIT 1";
    $retornoBancoMaisLeve = mysqli_query($auxconexao, $comandoSQLPessoaMaisLeve) or die(mysqli_error($auxconexao));
    while ($row = mysqli_fetch_array($retornoBancoMaisLeve)) {
        echo "A pessoa mais leve registrada tem " . number_format(round($row[0], 2), 2, ',', ' ') . " Kg";
    }
}

function pesoMedio(mysqli $auxconexao): void
{
    $comandoSQLPesoMedio = "SELECT AVG(peso) FROM pessoas";
    $retornoBancoPesoMedio = mysqli_query($auxconexao, $comandoSQLPesoMedio) or die(mysqli_error($auxconexao));
    while ($row = mysqli_fetch_array($retornoBancoPesoMedio)) {
        echo "O peso médio geral é " . number_format(round($row[0], 2), 2, ',', ' ') . " Kg";
    }
}

//Pega os que tão fora do normal
function imcForaDoNormal(mysqli $auxconexao): array
{
    $comandoSQLImcForadoNormal = "SELECT concat(nome, ' ' , sobrenome) as nome, peso,
        IF(IMC >= 18.5 AND IMC < 25, 'Normal',
        IF(IMC < 18.5, CONCAT('Abaixo do peso - Deve ganhar ', REPLACE(ROUND((18.5 * altura * altura - peso), 2), '.', ','), ' kg'),
        CONCAT('Acima do peso - Deve perder ', REPLACE(ROUND((peso - 24.9 * altura * altura), 2), '.', ','), ' kg'))) AS classificacao
        FROM ( SELECT  nome, sobrenome, peso, altura,peso / (altura * altura) AS IMC FROM pessoas) AS IMC_calc
        WHERE calcular_imc(peso, altura) < 18.5 OR calcular_imc(peso, altura) >= 25";
    $retornoBancoImcForadoNormal = mysqli_query($auxconexao, $comandoSQLImcForadoNormal) or die(mysqli_error($auxconexao));
    if (mysqli_num_rows($retornoBancoImcForadoNormal) > 0) {
        while ($registro = mysqli_fetch_array($retornoBancoImcForadoNormal)) {
            $arrayAux[] = array(
                'nome' => $registro['nome'],
                'peso' => $registro['peso'],
                'classificacao' => $registro['classificacao']
            );
        }
    }
    return $arrayAux;
}

//Funções para Idade
function pessoaMaisVelhaeIdade(mysqli $conexao): void
{
    $comandoSQLPessoaMaisVelhaeIdade = "SELECT CONCAT(nome,' ', sobrenome) as nome, idade FROM pessoas ORDER BY idade DESC LIMIT 1";
    $retornoBancoPessoaMaisVelhaeIdade = mysqli_query($conexao, $comandoSQLPessoaMaisVelhaeIdade) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoPessoaMaisVelhaeIdade)) {
        echo "<h1>Pessoa mais Velha:</h1>
                <div class='balaoTextoIdadesExtremos'>
                    <h2>Nome: " . ucwords($row[0]) . "</h2>
                </div>
                <div class='balaoTextoIdadesExtremos'>
                    <h2>Idade: " . $row[1] . " anos</h2>
                </div>";
    }
}

function pessoaMaisNovaIdadeeAltura(mysqli $conexao): void
{
    $comandoSQLPessoaMaisNovaIdadeeAltura = "SELECT CONCAT(nome,' ', sobrenome) as nome, idade, altura FROM pessoas ORDER BY idade LIMIT 1";
    $retornoBancoPessoaMaisNovaIdadeeAltura = mysqli_query($conexao, $comandoSQLPessoaMaisNovaIdadeeAltura) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoPessoaMaisNovaIdadeeAltura)) {
        echo "<h1>Pessoa mais Nova:</h1>
                <div class='balaoTextoIdadesExtremos'>
                    <h2>Nome: " . ucwords($row[0]) . "</h2>
                </div>
                <div class='balaoTextoIdadesExtremos'>
                    <h2>Idade: " . $row[1] . " anos</h2>
                </div>
                <div class='balaoTextoIdadesExtremos'>
                    <h2>Altura: " . number_format($row[2], 2, ',', '') . " Metros</h2>
                </div>";
    }
}

function mediaIdades(mysqli $conexao): void
{
    $comandoSQLMedia = "SELECT ROUND(AVG(idade)) FROM pessoas";
    $retornoBancoMedia = mysqli_query($conexao, $comandoSQLMedia) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoMedia)) {
        echo "<h1>Idade Média: " . $row[0] . " anos</h1>";
    }
}

function quantidadeAcimaMedia(mysqli $conexao): int{
    $comandoSQLQuantidade = "SELECT count(nome) FROM pessoas WHERE idade > (SELECT AVG(idade) FROM pessoas)";
    $retornoBancoQuantidade = mysqli_query($conexao, $comandoSQLQuantidade) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoQuantidade)) {
        $quantidade = $row[0];
    }
    return $quantidade;
}

function acimaMedia(mysqli $conexao): array{
    $comandoSQLAcimaMedia = "SELECT concat(nome, ' ', sobrenome) AS nome, idade FROM pessoas WHERE idade > (SELECT AVG(idade) FROM pessoas) ORDER BY 2";
    $retornoBancoAcimaMedia = mysqli_query($conexao, $comandoSQLAcimaMedia) or die(mysqli_error($conexao));
    if (mysqli_num_rows($retornoBancoAcimaMedia) > 0) {
        while ($registro = mysqli_fetch_array($retornoBancoAcimaMedia)) {
            $arrayAux[] = array(
                'nome' => $registro['nome'],
                'idade' => $registro['idade']
            );
        }
    }
    return $arrayAux;
}

function quantidadeAbaixoMedia(mysqli $conexao): int{
    $comandoSQLAbaixoMedia = "SELECT COUNT(*) FROM pessoas WHERE idade < (SELECT AVG(idade) FROM pessoas)";
    $retornoBancoAbaixoMedia = mysqli_query($conexao, $comandoSQLAbaixoMedia) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoAbaixoMedia)) {
        $quantidade = $row[0];
    }
    return $quantidade;
}

function abaixoMedia(mysqli $conexao): array{
    $comandoSQLAbaixoMedia = "SELECT concat(nome, ' ', sobrenome) AS nome, idade FROM pessoas WHERE idade < (SELECT AVG(idade) FROM pessoas) ORDER BY 2";
    $retornoBancoAbaixoMedia = mysqli_query($conexao, $comandoSQLAbaixoMedia) or die(mysqli_error($conexao));
    if (mysqli_num_rows($retornoBancoAbaixoMedia) > 0) {
        while ($registro = mysqli_fetch_array($retornoBancoAbaixoMedia)) {
            $arrayAux[] = array(
                'nome' => $registro['nome'],
                'idade' => $registro['idade']
            );
        }
    }
    return $arrayAux;
}

function imc3MaiorIdade(mysqli $conexao): array{
    $comandoSQLIMC3MaiorIdade = "SELECT concat(nome, ' ', sobrenome) AS nome, calcular_imc(peso, altura) as imc, idade FROM pessoas ORDER BY idade DESC LIMIT 3";
    $retornoBancoIMC3MaiorIdade = mysqli_query($conexao, $comandoSQLIMC3MaiorIdade) or die(mysqli_error($conexao));
    if (mysqli_num_rows($retornoBancoIMC3MaiorIdade) > 0) {
        while ($registro = mysqli_fetch_array($retornoBancoIMC3MaiorIdade)) {
            $arrayAux[] = array(
                'nome' => $registro['nome'],
                'imc' => $registro['imc'],
                'idade' => $registro['idade']
            );
        }
    }
    return $arrayAux;
}

function imc5MenorIdade(mysqli $conexao): array{
    $comandoSQLIMC5MenorIdade = "SELECT concat(nome, ' ', sobrenome) AS nome, calcular_imc(peso, altura) as imc, idade FROM pessoas ORDER BY idade LIMIT 5";
    $retornoBancoIMC5MenorIdade = mysqli_query($conexao, $comandoSQLIMC5MenorIdade) or die(mysqli_error($conexao));
    if (mysqli_num_rows($retornoBancoIMC5MenorIdade) > 0) {
        while ($registro = mysqli_fetch_array($retornoBancoIMC5MenorIdade)) {
            $arrayAux[] = array(
                'nome' => $registro['nome'],
                'imc' => $registro['imc'],
                'idade' => $registro['idade']
            );
        }
    }
    return $arrayAux;
}

//Funções IMC
function nomeIMCs(mysqli $conexao): array
{
    $comandoSQLNomeEIMC = "SELECT concat(nome, ' ', sobrenome) AS nome, calcular_imc(peso, altura) AS imc FROM pessoas ORDER BY 2";
    $retornoBancoNomeEIMC = mysqli_query($conexao, $comandoSQLNomeEIMC) or die(mysqli_error($conexao));
    if (mysqli_num_rows($retornoBancoNomeEIMC) > 0) {
        while ($registro = mysqli_fetch_array($retornoBancoNomeEIMC)) {
            $arrayAux[] = array(
                'nome' => $registro['nome'],
                'imc' => $registro['imc']
            );
        }
    }
    return $arrayAux;
}

function tipoCategoriaIMC(float $imc): String
{
    $classificacao = "";
    if ($imc < 18.5) {
        $classificacao = "Abaixo do Normal";
    } else if ($imc < 25) {
        $classificacao = "Normal";
    } else if ($imc < 30) {
        $classificacao = "Sobrepeso";
    } else if ($imc < 35) {
        $classificacao = "Obesidade Grau I";
    } else if ($imc < 40) {
        $classificacao = "Obesidade Grau II";
    } else if ($imc > 40) {
        $classificacao = "Obesidade Grau III";
    }




    return $classificacao;
}

function quantidadeAbaixoDoPeso(mysqli $conexao): int
{
    $comandoSQLQuantidadeAbaixoDoPeso = "SELECT count(calcular_imc(peso, altura)) AS qntIMC FROM pessoas WHERE calcular_imc(peso, altura) < 18.5";
    $retornoBancoQuantidadeAbaixoDoPeso = mysqli_query($conexao, $comandoSQLQuantidadeAbaixoDoPeso) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoQuantidadeAbaixoDoPeso)) {
        return $row[0];
    }
}

function quantidadeNormal(mysqli $conexao): int
{
    $comandoSQLQuantidadeNormal = "SELECT count(calcular_imc(peso, altura)) AS qntIMC FROM pessoas WHERE calcular_imc(peso, altura) >= 18.5 AND calcular_imc(peso, altura) < 25";
    $retornoBancoQuantidadeNormal = mysqli_query($conexao, $comandoSQLQuantidadeNormal) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoQuantidadeNormal)) {
        return $row[0];
    }
}

function quantidadeSobrepeso(mysqli $conexao): int
{
    $comandoSQLQuantidadeSobrepeso = "SELECT count(calcular_imc(peso, altura)) AS qntIMC FROM pessoas WHERE calcular_imc(peso, altura) >= 25 AND calcular_imc(peso, altura) < 30";
    $retornoBancoQuantidadeSobrepeso = mysqli_query($conexao, $comandoSQLQuantidadeSobrepeso) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoQuantidadeSobrepeso)) {
        return $row[0];
    }
}

function quantidadeObesidadeGrau1(mysqli $conexao): int
{
    $comandoSQLQuantidadeObesidadeGrau1 = "SELECT count(calcular_imc(peso, altura)) AS qntIMC FROM pessoas WHERE calcular_imc(peso, altura) >= 30 AND calcular_imc(peso, altura) < 35";
    $retornoBancoQuantidadeObesidadeGrau1 = mysqli_query($conexao, $comandoSQLQuantidadeObesidadeGrau1) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoQuantidadeObesidadeGrau1)) {
        return $row[0];
    }
}

function quantidadeObesidadeGrau2(mysqli $conexao): int
{
    $comandoSQLQuantidadeObesidadeGrau2 = "SELECT count(calcular_imc(peso, altura)) AS qntIMC FROM pessoas WHERE calcular_imc(peso, altura) >= 35 AND calcular_imc(peso, altura) < 40";
    $retornoBancoQuantidadeObesidadeGrau2 = mysqli_query($conexao, $comandoSQLQuantidadeObesidadeGrau2) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoQuantidadeObesidadeGrau2)) {
        return $row[0];
    }
}

function quantidadeObesidadeGrau3(mysqli $conexao): int
{
    $comandoSQLQuantidadeObesidadeGrau3 = "SELECT count(calcular_imc(peso, altura)) AS qntIMC FROM pessoas WHERE calcular_imc(peso, altura) >= 40";
    $retornoBancoQuantidadeObesidadeGrau3 = mysqli_query($conexao, $comandoSQLQuantidadeObesidadeGrau3) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoQuantidadeObesidadeGrau3)) {
        return $row[0];
    }
}

function mediaIMC(mysqli $conexao): float
{
    $comandoSQLMediaIMC = "SELECT avg(calcular_imc(peso, altura)) AS IMCMedio FROM pessoas";
    $retornoBancoMediaIMC = mysqli_query($conexao, $comandoSQLMediaIMC) or die(mysqli_error($conexao));
    while ($row = mysqli_fetch_array($retornoBancoMediaIMC)) {
        return $row[0];
    }
}