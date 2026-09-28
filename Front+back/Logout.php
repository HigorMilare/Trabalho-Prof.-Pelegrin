<?php
session_start();
session_destroy();
header("Location: Tela_Login.php");
exit;
?>