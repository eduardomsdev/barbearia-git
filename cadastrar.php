<?php
require_once "conexao.php";

header("Content-Type: application/json; charset=utf-8");

function resposta($ok, $msg, $extra = []) {
    echo json_encode(array_merge(['success'=>$ok,'message'=>$msg], $extra));
    exit;
}

// Recebe dados
$barbeiro = $_POST['barbeiro'] ?? '';
$nome     = $_POST['nome'] ?? '';
$gmail    = $_POST['gmail'] ?? '';
$data     = $_POST['data'] ?? '';
$hora     = $_POST['hora'] ?? '';
$servico  = $_POST['servico'] ?? '';
$obs      = $_POST['observacao'] ?? '';

// Validações básicas
if ($barbeiro == '' || $nome == '' || $gmail == '' || $data == '' || $hora == '' || $servico == '') {
    resposta(false, "Preencha todos os campos!");
}

if (!filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
    resposta(false, "Email inválido!");
}

// Validação da data
$d = strtotime($data);
$hoje = strtotime(date("Y-m-d"));

if ($d <= $hoje) resposta(false, "Escolha uma data futura!");

$diaSemana = date("w", $d);
if ($diaSemana == 0 || $diaSemana == 6) resposta(false, "A barbearia não funciona no fim de semana!");

//  VERIFICA SE O HORÁRIO JÁ FOI AGENDADO (SIMPLES)
$verifica = $conexao->prepare("
    SELECT id FROM agendamentos
    WHERE barbeiro = ? AND data = ? AND hora = ?
");
$verifica->bind_param("sss", $barbeiro, $data, $hora);
$verifica->execute();
$tem = $verifica->get_result();

if ($tem->num_rows > 0) {
    resposta(false, "Este horário já foi agendado! Escolha outro.");
}

// INSERIR AGENDAMENTO
$sql = $conexao->prepare("
    INSERT INTO agendamentos (barbeiro, nome, gmail, data, hora, servico, observacao)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");
$sql->bind_param("sssssss", $barbeiro, $nome, $gmail, $data, $hora, $servico, $obs);

if (!$sql->execute()) {
    resposta(false, "Erro ao salvar: " . $sql->error);
}

resposta(true, "Agendado com sucesso!", ["redirect"=>"listar.php"]);

?>
