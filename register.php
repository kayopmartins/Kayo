<?php
// --- register.php ---

// 1. Recebe os dados do formulário
$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
$email = $data['email'];
$password = $data['password'];

// Validação simples
if (empty($name) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
    exit;
}

// 2. Configurações do banco de dados
$host = 'localhost';
$db_name = 'clinicas_db';
$username = 'root';
$db_password = ''; // Deixe em branco se for a senha padrão do XAMPP

header('Content-Type: application/json');

try {
    // 3. Conecta ao banco
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 4. VERIFICA SE O E-MAIL JÁ EXISTE
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Este e-mail já está em uso.']);
        exit;
    }

    // 5. CRIPTOGRAFA A SENHA (ESSENCIAL PARA A SEGURANÇA)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 6. INSERE O NOVO USUÁRIO NO BANCO
    $stmt = $conn->prepare("INSERT INTO usuarios (nome_completo, email, senha) VALUES (:nome, :email, :senha)");
    $stmt->bindParam(':nome', $name);
    $stmt->bindParam(':email', 'email');
    $stmt->bindParam(':senha', $hashed_password);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cadastro realizado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao realizar o cadastro.']);
    }

} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro de conexão: ' . $e->getMessage()]);
}
?>
