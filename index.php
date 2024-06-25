<?php
include 'conexao.php';

// Query para selecionar todas as empresas
$sql = "SELECT * FROM empresas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Empresas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions {
            text-align: center;
        }
        .actions a {
            margin: 0 5px;
            text-decoration: none;
            color: #333;
        }
        .actions a:hover {
            color: #0066cc;
        }
    </style>
</head>
<body>
    <h2>Listagem de Empresas</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Razão Social</th>
            <th>Nome Fantasia</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Endereço</th>
            <th>CNAE</th>
            <th>Atividade Principal</th>
            <th class="actions">Ações</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['razao_social'] . "</td>";
                echo "<td>" . ($row['nome_fantasia'] ? $row['nome_fantasia'] : '-') . "</td>";
                echo "<td>" . ($row['telefone'] ? $row['telefone'] : '-') . "</td>";
                echo "<td>" . ($row['email'] ? $row['email'] : '-') . "</td>";
                echo "<td>" . ($row['endereco'] ? $row['endereco'] : '-') . "</td>";
                echo "<td>" . ($row['cnae'] ? $row['cnae'] : '-') . "</td>";
                echo "<td>" . ($row['atividade_principal'] ? $row['atividade_principal'] : '-') . "</td>";
                echo "<td class='actions'>
                          <a href='editar.php?id=" . $row['id'] . "'>Editar</a> |
                          <a href='excluir.php?id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir esta empresa?\");'>Excluir</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Nenhuma empresa cadastrada.</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="criar.php">Cadastrar Nova Empresa</a>
</body>
</html>
