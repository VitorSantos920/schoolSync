<?php
// Função para conectar ao banco de dados
function conectarBanco() {
    $servername = "localhost"; 
    $username = "seu_usuario"; 
    $password = "sua_senha"; 
    $dbname = "school_sync"; 
    // Cria conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }
    return $conn;
}

// Inicializa a sessão
session_start();

// Verifica se o usuário já está logado
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: sucesso.php");
    exit;
}

// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os valores do formulário
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Conecta ao banco de dados
    $conn = conectarBanco();

    // Consulta o banco de dados para encontrar o usuário pelo email
    $stmt = $conn->prepare("SELECT id, email, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        // Usuário encontrado, verifica a senha
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row["senha"])) {
            // Senha correta, inicia a sessão
            session_start();
                            
            // Armazena os dados da sessão
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $row["id"];
            $_SESSION["email"] = $row["email"];                            

            // Redireciona para a página de sucesso
            header("location: sucesso.php");
        } else {
            // Senha incorreta
            $erro = "Email ou senha incorretos.";
        }
    } else {
        // Nenhum usuário encontrado com o email fornecido
        $erro = "Email ou senha incorretos.";
    }

    // Fecha a conexão
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/global.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SchoolSync</title>
</head>
<body>
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>
        
        <button type="submit">Entrar</button>
    </form>
    
    <?php if(isset($erro)) { ?>
        <p><?php echo $erro; ?></p>
    <?php } ?>
</body>
</html>
