<?php
include 'conexao.php';

// Verifica se foi passado um ID válido pela URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Query para buscar dados da empresa pelo ID
    $sql = "SELECT * FROM empresas WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Nenhuma empresa encontrada.";
        exit;
    }
} else {
    echo "ID inválido.";
    exit;
}

// Se o formulário de confirmação de exclusão foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmacao'])) {
    if ($_POST['confirmacao'] == 'Sim') {
        // Query para excluir empresa
        $sql = "DELETE FROM empresas WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "Empresa excluída com sucesso!";
            header("Location: listar.php");
            exit();
        } else {
            echo "Erro ao excluir empresa: " . $conn->error;
        }
    } else {
        echo "Exclusão cancelada.";
        header("Location: listar.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Excluir Empresa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
        }
        p {
            margin-bottom: 20px;
        }
        input[type="submit"] {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <h2>Excluir Empresa</h2>
    <p>Tem certeza que deseja excluir a empresa "<?php echo htmlspecialchars($row['razao_social']); ?>"?</p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$id"; ?>">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <input type="submit" name="confirmacao" value="Sim">
        <input type="submit" name="confirmacao" value="Não">
    </form>
</body>
</html>
