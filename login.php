<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'login_system';
$user = 'root'; // Altere se necessário
$password = ''; // Altere se necessário

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obter dados do formulário
        $username = $_POST['username'];
        $password = md5($_POST['password']); // Use bcrypt em produção

        // Consultar usuário
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
        $stmt->execute(['username' => $username, 'password' => $password]);
        $user = $stmt->fetch();

        if ($user) {
            echo "Login bem-sucedido! Bem-vindo, " . htmlspecialchars($user['username']) . ".";
        } else {
            echo "Nome de usuário ou senha inválidos.";
        }
    }
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
