<?php
include 'conexao.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
    $cnpj = $_POST['cnpj'];
    
    if ($_POST['confirmar'] === 'sim') {
        // Verifica se todos os campos necessários estão presentes e não estão vazios
        if (isset($_POST['nome_fantasia'], $_POST['razao_social'], $_POST['endereco'], $_POST['cidade'], $_POST['estado'], $_POST['telefone'], $_POST['email'], $_POST['cnae'])) {
            // Sanitiza os dados recebidos do formulário
            $nome_fantasia = $conn->real_escape_string($_POST['nome_fantasia']);
            $razao_social = $conn->real_escape_string($_POST['razao_social']);
            $endereco = $conn->real_escape_string($_POST['endereco']);
            $cidade = $conn->real_escape_string($_POST['cidade']);
            $estado = $conn->real_escape_string($_POST['estado']);
            $telefone = $conn->real_escape_string($_POST['telefone']);
            $email = $conn->real_escape_string($_POST['email']);
            $cnae = $conn->real_escape_string($_POST['cnae']);
            
            // Verifica se o CNPJ já existe no banco de dados
            $sql_verifica_cnpj = "SELECT COUNT(*) AS total FROM empresas WHERE cnpj = '$cnpj'";
            $result_verifica_cnpj = $conn->query($sql_verifica_cnpj);
            $row = $result_verifica_cnpj->fetch_assoc();
            
            if ($row['total'] > 0) {
                echo "<script>alert('Este CNPJ já está cadastrado.'); window.location.href = 'buscar.php';</script>";
            } else {
                // Prepara e executa a inserção no banco de dados
                $sql = "INSERT INTO empresas (cnpj, nome_fantasia, razao_social, endereco, cidade, estado, telefone, email, cnae) 
                        VALUES ('$cnpj', '$nome_fantasia', '$razao_social', '$endereco', '$cidade', '$estado', '$telefone', '$email', '$cnae')";
                
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Empresa cadastrada com sucesso!'); window.location.href = 'listar.php';</script>";
                } else {
                    echo "Erro ao cadastrar empresa: " . $conn->error;
                }
            }
        } else {
            echo "Todos os campos são obrigatórios.";
        }
    } elseif ($_POST['confirmar'] === 'nao') {
        echo "Cadastro da empresa cancelado.";
    }
}

include 'includes/footer.php';
?>
