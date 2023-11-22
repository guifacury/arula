<?php
session_start();
require_once "./db/verifica.php";

if (!isset($_SESSION["loggedin"])) {
  header("Location: auth/sign-in");
  exit();
}

$ac_type = $_SESSION["account_type"];

if ($ac_type == 1) {
  header("Location: noplan");
}

$username = $_SESSION["username"];
?>

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

<body>
  <script src="./dist/js/demo-theme.min.js?1684106062"></script>





  <div class="page">
    <!-- Navbar -->
    <?php require_once "./partials/header_h.php"; ?>

    <div class="page-wrapper">

      <!-- Page body -->
      <div class="page-body">
        <div class="container-xl">


          <div class="row row-cards row-deck">
            <div class="d-flex">
              <div class="card-title mb-0 fw-bold">Meus Cursos</div>
            </div>

            <?php

            if ($ac_type == 2) {
              $sql = "SELECT * FROM users WHERE username = '$username'";
              $sql = $pdo->prepare($sql);
              $sql->execute();
              if ($sql->rowCount() > 0) {
                foreach ($sql->fetchAll() as $value) {
                  $access = $value['access'];    
                }
              }
              $courses_access = json_decode($access);
                $courses_db = implode(',', $courses_access);

              if (sizeof($courses_access) > 0) {
                $sql = "SELECT * FROM cursos WHERE id IN ($courses_db)";
              }
            } else if ($ac_type == 3) {
              $sql = "SELECT * FROM cursos";
            } else {
              header("Location: auth/sign-in");
              exit();
            }

            // $sql = "SELECT * FROM cursos";
            $sql = $pdo->prepare($sql);
            $sql->execute();

            if ($sql->rowCount() > 0) {
              foreach ($sql->fetchAll() as $value) {
                $id = $value['id'];
                $nome = $value['nome'];
                $descricao = $value['descricao'];
                $type = $value['type'];
                $videos = $value['videos'];
                $duracao = $value['duracao'];
                $difficulty = $value['difficulty'];

                switch ($type) {
                  case '1':
                    $df = "Iniciante";
                    break;
                  case '2':
                    $df = "Mediano";
                    break;
                  case '3':
                    $df = "Avançado";
                    break;
                }

                switch ($type) {
                  case '1':
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-python text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 9h-7a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h3" />
                    <path d="M12 15h7a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-3" />
                    <path d="M8 9v-4a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v5a2 2 0 0 1 -2 2h-4a2 2 0 0 0 -2 2v5a2 2 0 0 0 2 2h4a2 2 0 0 0 2 -2v-4" />
                    <path d="M11 6l0 .01" />
                    <path d="M13 18l0 .01" />
                    </svg>';
                    $color = "primary";
                    break;
                  case '2':
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-php text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M17 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M11 21v-6" /><path d="M14 15v6" /><path d="M11 18h3" /></svg>';
                    $color = "purple";
                    break;
                  case '3':
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-javascript text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 4l-2 14.5l-6 2l-6 -2l-2 -14.5z" /><path d="M7.5 8h3v8l-2 -1" /><path d="M16.5 8h-2.5a.5 .5 0 0 0 -.5 .5v3a.5 .5 0 0 0 .5 .5h1.423a.5 .5 0 0 1 .495 .57l-.418 2.93l-2 .5" /></svg>';
                    $color = "yellow";
                    break;
                  case '4':
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-react-native text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6.357 9c-2.637 .68 -4.357 1.845 -4.357 3.175c0 2.107 4.405 3.825 9.85 3.825c.74 0 1.26 -.039 1.95 -.097" /><path d="M9.837 15.9c-.413 -.596 -.806 -1.133 -1.18 -1.8c-2.751 -4.9 -3.488 -9.77 -1.63 -10.873c1.15 -.697 3.047 .253 4.974 2.254" /><path d="M6.429 15.387c-.702 2.688 -.56 4.716 .56 5.395c1.783 1.08 5.387 -1.958 8.043 -6.804c.36 -.67 .683 -1.329 .968 -1.978" /><path d="M12 18.52c1.928 2 3.817 2.95 4.978 2.253c1.85 -1.102 1.121 -5.972 -1.633 -10.873c-.384 -.677 -.777 -1.204 -1.18 -1.8" /><path d="M17.66 15c2.612 -.687 4.34 -1.85 4.34 -3.176c0 -2.11 -4.408 -3.824 -9.845 -3.824c-.747 0 -1.266 .029 -1.955 .087" /><path d="M8 12c.285 -.66 .607 -1.308 .968 -1.978c2.647 -4.844 6.253 -7.89 8.046 -6.801c1.11 .679 1.262 2.706 .56 5.393" /><path d="M12.26 12.015h-.01c-.01 .13 -.12 .24 -.26 .24a.263 .263 0 0 1 -.25 -.26c0 -.14 .11 -.25 .24 -.25h-.01c.13 -.01 .25 .11 .25 .24" /></svg>';
                    $color = "cyan";
                    break;
                  case '5':
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-stack-2 text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 4l-8 4l8 4l8 -4l-8 -4"></path><path d="M4 12l8 4l8 -4"></path><path d="M4 16l8 4l8 -4"></path></svg>';
                    $color = "teal";
                    break;
                  case '6':
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-abacus text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 3v18"></path><path d="M19 21v-18"></path><path d="M5 7h14"></path><path d="M5 15h14"></path><path d="M8 13v4"></path><path d="M11 13v4"></path><path d="M16 13v4"></path><path d="M14 5v4"></path><path d="M11 5v4"></path><path d="M8 5v4"></path><path d="M3 21h18"></path></svg>';
                    $color = "google";
                    break;
                  default:
                    $icon = "error";
                    $color = "black";
                }


            ?>

                <div class="col-md-4 course_el" data-el-type="<?= $type ?>">
                  <div class="card">
                    <div class="card-body">

                      <div class="row align-items-center mb-1">
                        <div class="col-auto">
                          <span class="avatar avatar-md bg-<?= $color ?>">
                            <?= $icon ?>
                          </span>
                        </div>
                        <div class="col">
                          <div class="fw-bold h4 mb-1"><?= $nome ?></div>
                          <div class="text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-hour-3 me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                              <path d="M12 12h3.5" />
                              <path d="M12 7v5" />
                            </svg><?= $duracao . " | " . $df ?>
                          </div>
                        </div>
                      </div>
                      <?php if ($ac_type == 2) { ?>
                        <div class="mt-3">
                          <div class="row">
                            <div class="col-md-6 mb-2">
                              <a href="./view_course?c_id=<?= $id ?>" class="w-100 btn btn-outline-primary">Assistir</a>
                            </div>
                            <div class="col-md-6 mb-2">
                              <a href="#" class="w-100 btn btn-outline-teal reembolsar_btn" data-course-id="<?=$id?>">Reembolso</a>
                            </div>
                          </div>
                        </div>
                        <?php } ?>
                      <?php if ($ac_type == 3) { ?>
                        <div class="mt-2">
                          <a href="./view_course?c_id=<?= $id ?>" class="w-100 btn btn-outline-primary">Assistir</a>
                        </div>
                        <?php } ?>
                    </div>
                  </div>
                </div>

            <?php
              }
            }
            ?>


          </div>








        </div>

        <div class="modal modal-blur fade" id="modal_reembolso" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="modal-status bg-teal"></div>
              <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-teal icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                <h3>Você quer mesmo reembolsar?</h3>
                <div class="text-secondary">Cuidado, essa ação não pode ser desfeita.</div>
              </div>
              <div class="modal-footer">
                <div class="w-100">
                  <div class="row">
                    <div class="col">
                      <a href="#" class="btn w-100" data-bs-dismiss="modal">
                        Cancelar.
                      </a>
                    </div>
                    <div class="col">
                      <a href="#" class="btn btn-teal w-100" id="reembolsar_confirm" data-bs-dismiss="modal">
                        Sim, eu quero.
                      </a>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="modal modal-blur fade" id="modal-small" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <div class="modal-title">Você já conhece os nossos planos?</div>
                <div>Torne-se um profissional na sua área com as vantagens de ser um membro.</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-link text-danger me-auto" data-bs-dismiss="modal">Não quero.</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Quero ser membro.</button>
              </div>
            </div>
          </div>
        </div>

      </div>
      <?php require "./partials/footer_arola.php"; ?>

    </div>
  </div>
  <!-- Libs JS -->
  <script src="./dist/libs/apexcharts/dist/apexcharts.min.js?1684106062" defer></script>
  <!-- Tabler Core -->
  <script src="./dist/js/tabler.min.js?1684106062" defer></script>
  <script src="./dist/js/demo.min.js?1684106062" defer></script>
  <script src="./dist/js/jquery3-7.min.js"></script>

  <script>
    $(document).ready(function() {


      <?php if (isset($_SESSION["arula_member"]) && $_SESSION["arula_member"] == false) { ?>

function numeroAleatorioNoIntervalo(min, max) {
  return Math.round(Math.random() * (max - min)) + min;
}
randowInt = numeroAleatorioNoIntervalo(1, 5);
randowInt = parseInt(randowInt);
console.log(randowInt);
if (randowInt == 1) {
  $("#modal-small").modal("show");
}


<?php } ?>





      var course_id;
      $(".reembolsar_btn").on("click", function(e) {
        e.preventDefault();
        get_id = $(this).data('course-id');
        course_id = parseInt(get_id);
        $("#modal_reembolso").modal("show");
      });

      $("#reembolsar_confirm").on("click", function(e) {
        e.preventDefault();

        formData = {
          type: "reembolsar_course",
          course_id: course_id,
        };
        console.log(formData);
        event.preventDefault();
        $.ajax({
          type: "POST",
          url: "./posts/ajax.php",
          data: formData,
          dataType: "json",
          encode: true,
          success: function(data) {
            // console.log(data);
            response = data;
            console.log(response);
            location.reload(true);
          },
          error: function(xhr, status, error) {
            console.log("Erro na requisição: " + error);
          }
        });


      });


      $(".show_all").on("click", function(e) {
        e.preventDefault();
        $('.course_el').show();
      });






      $(".filter_course").on("click", function(e) {
        e.preventDefault();
        $course_type = $(this).data("course-type");
        $('.course_el').each(function() {
          el_type = $(this).data('el-type');
          // Verifica se o texto do produto contém o filtro
          if ($course_type == el_type) {
            $(this).slideDown(); // Exibe o produto se o filtro corresponder
          } else {
            $(this).hide(); // Oculta o produto se o filtro não corresponder
          }
        });
        // $("#btn_hide_nav").trigger("click");
      });


    });
  </script>


</body>

</html>


<!-- SE NÃO DER O PONTO CHEIO É VIADO -->