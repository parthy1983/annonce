<?php
include 'include/init.php';

unset($_SESSION['membre']);

// $_SERVER['HTTP_REFERER'] : la page de laquelle on vient
$redirect = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : 'index.php';

header('Location: ' . $redirect);
die;
