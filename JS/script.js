// Abre modal e preenche dados
function abrirDetalhes(nome, descricao, imagem) {
    // Abre o modal
    document.getElementById("modal").classList.add("ativo");

    // Preenche os detalhes
    document.getElementById("detalhesNome").innerText = nome;
    document.getElementById("barbeiro").value = nome;
    document.getElementById("detalhesDescricao").innerText = descricao;
    document.getElementById("detalhesImagem").src = imagem;

    gerarHorarios();
}

// Fecha modal ao clicar fora
window.onclick = function (e) {
    if (e.target.id === "modal") {
        document.getElementById("modal").classList.remove("ativo");
    }
};

// Gera horários de 30 em 30 minutos (8:00 - 17:30)
function gerarHorarios() {
    let hora = document.getElementById("hora");
    hora.innerHTML = "";

    for (let h = 8; h <= 17; h++) {
        hora.innerHTML += `<option value="${h}:00">${h}:00</option>`;
        hora.innerHTML += `<option value="${h}:30">${h}:30</option>`;
    }
}

// Validação do formulário antes de enviar
function validarFormulario() {
    let nome = document.getElementById("nome");
    let gmail = document.getElementById("gmail");
    let data = document.getElementById("data");
    let servico = document.getElementById("servico");

    let valido = true;

    // Limpo classes de erro antigas
    [nome, gmail, data, servico].forEach(campo =>
        campo.classList.remove("erro")
    );

    // Nome obrigatório
    if (nome.value.trim() === "") {
        nome.classList.add("erro");
        alert("Nome obrigatório!");
        valido = false;
    }

    // Verifica formato simples de email
    if (!gmail.value.includes("@") || !gmail.value.includes(".com")) {
        gmail.classList.add("erro");
        alert("Email inválido!");
        valido = false;
    }

    // Verifica data futura e fim de semana
    let d = new Date(data.value);
    let hoje = new Date();
    hoje.setHours(0, 0, 0, 0);

    if (isNaN(d.getTime())) {
        data.classList.add("erro");
        alert("Data inválida!");
        valido = false;
    } else {
        if (d <= hoje) {
            data.classList.add("erro");
            alert("Escolha uma data futura!");
            valido = false;
        }

        // Bloqueia sábado (6) e domingo (0)
        if (d.getDay() === 6 || d.getDay() === 0) {
            data.classList.add("erro");
            alert("A barbearia não funciona sábado e domingo!");
            valido = false;
        }
    }

    // Serviço obrigatório
    if (servico.value === "") {
        servico.classList.add("erro");
        alert("Selecione um serviço!");
        valido = false;
    }

    return valido;
}

// Envia os dados via fetch para cadastrar.php 
function finalizarAgendamento() {

    if (!validarFormulario()) {
        return;
    }

    let form = new FormData();

    // Montando FormData com os mesmos names que o PHP espera
    form.append("nome", document.getElementById("nome").value);
    form.append("gmail", document.getElementById("gmail").value);
    form.append("data", document.getElementById("data").value);
    form.append("hora", document.getElementById("hora").value);
    form.append("servico", document.getElementById("servico").value);
    form.append("observacao", document.getElementById("obs").value);
    form.append("barbeiro", document.getElementById("barbeiro").value);

    fetch("cadastrar.php", {
        method: "POST",
        body: form
    })
    .then(r => r.json())
    .then(resp => {

        if (resp.success) {
            alert(resp.message);

            // Se o servidor pedir redirect
            if (resp.redirect) {
                document.getElementById("modal").classList.remove("ativo");
                window.location.href = resp.redirect;
            }

        } else {
            alert("Erro: " + resp.message);
        }

    })
    .catch((err) => {
        console.error('fetch error:', err);
        alert("Erro ao enviar dados! (fetch)");
    });
}
