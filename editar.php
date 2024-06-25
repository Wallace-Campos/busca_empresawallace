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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $razao_social = $_POST['razao_social'];
    $nome_fantasia = $_POST['nome_fantasia'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cnae = $_POST['cnae'];
    $atividade_principal = $_POST['atividade_principal'];

    // Query para atualizar empresa
    $sql = "UPDATE empresas SET 
                razao_social = '$razao_social',
                nome_fantasia = '$nome_fantasia',
                telefone = '$telefone',
                email = '$email',
                endereco = '$endereco',
                cidade = '$cidade',
                estado = '$estado',
                cnae = '$cnae',
                atividade_principal = '$atividade_principal'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Empresa atualizada com sucesso!";
        header("Location: listar.php");
        exit();
    } else {
        echo "Erro ao atualizar empresa: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Empresa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Editar Empresa</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
        
        <label>Razão Social:</label>
        <input type="text" name="razao_social" value="<?php echo htmlspecialchars($row['razao_social']); ?>" required><br>
        
        <label>Nome Fantasia:</label>
        <input type="text" name="nome_fantasia" value="<?php echo htmlspecialchars($row['nome_fantasia']); ?>"><br>
        
        <label>Telefone:</label>
        <input type="text" name="telefone" value="<?php echo htmlspecialchars($row['telefone']); ?>"><br>
        
        <label>Email:</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($row['email']); ?>"><br>
        
        <label>Endereço:</label>
        <input type="text" name="endereco" value="<?php echo htmlspecialchars($row['endereco']); ?>"><br>
        
        <label>Cidade:</label>
        <input type="text" name="cidade" value="<?php echo htmlspecialchars($row['cidade']); ?>"><br>
        
        <label>Estado:</label>
        <input type="text" name="estado" value="<?php echo htmlspecialchars($row['estado']); ?>"><br>
        
        <label>CNAE:</label>
        <input type="text" name="cnae" value="<?php echo htmlspecialchars($row['cnae']); ?>"><br>
        
        <label>Atividade Principal:</label>
        <textarea name="atividade_principal"><?php echo htmlspecialchars($row['atividade_principal']); ?></textarea><br>
        
        <input type="submit" value="Salvar Alterações">
    </form>
</body>
</html>
