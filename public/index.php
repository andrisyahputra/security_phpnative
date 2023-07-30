<?php
session_start();
    // include function 
    require '../private/include/function.php';
    
$page = isset($_GET['url']) ? $_GET['url'] : 'home';

// INI ADALAH FOLDER NYA
$folder = '../private/include/';

// UNTUK MENDAPATKAN SEMUA FILES
$files = glob($folder . "*.php");
$file_name = $folder . $page . ".php";
// var_dump($files);
if(in_array($file_name, $files)){
    include($file_name);
} else {
    include "../private/include/404.php";
}



?>