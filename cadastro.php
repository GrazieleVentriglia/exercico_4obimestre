<!DOCTYPE html>

<html lang = "pt-BR">
	
	<head>
		
		<title>Cadastro</title>
		<meta charset = "UTF-8" />
		<script src= "jquery-3.4.1.min.js"></script>
		<script>
			var id = null;
			var filtro = null;
			$(function(){
				
				paginacao(0);
				
				//Pegando os dados de cadastrado do cliente que slicitei a alteração e mudando
				//o nome do botão cadastrar para alterar
				$(document).on("click",".alterar",function(){
					id = $(this).attr("value");
					$.ajax({
						url: "carrega_cadastro_alterar.php",
						type: "post",
						data: {id: id},
						success: function(vetor){
							$("input[name='nome']").val(vetor.nome);
							$("input[name='email']").val(vetor.email);
							if (vetor.sexo=='F'){
								$("input[name='sexo'][value='M']").attr("checked",false);
								$("input[name='sexo'][value='F']").attr("checked",true);
							} else {
								$("input[name='sexo'][value='F']").attr("checked",false);
								$("input[name='sexo'][value='M']").attr("checked",true);
							}
							$(".btn_cadastrar").attr("class","alteracao"); // removo a class de cadastrar pra ficar só com uma 
							$(".alteracao").val("Alterar cadastro"); //coloco um novo nome no botão 
							
						}
					});
				});
				//Alterando o cadastro
				$(document).on("click",".alteracao",function(){
				$.ajax({ 
						url: "alteracao_cadastro.php",
						type: "post",
						data:{ id: id,
							   nome:$("input[name='nome']").val(), 
							   email:$("input[name='email']").val(), 
							   sexo:$("input[name='sexo']:checked").val()
							},
						
						success: function(data){
							console.log(data);
							if (data==1){
								$("#resultado").val("Cadastro alterado com sucesso!");
								paginacao(0);
								$("input[name='nome']").val("");
								$("input[name='email']").val("");
								$("input[name='sexo'][value='M']").attr("checked",false);
								$("input[name='sexo'][value='F']").attr("checked",false);
								$(".alteracao").attr("class","btn_cadastrar");
								$(".btn_cadastrar").val("Cadastrar");
							}else {
								console.log(data);
							}
						}
					});
				});
				
				//Função da paginação
				function paginacao(p) {
					$.ajax ({
						url: "carrega_cadastro.php",
						type: "post",
						data: {pg: p, nome_filtro: filtro},
						success: function(matriz){
							
							$("#tb").html("");
							for (i=0;i<matriz.length;i++){
								linha = "<tr>";
								linha += "<td class = 'nome'>" + matriz[i].nome_cadastro + "</td>";
								linha += "<td class = 'email'>" + matriz[i].email + "</td>";
								linha += "<td class = 'sexo'>" + matriz[i].sexo + "</td>";
								linha += "<td class = 'salario'>" + matriz[i].salario + "</td>";
								linha += "<td class = 'cidade'>" + matriz[i].nome_cidade + "</td>";
								linha += "<td><button type = 'button' class = 'alterar' value = '"+ matriz[i].id_cadastro + "'>Alterar</button> <button type = 'button' class = 'remover' value = '"+ matriz[i].id_cadastro + "'>Remover</button></td>";
								linha += "</tr>";
								$("#tb").append(linha);
							}
						}
					});
				}
				
				$(document).on("click",".pg",function(){
					p = $(this).val();
					p = (p-1)*5;
					paginacao(p);
				});
				
				//cadastrando uma pessoa
				$(document).on("click",".btn_cadastrar",function(){
					$.ajax({ 
						url: "insere.php",
						type: "post",
						data:{ nome:$("input[name='nome']").val(), 
							   email:$("input[name='email']").val(), 
							   sexo:$("input[name='sexo']:checked").val(),
							   salario:$("input[name='salario']").val(),
							   cod_cidade:$("select[name='cod_cidade']").val()
							},
						success: function(data){
							if (data=='1'){
								$("#resultado").html("Cadastro efetuado!");
								$("input[name='nome']").val("");
								$("input[name='email']").val("");
								$("input[name='sexo']:checked").val("");
								$("input[name='salario']").val("");
								$("select[name='cod_cidade']").val("");
								paginacao(0);
							}else {
								console.log(data);
							}
						}
					});
				});
				
				
				//Transformando a coluna em um input (NOME)
				$(document).on("click",".nome",function(){
					td = $(this); //pego o valor do td todo <td class = 'nome'>"(o nome que estiver la)"</td>";
					nome = td.html(); //pego apenas o conteudo htmll daquela td 
					td.html("<input type = 'text' id = 'nome_alterar' name = 'nome' value ='"+ nome +"'/>"); //troco o conteudo da td toda por uma tag de input
					td.attr("class", "nome_alterar"); //mudo a class pra se eu clicar mais vezes não ficar entrando sempre na função e adicinando um input novo
				});
				
				$(document).on("blur",".nome_alterar",function(){ //Quando eu sair do campo...
					td = $(this); //Eu pego o valor daquela td dnv
					id_linha = $(this).closest("tr").find("button").val(); //Eu pego o id do botão alterar que é o que contem o id e está mais próximo
					$.ajax({
						url:"alterar_coluna.php",
						type:"POST",
						data:{
							   tabela: "cadastro",
							   coluna:"nome", //mando o nome 
							  valor:$("#nome_alterar").val(),
							  id: id_linha // o id que peguei
						},
						success: function(data){
							nome = $("#nome_alterar").val();
							td.html(nome);
							td.attr("class","nome"); //troco a class dnv
							//console.log(data);
						}
					});
				
				});
				//Transformando a coluna em um input (EMAIL)
				$(document).on("click",".email",function(){
					td = $(this); //pego o valor do td todo <td class = 'email'>"(o email que estiver la)"</td>";
					email = td.html(); //pego apenas o conteudo htmll daquela td 
					td.html("<input type = 'text' id = 'email_alterar' name = 'email' value ='"+ email +"'/>"); //troco o conteudo da td toda por uma tag de input
					td.attr("class", "email_alterar"); //mudo a class pra se eu clicar mais vezes não ficar entrando sempre na função e adicinando um input novo
				});
				
				$(document).on("blur",".email_alterar",function(){ //Quando eu sair do campo...
					td = $(this); //Eu pego o valor daquela td dnv
					id_linha = $(this).closest("tr").find("button").val(); //Eu pego o id do botão alterar que é o que contem o id e está mais próximo
					$.ajax({
						url:"alterar_coluna.php",
						type:"POST",
						data:{
								tabela: "cadastro",
								coluna:"email", //mando o email 
							  valor:$("#email_alterar").val(),
							  id: id_linha // o id que peguei
						},
						success: function(data){
							email = $("#email_alterar").val();
							td.html(email);
							td.attr("class","email"); //troco a class dnv
							//console.log(data);
						}
					});
				
				});
				
				//Filtro
				$("#filtrar").click(function(){
					$.ajax({
						url:"paginacao_cadastro.php",
						type:"POST",
						data:{
								nome_filtro: $("input[name='nome_filtro']").val()
						},
						success: function(data){ //Colocando os botões que retorna do paginacao_cadastro na div paginacao
							$("#paginacao").html(data);
							filtro = $("input[name='nome_filtro']").val();
							paginacao(0);
							
						}
				});
			});
		});
		</script>
		
	</head>
	
	<body>
		
		<h3>Cadastro de Pessoas</h3>
		
		<form>
			
			<input type = "text" name = "nome" placeholder = "Nome..." /> <br /><br />
			<input type = "email" name = "email" placeholder = "E-mail..." /><br /><br />
			<input type = "number" name = "salario" placeholder = "Salario..." min='0' step="0.01"/><br /><br />
			Sexo: <br />
			M <input type = "radio" name = "sexo" value = "M" />
			F <input type = "radio" name = "sexo" value = "F" /><br /><br />
			
			<select name='cod_cidade'>
				<option>::selecione uma cidade</option>
				<?php
					include("conexao.php");
					$sql = "SELECT id_cidade, cidade.nome as nome_cidade, estado.uf FROM cidade INNER JOIN estado on cidade.cod_estado=estado.id_estado";
					$resultado = mysqli_query($conexao,$sql);
					while($linha=mysqli_fetch_assoc($resultado)){
						echo "<option value='".$linha["id_cidade"]."'>".$linha["nome_cidade"]."/".$linha["uf"]."</option>";
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
		
		<form name = "filtro">
			<input type = "text" name = "nome_filtro" placeholder = "Filtrar por nome..."/>
			<button type = "button" id = "filtrar">Filtrar</button>
		</form>
		</br>
		
		<table border = '1'>
						
			<thead>
				<tr>
					<th>Nome</th>
					<th>E-mail</th>
					<th>Sexo</th>
					<th>Salario</th>
					<th>Cidade</th>
					<th>Ação</th>
				</tr>
			 </thead>
		
			<tbody id = 'tb'></tbody>
					
		</table>
		<br /><br />
		
		<div id = "paginacao">
			<?php
				include("conexao.php");
				include("paginacao_cadastro.php");
			?>
		</div>
	</body>
	
</html>