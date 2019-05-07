<?php
/* Source logout https://youtu.be/b-2_Y53CTYA */

session_start();
session_destroy();
header("location:login.php");

?>
