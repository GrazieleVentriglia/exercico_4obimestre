<?php
	
	header("Content-Type: Application/json");
	
	include("conexao.php");
	$p = $_POST["pg"];	
	$sql = "SELECT id_cadastro, email, sexo, salario, cadastro.nome as nome_cadastro, cidade.nome as nome_cidade FROM cadastro INNER JOIN cidade ON cadastro.cod_cidade=cidade.id_cidade ";
	if(isset($_POST["nome_filtro"])){
		$nome = $_POST["nome_filtro"];
		$sql .= " WHERE cadastro.nome LIKE '%$nome%'";
	}
	
	$sql .= " LIMIT $p,5";
	$resultado = mysqli_query($conexao,$sql) or die ("Erro." . mysqli_error($conexao));
	
	$matriz = null;
	
	while ($linha = mysqli_fetch_assoc($resultado)){
		$matriz[] = $linha;
	}
	
	echo json_encode($matriz);
	
?>