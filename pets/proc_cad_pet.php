<?php
	// proc_cad.php

	// testa se não existe a variavel $_POST["cadastrar"]
	// para ela não existir, significa que o usuário acessou diretamente o arquivo proc_cad.php sem ter acessado o formulário de cadastro
	if (! isset($_POST["cadastrar"]) ){
		header("location: cadastrar.php");	// redirecionada para a página de cadastro
	} 

	// armazena as informações vindas do formulário em variaveis
	$nome = $_POST["nome"];
	$nascimento = $_POST["nascimento"];
	$prontuario = $_POST["prontuario"];
	$genero = $_POST["genero"];
	$especie = $_POST["especie"];


	// array para controle dos erros. Em cada cada validação, se houver um erro, a mensagem será armazenada neste array 
	$erros = [];	

	// validando cada variavel para saber se ela foi preenchida corretamente
	if (empty($nome) ){
		$erros[] = "Preencha o <b>nome</b>";	// adicionando a mensagem de erro ao array
	}

	if (empty($nascimento) ){
		$erros[] = "Preencha a <b>data de nascimento</b>";
	}

	if (empty($prontuario) ){
		$erros = ["Preencha o <b>prontuario</b>"];
	}

	if (empty($genero) ){
		$erros [] = "Escolha o <b>gênero</b>";
	}

	if (empty($especie)){
		$erros[] = "Escolha a <b>espécie<b>";
	}


	// se o array estiver zerado é por que não teve nenhum erro no preenchimento
	if (count($erros) == 0){
		// aqui dentro será a lógica relacionada ao banco de dados

		// estabelece a conexão com o banco de dados
		require_once("../conecta.php");
		
		// testa se a conexão ocorreu com sucesso
		if ($conn){
			
			$id = $_POST["id_pet"];

			// se existe o parametro id_usuario no form é por que é uma operação de edição
			if (isset($id) && !empty($id))
				// consulta sql que atualiza o registro
				echo $sql = "UPDATE pets SET nome = '$nome', nascimento = '$nascimento', prontuario = '$prontuario', genero = '$genero', id_especie = '$especie' WHERE id = $id";		
			else
				// consulta sql que insere o registro
				$sql = "INSERT INTO pets (nome, nascimento, prontuario, genero, id_especie) VALUES ('$nome', '$nascimento', '$prontuario', '$genero', '$especie') ";

			// manda executar a consulta e testa se ela retornou true, indicando que houve sucesso
			// se retornar false, indica que houve erro na consulta
			if (mysqli_query($conn, $sql) ) {
				// para mostrar a mensagem de sucesso, será necessário uma variavel de sessão
				session_start();	// iniciando a sessão
				
				if (isset($id) && !empty($id))
					$_SESSION["msg_sucesso"] = "Pet atualizado com sucesso"; // armazena a mensagem de sucesso na variavel de sessão
				else
					$_SESSION["msg_sucesso"] = "Pet inserido com sucesso"; // armazena a mensagem de sucesso na variavel de sessão

				header("location: mostrar.php");	// faz um redirecionamento para outra página
				
				mysqli_close($conn);	// fecha a conexão com o banco de dados
			} else {
				echo ("Houve um erro ao tentar inserir <br> " . mysqli_error($conn) );
			}

		} else {
			die("Houve um erro ao conectar com o banco de dados");
		}

		echo ("Nome: <b>$nome</b><br>");
		echo ("Data de nascimento: <b>$nascimento</b><br>");
		echo ("Prontuário: <b>$prontuario</b><br>");
		echo ("Gênero: <b>$genero</b><br>");
		echo ("Espécie: <b>$especie</b><br>");
	} else {
		// percorrendo o array para mostrar os erros de preenchimento noi formulário
		for ($i=0; $i < count($erros); $i++){
			echo ($erros[$i] . "<br>");	// exibindo cada erro armazenado no array
		}
	}
?>