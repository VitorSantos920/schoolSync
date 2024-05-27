<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <script src="https://kit.fontawesome.com/4ac8bcd2f5.js" crossorigin="anonymous" defer></script>
</head>

<header class="header">
    <h2>Painel</h2>

    <div class="container-pesquisa">
        <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>

    <div class="acoes-usuario">
        <button id="modo-claro-escuro">
            <i class="fas fa-moon"></i>
        </button>

        <div class="perfil" style="display: flex; align-items: center;">
            <img src="https://picsum.photos/id/237/536/354" style="border-radius: 50%; width: 40px; height: 40px; margin-right: .625rem" alt="">

            <div>
                <div>
                    <p>Maria</p>
                    <small>Aluno</small>
                </div>
                <div class="dropdown">
                    <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fa-solid fa-user"></i>
                                Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fa-solid fa-gear"></i>
                                Configurações
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

    <button>
        <i class="fa-solid fa-bell" style="font-size: 1.75rem;"></i>
    </button>
</header>

<script src="../assets/js/bootstrap.bundle.min.js"></script>