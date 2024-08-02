<?php
function conectarBanco(): PDO
{
    $conectarServidor = "mysql:dbname=localhost;dbname=pessoasIMC;port=3307";
    $usuario = "root";
    $senha = "";
    $nomeBanco = "pessoasIMC";

    $conexao = new PDO($conectarServidor, $usuario, $senha);
    return $conexao;
}

//INSERT
function insert(String $nome, String $sobrenome, int $idade, float $peso, float $altura): void
{
    $conexao = conectarBanco();
    date_default_timezone_set("America/Sao_Paulo");
    $comandoSQL = "insert into pessoas (nome, sobrenome, idade, peso, altura) values (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($comandoSQL);
    $stmt->bindParam(1, $nome, PDO::PARAM_STR);
    $stmt->bindParam(2, $sobrenome, PDO::PARAM_STR);
    $stmt->bindParam(3, $idade, PDO::PARAM_INT);
    $stmt->bindParam(4, $peso, PDO::PARAM_INT);
    $stmt->bindParam(5, $altura, PDO::PARAM_INT);
    $stmt->execute();
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
    $stmt = null;
}

//DELETE
function delete(int $id): void
{
    $conexao = conectarBanco();
    date_default_timezone_set("America/Sao_Paulo");
    //SELECT PARA COLOCAR OS DADOS NA LOG
    $comandoSQLConsulta = "select * from pessoas where id_pessoa = ?";
    $stmt = $conexao->prepare($comandoSQLConsulta);
    $stmt->bindParam(1, $id, PDO::PARAM_INT);

    $stmt->execute();

    $listaPessoas = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($listaPessoas as $row) {
        $nome = $row[1];
        $sobrenome = $row[2];
        $idade = $row[3];
        $peso = $row[4];
        $altura = $row[5];
    }

    $stmt = null;
    //QUERY DO DELETE
    $comandoSQL = "delete from pessoas where id_pessoa = ?";
    $stmt = $conexao->prepare($comandoSQL);
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
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
    $stmt = null;
}

//UPDATE
function update(int $id, String $nome, String $sobrenome, int $idade, float $peso, float $altura): void
{
    $conexao = conectarBanco();
    date_default_timezone_set("America/Sao_Paulo");
    //SELECT PARA COLOCAR OS DADOS NA LOG
    $comandoSQLConsulta = "select * from pessoas where id_pessoa = ?";
    $stmt = $conexao->prepare($comandoSQLConsulta);
    $stmt->bindParam(1, $id, PDO::PARAM_INT);

    $stmt->execute();

    $listaPessoas = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($listaPessoas as $row) {
        $nomeAntigo = $row[1];
        $sobrenomeAntigo = $row[2];
        $idadeAntigo = $row[3];
        $pesoAntigo = $row[4];
        $alturaAntigo = $row[5];
    }

    $stmt = null;
    //QUERY DO UPDATE
    $comandoSQL = "update pessoas set nome = ?, sobrenome = ?, idade = ?, peso = ?, altura = ? where id = ?";
    $stmt = $conexao->prepare($comandoSQLConsulta);
    $stmt->bindParam(1, $nome, PDO::PARAM_STR);
    $stmt->bindParam(2, $sobrenome, PDO::PARAM_STR);
    $stmt->bindParam(3, $idade, PDO::PARAM_INT);
    $stmt->bindParam(4, $peso, PDO::PARAM_INT);
    $stmt->bindParam(5, $altura, PDO::PARAM_INT);
    $stmt->bindParam(6, $id, PDO::PARAM_INT);
    $stmt->execute();
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
    $stmt = null;
}

//SELECT
function select(): array
{
    $arrayAux = array();
    $conexao = conectarBanco();
    $comandoSQL = "select * from pessoas";
    $stmt = $conexao->prepare($comandoSQL);
    $stmt->execute();
    /*
    
    if (mysqli_num_rows($array) > 0) {
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
    */
    $listaPessoas = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach ($listaPessoas as $registro) {
        $arrayAux[$registro->id_pessoa] = array(
            'nome' => $registro->nome,
            'sobrenome' => $registro->sobrenome,
            'idade' => $registro->idade,
            'peso' => $registro->peso,
            'altura' => $registro->altura
        );
    }
    $stmt = null;
    return $arrayAux;
}

