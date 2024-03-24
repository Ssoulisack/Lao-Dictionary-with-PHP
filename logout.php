<?php
require_once "db/session.php";
?>
<?php
session_destroy();
header ("Location:login.php");
?>