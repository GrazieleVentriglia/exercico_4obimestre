<!DOCTYPE html>

<html lang = "pt-BR">
	
	<head>
		
		<title>Cadastro</title>
		<meta charset = "UTF-8" />
		<script src= "jquery-3.4.1.min.js"></script>
		<script>
			var id = null;
			$(function(){
				paginacao(0);
				
				//cadastrando uma cidade
				$(document).on("click",".btn_cadastrar",function(){
					$.ajax({ 
						url: "insere_cidade.php",
						type: "post",
						data:{ nome_cidade:$("input[name='nome_cidade']").val(),
								cod_estado:$("select[name='cod_estado']").val()
							},
						success: function(data){
							if (data==1){
								$("#resultado").val("Cadastro efetuado!");
								$("input[name='nome_cidade']").val("");
								$("select[name='cod_estado']").val("");
								paginacao(0);
							}else {
								console.log(data);
							}
						}
					});
				});
				
				//Função da Paginação
				function paginacao(p) {
						$.ajax ({
							url: "carrega_cidade.php",
							type: "post",
							data: {pg: p},
							success: function(matriz){
								$("#tb").html("");
								for (i=0;i<matriz.length;i++){
									linha = "<tr>";
									linha += "<td class = 'nome_cidade'>" + matriz[i].nome_cidade + "</td>";
									linha += "<td class = 'nome_estado'>" + matriz[i].nome_estado + "</td>";
									linha += "<td><button type = 'button' class = 'alterar' value = '"+ matriz[i].id_cidade + "'>Alterar</button> <button type = 'button' class = 'remover' value = '"+ matriz[i].id_cidade + "'>Remover</button></td>";
									linha += "</tr>";
									$("#tb").append(linha);
								}
							}
						});
				}
				
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
				//Alterando o cadastro da cidade
				$(document).on("click",".alteracao",function(){
				$.ajax({ 
						url: "alteracao_cidade.php",
						type: "post",
						data:{ id: id,
							   nome_cidade:$("input[name='nome_cidade']").val(), 
							   uf:$("select[name='cod_estado']").val() 
							},
						
						success: function(data){
							if (data==1){
								$("#resultado").val("Cidade alterada com sucesso!");
								paginacao(0);
								$("input[name='nome_cidade']").val("");
								$("select[name='cod_estado']").val("");
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
		<h3>Cadastro de Cidades</h3>
		<form>
			<input type = "text" name = "nome_cidade" placeholder = "Nome da Cidade..." /> <br /><br />
			<select name='cod_estado' placeholder = "Selecione um estado...">
				<option>Selecione um estado</option>
				<?php
					include("conexao.php");
					$sql = "SELECT * FROM estado";
					$resultado = mysqli_query($conexao,$sql);
					while($linha=mysqli_fetch_assoc($resultado)){
						echo "<option value='".$linha["id_estado"]."'>".$linha["nome"]."/".$linha["uf"]."</option>";
					}
				?>	
			</select>
			</br></br>
			<input type = "button" class = "btn_cadastrar" value = "Cadastrar" />
		</form>
		<br />
		<div id = "resultado"></div>
		<br />
		
		<h3>Cadastros</h3>
		<table border = '1'>			
			<thead>
				<tr>
					<th>Cidade</th>
					<th>Estado</th>
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
				

			include("paginacao_cidade.php");
			
		?>
		
	</body>
	
</html>