//Funções Peso
//Pega o maior peso
function maisPeso(PDO $auxconexao): void
{
    $comandoSQLPessoaMaisPeso = "SELECT peso FROM pessoas ORDER BY peso DESC LIMIT 1";
    $stmt = $auxconexao->prepare($comandoSQLPessoaMaisPeso);
    $stmt->execute();
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        echo "A pessoa mais pesada registrada tem " . number_format(round($row[0], 2), 2, ',', ' ') . " Kg";
    }
    $stmt = null;
}

//Pega o menor peso
function menorPeso(PDO $auxconexao): void
{
    $comandoSQLPessoaMaisLeve = "SELECT peso FROM pessoas ORDER BY peso LIMIT 1";
    $stmt = $auxconexao->prepare($comandoSQLPessoaMaisLeve);
    $stmt->execute();
    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        echo "A pessoa mais leve registrada tem " . number_format(round($row[0], 2), 2, ',', ' ') . " Kg";
    }
    $stmt = null;
}

function pesoMedio(PDO $auxconexao): void
{
    $comandoSQLPesoMedio = "SELECT AVG(peso) FROM pessoas";
    $stmt = $auxconexao->prepare($comandoSQLPesoMedio);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "O peso médio geral é " . number_format(round($row[0], 2), 2, ',', ' ') . " Kg";
    }
}

//Pega os que tão fora do normal
function imcForaDoNormal(PDO $auxconexao): array
{
    $comandoSQLImcForadoNormal = "SELECT concat(nome, ' ' , sobrenome) as nome, peso,
        IF(IMC >= 18.5 AND IMC < 25, 'Normal',
        IF(IMC < 18.5, CONCAT('Abaixo do peso - Deve ganhar ', REPLACE(ROUND((18.5 * altura * altura - peso), 2), '.', ','), ' kg'),
        CONCAT('Acima do peso - Deve perder ', REPLACE(ROUND((peso - 24.9 * altura * altura), 2), '.', ','), ' kg'))) AS classificacao
        FROM ( SELECT  nome, sobrenome, peso, altura,peso / (altura * altura) AS IMC FROM pessoas) AS IMC_calc
        WHERE calcular_imc(peso, altura) < 18.5 OR calcular_imc(peso, altura) >= 25";
    $stmt = $auxconexao->prepare($comandoSQLImcForadoNormal);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $arrayAux = [];
    foreach ($row as $registro) {
        $arrayAux[] = array(
            'nome' => $registro['nome'],
            'peso' => $registro['peso'],
            'classificacao' => $registro['classificacao']
        );
    }
    return $arrayAux;
}

//Funções para Idade
function pessoaMaisVelhaeIdade(PDO $conexao): void
{
    $comandoSQLPessoaMaisVelhaeIdade = "SELECT CONCAT(nome,' ', sobrenome) as nome, idade FROM pessoas ORDER BY idade DESC LIMIT 1";
    $stmt = $conexao->prepare($comandoSQLPessoaMaisVelhaeIdade);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "<h1>Pessoa mais Velha:</h1>
              <div class='balaoTextoIdadesExtremos'>
                  <h2>Nome: " . ucwords($row['nome']) . "</h2>
              </div>
              <div class='balaoTextoIdadesExtremos'>
                  <h2>Idade: " . $row['idade'] . " anos</h2>
              </div>";
    }
}

