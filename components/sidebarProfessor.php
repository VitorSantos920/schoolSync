<?php
$servername = "15.235.9.101";
$username = "vfzzdvmy_school_sync";
$password = "L@QCHw9eKZ7yRxz";
$database = "vfzzdvmy_school_sync";

$conn = mysqli_connect($servername, $username, $password, $database);

$aluno_id = $_GET['aluno_id'];
?>

<head>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/sidebar.css" />
</head>

<body>
    <aside id="sidebar">
        <div class="logo-container">
            <a id="logo" href="../pages/pagina-inicial-professor.php">SchoolSync</a>
        </div>
        <div>
            <p>Menu</p>
            <ul class="sidebar__menu">
                <li>
                    <a href="../pages/pagina-inicial-professor.php">
                        <i class="fa-solid fa-square-poll-vertical"></i>
                        Painel principal
                    </a>
                </li>
                <?php
                // Verifica se o script está sendo acessado através do URL correto
                if (isset($_GET['aluno_id'])) {
                    echo '<li><a href="../pages/painelAlunoProfessor.php?aluno_id=' . $aluno_id . '"><i class="fa-solid fa-square-poll-vertical"></i> Painel do aluno</a></li>';
                }
                ?>

                <?php
                // Verifica se o script está sendo acessado através do URL correto
                if (isset($_GET['aluno_id'])) {
                    echo '<li><a href="../pages/gerenciarAluno.php?aluno_id=' . $aluno_id . '"><i class="fa-solid fa-book"></i> Gerenciar aluno</a></li>';
                }
                ?>

                <?php
                // Verifica se o script está sendo acessado através do URL correto
                if (isset($_GET['aluno_id'])) {
                    echo '<li><a href="../pages/ver-eventos.php?aluno_id=' . $aluno_id . '"><i class="fa-solid fa-calendar"></i> Eventos escolares</a></li>';
                }
                ?>

                <?php
                // Verifica se o script está sendo acessado através do URL correto
                if (isset($_GET['aluno_id'])) {
                    echo '<li><a href="../pages/ver-conquistas.php?aluno_id=' . $aluno_id . '"><i class="fa-solid fa-award"></i> Conquistas do aluno</a></li>';
                }
                ?>
            </ul>

            <p>Outros</p>
            <ul class="sidebar__menu">
                <li>
                    <a href="../pages/professorPerfil.php">
                        <i class="fa-solid fa-user"></i>
                        Perfil
                    </a>
                </li>
                <li>
                    <a href="../pages/ajuda.php">
                        <i class="fa-solid fa-circle-info"></i>
                        Ajuda e Tutorial
                    </a>
                </li>
                <li>
                    <a href="../backend/logout.php">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Sair
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <script src="https://kit.fontawesome.com/4ac8bcd2f5.js" crossorigin="anonymous"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>