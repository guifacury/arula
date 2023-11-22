<?php

session_start();

$size_plan = 4;
$one_c = "";
if (isset($_GET['member'])) {
  if ($_GET['member'] == 1) {
    $size_plan = 6;
    $one_c = "display:none;";
  }
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



          <div class="row row-cards row-deck">
            <div class="col-sm-6 col-lg-<?=$size_plan?>" style="<?=$one_c?>">
              <div class="card card-md">
                <div class="card-body text-center">
                  <div class="text-uppercase text-muted font-weight-medium">1 CURSO</div>
                  <div class="fw-bold my-3"><span style="font-size: 3rem;">R$20</span> </div>
                  <ul class="list-unstyled lh-lg">

                    <li>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M18 6l-12 12"></path>
                        <path d="M6 6l12 12"></path>
                      </svg>
                      Acesso ilimitado
                    </li>

                    <li>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M18 6l-12 12"></path>
                        <path d="M6 6l12 12"></path>
                      </svg>
                      Promoções Futuras
                    </li>

                    <li>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M18 6l-12 12"></path>
                        <path d="M6 6l12 12"></path>
                      </svg>
                      Economizando
                    </li>

                  </ul>
                  <div class="text-center mt-4">
                    <a href="#" class="btn w-100">Comprar</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-<?=$size_plan?>">
              <div class="card card-md">

                <div class="card-body text-center">
                  <div class="text-uppercase text-muted font-weight-medium">MENSAL</div>
                  <div class="fw-bold my-3"><span style="font-size: 3rem;">R$140</span> </div>
                  <ul class="list-unstyled lh-lg">


                    <li>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                      </svg>
                      Acesso ilimitado
                    </li>

                    <li>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                      </svg>
                      Promoções Futuras
                    </li>

                    <li>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M18 6l-12 12"></path>
                        <path d="M6 6l12 12"></path>
                      </svg>
                      Economizando
                    </li>

                  </ul>
                  <div class="text-center mt-4">
                    <a href="#" class="btn w-100 setMensal">Comprar</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-<?=$size_plan?>">
              <div class="card card-md">
                <div class="ribbon ribbon-top bg-primary">
                  <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path>
                  </svg>
                </div>
                <div class="card-body text-center">
                  <div class="text-uppercase text-muted font-weight-medium">ANUAL</div>
                  <div class="align-items-center d-flex fw-bold justify-content-center mb-0 mt-1">
                    <span class="me-2">12x</span> <span style="font-size: 3rem;">R$100</span>
                  </div>
                  <div class="mb-2">
                    <span class="">a vísta de <del>R$ 1200</del> por R$ 1000</span>
                  </div>
                  <ul class="list-unstyled lh-lg">

                    <li>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                      </svg>
                      Acesso ilimitado
                    </li>

                    <li>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                      </svg>
                      Promoções Futuras
                    </li>

                    <li>
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                      </svg>
                      Economizando
                    </li>

                  </ul>
                  <div class="text-center mt-4">
                    <a href="#" class="btn  btn-primary w-100 setMensal">Comprar</a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="card card-md">
                <div class="card-body">
                  <div class="row align-items-center">

                    <div class="col">
                      <h2 class="h3 mb-0">Garantia de 30 Dias.</h2>
                      <p class="m-0 text-muted">Experimente a nossa plataforma durante o período de testes. Caso não goste, você terá direito ao <strong>reembolso integral e gratuito.</strong> </p>
                    </div>

                    <div class="col-auto">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shield-lock icon-md" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" />
                        <path d="M12 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                        <path d="M12 12l0 2.5" />
                      </svg>
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



      $(".setMensal").on("click", function(e) {
        event.preventDefault();
        formData = {
          type: "set_plan",
          plan: 3,
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
            // location.reload(true);
            location.href = "./auth/logout";
          },
          error: function(xhr, status, error) {
            console.log("Erro na requisição: " + error);
          }
        });
      });


      $(".filter_course").on("click", function(e) {
        location.href = "index.php";
      });


    });
  </script>


</body>

</html>


<!-- SE NÃO DER O PONTO CHEIO É VIADO -->