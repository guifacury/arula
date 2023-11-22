<?php

session_start();
require_once "./db/verifica.php";


if (!isset($_SESSION["loggedin"])) {
  header("Location: auth/sign-in");
  exit();
}

if (!isset($_SESSION["username"])) {
  header("Location: auth/sign-in");
  exit();
}

$username = $_SESSION["username"];






if (isset($_GET['c_id'])) {
  if ($_GET['c_id'] != "") {
    $c_id = $_GET['c_id'];
    $sql = "SELECT * FROM videos WHERE curso_id = $c_id";
    $sql = $pdo->prepare($sql);
    $sql->execute();

    if ($sql->rowCount() > 0) {
      foreach ($sql->fetchAll() as $value) {
        $curso_id = $value['curso_id'];
      }
    }
  }
} else {
  echo "ERROR 902";
  exit();
}


$sql = "SELECT * FROM users WHERE username = '$username'";
$sql = $pdo->prepare($sql);
$sql->execute();
if ($sql->rowCount() > 0) {
  foreach ($sql->fetchAll() as $value) {
    $access = $value['access'];
    if ($access != "") {
      $courses_access = json_decode($access);
      if (in_array($c_id, $courses_access)) {
        header("Location: index");
        exit();
      }
    }
  }
}

?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>ARULA - Plataforma de ensino</title>
<link rel="shortcut icon" href="./assets/icon.png" type="image/x-icon">
  
  <!-- CSS files -->
  <link href="./dist/css/tabler.min.css?1684106062" rel="stylesheet" />
  <link href="./dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
  <link href="./dist/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
  <link href="./dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
  <link href="./dist/css/demo.min.css?1684106062" rel="stylesheet" />
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
  <script src="./dist/js/demo-theme.min.js?1684106062"></script>
  <div class="page page-center">
    <div class="container container-tight py-4">
      <div class="text-center mb-4">
        <a href="." class="navbar-brand navbar-brand-autodark"><img src="./assets/logo_2.svg" height="36" alt=""></a>
      </div>
      <div class="card card-md">
        <div class="card-body">
          <h3 class="mb-2">Você ainda não tem acesso a esse curso.</h3>
          <p class="text-muted mb-3">
            Você precisa assinar um dos nossos pacotes ou comprar esse curso.
          </p>

          <?php if ($c_id != "") { ?>

            <div class="card mb-3" style="height:16rem;">
              <div class="card-header border-0">
                <div class="card-title">
                  Preview do Curso
                </div>
              </div>
              <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                <div class="divide-y">


                  <?php
                  $sql = "SELECT * FROM videos WHERE curso_id = $c_id";
                  $sql = $pdo->prepare($sql);
                  $sql->execute();
                  $counter = 1;
                  if ($sql->rowCount() > 0) {
                    foreach ($sql->fetchAll() as $value) {
                      $aula_id = $value['id'];
                      $curso_id = $value['curso_id'];
                      $title = $value['title'];
                      $thumb = $value['thumb'];
                      if ($thumb == "") {
                        $thumb = "error.jpg";
                      }
                      $display = "";
                      $sec_d = "";

                  ?>
                      <div class="course_video" id="" data-aula-id="<?= $aula_id ?>">
                        <div class="row align-items-center">

                          <div class="col-4">
                            <div class="card-img-top img-responsive img-responsive-16x9" style="background-image: url(./assets/thumbs/<?= $thumb ?>);"></div>

                          </div>
                          <div class="col">
                            <h3 class="card-title mb-1">
                              <a href="#" class="text-reset">
                                <div class="align-items-center d-flex">
                                  <div>
                                    Aula #<?= sprintf("%02d", $counter) ?>
                                  </div>
                                  <div class="ms-2" style="<?= $sec_d ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                      <path d="M9 15l6 -6" />
                                      <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" />
                                      <path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" />
                                    </svg>
                                  </div>
                                </div>
                              </a>
                            </h3>
                            <div class="text-muted">
                              <?= $title ?>
                            </div>
                          </div>
                        </div>
                      </div>
                  <?php
                      $counter++;
                    }
                  }

                  ?>



                </div>
              </div>
            </div>

          <?php } ?>


          <div class="mb-2">
            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-simple" class="btn btn-purple btn-lg w-100">
              Comprar esse Curso
            </a>
          </div>
          <div class="mb-2">
            <a href="./buycourse.php" class="btn w-100">
              Ver Planos
            </a>
          </div>
          <p class="text-muted">
            Caso precise de ajuda, <a href="https://wa.me/+5579999211200">fale com a gente</a>.
          </p>
        </div>
      </div>
    </div>

    <div class="modal modal-blur fade" id="modal-simple" tabindex="-1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-title">Você está comprando esse Curso.</div>
            <div class="mb-2">Ao clicar em comprar você terá acesso imediato ao curso.</div>

            <div class="">
              <label class="form-label">Método de Pagamento</label>
              <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                <label class="form-selectgroup-item flex-fill">
                  <input type="radio" name="form-payment" value="visa" class="form-selectgroup-input">
                  <div class="form-selectgroup-label d-flex align-items-center p-3">
                    <div class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </div>
                    <div>
                      <span class="payment payment-provider-visa payment-xs me-2"></span>
                      Visa de final <strong>7998</strong>
                    </div>
                  </div>
                </label>
                <label class="form-selectgroup-item flex-fill">
                  <input type="radio" name="form-payment" value="mastercard" class="form-selectgroup-input" checked="">
                  <div class="form-selectgroup-label d-flex align-items-center p-3">
                    <div class="me-3">
                      <span class="form-selectgroup-check"></span>
                    </div>
                    <div>
                      <span class="payment payment-provider-mastercard payment-xs me-2"></span>
                      Mastercard de final <strong>2807</strong>
                    </div>
                  </div>
                </label>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Voltar</button>
            <button type="button" class="btn btn-purple" data-bs-dismiss="modal" id="buycourse">Quero comprar</button>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- Libs JS -->
  <!-- Tabler Core -->
  <script src="./dist/js/tabler.min.js?1684106062" defer></script>
  <script src="./dist/js/demo.min.js?1684106062" defer></script>
  <script src="./dist/js/jquery3-7.min.js"></script>



  <script>
    $(document).ready(function() {

    
      $("#buycourse").on("click", function(e){
        event.preventDefault();
        

        c_id = <?= $c_id ?>;

        formData = {
          type: "new_course_access",
          c_id: c_id,
        };
        console.log(formData);
        $.ajax({
          type: "POST",
          url: "./posts/ajax.php",
          data: formData,
          dataType: "json",
          encode: true,
          success: function(data) {
            console.log(data);
            response = data;
            if (response.status = 1) {
              location.href = `view_course.php?c_id=${c_id}`;
            }

          },
          error: function(xhr, status, error) {
            console.log("Erro na requisição: " + error);
          }
        });



      });

    });
  </script>


</body>

</html>