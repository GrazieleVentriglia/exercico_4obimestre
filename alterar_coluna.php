<?php
	include("conexao.php");

	$tb = $_POST["tabela"];
	$coluna = $_POST["coluna"];
	$valor = $_POST["valor"];
	$id = $_POST["id"];
	
	$update = "UPDATE $tb SET 
		$coluna = '$valor'
			WHERE id_$tb = '$id'";
		
	mysqli_query($conexao,$update)
			or die(mysql_error($conexao));
			
			
	echo "1";
?> 