<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('translate')) {
    function translate($key)
    {
        global $dictionary, $lang;
        if (isset($dictionary[$lang][$key])) {
            return $dictionary[$lang][$key];
        }
        return $key;
    }
}

if (isset($_POST['toggle_language'])) {
    $_SESSION['language'] = ($_SESSION['language'] == 'en') ? 'tag' : 'en';
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'en';
}

include('translations_dictionary.php');

$lang = $_SESSION['language'];
