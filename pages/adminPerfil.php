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



// Obtenha os dados do usuário, incluindo o caminho da imagem de perfil

$query = "SELECT nome, email, categoria, imagem_perfil FROM usuario WHERE id = $usuario_id";

$result = mysqli_query($conn, $query);



if (mysqli_num_rows($result) > 0) {

    $user_data = mysqli_fetch_assoc($result);
} else {

    echo "Usuário não encontrado.";

    exit;
}



$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];



mysqli_close($conn);

?>



<!DOCTYPE html>

<html lang="pt-br">



<head>

    <meta charset="UTF-8">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="../assets/css/global.css">

    <link rel="icon" href="../assets/img/logo_transparente.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <style>
        .container {

            width: 50%;

            margin: 0 auto;

            text-align: center;

            padding-top: 50px;

        }



        .profile-header {

            margin-bottom: 30px;

        }



        .profile-image {

            width: 150px;

            height: 150px;

            border-radius: 50%;

            object-fit: cover;

        }



        .form-group {

            text-align: left;

        }



        .welcome-message {

            margin-bottom: 30px;

        }
    </style>

    <title>Perfil do Professor</title>

</head>



<body>

    <?php include_once "../components/sidebarAdmin.php"; ?>

    <?php include_once "../components/Header.php"; ?>

    <main>

        <div class="container">

            <div class="welcome-message">

                <h3><img src="../assets/img/maozinha.png" width="30px" alt="Ícone de mão dando saudação."> Olá, <?php echo $user_data['nome']; ?>!</h3>

            </div>

            <div class="profile-header">

                <?php if ($user_data['imagem_perfil']) : ?>

                    <img src="<?php echo $user_data['imagem_perfil']; ?>" alt="Imagem de Perfil" class="profile-image">

                <?php else : ?>

                    <img src="uploads/default_profile.jpg" alt="Imagem de Perfil" class="profile-image">

                <?php endif; ?>

            </div>

            <form action="atualizar_perfil.php" method="post" enctype="multipart/form-data">

                <div class="form-group">

                    <label for="nome">Nome:</label>

                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $user_data['nome']; ?>">

                </div>

                <div class="form-group">

                    <label for="email">Email:</label>

                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_data['email']; ?>" readonly>

                </div>

                <div class="form-group">

                    <label for="categoria">Categoria:</label>

                    <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo $user_data['categoria']; ?>" readonly>

                </div>

                <div class="form-group">

                    <label for="imagem_perfil">Imagem de Perfil:</label>

                    <input type="file" class="form-control" id="imagem_perfil" name="imagem_perfil">

                </div>

                <button type="submit" class="btn btn-primary">Atualizar Perfil</button>

            </form>

        </div>

    </main>

</body>



</html>