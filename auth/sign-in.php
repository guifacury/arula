<?php
// Inicialize a sessão
session_start();

// // Verifique se o usuário já está logado, em caso afirmativo, redirecione-o para a página de boas-vindas
// if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
//   // header("location: ../index");
//   echo "ola";
//   exit;
// }

// unset($_SESSION["loggedin"]);
session_destroy();

// Incluir arquivo de configuração
require_once "../db/verifica.php";


// Defina variáveis e inicialize com valores vazios
$p_username = $password = "";
$p_username_err = $password_err = $login_err = "";

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Verifique se o nome de usuário está vazio
  if (empty(trim($_POST["p_username"]))) {
    $p_username_err = "Por favor, insira o nome de usuário.";
  } else {
    $p_username = trim($_POST["p_username"]);
  }

  // Verifique se a senha está vazia
  if (empty(trim($_POST["password"]))) {
    $password_err = "Por favor, insira sua senha.";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validar credenciais
  if (empty($p_username_err) && empty($password_err)) {
    // Prepare uma declaração selecionada
    $sql = "SELECT username, password, level, plano, access FROM users WHERE username = :p_username";

    if ($stmt = $pdo->prepare($sql)) {
      // Vincule as variáveis à instrução preparada como parâmetros
      $stmt->bindParam(":p_username", $param_p_username, PDO::PARAM_STR);

      // Definir parâmetros
      $param_p_username = trim($_POST["p_username"]);

      // Tente executar a declaração preparada
      if ($stmt->execute()) {
        // Verifique se o nome de usuário existe, se sim, verifique a senha
        if ($stmt->rowCount() == 1) {
          if ($row = $stmt->fetch()) {

            $hashed_password = $row["password"];
            $level = $row["level"];
            $plano = $row["plano"];
            $access = $row["access"];
            if (password_verify($password, $hashed_password)) {
              session_start();

              $_SESSION["loggedin"] = true;
              $_SESSION["username"] = $param_p_username;

              if ($level == '2') {
                $_SESSION['admin_level'] = true;
                $_SESSION["platform_access"] = true;
                $_SESSION["unlimited_access"] = true;
                $_SESSION["arula_member"] = true;
                $_SESSION["account_type"] = 3;
                header("location: ../admin");
                exit();
              } else {
                $_SESSION['admin_level'] = false;
                switch ($plano) {
                  case '1':
                    $_SESSION["platform_access"] = false;
                    $_SESSION["account_type"] = 1;
                    $_SESSION["unlimited_access"] = false;
                    $_SESSION["arula_member"] = false;
                    break;
                  case '2':
                    $_SESSION["platform_access"] = true;
                    $_SESSION["account_type"] = 2;
                    $_SESSION["unlimited_access"] = false;
                    $_SESSION["arula_member"] = false;
                    break;
                  case '3':
                    $_SESSION["platform_access"] = true;
                    $_SESSION["unlimited_access"] = true;
                    $_SESSION["arula_member"] = true;
                    $_SESSION["account_type"] = 3;
                    break;
                }
                header("location: ../");
                exit();
              }


            } else {
              // A senha não é válida, exibe uma mensagem de erro genérica
              $login_err = "Usuário ou senha inválidos.";
            }
          }
        } else {
          // O nome de usuário não existe, exibe uma mensagem de erro genérica
          $login_err = "Usuário ou senha inválidos.";
        }
      } else {
        echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
      }

      // Fechar declaração
      unset($stmt);
    }
  }

  // Fechar conexão
  unset($pdo);
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Entrar - Arula.</title>
<link rel="shortcut icon" href="../assets/icon.png" type="image/x-icon">

  <!-- CSS files -->
  <link href=".././dist/css/tabler.min.css?1684106062" rel="stylesheet" />
  <link href=".././dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
  <link href=".././dist/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
  <link href=".././dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
  <link href=".././dist/css/demo.min.css?1684106062" rel="stylesheet" />
  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }
  </style>
</head>

<body class=" d-flex flex-column">
  <script src=".././dist/js/demo-theme.min.js?1684106062"></script>
  <div class="page page-center">
    <div class="container container-tight py-4">
      <div class="text-center mb-4">
        <a href="../" class="navbar-brand navbar-brand-autodark"><img src="../assets/logo_2.svg" height="36" alt=""></a>
      </div>
      <div class="card card-md">
        <div class="card-body">
          <h2 class="h2 text-center mb-4">Entrar</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
              <label class="form-label">Usuário</label>
              <input type="text" class="form-control" name="p_username" value="<?php echo $p_username; ?>" placeholder="Usuário">
              <?php
              if (!empty($login_err)) {
                echo '<span class="text-danger">' . $login_err . '</span>';
              }
              ?>
            </div>
            <div class="mb-2">
              <label class="form-label">
                Senha
                <!-- <span class="form-label-description">
                  <a href="./forgot-password.php">Esqueci a senha</a>
                </span> -->
              </label>
              <div class="input-group input-group-flat">
                <!-- <input type="password" class="form-control" name="password" id="myInput" placeholder="Sua senha"> -->
                <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" name="password" id="myInput" placeholder="Senha">

                <span class="input-group-text">
                  <a onclick="myFunction()" class="link-secondary" title="Mostrar Senha" data-bs-toggle="tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <circle cx="12" cy="12" r="2" />
                      <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                    </svg>
                  </a>
                </span>
              </div>
              <?php
              if (!empty($password_err)) {
                echo '<span class="text-danger">' . $password_err . '</span>';
              }
              ?>
            </div>

            <!-- <div class="mb-2">
              <label class="form-check">
                <input type="checkbox" class="form-check-input" />
                <span class="form-check-label">Lembrar de mim nesse dispositivo.</span>
              </label>
            </div> -->
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </div>
          </form>
        </div>
      </div>

      <div class="text-center text-muted mt-3">
        Ainda não tem um conta? <a href="./sign-up.php">Cadastre-se.</a>
      </div>

      <!-- <div class="text-center text-muted mt-3">
          Ainda? <a href="../sign-up.html" tabindex="-1">Sign up</a>
        </div> -->
    </div>
  </div>
  <!-- Libs JS -->
  <!-- Tabler Core -->
  <script src=".././dist/js/tabler.min.js?1684106062" defer></script>
  <script src=".././dist/js/demo.min.js?1684106062" defer></script>

  <script>
    function myFunction() {
      var x = document.getElementById("myInput");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>
</body>

</html>