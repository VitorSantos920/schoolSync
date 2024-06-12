<?php
$servername = "15.235.9.101";
$username = "vfzzdvmy_school_sync";
$password = "L@QCHw9eKZ7yRxz";
$database = "vfzzdvmy_school_sync";

$conn = mysqli_connect($servername, $username, $password, $database);

session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ./index.php');
    exit;
}

$usuario_id = $_SESSION['id'];

$nome = $_POST['nome'];
$imagem_perfil = $_FILES['imagem_perfil'];

// Primeiro, obter o caminho da imagem atual do banco de dados
$query_select_imagem = "SELECT imagem_perfil FROM usuario WHERE id = $usuario_id";
$result_select_imagem = mysqli_query($conn, $query_select_imagem);
$dados_usuario = mysqli_fetch_assoc($result_select_imagem);
$imagem_atual = $dados_usuario['imagem_perfil'];

// Se uma nova imagem foi enviada, faça o upload dela e atualize o banco de dados
if ($imagem_perfil['name']) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($imagem_perfil["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($imagem_perfil["tmp_name"]);
    if ($check !== false) {
        if (!file_exists($target_file)) {
            if ($imagem_perfil["size"] <= 5000000) {
                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                    // Antes de mover a nova imagem, exclua a imagem atual, se existir
                    if ($imagem_atual && file_exists($imagem_atual)) {
                        unlink($imagem_atual); // Excluir a imagem atual
                    }

                    // Mover a nova imagem para o diretório de destino
                    if (move_uploaded_file($imagem_perfil["tmp_name"], $target_file)) {
                        $query = "UPDATE usuario SET nome='$nome', imagem_perfil='$target_file' WHERE id=$usuario_id";
                    } else {
                        echo "Desculpe, houve um erro ao fazer o upload do seu arquivo.";
                    }
                } else {
                    echo "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
                }
            } else {
                echo "Desculpe, seu arquivo é muito grande.";
            }
        } else {
            echo "Desculpe, o arquivo já existe.";
        }
    } else {
        echo "O arquivo não é uma imagem.";
    }
} else {
    $query = "UPDATE usuario SET nome='$nome' WHERE id=$usuario_id";
}

// Executar a consulta de atualização do banco de dados
if (isset($query) && mysqli_query($conn, $query)) {
    echo "Perfil atualizado com sucesso!";
} elseif (isset($query)) {
    echo "Erro ao atualizar o perfil: " . mysqli_error($conn);
}

mysqli_close($conn);

// Redirecionamento
if (isset($_SESSION['redirect_url'])) {
    $redirect_url = $_SESSION['redirect_url'];
    unset($_SESSION['redirect_url']);
    header('Location: ' . $redirect_url);
    exit;
} else {
    header('Location: index.php');
    exit;
}
