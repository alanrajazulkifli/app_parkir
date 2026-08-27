<?php

if ($_SESSION['user']) {
    session_destroy();
    header('location:index.php');
}
?>