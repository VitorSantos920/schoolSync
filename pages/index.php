<?php
// Função para conectar ao banco de dados
function conectarBanco() {
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
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

    //Lógica para lembrar login
    // Função para definir um cookie com o nome do usuário se a caixa de seleção "Lembrar login" estiver marcada
    if(isset($_POST['lembrar-login']) && $_POST['lembrar-login'] == 'on'){
        // Defina o cookie com o nome do usuário (substitua 'nome_do_usuario' pela variável real do nome do usuário)
        setcookie('lembrar_login', 'nome_do_usuario', time() + (86400 * 30), "/"); // cookie válido por 30 dias
    } else{
        // Se a caixa de seleção não estiver marcada, remova o cookie
        setcookie('lembrar_login', '', time() - 3600, "/");
    }

    // Recupere a categoria do usuário do banco de dados
    try {
        $sql = "SELECT categoria FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":email", $email); // Supondo que $email seja o email do usuário logado
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $categoria = $row['categoria'];
        } else {
            // Categoria não encontrada para o usuário
            // Lidar com isso conforme necessário (por exemplo, redirecionar para uma página de erro)
            header("Location: erro.php");
            exit();
        }
    } catch (PDOException $e) {
        // Erro ao executar a consulta SQL
        // Lidar com isso conforme necessário (por exemplo, redirecionar para uma página de erro)
        echo "Erro: " . $e->getMessage();
        exit();
    }

    // Redirecionamento com base na categoria do usuário
    switch ($categoria) {
        case "aluno":
            header("Location: painel_aluno.php");
            break;
        case "professor":
            header("Location: pagina_inicial_professor.php");
            break;
        case "responsavel":
            header("Location: pagina_inicial_responsavel.php");
            break;
        case "administrador":
            header("Location: tela_inicial_admin.php");
            break;
        default:
            // Categoria inválida, redirecionar para uma página de erro
            header("Location: erro.php");
            break;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/variables.css">
    <title>Login SchoolSync</title>

    <style>

        .logo-text{
            font-size: var(--fontSize-5xl);
            font-family: var(--fontFamily-poppins);
            font-weight: var(--fontWeight-bold);
            color: var(--brand-color);
        }

        .sub-text{
            font-size: var(--fontSize-sm);
            font-family: var(--fontFamily-roboto);
            font-weight: var(--fontWeight-regular);
            color: var(--level-gray500);
        }

        .lembrar-de-mim {
            font-size: var(--fontSize-sm);
            font-family: var(--fontFamily-poppins);
            font-weight: var(--fontWeight-regular);
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <!-- alt é um atributo que determina o texto que deve aparecer caso a imagem não seja exibida-->
            <img src="../assets/img/logo_transparente.png" alt="SchoolSync" class="logo">
            <p class="logo-text">SchoolSync</p>
            <p class="sub-text">Se você é um aluno, professor ou um responsável e já possui cadastro no sistema, faça seu login abaixo!</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="mt-4">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br><br>
                </div>
                
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required><br><br>


                <input type="checkbox" id="lembrar-login" name="lembrar-login">
                <label for="lembrar-login">Lembrar login</label><br><br>
                
                <button type="submit">REALIZAR LOGIN</button>
            </form>
            
            <?php if(isset($erro)) { ?>
                <p><?php echo $erro; ?></p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
