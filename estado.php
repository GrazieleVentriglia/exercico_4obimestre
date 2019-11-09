<!DOCTYPE html>

<html lang = "pt-BR">
	
	<head>
		
		<title>Cadastro de Estados</title>
		<meta charset = "UTF-8" />
		<script src= "jquery-3.4.1.min.js"></script>
		<script>
			var id = null;
			$(function(){
				paginacao(0);
				
				//cadastrando um estado
				$(document).on("click",".btn_cadastrar",function(){
					
					$.ajax({ 
						url: "insere_estado.php",
						type: "post",
						data:{ nome_estado:$("input[name='nome_estado']").val(), 
								uf:$("input[name='uf']").val()
							},
						success: function(data){
							
							if (data=='1'){
								$("#resultado").html("Cadastro efetuado!");
								$("input[name='nome_estado']").val("");
								$("input[name='uf']").val("");
								paginacao(0);
							}else {
								console.log(data);
							}
						}
					});
				});
				//Função da paginação
				function paginacao(p) {
						$.ajax ({
							url: "carrega_estado.php",
							type: "post",
							data: {pg: p},
							success: function(matriz){
								$("#tb").html("");
								for (i=0;i<matriz.length;i++){
									linha = "<tr>";
									linha += "<td class = 'nome_estado'>" + matriz[i].nome + "</td>";
									linha += "<td class = 'nome_estado'>" + matriz[i].uf + "</td>";
									linha += "<td><button type = 'button' class = 'alterar' value = '"+ matriz[i].id_estado + "'>Alterar</button> <button type = 'button' class = 'remover' value = '"+ matriz[i].id_estado + "'>Remover</button></td>";
									linha += "</tr>";
									$("#tb").append(linha);
								}
							}
						});
				}
				
				$(".pg").click(function(){
					p = $(this).val();
					p = (p-1)*5;
					paginacao(p);
				});
				
				//Pegando os dados de cadastrado do estado que solicitei a alteração e mudando
				//o nome do botão cadastrar para alterar
				$(document).on("click",".alterar",function(){
					id = $(this).attr("value");
					$.ajax({
						url: "carrega_cadastro_alterar_estado.php",
						type: "post",
						data: {id: id},
						success: function(vetor){
							$("input[name='nome_estado']").val(vetor.nome);
							$("input[name='uf']").val(vetor.uf);
							$(".btn_cadastrar").attr("class","alteracao"); // removo a class de cadastrar pra ficar só com uma 
							$(".alteracao").val("Alterar estado"); //coloco um novo nome no botão 
						}
					});
				});
				//Alterando o cadastro do estado
				$(document).on("click",".alteracao",function(){
				$.ajax({ 
						url: "alteracao_estado.php",
						type: "post",
						data:{ id: id,
							   nome_estado:$("input[name='nome_estado']").val(), 
							   uf:$("input[name='uf']").val() 
							},
						
						success: function(data){
							if (data==1){
								$("#resultado").val("Estado alterado com sucesso!");
								paginacao(0);
								$("input[name='nome_estado']").val("");
								$("input[name='uf']").val("");
								$(".alteracao").attr("class","btn_cadastrar");
								$(".btn_cadastrar").val("Cadastrar");
							}else {
								console.log(data);
							}
						}
					});
				});
			});
		</script>
	</head>
	<body>
		<h3>Cadastro de Estados</h3>
		<form>
			<input type = "text" name = "nome_estado" placeholder = "Nome do Estado..." /> <br /><br />
			<input type = "text" name = "uf" placeholder = "UF..." /> <br /><br />
			<input type = "button" class = "btn_cadastrar" value = "Cadastrar" />	
		</form>
		<br />
		<div id = "resultado"></div>
		<br />
		
		<h3>Estados</h3>
		<table border = '1'>			
			<thead>
				<tr>
					<th>Estado</th>
					<th>UF</th>
					<th>Ação</th>
				</tr>
			 </thead>
		
			<tbody id = 'tb'></tbody>
					
		</table>
		<br /><br />
		
		<?php
			
			include("conexao.php");
				
				// $consulta = "SELECT * FROM cidade ORDER BY cidade";
				
				// $resultado = mysqli_query($conexao,$consulta) or die ("Erro." . mysqli_query($conexao)); 
				

			include("paginacao_estado.php");
			
		?>
		
	</body>
	
</html>