<?php
session_start();
session_unset();
session_destroy();

error_log("Wylogowanie zakończone, przekierowanie do ../index.php");
header("Location: ../index.php");
exit();
