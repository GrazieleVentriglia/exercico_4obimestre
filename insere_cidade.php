<?php
	
	include("conexao.php");
	
	$nome_cidade = $_POST["nome_cidade"];
	$cod_estado = $_POST["cod_estado"];;
	
	$insercao = "INSERT INTO cidade (nome, cod_estado)
						VALUES('$nome_cidade', '$cod_estado')";

	mysqli_query($conexao,$insercao)
		or die("0");
	
	echo "1";
	
?>