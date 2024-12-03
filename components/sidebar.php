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
                    <?php
                    if ($_SESSION['categoria'] == "Aluno") {
                        echo "

                            <li>
                                <a href='./pagina-inicial-aluno.php'>
                                    <i class='fa-solid fa-house-chimney'></i>
                                    <span>Página Inicial</span>
                                </a>
                            </li>

                            <li>
                                <a href=''>
                                    <i class='fa-solid fa-lightbulb'></i>
                                    <span>Recursos Educacionais</span>
                                </a>
                            </li>

                            <li>
                                <a href=''>
                                    <i class='fa-solid fa-book'></i>
                                    <span>Matérias</span>
                                </a>
                            </li>

                            <li>
                                <a href=''>
                                    <i class='fa-solid fa-award'></i>
                                    <span>Conquistas Acadêmicas</span>
                                </a>
                            </li>

                            <li>
                                <a href=''>
                                    <i class='fa-solid fa-calendar'></i>
                                    <span>Agenda Escolar</span>
                                </a>
                            </li>
                            ";
                    }

                    if ($_SESSION['categoria'] == "Professor") {
                        $dadosProfessor = DB::queryFirstRow("SELECT *, pr.id as 'prof_id' FROM usuario us INNER JOIN professor pr ON pr.usuario_id = us.id WHERE us.id = %i", $dadosUsuario['id']);
                        $turmasProfessor = DB::query("SELECT * FROM classe cl WHERE cl.professor_id = %i", $dadosProfessor['prof_id']);

                        echo "
                            <li>
                                <a href='./pagina-inicial-professor.php'>
                                    <i class='fa-solid fa-house-chimney'></i>
                                    <span>Página Inicial</span>
                                </a>
                            </li>
                        ";

                        if (!empty($turmasProfessor)) {
                            foreach ($turmasProfessor as $turma) {
                                echo "
                                    <li>
                                      <a href='./lista-alunos-turma.php?turma_id={$turma['id']}'>
                                      <i class='fa-solid fa-chalkboard-user'></i>
                                        {$turma['nome']} - {$turma['serie']}° Ano
                                      </a>
                                    </li>
                                  ";
                            }
                        }
                    }

                    if ($_SESSION['categoria'] == "Responsavel") {

                        $dadosResponsavel = DB::queryFirstRow("SELECT *, us.id as 'us_id', res.id as 'res_id' FROM usuario us INNER JOIN responsavel res ON res.usuario_id = us.id WHERE us.id = %i", $_SESSION['id']);
                        $filhosResponsavel = DB::query("SELECT *, al.id as 'aluno_id' FROM aluno al INNER JOIN usuario us ON al.usuario_id = us.id WHERE al.responsavel_id = %i", $dadosResponsavel['res_id']);

                        echo "
                            <li>
                                <a href='./pagina-inicial-responsavel.php'>
                                    <i class='fa-solid fa-house-chimney'></i>
                                    <span>Página Inicial</span>
                                </a>
                            </li>
                        ";

                        if (!empty($filhosResponsavel)) {
                            foreach ($filhosResponsavel as $filho) {
                                echo "
                                    <li>
                                        <a href='pagina-inicial-aluno.php?aluno_id=$filho[aluno_id]'>
                                            <i class='fa-solid fa-child-reaching'></i>
                                            <span>$filho[nome]</span>
                                        </a>
                                    </li>
                                ";
                            }
                        }
                    }
                    ?>



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
                        <a href="ajuda.php">
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

            sidebar.classList.remove('show');

            const expandida = sidebar.classList.contains('show');

            sidebar.setAttribute('aria-expanded', expandida);
            sidebar.setAttribute('aria-hidden', !expandida);

            expandida ? sidebar.removeAttribute('inert') : sidebar.setAttribute('inert', '');
        }
    </script>
</body>