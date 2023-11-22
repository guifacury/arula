<?php

session_start();
require_once "../db/verifica.php";


function generateRandomString($length = 12)
{
    $characters = '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}


$type = (isset($_POST['type'])) ? $_POST['type'] : '';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $resposta = array(
        'status' => 0,
        'teste' => "Fazer login",
    );
    $json_resposta = json_encode($resposta);
    header('Content-Type: application/json');
    echo $json_resposta;
    exit();
}



switch ($type) {
    case "new_rate": // addCategory.php
        try {
            $video_id = (isset($_POST['video_id'])) ? $_POST['video_id'] : '';
            $rate_val = (isset($_POST['rate_val'])) ? $_POST['rate_val'] : '';
            $rate_obs = (isset($_POST['rate_obs'])) ? $_POST['rate_obs'] : '';
            $rate_val = intval($rate_val);

            $sql = "INSERT INTO ratings (video_id, user, rate, obs) VALUES('$video_id', '$username', $rate_val, '$rate_obs')";
            $sql = $pdo->prepare($sql);
            $sql->execute();

            $status = 1;
        } catch (Exception $e) {
            $status = 0;
        }
        $resposta = array(
            'status' => $status,
        );
        break;
    case "get_video_info": // addCategory.php
        try {
            // username
            $video_id = (isset($_POST['video_id'])) ? $_POST['video_id'] : '';
            $video_id = intval($video_id);


            $sql = "SELECT * FROM videos WHERE id = $video_id LIMIT 1";
            $sql = $pdo->prepare($sql);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                foreach ($sql->fetchAll() as $value) {
                    $yt_id = $value['yt_id'];
                    $title = $value['title'];
                    $thumb = $value['thumb'];
                    $curso_id = $value['curso_id'];

                    $video_json = array(
                        'yt_id' => $yt_id,
                        'title' => $title,
                        'thumb' => $thumb,
                        'curso_id' => $curso_id,
                    );
                }
            }

            mb_internal_encoding('UTF-8');
            $enc_vjson = json_encode($video_json, JSON_UNESCAPED_UNICODE);



            $status = 1;
        } catch (Exception $e) {
            $status = 0;
        }
        $resposta = array(
            'status' => $status,
            'video_json' => $enc_vjson,
        );
        break;
    case "set_plan":
        try {
            $plan = (isset($_POST['plan'])) ? $_POST['plan'] : '';
            $plan = intval($plan);
            $sql = "UPDATE users SET plano = $plan WHERE username = '$username'";
            $sql = $pdo->prepare($sql);
            $sql->execute();

            $status = 1;
        } catch (Exception $e) {
            $status = 0;
        }
        $resposta = array(
            'status' => $status,
        );
        break;
    case "new_course_access":
        try {
            // username
            $c_id = (isset($_POST['c_id'])) ? $_POST['c_id'] : '';
            $c_id = intval($c_id);

            $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
            $sql = $pdo->prepare($sql);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                foreach ($sql->fetchAll() as $value) {
                    $plano = $value['plano'];
                    $access = $value['access'];
                }
            }
            $data_arr = json_decode($access);
            $data_arr[] = $c_id;
            $new_whitelist = json_encode($data_arr);

            if ($plano == "1") {
                $sql = "UPDATE users SET access = '$new_whitelist', plano = 2 WHERE username = '$username'";
                $_SESSION['account_type'] = 2;
            } else {
                $sql = "UPDATE users SET access = '$new_whitelist' WHERE username = '$username'";
            }

            $sql = $pdo->prepare($sql);
            $sql->execute();



            $status = 1;
        } catch (Exception $e) {
            $status = 0;
        }
        $resposta = array(
            'status' => $status,
        );
        break;
    case "check_video":
        try {
            // username
            $v_id = (isset($_POST['v_id'])) ? $_POST['v_id'] : '';
            $c_id = (isset($_POST['c_id'])) ? $_POST['c_id'] : '';
            $v_id = intval($v_id);

            $sql = "SELECT * FROM history WHERE username = '$username' AND video_id = $v_id LIMIT 1";
            $sql = $pdo->prepare($sql);
            $sql->execute();
            if ($sql->rowCount() == 0) {
                $sql2 = "INSERT INTO history (username, c_id, video_id, created) VALUES('$username', $c_id, $v_id, NOW())";
                $sql2 = $pdo->prepare($sql2);
                $sql2->execute();
            }
            $status = 1;
        } catch (Exception $e) {
            $status = 0;
        }
        $resposta = array(
            'status' => $status,
        );
        break;
    case "delete_course": // addCategory.php
        try {
            $course_id = (isset($_POST['course_id'])) ? $_POST['course_id'] : '';
            $course_id = intval($course_id);

            $sql = "DELETE FROM cursos WHERE id = $course_id";
            $sql = $pdo->prepare($sql);
            $sql->execute();

            $sql = "DELETE FROM videos WHERE curso_id = $course_id";
            $sql = $pdo->prepare($sql);
            $sql->execute();

            $status = 1;
        } catch (Exception $e) {
            $status = 0;
        }
        $resposta = array(
            'status' => $status,
        );
        break;
    case "delete_video": // addCategory.php
        try {
            $video_id = (isset($_POST['video_id'])) ? $_POST['video_id'] : '';
            $video_id = intval($video_id);


            $sql = "DELETE FROM videos WHERE id = $video_id";
            $sql = $pdo->prepare($sql);
            $sql->execute();

            $status = 1;
        } catch (Exception $e) {
            $status = 0;
        }
        $resposta = array(
            'status' => $status,
        );
        break;
    case "add_video": // addCategory.php
        try {
            $video_title = (isset($_POST['video_title'])) ? $_POST['video_title'] : '';
            $video_id = (isset($_POST['video_id'])) ? $_POST['video_id'] : '';
            $course_id = (isset($_POST['course_id'])) ? $_POST['course_id'] : '';
            $course_id = intval($course_id);


            $randItem = generateRandomString($length = 8);

            if (isset($_FILES["video_image"]) && $_FILES["video_image"]["error"] === UPLOAD_ERR_OK) {
                $file_name = $_FILES["video_image"]["name"];
                $file_size = $_FILES["video_image"]["size"];
                $file_tmp = $_FILES["video_image"]["tmp_name"];
                $file_type = $_FILES["video_image"]["type"];
                $file_error = $_FILES["video_image"]["error"];
                $file_info = pathinfo($file_name);
                $file_name_only = $file_info['filename']; // Nome do arquivo sem a extensão
                $file_extension = $file_info['extension']; // Extensão do arquivo
                $full_file_name = $randItem . "." . $file_extension;
                if ($file_error == UPLOAD_ERR_OK) {
                    $allowed_types = array("image/jpeg", "image/png", "image/gif");
                    if (in_array($file_type, $allowed_types)) {
                        $max_file_size = 8 * 1024 * 1024;
                        if ($file_size < $max_file_size) {
                            $target_directory = "../assets/thumbs/";
                            $target_file = $target_directory . $full_file_name;
                            move_uploaded_file($file_tmp, $target_file);
                        }
                    }
                }
            } else {
                $full_file_name = '';
            }

            $sql2 = "INSERT INTO videos (yt_id, title, thumb, curso_id) VALUES('$video_id', '$video_title', '$full_file_name', $course_id)";
            $sql2 = $pdo->prepare($sql2);
            $sql2->execute();





            $status = 1;
        } catch (Exception $e) {
            $status = 0;
        }
        $resposta = array(
            'status' => $status,
        );
        break;
    case "create_course": // addCategory.php
        try {
            $course_name = (isset($_POST['course_name'])) ? $_POST['course_name'] : '';
            $course_desc = (isset($_POST['course_desc'])) ? $_POST['course_desc'] : '';
            $course_duration = (isset($_POST['course_duration'])) ? $_POST['course_duration'] : '';
            $course_dificulty = (isset($_POST['course_dificulty'])) ? $_POST['course_dificulty'] : '';
            $course_theme = (isset($_POST['course_theme'])) ? $_POST['course_theme'] : '';
            $sql2 = "INSERT INTO cursos (nome, descricao, type, difficulty, duracao) VALUES('$course_name', '$course_desc', $course_theme, $course_dificulty, '$course_duration')";
            $sql2 = $pdo->prepare($sql2);
            $sql2->execute();
            $status = 1;
        } catch (Exception $e) {
            $status = 0;
        }
        $resposta = array(
            'status' => $status,
        );
        break;
    case "next_video": // addCategory.php
        try {
            $v_id = (isset($_POST['v_id'])) ? $_POST['v_id'] : '';
            $c_id = (isset($_POST['c_id'])) ? $_POST['c_id'] : '';
            $v_id = intval($v_id);
            $state = $next = 0;

            $sql = "SELECT * FROM history WHERE username = '$username' AND video_id = $v_id LIMIT 1";
            $sql = $pdo->prepare($sql);
            $sql->execute();
            if ($sql->rowCount() == 0) {
                $sql2 = "INSERT INTO history (username, c_id, video_id, created) VALUES('$username', $c_id, $v_id, NOW())";
                $sql2 = $pdo->prepare($sql2);
                $sql2->execute();
            }

            // c_id

            $history_arr = array();
            $sql = "SELECT * FROM history WHERE c_id = $c_id AND username = '$username' ORDER BY id ASC";
            $sql = $pdo->prepare($sql);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                foreach ($sql->fetchAll() as $value) {
                    $video_id = $value['video_id'];
                    $history_arr[] = $video_id;
                }
            }

            $videos_arr = array();
            $sql = "SELECT * FROM videos WHERE curso_id = $c_id AND username = '$username' ORDER BY id ASC";
            $sql = $pdo->prepare($sql);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                foreach ($sql->fetchAll() as $value) {
                    $id = $value['id'];
                    $videos_arr[] = $id;
                }
            }

            foreach ($history_arr as $hv) {
                echo $hv;
                if (in_array($hv, $videos_arr)) {
                    echo "111111";
                    $posicao = array_search($hv, $videos_arr);
                    if ($posicao !== false) {
                        unset($videos_arr[$posicao]);
                        print_r($videos_arr);
                    }
                }
            }


            if (sizeof($videos_arr) > 0) {
                $next = reset($videos_arr);
                $state = 1;
            } else {
                $state = 0;
                $next = "";
            }

            $dec = json_encode($videos_arr);


            // print_r($videos_arr);

            $status = 1;
        } catch (Exception $e) {
            $status = 0;
        }
        $resposta = array(
            'status' => $status,
            'state' => $state,
            'next' => "$next",
            'dec' => "$dec",
        );
        break;
    default:
        $resposta = array(
            'status' => 0,
            'message' => "Nenhum type"
        );
}







$json_resposta = json_encode($resposta);
header('Content-Type: application/json');
echo $json_resposta;
