<?php
	
	header ("Content-Type: Application/json");
	
	include("conexao.php");
	$p = $_POST["pg"];	
	$sql = "SELECT id_cidade, cidade.nome as nome_cidade,estado.nome as nome_estado FROM cidade INNER JOIN estado ON cidade.cod_estado=estado.id_estado LIMIT $p,5";
	$resultado = mysqli_query($conexao,$sql) or die ("Erro." . mysqli_query($conexao));
	
	while ($linha = mysqli_fetch_assoc($resultado)){
		$matriz[] = $linha;
	}
	
	echo json_encode($matriz);
	
?>