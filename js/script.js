function mostraAcimaIdade(){
    var divAcimaIdade = document.getElementById("DivAcimaMedia");
    var divAbaixoIdade = document.getElementById("DivAbaixoMedia");
    var labelIdadesMedias = document.getElementById("labelIdadesMedias");
    divAbaixoIdade.style.zIndex = -1;
    divAbaixoIdade.style.position = "absolute";
    labelIdadesMedias.textContent = "Pessoas Acima da Média";
    divAcimaIdade.style.zIndex = 0;
    divAcimaIdade.style.position = "relative";
    
}

function mostraAbaixoIdade(){
    var divAcimaIdade = document.getElementById("DivAcimaMedia");
    var divAbaixoIdade = document.getElementById("DivAbaixoMedia");
    var labelIdadesMedias = document.getElementById("labelIdadesMedias");
    divAcimaIdade.style.zIndex = -1;
    divAcimaIdade.style.position = "absolute";
    labelIdadesMedias.textContent = "Pessoas Abaixo da Média";
    divAbaixoIdade.style.zIndex = 0;
    divAbaixoIdade.style.position = "relative";
}

function validarExclusao(){
    if (window.confirm("Você realmente quer excluir esse item?")) {
        window.open("deletar.php", "Deletado com sucesso");
    }
}