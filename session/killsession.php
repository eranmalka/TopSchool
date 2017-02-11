<?php
session_start();
session_destroy();
header('Location: /project-3-5/login.php');
?>