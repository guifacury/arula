<?php
session_start();
require_once "./db/verifica.php";

try {
    $username = "guilhermef";
    $v_id = 16;
    $c_id = 5;
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
    $sql = "SELECT * FROM videos WHERE curso_id = $c_id ORDER BY id ASC";
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
    echo $e;
}
$resposta = array(
    'status' => $status,
    'state' => $state,
    'next' => "$next",
    'dec' => "$dec",
);

$json_resposta = json_encode($resposta);
header('Content-Type: application/json');
echo $json_resposta;