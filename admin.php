<?php

session_start();

require_once "./db/verifica.php";

$username = $_SESSION['username'];




$courses_arr = array();

function course_videos_qty($id)
{
  global $pdo;

  $cc = 0;
  $sql = "SELECT * FROM videos WHERE curso_id = $id";
  $sql = $pdo->prepare($sql);
  $sql->execute();
  if ($sql->rowCount() > 0) {
    foreach ($sql->fetchAll() as $value) {
      $cc++;
    }
  }
  return $cc;
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



          <div class="row row-cards">




            <div class="col-lg-6">
              <div class="card" id="" style="max-height: 30rem;">
                <div class="card-header">
                  <div class="card-title">Cursos</div>
                  <div class="ms-auto">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal_add_course">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 5l0 14"></path>
                        <path d="M5 12l14 0"></path>
                      </svg>
                      Criar Curso
                    </a>
                  </div>
                </div>
                <div class="list-group card-list-group card-body-scrollable card-body-scrollable-shadow" id="drop-categories">

                  <?php

                  $sql = "SELECT * FROM cursos ORDER BY id DESC";
                  $sql = $pdo->prepare($sql);
                  $sql->execute();
                  if ($sql->rowCount() > 0) {
                    foreach ($sql->fetchAll() as $value) {
                      $id = $value['id'];
                      $nome = $value['nome'];
                      $duracao = $value['duracao'];
                      $type = $value['type'];
                      $id_c = intval($id);
                      $courses_arr[] = $id_c;
                  ?>

                      <div class="list-group-item catSelect" id="<?= $id; ?>">
                        <div class="row g-2 align-items-center">
                          <div class="col">
                            <div class="h3 mb-1"><?= $nome; ?></div>
                            <div class="text-muted">
                              <?= course_videos_qty($id) ?> Aula(s). | Duração: <?=$duracao?>
                            </div>
                          </div>
                          <div class="col-auto ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <path d="M9 6l6 6l-6 6"></path>
                            </svg>
                          </div>
                        </div>
                        <div class="row g-2 align-items-center mt-2 excluirCategoria" style="display: none;">
                          <!-- <div class="col-auto">
                            <a href="#" class="btn btn-outline-primary edit_course_btn">Editar</a>
                          </div> -->
                          <div class="col-auto">
                            <a href="#" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-danger">Excluir Curso</a>
                          </div>
                        </div>
                      </div>

                    <?php
                    }
                  } else { ?>
                    <div class="empty">
                      <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <circle cx="12" cy="12" r="9" />
                          <line x1="9" y1="10" x2="9.01" y2="10" />
                          <line x1="15" y1="10" x2="15.01" y2="10" />
                          <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" />
                        </svg>
                      </div>
                      <p class="empty-title">Nenhum Resultado</p>
                      <p class="empty-subtitle text-muted">
                        Você ainda não adicionou nenhum video
                      </p>
                      <div class="empty-action">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-category">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                          </svg>
                          Adicionar Agora
                        </a>
                      </div>
                    </div>
                  <?php }
                  ?>
                </div>
              </div>
            </div>

            <div class="col-lg-6">

              <?php
              $aulas_counter_div = 0;
              foreach ($courses_arr as $course_id) { ?>

                <div class="card AllCatView" id="cat<?= $course_id ?>View" <?php
                                                                            if ($aulas_counter_div > 0) {
                                                                              echo "style='display:none;max-height:30rem'";
                                                                            } else {
                                                                              echo "style='max-height:30rem'";
                                                                            }
                                                                            ?>>
                  <div class="card-header">
                    <div class="card-title">Videos do Curso</div>
                    <div class="ms-auto">
                      <a href="#" class="addItemBtn" id="<?= $course_id ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M12 5l0 14"></path>
                          <path d="M5 12l14 0"></path>
                        </svg>
                        Adicionar Item
                      </a>
                    </div>
                  </div>
                  <div class="list-group card-list-group card-body-scrollable card-body-scrollable-shadow card-list-group list-group product-card-edit">

                    <?php

                    $sql = "SELECT * FROM videos WHERE curso_id = $course_id";
                    $sql = $pdo->prepare($sql);
                    $sql->execute();
                    $catArr = array();
                    if ($sql->rowCount() > 0) {
                      foreach ($sql->fetchAll() as $value) {
                        $id = $value['id'];
                        $aula_id = $value['id'];
                        $curso_id = $value['curso_id'];
                        $title = $value['title'];
                        $thumb = $value['thumb'];
                        if ($thumb == "") {
                          $thumb = "error.jpg";
                        }
                    ?>

                        <div class="list-group-item itemCard" id="<?= $id ?>">
                          <div class="row g-2 align-items-center">
                            <div class="col-3">
                              <div class="card-img-top img-responsive img-responsive-16x9" style="background-image: url(./assets/thumbs/<?= $thumb ?>);"></div>
                            </div>
                            <div class="col">
                              <div class="h3 mb-2"><?= $title ?></div>
                            </div>
                            <!-- <div class="col-auto">
                              <span class="avatar avatar-xl" style="background-image: url(../../static/photos/<?= $identifier . "/" . $iImage ?>)"></span>
                            </div> -->
                          </div>
                        </div>

                      <?php
                      }
                    } else { ?>

                      <div class="empty">
                        <div class="empty-icon">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <circle cx="12" cy="12" r="9" />
                            <line x1="9" y1="10" x2="9.01" y2="10" />
                            <line x1="15" y1="10" x2="15.01" y2="10" />
                            <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" />
                          </svg>
                        </div>
                        <p class="empty-title">Nenhum Resultado</p>
                        <p class="empty-subtitle text-muted">
                          Você ainda não adicionou nenhum vídeo nesse curso
                        </p>
                        <div class="empty-action">
                          <a href="#" class="btn btn-primary addItemBtn" id="<?= $course_id ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <path d="M12 5l0 14"></path>
                              <path d="M5 12l14 0"></path>
                            </svg>
                            Adicionar Agora
                          </a>
                        </div>
                      </div>


                    <?php } ?>
                  </div>
                </div>
              <?php


                $aulas_counter_div++;
              }

              ?>

            </div>



          </div>


          <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
              <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-status bg-danger"></div>
                <div class="modal-body text-center py-4">
                  <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z"></path>
                    <path d="M12 9v4"></path>
                    <path d="M12 17h.01"></path>
                  </svg>
                  <h3>Excluir Curso?</h3>
                  <div class="text-muted">Essa ação não pode ser desfeita, e excluirá todos os vídeos desse curso.</div>
                </div>
                <div class="modal-footer">
                  <div class="w-100">
                    <div class="row">
                      <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                          Cancelar
                        </a></div>
                      <div class="col">
                        <a href="#" class="btn btn-danger w-100" id="deleteCatBtn" data-bs-dismiss="modal">
                          Escluir Curso
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal modal-blur fade" id="modal_add_course" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Novo Curso</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-7">
                      <div class="mb-3">
                        <label class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="course_name">
                      </div>
                    </div>

                    <div class="col-md-5">
                      <div class="mb-3">
                        <label class="form-label">Dificuldade</label>
                        <div class="form-selectgroup">
                          <label class="form-selectgroup-item">
                            <input type="radio" name="course_dificulty" value="1" class="form-selectgroup-input" checked="">
                            <span class="form-selectgroup-label">Fácil</span>
                          </label>
                          <label class="form-selectgroup-item">
                            <input type="radio" name="course_dificulty" value="2" class="form-selectgroup-input">
                            <span class="form-selectgroup-label">Médio</span>
                          </label>
                          <label class="form-selectgroup-item">
                            <input type="radio" name="course_dificulty" value="3" class="form-selectgroup-input">
                            <span class="form-selectgroup-label">Avançado</span>
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-7">
                      <div class="mb-3">
                        <label class="form-label">Descrição do Curso</label>
                        <input type="text" class="form-control" id="course_desc">
                      </div>
                    </div>

                    <div class="col-md-5">
                      <div class="mb-3">
                        <label class="form-label">Duração</label>
                        <input type="text" class="form-control" id="course_duration">
                      </div>
                    </div>



                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Tema</label>
                        <div class="form-selectgroup">
                          <label class="form-selectgroup-item">
                            <input type="radio" name="course_theme" value="1" class="form-selectgroup-input" checked="">
                            <span class="form-selectgroup-label">Python</span>
                          </label>
                          <label class="form-selectgroup-item">
                            <input type="radio" name="course_theme" value="2" class="form-selectgroup-input">
                            <span class="form-selectgroup-label">PHP</span>
                          </label>
                          <label class="form-selectgroup-item">
                            <input type="radio" name="course_theme" value="3" class="form-selectgroup-input">
                            <span class="form-selectgroup-label">JavaScript</span>
                          </label>
                          <label class="form-selectgroup-item">
                            <input type="radio" name="course_theme" value="4" class="form-selectgroup-input">
                            <span class="form-selectgroup-label">React</span>
                          </label>
                          <label class="form-selectgroup-item">
                            <input type="radio" name="course_theme" value="5" class="form-selectgroup-input">
                            <span class="form-selectgroup-label">FullStack</span>
                          </label>
                          <label class="form-selectgroup-item">
                            <input type="radio" name="course_theme" value="6" class="form-selectgroup-input">
                            <span class="form-selectgroup-label">Lógica</span>
                          </label>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>



                <div class="modal-footer">
                  <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancel
                  </a>
                  <a href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal" id="btn_create_course">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M12 5l0 14"></path>
                      <path d="M5 12l14 0"></path>
                    </svg>
                    Criar Curso
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="modal modal-blur fade" id="modal_add_video" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Novo Vídeo</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="p_addVideoTitle">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Link do Youtube</label>
                        <input type="text" class="form-control" id="p_addVideoID">
                      </div>
                    </div>


                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Capa do Vídeo</label>
                        <input type="file" accept=".jpg, .png, .jpeg" class="form-control" id="p_addVideoImage" name="" placeholder="Imagem do Produto">
                      </div>
                    </div>
                  </div>
                </div>



                <div class="modal-footer">
                  <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancel
                  </a>
                  <a href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal" id="btn_addVideo">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M12 5l0 14"></path>
                      <path d="M5 12l14 0"></path>
                    </svg>
                    Adicionar Item
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="modal modal-blur fade" id="modal_edit_video" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Editar Vídeo</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="edit_videoTitle">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">ID do Youtube</label>
                        <input type="text" class="form-control" id="edit_videoID">
                      </div>
                    </div>


                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Capa do Vídeo</label>
                        <input type="file" accept=".jpg, .png, .jpeg" class="form-control" id="edit_videoImage" name="" placeholder="Imagem do Produto">
                      </div>
                    </div>
                  </div>
                </div>



                <div class="modal-footer">
                  <a href="#" class="btn btn-outline-danger" id="delete_video" data-bs-dismiss="modal">
                    Excluir
                  </a>
                  <a href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal" id="btn_addVideo">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M12 5l0 14"></path>
                      <path d="M5 12l14 0"></path>
                    </svg>
                    Adicionar Item
                  </a>
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

  <script>
    $(document).ready(function() {


      var course_id;
      $(".catSelect").on('click', function(event) {
        id = $(this).attr('id');
        console.log("course_id ->" + id);
        if ($(this).attr('id') != course_id) {
          $(".AllCatView").hide();
          $("#cat" + id + "View").slideToggle('slow');
          $('.excluirCategoria').hide('slow');
          const excluirCategoria = $(this).find('.excluirCategoria');
          excluirCategoria.show('slow');
        }

        course_id = id;
        // $(this).closest(".optionsCat").slideToggle('slow');
      });


      $("#deleteCatBtn").on('click', function(event) {
        console.log("Excluindo Curso - " + course_id);
        event.preventDefault();
        formData = {
          type: "delete_course",
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
            console.log(data);
            response = data;
            location.reload(true);
          },
          error: function(xhr, status, error) {
            console.log("Erro na requisição: " + error);
          }
        });
      });

      var course_slc_id;
      $(".addItemBtn").on('click', function(event) {
        id = $(this).attr('id');
        console.log("course_slc_id - " + id);
        course_slc_id = id;
        $('#modal_add_video').modal('show');
      });


      $("#btn_create_course").on('click', function(event) {
        event.preventDefault();

        course_name = $("#course_name").val();
        course_desc = $("#course_desc").val();
        course_duration = $("#course_duration").val();
        course_dificulty = $("input[name=course_dificulty]:checked").val();
        course_theme = $("input[name=course_theme]:checked").val();


        formData = {
          type: "create_course",
          course_name: course_name,
          course_desc: course_desc,
          course_duration: course_duration,
          course_dificulty: course_dificulty,
          course_theme: course_theme,
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
            location.reload(true);
          },
          error: function(xhr, status, error) {
            console.log("Erro na requisição: " + error);
          }
        });
        
      });

      $("#btn_addVideo").on('click', function(event) {
        event.preventDefault();

        p_addVideoTitle = $("#p_addVideoTitle").val();
        p_addVideoID = $("#p_addVideoID").val();


        function obterValorDoParametro(parametro, url) {
          url = url || window.location.href;
          parametro = parametro.replace(/[\[\]]/g, "\\$&");
          var regex = new RegExp("[?&]" + parametro + "(=([^&#]*)|&|#|$)"),
            resultados = regex.exec(url);
          if (!resultados) return null;
          if (!resultados[2]) return '';
          return decodeURIComponent(resultados[2].replace(/\+/g, " "));
        }

        youtube_id = obterValorDoParametro('v', p_addVideoID);
        console.log(youtube_id);




        p_addVideoImage = $("#p_addVideoImage")[0].files[0];



        course_id = course_slc_id;
        var formData = new FormData();
        formData.append("type", "add_video");
        formData.append("course_id", course_id);
        formData.append("video_title", p_addVideoTitle);
        formData.append("video_id", youtube_id);
        formData.append("video_image", p_addVideoImage);


        for (var pair of formData.entries()) {
          console.log(pair[0] + ', ' + pair[1]);
        }




        $.ajax({
          type: "POST",
          url: "./posts/ajax.php",
          data: formData,
          processData: false, // Não processar os dados do formulário
          contentType: false, // Não definir o tipo de conteúdo
          success: function(data) {
            console.log(data);
            response = data;
            // location.reload(true);
          },
          error: function(xhr, status, error) {
            console.log("Erro na requisição: " + error);
          }
        });
      });


      var video_id;
      $(".itemCard").on('click', function(event) {
        video_id = $(this).attr('id');
        console.log(video_id);
        event.preventDefault();
        formData = {
          type: "get_video_info",
          video_id: video_id,
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
            console.log(response);

            try {

              video_json = JSON.parse(response.video_json);
              console.log(video_json.yt_id);
              console.log(video_json.title);
              console.log(video_json.thumb);
              console.log(video_json.curso_id);

              $("#edit_videoTitle").val(video_json.title);
              $("#edit_videoID").val(video_json.yt_id);
              $("#modal_edit_video").modal('show');



            } catch (error) {
              console.error("Erro ao parsear JSON:", error.message);
            }


          },
          error: function(xhr, status, error) {
            console.log("Erro na requisição: " + error);
          }
        });

      });


      $("#delete_video").on("click", function(e) {
        event.preventDefault();
        formData = {
          type: "delete_video",
          video_id: video_id,
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
            console.log(response);
            location.reload(true);
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


<!-- SE NÃO DER O PONTO CHEIO É VIADO -->