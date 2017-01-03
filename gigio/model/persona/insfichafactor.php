<?php
session_start();
include_once '../../lib/php/libphp.php';
$conn = conectar();
$ch = $_POST['ch'];
if(isset($ch)){
	if(is_array($ch)){
		$selected = '';
		$num = count($ch);
		$i = 0;
		foreach($ch as $key => $value){
			if($i!=$num-1){
				$selected .= $value.", ";
			}else{
				$selected .= $value.".";
			}
			$i++;
		}
	}
}else{
	$selected = "Debe elegir una opcion";
}
echo $selected; 
?>