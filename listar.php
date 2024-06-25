<?php
include 'conexao.php';
include 'includes/header.php';

// Consulta SQL para selecionar todas as empresas
$sql = "SELECT id, cnpj, razao_social, nome_fantasia, telefone, email, endereco, cidade, estado, cnae, atividade_principal FROM empresas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Exibe os resultados em uma tabela
    echo "<h2>Lista de Empresas</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>CNPJ</th>
            <th>Razão Social</th>
            <th>Nome Fantasia</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Endereço</th>
            <th>Cidade</th>
            <th>Estado</th>
            <th>CNAE</th>
            <th>Atividade Principal</th>
            <th>Ações</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['cnpj']) . "</td>";
        echo "<td>" . htmlspecialchars($row['razao_social']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nome_fantasia']) . "</td>";
        echo "<td>" . htmlspecialchars($row['telefone']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['endereco']) . "</td>";
        echo "<td>" . htmlspecialchars($row['cidade']) . "</td>";
        echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
        echo "<td>" . htmlspecialchars($row['cnae']) . "</td>";
        echo "<td>" . htmlspecialchars($row['atividade_principal']) . "</td>";
        echo "<td>
                <a href='editar.php?id=" . htmlspecialchars($row['id']) . "'>Editar</a> |
                <a href='excluir.php?id=" . htmlspecialchars($row['id']) . "'>Excluir</a>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<h2>Nenhuma empresa cadastrada.</h2>";
}

include 'includes/footer.php'; // Inclui o rodapé
?>
