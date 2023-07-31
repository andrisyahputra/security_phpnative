<?php
// session_start();
// // include function
// require '../private/include/function.php';

// $page = isset($_GET['url']) ? $_GET['url'] : 'home';

// // INI ADALAH FOLDER NYA
// $folder = '../private/include/';

// // UNTUK MENDAPATKAN SEMUA FILES
// $files = glob($folder . "*.php");
// $file_name = $folder . $page . ".php";
// // var_dump($files);
// if (in_array($file_name, $files)) {
//     include "$file_name";
// } else {
//     include "../private/include/404.php";
// }
session_start();
require '../private/include/function.php';

// Daftar putih (whitelist) file yang diperbolehkan
$allowedFiles = array(
    'home' => 'home.php',
    'about' => 'about.php',
    'contact' => 'contact.php',
);

// Mendapatkan nilai dari parameter 'url' dan membersihkannya
$page = isset($_GET['url']) ? $_GET['url'] : 'home';
$page = basename($page); // Hanya mengambil bagian paling akhir dari jalur file, jika ada

// Cek apakah nilai $page ada dalam daftar putih
if (isset($allowedFiles[$page])) {
    $file_name = '../private/include/' . $allowedFiles[$page];
    if (file_exists($file_name)) {
        include $file_name;
    } else {
        include '../private/include/404.php';
    }
} else {
    include '../private/include/404.php';
}
