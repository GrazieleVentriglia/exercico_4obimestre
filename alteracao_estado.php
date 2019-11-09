<?php
	include("conexao.php");
	$id = $_POST["id"];
	$nome = $_POST["nome_estado"];
	$uf = $_POST["uf"];
	
	$update = "UPDATE estado SET 
		nome = '$nome',
		uf = '$uf'
		WHERE id_estado = $id";
		
	mysqli_query($conexao,$update)
			or die(mysql_error($conexao));
			
			
	echo "1";


?> 