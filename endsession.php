<?php
include_once ("login.php");
session_destroy ();
header("Location: index.php");
?>
