<?php
// Incluir arquivo de configuração
require_once "../db/verifica.php";


session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  session_destroy();
  // exit;
}

function generateRandomString($length = 7) {
  $characters = '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[random_int(0, $charactersLength - 1)];
  }
  return $randomString;
}


// $username = $username_err = "";
$userEmail = $confirm_email = $p_username_err = $confirm_email_err = "";
$password = $password_err = $confirm_password = "";
$userCPF = $userCPF_err = "";
$userFistName = $userFistName_err = "";
$userLastName = $userLastName_err = "";
 
// Processando dados do formulário quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){


 
    // Validar Email
    if(empty(trim($_POST["p_username"]))){
        $p_username_err = "Por favor coloque um Email.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["p_username"]))){
        $p_username_err = "Ops, isso não é um Email Válido.";
    } else{
        // Prepare uma declaração selecionada
        $sql = "SELECT username FROM users WHERE username = :p_username";
        
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":p_username", $param_username, PDO::PARAM_STR);
            
            // Definir parâmetros
            $param_username = trim($_POST["p_username"]);
            
            // Tente executar a declaração preparada
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $p_username_err = "Este usuário já está em uso.";
                } else{
                    $p_username = trim($_POST["p_username"]);
                }
            } else{
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }


    // Validar senha
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor insira uma senha.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "A senha deve ter pelo menos 6 caracteres.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Verifique os erros de entrada antes de inserir no banco de dados
    if(empty($p_username_err) && empty($password_err)){

        // Prepare uma declaração de inserção
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
         
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            // $stmt->bindParam(":lastname", $param_lastname, PDO::PARAM_STR);
            $param_username = $p_username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            
            // Tente executar a declaração preparada
            if($stmt->execute()){
                // Redirecionar para a página de login
                header("location: sign-in");
            } else{
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
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Criar Conta - Arula.</title>
<link rel="shortcut icon" href="../assets/icon.png" type="image/x-icon">
    <!-- CSS files -->
    <link href=".././dist/css/tabler.min.css?1684106062" rel="stylesheet"/>
    <link href=".././dist/css/tabler-flags.min.css?1684106062" rel="stylesheet"/>
    <link href=".././dist/css/tabler-payments.min.css?1684106062" rel="stylesheet"/>
    <link href=".././dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet"/>
    <link href=".././dist/css/demo.min.css?1684106062" rel="stylesheet"/>
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
  <body  class=" d-flex flex-column">
    <script src=".././dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="../" class="navbar-brand navbar-brand-autodark"><img src="../assets/logo_2.svg" height="36" alt=""></a>
        </div>
        <form class="card card-md" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Criar uma nova Conta</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <div class="mb-3">
              <label class="form-label required">Nome Completo</label>
              <input type="text" class="form-control" placeholder="Guilherme Facury" name="">
            </div>
            
            <div class="mb-3">
              <label class="form-label required">Email</label>
              <input type="email" class="form-control" placeholder="guilherme.facury@icloud.com" name="" maxlength="">
            </div>

            <div class="mb-3">
              <label class="form-label required">Usuário</label>
              <input type="text" class="form-control" value="<?php echo $userFistName; ?>" placeholder="futvidal" name="p_username" maxlength="16" onkeypress="return event.charCode != 32" required>
              <span class="text-danger fw-bold"><?= $p_username_err; ?></span>
            </div>
            

            <div class="mb-2">
            <label class="form-label required">
              Senha
            </label>
            <div class="input-group input-group-flat">
              <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password_err; ?>" name="password" id="myInput" placeholder="Senha">
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
          </div>
            <div class="mb-3">
              <label class="form-check">
                <input type="checkbox" class="form-check-input" required/>
                <span class="form-check-label">Eu Concordo com <a href="../licence" tabindex="-1">Termos e Condições</a>.</span>
              </label>
            </div>
            <div class="form-footer">
              <button type="submit" id="NewUserForm" class="btn btn-primary w-100">Criar</button>
            </div>
            </form>
          </div>
        </form>
        <div class="text-center text-muted mt-3">
          Já tem uma Conta? <a href="./sign-in" tabindex="-1">Entrar</a>
        </div>
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