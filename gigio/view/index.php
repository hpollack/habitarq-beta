<?php
session_start();
if(!$_SESSION['rut']){
	header("Location: ../login.php");
	exit();
}