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

        <div class="row justify-content-center">
        <div class="col-lg-8">
                <div class="card card-lg">
                    
                  <div class="card-body">
                    <div class="markdown">
                        <div class="text-center mb-3">
                            <h1 id="tabler-free-license">Licença Arula</h1>
                        </div>
                      <h3 id="tabler-free-license">TERMOS DE USO - ARULA</h3>
                      <p>Bem-vindo ao ARULA! Estes Termos de Uso regem o acesso e uso dos serviços fornecidos pelo site ARULA, uma plataforma dedicada à oferta de cursos online. Ao utilizar nossos serviços, você concorda com os termos aqui apresentados. Por favor, leia atentamente.</p>
                      
                      <h3 id="tabler-free-license">
1. Aceitação dos Termos
</h3>
                      <p>Ao acessar ou usar o site ARULA, você concorda em cumprir e estar vinculado a estes Termos de Uso. Se você não concordar com algum aspecto destes termos, recomendamos que pare de usar nossos serviços.

</p>
                      
                      <h3 id="tabler-free-license">2. Uso do Serviço
</h3>
                      <p>O ARULA oferece serviços diversos, incluindo cursos online, informações, conteúdo multimídia e interação com outros usuários. Você concorda em utilizar esses serviços apenas para fins legais, éticos e aceitáveis. Qualquer uso indevido ou violação destes termos resultará na rescisão imediata dos serviços.
</p>
                      
                      <h3 id="tabler-free-license">3. Registro e Conta do Usuário
</h3>
                      <p>Para acessar determinados recursos do ARULA, você pode precisar criar uma conta. Ao fazer isso, você concorda em fornecer informações precisas, completas e atualizadas. Você é responsável por manter a confidencialidade de sua conta e senha, bem como por todas as atividades que ocorram em sua conta.</p>
                      
                      <h3 id="tabler-free-license">4. Conteúdo do Usuário</h3>
                      <p>Ao enviar conteúdo para o ARULA, você concede à ARULA uma licença mundial, não exclusiva, livre de royalties, sublicenciável e transferível para usar, reproduzir, distribuir, preparar obras derivadas, exibir publicamente e realizar de outra forma o conteúdo em conexão com os serviços ARULA.
</p>
                      
                      <h3 id="tabler-free-license">5. Propriedade Intelectual
</h3>
                      <p>Todo o conteúdo presente no ARULA, incluindo, mas não se limitando a, textos, gráficos, logotipos, ícones e imagens, é propriedade exclusiva da ARULA ou de seus licenciantes e está protegido por leis de direitos autorais e outras leis de propriedade intelectual.
</p>
                      
                      <h3 id="tabler-free-license">6. Modificações nos Termos de Uso
</h3>
                      <p>A ARULA se reserva o direito de modificar estes Termos de Uso a qualquer momento. As alterações entrarão em vigor imediatamente após a publicação no site. Recomendamos que você revise periodicamente os termos para estar ciente de quaisquer alterações.
</p>
                      
                      <h3 id="tabler-free-license">7. Rescisão
</h3>
                      <p>A ARULA se reserva o direito de encerrar ou suspender sua conta e acesso aos serviços, com ou sem aviso prévio, por qualquer motivo, incluindo, mas não se limitando a, violações destes Termos de Uso.
</p>
                      
                      <h3 id="tabler-free-license">8. Disposições Gerais
</h3>
                      <p>Estes Termos de Uso constituem o acordo completo entre você e a ARULA em relação ao uso dos serviços e substituem todos os acordos anteriores.
</p>

<h3 class="mt-3">Se você tiver dúvidas ou preocupações sobre estes Termos de Uso, entre em contato conosco através dos meios disponíveis no site ARULA.</h3>
<h2 class="mt-3">Obrigado por escolher ARULA!</h2>
                      
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