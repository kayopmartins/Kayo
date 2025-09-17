<?php
// --- login.php ---

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$password = $data['password'];

$host = 'localhost';
$db_name = 'clinicas_db';
$username = 'root';
$db_password = ''; // Senha padrão do XAMPP é vazia

header('Content-Type: application/json');

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['senha'])) {
        // Sucesso!
        echo json_encode([
            'success' => true,
            'message' => 'Login bem-sucedido!',
            'user' => [
                'name' => $user['nome_completo'],
                'email' => $user['email']
            ]
        ]);
    } else {
        // Falha
        http_response_code(401); // Unauthorized
        echo json_encode([
            'success' => false,
            'message' => 'Email ou senha incorretos.'
        ]);
    }

} catch(PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false,
        'message' => 'Erro interno no servidor.'
    ]);
}
?>