function pessoaMaisNovaIdadeeAltura(PDO $conexao): void
{
    $comandoSQLPessoaMaisNovaIdadeeAltura = "SELECT CONCAT(nome,' ', sobrenome) as nome, idade, altura FROM pessoas ORDER BY idade LIMIT 1";
    $stmt = $conexao->prepare($comandoSQLPessoaMaisNovaIdadeeAltura);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "<h1>Pessoa mais Nova:</h1>
              <div class='balaoTextoIdadesExtremos'>
                  <h2>Nome: " . ucwords($row['nome']) . "</h2>
              </div>
              <div class='balaoTextoIdadesExtremos'>
                  <h2>Idade: " . $row['idade'] . " anos</h2>
              </div>
              <div class='balaoTextoIdadesExtremos'>
                  <h2>Altura: " . number_format($row['altura'], 2, ',', '') . " Metros</h2>
              </div>";
    }
}

function mediaIdades(PDO $conexao): void
{
    $comandoSQLMedia = "SELECT ROUND(AVG(idade)) FROM pessoas";
    $stmt = $conexao->prepare($comandoSQLMedia);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "<h1>Idade Média: " . $row['ROUND(AVG(idade))'] . " anos</h1>";
    }

    function quantidadeAcimaMedia(PDO $conexao): int
    {
        $comandoSQLQuantidade = "SELECT count(nome) FROM pessoas WHERE idade > (SELECT AVG(idade) FROM pessoas)";
        $stmt = $conexao->prepare($comandoSQLQuantidade);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int) $row['count(nome)'] : 0;
    }

    function acimaMedia(PDO $conexao): array
    {
        $comandoSQLAcimaMedia = "SELECT concat(nome, ' ', sobrenome) AS nome, idade FROM pessoas WHERE idade > (SELECT AVG(idade) FROM pessoas) ORDER BY 2";
        $stmt = $conexao->prepare($comandoSQLAcimaMedia);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arrayAux = [];
        foreach ($result as $registro) {
            $arrayAux[] = array(
                'nome' => $registro['nome'],
                'idade' => $registro['idade']
            );
        }
        $stmt = null;
        $conexao = null;
        return $arrayAux;
        

    }

    function quantidadeAbaixoMedia(PDO $conexao): int
    {
        $comandoSQLAbaixoMedia = "SELECT COUNT(*) FROM pessoas WHERE idade < (SELECT AVG(idade) FROM pessoas)";
        $stmt = $conexao->prepare($comandoSQLAbaixoMedia);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? (int) $row['COUNT(*)'] : 0;
    }

    function abaixoMedia(PDO $conexao): array
    {
        $comandoSQLAbaixoMedia = "SELECT concat(nome, ' ', sobrenome) AS nome, idade FROM pessoas WHERE idade < (SELECT AVG(idade) FROM pessoas) ORDER BY 2";
        $stmt = $conexao->prepare($comandoSQLAbaixoMedia);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $arrayAux = [];
        foreach ($result as $registro) {
            $arrayAux[] = array(
                'nome' => $registro['nome'],
                'idade' => $registro['idade']
            );
        }
        return $arrayAux;
    }

    function imc3MaiorIdade(PDO $conexao): array
    {
        $comandoSQLIMC3MaiorIdade = "SELECT concat(nome, ' ', sobrenome) AS nome, calcular_imc(peso, altura) as imc, idade FROM pessoas ORDER BY idade DESC LIMIT 3";
        $stmt = $conexao->prepare($comandoSQLIMC3MaiorIdade);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $arrayAux = [];
        foreach ($result as $registro) {
            $arrayAux[] = array(
                'nome' => $registro['nome'],
                'imc' => $registro['imc'],
                'idade' => $registro['idade']
            );
        }
        return $arrayAux;
    }

    function imc5MenorIdade(PDO $conexao): array
    {
        $comandoSQLIMC5MenorIdade = "SELECT concat(nome, ' ', sobrenome) AS nome, calcular_imc(peso, altura) as imc, idade FROM pessoas ORDER BY idade LIMIT 5";
        $stmt = $conexao->prepare($comandoSQLIMC5MenorIdade);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $arrayAux = [];
        foreach ($result as $registro) {
            $arrayAux[] = array(
                'nome' => $registro['nome'],
                'imc' => $registro['imc'],
                'idade' => $registro['idade']
            );
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
}
