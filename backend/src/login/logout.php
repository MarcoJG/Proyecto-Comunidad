<?php
session_start();
session_destroy();
header("Location: ../../../web/src/login/index.php");
exit();
?>