<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Nova Empresa</title>
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
    <h2>Cadastrar Nova Empresa</h2>
    <form method="post" action="criar.php">
        <label>Razão Social:</label>
        <input type="text" name="razao_social" required><br>
        
        <label>Nome Fantasia:</label>
        <input type="text" name="nome_fantasia"><br>
        
        <label>Telefone:</label>
        <input type="text" name="telefone"><br>
        
        <label>Email:</label>
        <input type="text" name="email"><br>
        
        <label>Endereço:</label>
        <input type="text" name="endereco"><br>
        
        <label>CNAE:</label>
        <input type="text" name="cnae"><br>
        
        <label>Atividade Principal:</label>
        <textarea name="atividade_principal"></textarea><br>
        
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
