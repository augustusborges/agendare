<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <meta name="author" content="Focus 4 Business Intelligence Ltda"/>
    <meta name="description" content="Login de acesso ao sistema"/>
    <meta name="keywords" content="login, segurança, acesso seguro, sistema web"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>d.a.a.b - Login de Acesso</title>

    <links>
      <link rel="stylesheet" href="css/bootstrap.css"/>
      <link rel="stylesheet" href="css/jquery-ui.css"/>
      <link rel="stylesheet" href="css/mine.css"/>
      <link rel="stylesheet" href="css/principal.css"/>
      <link rel="stylesheet" href="css/radio_check_personalization.css"/>
    </links>

  </head>
  <body>

    <div class="container-fluid body_color">

      <div class="row" id="php">
        <?php
          require 'config.php';
          require BASE_DIR.'lib'.DS.'utils.php';
        ?>
      </div>

      <div class="row" id="menu">
        <?php include BASE_DIR.'view'.DS.'_menu.php';?>
        <div></div>
      </div>

      <div class="row" id="cabecalho">
        <div class="col-sm-12">

          <header>
            <div id="cabecalho" name="cabecalho" class="cabecalho-borda cabecalho-texto">Login de Acesso</div>
          </header>
        </div>
      </div>

      <div class="row" id="form">

      </div>
        <form class="navbar-form navbar-right" method="post" action="lib/acesso.php">
          <div class="form-group">
            <label>Email</label>
            <input type="text" id="userEmail" name="userEmail" class="form-control form-control-navbar" placeholder="login"/>
            <label>Senha</label>
            <input type="password" id="userPassword" name="userPassword" class="form-control form-control-navbar" placeholder="senha"/>

            <button type="submit" class="btn btn-default">
              <span class="glyphicon glyphicon-log-in"></span>
            </button>

            <div id="rememberme" class="remember">
              <input type="checkbox" name="rememberme" class="remember" value="1"/>
              <label for="rememberme" class="remember-label">
                Manter-me Logado:
              </label>
        </div>
        </div>
      </form>
    </div>

  </body>
</html>
