<?php

session_start();

require_once "./db/verifica.php";



$sess_user = $_SESSION['username'];


if (isset($_GET['c_id'])) {
  if ($_GET['c_id'] != "") {
    $c_id = $_GET['c_id'];
    $sql = "SELECT * FROM videos WHERE curso_id = $c_id ORDER BY id ASC";
    $sql = $pdo->prepare($sql);
    $sql->execute();

    if ($sql->rowCount() > 0) {
      foreach ($sql->fetchAll() as $value) {
        $curso_id = $value['curso_id'];
        $v_id = $value['id'];
        header("Location: ?v_id=$v_id");
        exit;
      }
    }
  }
}


if (isset($_GET['v_id'])) {
  if ($_GET['v_id'] != "") {
    $v_id = $_GET['v_id'];
    // BUSCAR INFORMAÇÕES DO CURSO
    $sql = "SELECT * FROM videos WHERE id = $v_id";
    $sql = $pdo->prepare($sql);
    $sql->execute();
    if ($sql->rowCount() > 0) {
      foreach ($sql->fetchAll() as $value) {
        $curso_id = $value['curso_id'];
        $yt_id = $value['yt_id'];
      }
    } else {
      header("Location: index");
      exit();
    }
  } else {
    header("Location: index");
    exit();
  }
} else {
  header("Location: index");
  exit();
}

if (!isset($curso_id)) {
  echo "ERROR 502";
  exit();
}

$cid_int = intval($curso_id);


if (isset($_SESSION['account_type'])) {
  $c_type = $_SESSION['account_type'];
  if ($c_type == 1) {
    // header("Location: noplan");
    header("Location: noaccess?c_id=$cid_int");

    exit();
  } elseif ($c_type == 2) {
    // $verify = 3;

    $sql = "SELECT * FROM users WHERE username = '$sess_user'";
    $sql = $pdo->prepare($sql);
    $sql->execute();
    if ($sql->rowCount() > 0) {
      foreach ($sql->fetchAll() as $value) {
        $access = $value['access'];
      }
    }


    $courses_access = json_decode($access);

    if (!in_array($cid_int, $courses_access)) {
      header("Location: noaccess?c_id=$cid_int");
      exit();
    }
  } elseif ($c_type == 3) {
    // PERMITE O ACESSO
  } else {
    // NENHUM OUTRO TIPO DE CONTA POSSÍVEL
  }
} else {
  header("Location: auth/sign-in.php");
  exit();
}

$history = array();

$sql_h = "SELECT * FROM history WHERE username = '$sess_user'";
$sql_h = $pdo->prepare($sql_h);
$sql_h->execute();
if ($sql_h->rowCount() > 0) {
  foreach ($sql_h->fetchAll() as $value) {
    $video_id = $value['video_id'];
    $video_id = intval($video_id);
    $history[] = $video_id;
  }
}




// VERIFICA SE JA AVALIOU


$sql = "SELECT * FROM ratings WHERE video_id = $v_id AND user = '$sess_user' LIMIT 1";
$sql = $pdo->prepare($sql);
$sql->execute();

if ($sql->rowCount() > 0) {
  $rate_div = "display:none";
  $already_rate = "";
} else {
  $already_rate = "display:none";
  $rate_div = "";
}


?>

