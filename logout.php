<?php
session_start();

 unset($_SESSION['user']);
 unset($_SESSION['user_data']);
 header ("Location: /");
 exit();
?>