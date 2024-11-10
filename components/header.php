<head>
  <link rel="stylesheet" href="../assets/css/header.css">
</head>

<header class="header">
  <button class="btn" onclick="openSidebar()" aria-controls="sidebar">
    <i class="fa-solid fa-bars"></i>
  </button>

  <div class="container-pesquisa">
    <input type="text" class="form-control" id="pesquisa" placeholder="Pesquisar">
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
          <p><?php echo $dadosUsuario['nome'] ?></p>
          <small><?php echo $_SESSION['categoria']; ?></small>
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

<script src="../assets/js/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/4ac8bcd2f5.js" crossorigin="anonymous"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script>
  function openSidebar() {
    const sidebar = document.querySelector('#sidebar');
    const contentWrapper = document.querySelector('.content-wrapper');

    sidebar.classList.add('show');
    contentWrapper.classList.toggle('sidebar-show')

    const expandida = sidebar.classList.contains('show');

    sidebar.setAttribute('aria-expanded', expandida);
    sidebar.setAttribute('aria-hidden', !expandida);

    expandida ? sidebar.removeAttribute('inert') : sidebar.setAttribute('inert', '');
  }
</script>