<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>ARULA - Plataforma de ensino</title>
  <link rel="shortcut icon" href="./assets/icon.png" type="image/x-icon">
  <!-- CSS files -->
  <link href="./dist/libs/plyr/dist/plyr.css?1684106062" rel="stylesheet" />
  <link href="./dist/libs/star-rating.js/dist/star-rating.min.css?1684106062" rel="stylesheet" />

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

    .icon-star {
      --tblr-icon-size: 2.0rem;
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



          <div class="row row-cards">
            <div class="col-md-4">
              <div class="card" style="height:30rem;">
                <div class="card-header border-0">
                  <div class="card-title">
                    Aulas Disponíveis
                  </div>
                </div>
                <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                  <div class="divide-y">


                    <?php
                    $sql = "SELECT * FROM videos WHERE curso_id = $curso_id";
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

                        if ($v_id == $aula_id) {
                          $display = "";
                          $sec_d = "display:none;";
                        } else {
                          $sec_d = "";
                          $display = "display:none;";
                        }
                    ?>
                        <div class="course_video" id="" data-aula-id="<?= $aula_id ?>">
                          <div class="row align-items-center">

                            <div class="col-auto badgeSelect" style="padding-right: 2px;<?= $display ?>">
                              <span class="badge bg-primary-lt">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye ms-0 me-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                  <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                  <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                </svg>
                              </span>
                            </div>




                            <div class="col-4">
                              <div class="card-img-top img-responsive img-responsive-16x9" style="background-image: url(./assets/thumbs/<?= $thumb ?>);"></div>

                            </div>
                            <div class="col">
                              <h3 class="card-title mb-1">
                                <a href="#" class="text-reset redirect_video" data-link-video="?v_id=<?= $aula_id ?>">
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

                            <?php

                            if (in_array($aula_id, $history)) {
                            ?>
                              <div class="col-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-discount-check text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                  <path d="M5 7.2a2.2 2.2 0 0 1 2.2 -2.2h1a2.2 2.2 0 0 0 1.55 -.64l.7 -.7a2.2 2.2 0 0 1 3.12 0l.7 .7c.412 .41 .97 .64 1.55 .64h1a2.2 2.2 0 0 1 2.2 2.2v1c0 .58 .23 1.138 .64 1.55l.7 .7a2.2 2.2 0 0 1 0 3.12l-.7 .7a2.2 2.2 0 0 0 -.64 1.55v1a2.2 2.2 0 0 1 -2.2 2.2h-1a2.2 2.2 0 0 0 -1.55 .64l-.7 .7a2.2 2.2 0 0 1 -3.12 0l-.7 -.7a2.2 2.2 0 0 0 -1.55 -.64h-1a2.2 2.2 0 0 1 -2.2 -2.2v-1a2.2 2.2 0 0 0 -.64 -1.55l-.7 -.7a2.2 2.2 0 0 1 0 -3.12l.7 -.7a2.2 2.2 0 0 0 .64 -1.55v-1" />
                                  <path d="M9 12l2 2l4 -4" />
                                </svg>
                              </div>
                            <?php
                            } else { ?>

                              <div class="col-auto" style="padding-right: 2px;<?= $sec_d ?>">
                                <a href="#" class="download_btn">
                                  <span class="badge bg-purple-lt">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                      <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                      <path d="M7 11l5 5l5 -5" />
                                      <path d="M12 4l0 12" />
                                    </svg>
                                  </span>
                                </a>
                              </div>

                            <?php } ?>




                          </div>
                        </div>
                    <?php
                        $counter++;
                      }
                    }

                    ?>

                    <!-- <div class="course_video" id="Er2fFvNCY" data-aula-id="2">
                      <div class="row align-items-center">
                        <div class="col-auto badgeSelect" style="padding-right: 2px;">
                          <span class="badge bg-primary-lt">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right ms-0 me-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <path d="M9 6l6 6l-6 6"></path>
                            </svg>
                          </span>
                        </div>
                        <div class="col-4">
                          <div class="card-img-top img-responsive img-responsive-16x9" style="background-image: url(https://i.ytimg.com/vi/S9uPNppGsGo/hqdefault.jpg?sqp=-oaymwEiCKgBEF5IWvKriqkDFQgBFQAAAAAYASUAAMhCPQCAokN4AQ==&amp;rs=AOn4CLCUckYRqeqBABURzsBMNgm_DyilYg);"></div>
                        </div>
                        <div class="col">
                          <h3 class="card-title mb-1">
                            <a href="#" class="text-reset">Introdução a Python</a>
                          </h3>
                          <div class="text-muted">
                            Aula #01
                          </div>

                        </div>
                      </div>
                    </div> -->


                  </div>
                </div>
                <div class="card-footer">
                  <div class="row">

                    <div class="col mb-2">
                      <a href="#" class="btn btn-outline-primary w-100 next_video">Próxima Aula</a>
                      <a href="./assets/certificado.pdf" class="btn btn-purple w-100 download_certificado" download="certificado.pdf" style="display:none;"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                          <path d="M7 11l5 5l5 -5" />
                          <path d="M12 4l0 12" />
                        </svg> Baixar Certificado</a>
                    </div>
                    <div class="col-auto mb-2">
                      <a href="#" class="btn btn-outline-purple btn-icon w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                          <path d="M7 11l5 5l5 -5" />
                          <path d="M12 4l0 12" />
                        </svg>
                      </a>
                    </div>


                  </div>
                </div>


              </div>
            </div>

            <div class="col-md-8">
              <div class="card">
                <div class="card-body p-0">
                  <div id="player-youtube" data-plyr-provider="youtube" data-plyr-embed-id="<?= $yt_id ?>"></div>
                </div>

              </div>
            </div>

            <div class="col-md-12">
              <div class="card">
                <div class="card-body">

                  <div class="row row-cards">

                    <div class="col-md-4">


                      <div id="rate_div" style="<?= $rate_div ?>">
                        <div class="mb-3">
                          <label class="form-label">O quanto você gostou dessa aula?</label>
                          <select type="text" class="form-select" id="select-users" value="">
                            <option value="5">Gostei muito</option>
                            <option value="4">Gostei</option>
                            <option value="3">Normal</option>
                            <option value="2">Não gostei</option>
                            <option value="1">Péssima</option>
                          </select>
                        </div>

                        <div class="mb-2">
                          <label class="form-label">Deixe um comentário. <span class="form-label-description">0/100</span></label>
                          <textarea class="form-control" id="rate_obs" name="example-textarea-input" rows="2" placeholder="Content.."></textarea>
                        </div>


                        <div class="row">
                          <a href="#" class="btn btn-primary w-100" id="sendRate">Enviar Avaliação</a>
                        </div>
                      </div>


                      <div class="empty" id="already_rate" style="<?= $already_rate ?>">
                        <p class="empty-title">Você já avaliou essa aula</p>
                        <p class="empty-subtitle text-secondary">
                          Obrigado pelo feedback, isso nos ajuda muito.
                        </p>
                      </div>

                    </div>
                    <div class="col-md-8">
                      <div class="mb-3">
                        <div class="card-title">
                          Comentários
                        </div>

                        <div class="divide-y ms-3">

                          <?php



                          $sql = "SELECT * FROM ratings WHERE video_id = $v_id";
                          $sql = $pdo->prepare($sql);
                          $sql->execute();

                          if ($sql->rowCount() > 0) {
                            foreach ($sql->fetchAll() as $value) {
                              $username = $value['user'];
                              $rate = $value['rate'];
                              $rate = intval($rate);
                              $obs = $value['obs'];
                              if ($obs == "") {
                                $obs = "Não fez nenhum comentário.";
                              }


                              $ii = 1;
                              $svg = "";
                              while ($ii <= 5) {
                                if ($ii <= $rate) {
                                  $svg .= '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star-filled text-yellow" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" fill="currentColor"></path>
                              </svg>';
                                } else {
                                  $svg .= '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                         </svg>';
                                }
                                $ii++;
                              }
                          ?>

                              <div class="row">
                                <div class="col align-self-center">
                                  <div>
                                    <strong><?= $username ?></strong>
                                    <p class="mb-0"><?= $obs ?></p>
                                  </div>
                                </div>

                                <div class="col-auto ms-auto align-self-center">
                                  <div class="text-reset">
                                    <?= $svg ?>
                                  </div>
                                </div>

                              </div>

                            <?php
                            }
                          } else {
                            ?>

                            <div class="row">
                              <div class="col align-self-center">
                                <div>
                                  <strong>Ninguém avaliou esse vídeo ainda...</strong>
                                </div>
                              </div>


                            </div>

                          <?php
                          }







                          ?>



                          <!-- <div class="row">
                            <div class="col align-self-center">
                              <div>
                                <strong>futvdal</strong>
                                <p class="mb-0">falotou so o sustinho.</p>
                              </div>
                            </div>

                            <div class="col-auto ms-auto align-self-center">
                              <div class="text-reset">
                                <?= $svg ?>
                              </div>
                            </div>

                          </div> -->


                        </div>

                      </div>
                    </div>


                  </div>


                </div>
              </div>
            </div>

          </div>








        </div>


        <div class="modal modal-blur fade" id="modal_download" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="modal-status bg-purple"></div>
              <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-purple icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                <h3>Download Concluido</h3>
                <div class="text-secondary">Seus downloads estarão disponíveis na sua conta.</div>
              </div>
              <div class="modal-footer">
                <div class="w-100">
                  <div class="row">
                    <a href="#" class="btn btn-purple w-100" data-bs-dismiss="modal">
                      Obrigado.
                    </a>
                    
                  </div>
                </div>
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
  <script src="./dist/libs/tom-select/dist/js/tom-select.base.min.js?1684106062" defer></script>

  <script src="./dist/libs/plyr/dist/plyr.min.js?1684106062" defer></script>
  <script src="./dist/libs/star-rating.js/dist/star-rating.min.js" defer></script>


  <script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function() {
      const rating = new StarRating('#rating-default-all', {
        tooltip: false,
        clearable: false,
        stars: function(el, item, index) {
          el.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-star gl-star-full icon-1 me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" fill="currentColor" /></svg>`;
        },
      })
    })
    // @formatter:on
  </script>

  <script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function() {
      var el;
      window.TomSelect && (new TomSelect(el = document.getElementById('select-users'), {
        copyClassesToDropdown: false,
        dropdownParent: 'body',
        controlInput: false,
        render: {
          item: function(data, escape) {
            if (data.customProperties) {
              return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
            }
            return '<div>' + escape(data.text) + '</div>';
          },
          option: function(data, escape) {
            if (data.customProperties) {
              return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
            }
            return '<div>' + escape(data.text) + '</div>';
          },
        },
      }));
    });
    // @formatter:on
  </script>

  <script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function() {
      window.Plyr && (new Plyr('#player-youtube', {
        ratio: '16:9',
      }));
    });
    // @formatter:on
  </script>

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


      $("#sendRate").on("click", function(e) {
        rate_val = $("#select-users").val();
        rate_obs = $("#rate_obs").val();
        formData = {
          type: "new_rate",
          video_id: <?= $v_id ?>,
          rate_val: rate_val,
          rate_obs: rate_obs,
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
            console.log(data);
            response = data;
            $("#rate_div").hide();
            $("#already_rate").show();

          },
          error: function(xhr, status, error) {
            console.log("Erro na requisição: " + error);
          }
        });
      });




      $(".redirect_video").on("click", function(e) {
        link_video = $(this).data("link-video");


        formData = {
          type: "check_video",
          c_id: "<?= $curso_id ?>",
          v_id: <?= $v_id ?>,
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
            console.log(data);
            response = data;
            location.href = link_video;
            // $history
          },
          error: function(xhr, status, error) {
            console.log("Erro na requisição: " + error);
          }
        });


      });



      $(".next_video").on("click", function(e) {
        formData = {
          type: "next_video",
          c_id: <?= $curso_id ?>,
          v_id: <?= $v_id ?>,
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

            if (response.state == 1) {
              location.href = "?v_id=" + response.next;
            } else {
              $(".next_video").slideUp();
              $(".download_certificado").slideDown();
            }
          },
          error: function(xhr, status, error) {
            console.log("Erro na requisição: " + error);
          }
        });
      });


      $(".download_btn").on("click", function(e) {
        $("#modal_download").modal("show");
      });


      $(".filter_course").on("click", function(e) {
        location.href = "index.php";
      });

    });
  </script>


</body>

</html>


<!-- SE NÃO DER O PONTO CHEIO É VIADO -->