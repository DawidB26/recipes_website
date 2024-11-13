<?php
require_once '../includes/db.php';
// logout.php
session_start();
session_unset();
session_destroy();
exit();
?>