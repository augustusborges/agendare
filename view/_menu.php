<div class="row" id="linha_menu">
  <div class="col-sm-12">
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">AGENDARE</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li><a href="agendacliente.php">Minha Agenda</a></li>
            <li role="presentation" class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Colaboradores <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="criaragenda.php">Montar Agenda</a></li>
                <li><a href="disponibilidadecolaboradores.php">Disponibilidade</a></li>
              </ul>
            </li>
            <li role="presentation" class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Administração <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="criaragenda.php">Montar Agenda</a></li>
                <li><a href="disponibilidadecolaboradores.php">Disponibilidade</a></li>
                <li><a href="cadastro.php">Cadastrar Usuário</a></li>
                <li><a href="graficos.php">Gráficos</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="excluicookie.php">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</div>


          <?php
            // //Validação de usuário logado no sistema
            // //com mensagem de boas vindas.
            // if($pessoa->usuarioLogado()){
            //
            //   echo "<a href=\"#\"
            //   title=\"Bem vindo, "
            //   . $_SESSION['userName']
            //   . "!\"
            //   >
            //
            //   <span id=\"loginIcone\"
            //   class=\"glyphicon
            //   glyphicon-user
            //   icone-color-navbar-ok
            //   navbar-right
            //   \"
            //   ></span></a>";
            // }
            // else{
            //   echo "<a href=\"#\"
            //   title=\"Olá, você precisa estar logado
            //   para acessar o sistema!\"
            //   >
            //
            //   <span id=\"loginIcone\"
            //   class=\"glyphicon
            //   glyphicon-user
            //   icone-color-navbar-nok
            //   navbar-right
            //   \"
            //   ></span></a>";
            // }
          ?>
