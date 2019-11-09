<?php
	
	include("conexao.php");
	
	$nome_estado = $_POST["nome_estado"];
	$uf = $_POST["uf"];
	
	$insercao = "INSERT INTO estado (nome, uf)
						VALUES('$nome_estado', '$uf')";

	mysqli_query($conexao,$insercao)
		or die("0");
	
	echo "1";
	
?>