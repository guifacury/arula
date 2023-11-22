<?php

session_start();

require_once "./db/verifica.php";
$courses_watched = array();

if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  $sql = "SELECT * FROM history WHERE username = '$username'";
  $sql = $pdo->prepare($sql);
  $sql->execute();
  if ($sql->rowCount() > 0) {
    foreach ($sql->fetchAll() as $value) {
      $c_id = $value['c_id'];
      if (!in_array($c_id, $courses_watched)) {
        $courses_watched[] = $c_id;
      }
    }
  }
}



// print_r($courses_watched);



function check_proccess($course, $username)
{
  global $pdo;

  // BUSCAR QUANTAS AULAS TEM O CURSO
  // VER QUANTAS O USUARIO JA ASSISTIU

  $sql = "SELECT * FROM videos WHERE curso_id = $course";
  $sql = $pdo->prepare($sql);
  $sql->execute();
  $aulas_arr = array();
  $qty_aulas = $sql->rowCount();
  if ($qty_aulas > 0) {
    foreach ($sql->fetchAll() as $value) {
      $id = $value['id'];
      $aulas_arr[] = $id;
    }
  }

  $sql = "SELECT * FROM history WHERE username = '$username' AND c_id = $course ORDER BY id ASC";
  $sql = $pdo->prepare($sql);
  $sql->execute();
  $counter = 0;
  if ($sql->rowCount() > 0) {
    foreach ($sql->fetchAll() as $value) {
      $video_id = $value['video_id'];
      $last = $value['created'];
      if (in_array($video_id, $aulas_arr)) {
        $counter++;
      }
    }
  }
  $pp = ($counter / $qty_aulas) * 100;

  $arr_response = array(
    "pp" => $pp,
    "last" => $last,
  );

  $arr_encoded = json_encode($arr_response);

  return $arr_encoded;
}


$cc = 1;
$sz_c = sizeof($courses_watched);





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

          <?php

          if (isset($_SESSION["loggedin"])) {
            if ($sz_c > 0) {

              if ($sz_c == 1) {
                $col_size = "12";
              } else {
                $col_size = "6";
              }

          ?>

              <div class="row row-cards row-deck mb-5">

                <?php
                foreach ($courses_watched as $curso) {
                  if ($cc <= 2) {

                    $sql = "SELECT * FROM cursos WHERE id = $curso LIMIT 1";
                    $sql = $pdo->prepare($sql);
                    $sql->execute();
                    if ($sql->rowCount() > 0) {
                      foreach ($sql->fetchAll() as $value) {
                        $c_name = $value['nome'];
                        $type = $value['type'];
                      }
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


                    $fc_response = check_proccess($curso, $username);
                    $dec_c = json_decode($fc_response, true);
                    $porc = $dec_c["pp"];
                    $porc = intval($porc);
                    $lastView = $dec_c["last"];
                    $datetime = new DateTime($lastView);
                    $date = $datetime->format('d/m/Y');
                    $time = $datetime->format('H:i');

                    if ($porc != "100") {



                ?>
                      <div class="col-lg-6">
                        <div class="card">
                          <div class="card-body">
                            <div class="row align-items-center">
                              <div class="col-auto">
                                <!-- <img src="./assets/imgs/python.png" alt="" class="rounded"> -->
                                <span class="avatar avatar-lg bg-<?= $color ?>">
                                  <?= $icon ?>
                                </span>
                              </div>
                              <div class="col">
                                <h3 class="card-title mb-1 text-truncate">
                                  <a href="#" class="text-reset"><?= $c_name ?></a>
                                </h3>
                                <div class="text-muted">
                                  Visto por último: <?= $date . " - " . $time ?>
                                </div>
                                <div class="mt-3">
                                  <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                      <?= $porc ?>%
                                    </div>
                                    <div class="col">
                                      <div class="progress progress-sm">
                                        <div class="progress-bar" style="width: <?= $porc ?>%" role="progressbar" aria-valuenow="<?= $porc ?>" aria-valuemin="0" aria-valuemax="100" aria-label="<?= $porc ?>% Complete">
                                          <span class="visually-hidden"><?= $porc ?>% Complete</span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-auto">
                                <!-- <div class="dropdown">
                                  <a href="#" class="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                      <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                      <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                      <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    </svg>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-end">
                                    <a href="#" class="dropdown-item text-danger">Resetar Progresso</a>
                                  </div>
                                </div> -->
                                <a href="./view_course?c_id=<?=$curso?>" class="btn btn-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                <?php
                      $cc++;
                    }
                  }
                }

                ?>


              </div>



          <?php
            }
          }
          ?>



          <div class="row row-cards row-deck">
            <div class="d-flex">
              <div class="card-title mb-0 fw-bold">Cursos Disponíveis</div>
              <a href="#" class="ms-auto">Ver todos os Cursos <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                  <path d="M11 13l9 -9" />
                  <path d="M15 4h5v5" />
                </svg></a>
            </div>
            <!-- <div class="col-md-6 col-lg-3">
                <div class="card">
                  <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://i.ytimg.com/vi/S9uPNppGsGo/hqdefault.jpg?sqp=-oaymwEiCKgBEF5IWvKriqkDFQgBFQAAAAAYASUAAMhCPQCAokN4AQ==&rs=AOn4CLCUckYRqeqBABURzsBMNgm_DyilYg)"></div>
                  <div class="card-body">
                    <h3 class="card-title">Card with top image</h3>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam deleniti fugit incidunt, iste, itaque minima
                      neque pariatur perferendis sed suscipit velit vitae voluptatem.</p>
                      <a href="" class="w-100 btn btn-outline-primary">Saber mais</a>
                  </div>
                </div>
              </div> -->



            <!-- <div class="col-md-4">
              <div class="card">
                <div class="card-body">

                  <div class="row align-items-center">
                    <div class="col-auto">
                      <span class="avatar avatar-md bg-google">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-python text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M12 9h-7a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h3" />
                          <path d="M12 15h7a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-3" />
                          <path d="M8 9v-4a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v5a2 2 0 0 1 -2 2h-4a2 2 0 0 0 -2 2v5a2 2 0 0 0 2 2h4a2 2 0 0 0 2 -2v-4" />
                          <path d="M11 6l0 .01" />
                          <path d="M13 18l0 .01" />
                        </svg>
                      </span>
                    </div>
                    <div class="col">
                      <div class="fw-bold h4 mb-1">Python: Entendendo a Orientação a Objetos</div>
                      <div class="text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-hour-3 me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                          <path d="M12 12h3.5" />
                          <path d="M12 7v5" />
                        </svg>8 horas | Iniciante
                      </div>
                    </div>
                  </div>
                  <div class="mt-2">
                    <a href="#" class="w-100 btn btn-outline-primary">Saber mais</a>
                  </div>
                </div>
              </div>
            </div> -->



            <?php
            $sql = "SELECT * FROM cursos";
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

                      <div class="row align-items-center">
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
                      <div class="mt-2">
                        <a href="./view_course?c_id=<?= $id ?>" class="w-100 btn btn-outline-primary">Saber mais</a>
                      </div>
                    </div>
                  </div>
                </div>

            <?php
              }
            }
            ?>


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