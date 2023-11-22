<?php

$videos_arr = array(1,2,3);
$history_arr = array(1,2);
$state = $next = 0;


foreach ($history_arr as $hv) {
    if (in_array($hv, $videos_arr)) {
        echo "$hv estava<br>";
        $posicao = array_search($hv, $videos_arr);
        if ($posicao !== false) {
            unset($videos_arr[$posicao]);
        }
    }
}


// if (!empty($videos_arr) && isset($videos_arr[0])) {
//     if (sizeof($videos_arr) > 0) {
//         $state = 1;
//         $next = $videos_arr[0];
//     } else {
//         $state = 0;
//         $next = "";
//     }
// }

$next = reset($videos_arr);
echo $next; // Saída: a
echo sizeof($videos_arr); // Saída: a

// Exibir o primeiro elemento

// print_r($videos_arr);
// echo $videos_arr[2];
// echo "state: " . $state;
// echo "<br>next: " . $next;