<?php
	include("conexao.php");
	$id = $_POST["id"];
	$nome_cidade = $_POST["nome_cidade"];
	$uf = $_POST["uf"];
	
	$update = "UPDATE cidade SET 
		nome = '$nome_cidade',
		uf = '$uf'
		WHERE id_cidade = $id";
		
	mysqli_query($conexao,$update)
			or die(mysql_error($conexao));
			
			
	echo "1";


?> 