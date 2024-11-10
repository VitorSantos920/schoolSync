<head>
    <link rel="stylesheet" type="text/css" href="../assets/css/sidebar.css" />
</head>

<body>
    <aside id="sidebar" aria-expanded="false" aria-hidden="true" inert>
        <header style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <a style="margin: 0; font-size: 2rem; text-align: left;" id="logo" href="index.php">SchoolSync</a>
            <button onclick="closeSidebar()" class="btn" type="button"><i class="fa-solid fa-xmark" style="margin: 0;"></i></button>
        </header>

        <section>
            <div>
                <p>Menu</p>
                <ul class="sidebar__menu">
                    <li>
                        <a href="">
                            <i class="fa-solid fa-square-poll-vertical"></i>
                            <span>Painel</span>
                        </a>
                    </li>

                    <li>
                        <a href="">
                            <i class="fa-solid fa-lightbulb"></i>
                            <span>Recursos Educacionais</span>
                        </a>
                    </li>

                    <li>
                        <a href="">
                            <i class="fa-solid fa-book"></i>
                            <span>Matérias</span>
                        </a>
                    </li>

                    <li>
                        <a href="">
                            <i class="fa-solid fa-award"></i>
                            <span>Conquistas Acadêmicas</span>
                        </a>
                    </li>

                    <li>
                        <a href="">
                            <i class="fa-solid fa-calendar"></i>
                            <span>Agenda Escolar</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div>
                <p>Outros</p>
                <ul class="sidebar__menu">
                    <li>
                        <a href="">
                            <i class="fa-solid fa-gear"></i>
                            <span>Configuranções</span>
                        </a>
                    </li>

                    <li>
                        <a href="">
                            <i class="fa-solid fa-user"></i>
                            <span>Perfil</span>
                        </a>
                    </li>

                    <li>
                        <a href="">
                            <i class="fa-solid fa-circle-info"></i>
                            <span>Ajuda e Tutorial</span>
                        </a>
                    </li>

                    <li>
                        <a href="../backend/logout.php">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Sair</span>
                        </a>
                    </li>

                </ul>
            </div>
        </section>
    </aside>

    <script>
        function closeSidebar() {
            const sidebar = document.querySelector('#sidebar');
            // const contentWrapper = document.querySelector('.content-wrapper');

            sidebar.classList.remove('show');
        }
    </script>
</body>