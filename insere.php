<?php
	
	include("conexao.php");
	
	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$sexo = $_POST["sexo"];
	$salario = $_POST["salario"];
	$cod_cidade = $_POST["cod_cidade"];
	
	$insercao = "INSERT INTO cadastro (nome, email, sexo, cod_cidade, salario)
						VALUES('$nome', '$email', '$sexo', '$cod_cidade', '$salario')";

	mysqli_query($conexao,$insercao)
		or die("Erro." . mysqli_error($conexao));
	
	echo "1";
	
?>