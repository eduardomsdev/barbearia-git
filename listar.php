<?php

include "conexao.php";

// Excluir se veio ?excluir=ID
if (isset($_GET["excluir"])) {
    $id = intval($_GET["excluir"]);
    $conexao->query("DELETE FROM agendamentos WHERE id = $id");
    header("Location: listar.php");
    exit;
}

// Pego todos os agendamentos ordenados por barbeiro/data/hora
$sql = "SELECT * FROM agendamentos ORDER BY barbeiro, data, hora";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listagem</title>
    <link rel="stylesheet" href="CSS/listar.css">
</head>
<body class="listar-page">

<div class="listar-container">
    <h1>Agendamentos</h1>

<?php
if ($result && $result->num_rows > 0):

    $barbeiroAtual = "";

    while ($row = $result->fetch_assoc()):

        if ($barbeiroAtual != $row["barbeiro"]) {

            if ($barbeiroAtual != "") {
                echo "</div>";
            }

            $barbeiroAtual = $row["barbeiro"];

            echo "<div class='grupo-barbeiro'>";
            echo "<h2>Agendamentos de {$barbeiroAtual}</h2>";
        }

        // Exibindo o serviço como texto - agora o banco já deve ter o texto
        echo "
        <div class='agendamento-item'>
            <b>Cliente:</b> {$row['nome']}<br>
            <b>Email:</b> {$row['gmail']}<br>
            <b>Data:</b> {$row['data']}<br>
            <b>Hora:</b> {$row['hora']}<br>
            <b>Serviço:</b> {$row['servico']}<br><br>

            <a href='listar.php?excluir={$row['id']}' onclick=\"return confirm('Excluir agendamento?')\">
               Excluir
            </a>
        </div>";
    endwhile;

    echo "</div>";

else:
    echo "<p style='text-align:center;color:white;'>Nenhum agendamento cadastrado.</p>";
endif;
?>

</div>

</body>
</html>
