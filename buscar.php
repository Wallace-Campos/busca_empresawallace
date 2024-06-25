<?php
include 'conexao.php';
include 'includes/header.php';

// Função para buscar empresa na API ReceitaWS
function buscarEmpresaNaAPI($cnpj) {
    // Token de acesso à API ReceitaWS
    $tokenReceitaWS = 'd51084e4cea4f68f564616befe47c2a2765f83d0008a2ce15784c1a544eaaf32';
    $urlReceitaWS = "https://www.receitaws.com.br/v1/cnpj/$cnpj?token=$tokenReceitaWS";
    
    // Realiza a requisição GET para a API ReceitaWS
    $responseReceitaWS = file_get_contents($urlReceitaWS);
    $dataReceitaWS = json_decode($responseReceitaWS, true); // Converte a resposta para um array associativo
    
    return $dataReceitaWS;
}

// Função para buscar empresa na nova API
function buscarEmpresaNaNovaAPI($cnpj) {
    // Token de acesso à nova API
    $tokenNovaAPI = '22dced17-bf60-493c-a2f6-f7e64856a90e-2f4a6422-dbe9-41f0-8a74-e357aa596462';
    $urlNovaAPI = "https://api.novaempresa.com.br/v1/cnpj/$cnpj?token=$tokenNovaAPI";
    
    // Realiza a requisição GET para a nova API
    $responseNovaAPI = file_get_contents($urlNovaAPI);
    $dataNovaAPI = json_decode($responseNovaAPI, true); // Converte a resposta para um array associativo
    
    return $dataNovaAPI;
}

// Função para mostrar o formulário de cadastro da empresa
function cadastrarEmpresa($cnpj, $dadosEmpresa) {
    global $conn;
    
    // Trata o nome fantasia para pegar apenas o primeiro nome, desconsiderando numerações anteriores
    $nomeFantasia = preg_replace('/^\d+\s*/', '', $dadosEmpresa['fantasia'] ?? '');
    
    // Exibe os dados da empresa encontrada na API
    echo "<h2>Empresa Encontrada</h2>";
    echo "<strong>CNPJ:</strong> " . htmlspecialchars($dadosEmpresa['cnpj']) . "<br>";
    echo "<strong>Nome Fantasia:</strong> " . htmlspecialchars($nomeFantasia) . "<br>";
    echo "<strong>Razão Social:</strong> " . htmlspecialchars($dadosEmpresa['nome']) . "<br>";
    echo "<strong>Endereço:</strong> " . htmlspecialchars($dadosEmpresa['logradouro']) . "<br>";
    echo "<strong>Cidade:</strong> " . htmlspecialchars($dadosEmpresa['municipio']) . "<br>";
    echo "<strong>Estado:</strong> " . htmlspecialchars($dadosEmpresa['uf']) . "<br>";
    echo "<strong>Telefone:</strong> " . htmlspecialchars($dadosEmpresa['telefone']) . "<br>";
    echo "<strong>Email:</strong> " . htmlspecialchars($dadosEmpresa['email']) . "<br>";
    
    // Exibe o CNAE principal da empresa, se disponível
    if (!empty($dadosEmpresa['atividade_principal'][0]['code'])) {
        echo "<strong>CNAE Principal:</strong> " . htmlspecialchars($dadosEmpresa['atividade_principal'][0]['code']) . " - " . htmlspecialchars($dadosEmpresa['atividade_principal'][0]['text']) . "<br>";
    }
    
    // Mostra o formulário de confirmação para cadastrar a empresa
    echo "<form action='cadastrar.php' method='POST'>";
    echo "<input type='hidden' name='cnpj' value='" . htmlspecialchars($cnpj) . "'>";
    echo "<input type='hidden' name='nome_fantasia' value='" . htmlspecialchars($nomeFantasia) . "'>";
    echo "<input type='hidden' name='razao_social' value='" . htmlspecialchars($dadosEmpresa['nome']) . "'>";
    echo "<input type='hidden' name='endereco' value='" . htmlspecialchars($dadosEmpresa['logradouro']) . "'>";
    echo "<input type='hidden' name='cidade' value='" . htmlspecialchars($dadosEmpresa['municipio']) . "'>";
    echo "<input type='hidden' name='estado' value='" . htmlspecialchars($dadosEmpresa['uf']) . "'>";
    echo "<input type='hidden' name='telefone' value='" . htmlspecialchars($dadosEmpresa['telefone']) . "'>";
    echo "<input type='hidden' name='email' value='" . htmlspecialchars($dadosEmpresa['email']) . "'>";
    echo "<input type='hidden' name='cnae' value='" . htmlspecialchars($dadosEmpresa['atividade_principal'][0]['code']) . "'>";
    echo "<button type='submit' name='confirmar' value='sim'>Clique aqui para cadastrar</button>";
    echo "</form>";
}

?>

<main class="container">
    <h2>Buscar Empresa</h2>
    <form action="buscar.php" method="POST">
        <label for="cnpj">CNPJ:</label>
        <input type="text" id="cnpj" name="cnpj" placeholder="00.000.000/0000-00" required>
        <button type="submit">Buscar</button>
    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : '';
    
    // Remove pontos, barras e traços do CNPJ
    $cnpj = preg_replace("/[^0-9]/", "", $cnpj);
    
    // Verifica se o CNPJ tem 14 dígitos após remoção de caracteres especiais
    if (strlen($cnpj) !== 14) {
        echo "CNPJ inválido. Digite no formato correto (00.000.000/0000-00).";
    } else {
        // Busca a empresa pelo CNPJ na API ReceitaWS
        $dadosEmpresa = buscarEmpresaNaAPI($cnpj);
        
        // Verifica se encontrou a empresa na API ReceitaWS
        if (!empty($dadosEmpresa) && isset($dadosEmpresa['status']) && $dadosEmpresa['status'] === 'OK') {
            // Exibe os dados da empresa encontrada na API ReceitaWS e o formulário de cadastro
            cadastrarEmpresa($cnpj, $dadosEmpresa);
        } else {
            // Busca a empresa pelo CNPJ na nova API
            $dadosEmpresaNovaAPI = buscarEmpresaNaNovaAPI($cnpj);
            
            // Verifica se encontrou a empresa na nova API
            if (!empty($dadosEmpresaNovaAPI) && isset($dadosEmpresaNovaAPI['status']) && $dadosEmpresaNovaAPI['status'] === 'OK') {
                // Exibe os dados da empresa encontrada na nova API e o formulário de cadastro
                cadastrarEmpresa($cnpj, $dadosEmpresaNovaAPI);
            } else {
                echo "<h2>Empresa não encontrada</h2>";
                echo "Empresa não encontrada em nenhuma API. Verifique o CNPJ digitado.";
                echo "<script>setTimeout(function(){ window.location.href = 'buscar.php'; }, 5000);</script>";
            }
        }
    }
}
?>

</main>

<?php include 'includes/footer.php'; ?>
