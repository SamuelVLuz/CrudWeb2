<?php
	
	if (! isset($_POST["cadastrar"]) ){
		header("location: cadastrar.php");	// redirecionada para a página de cadastro
	} 

	$especie = $_POST["especie"];

	$erros = [];	

	if (empty($especie)){
		$erros[] = "Escolha a <b>espécie<b>";
	}

	if (count($erros) == 0){
		require_once("../conecta.php");
		
		if ($conn){
			
			$id = $_POST["id_especie"];

			if (isset($id) && !empty($id))
				// consulta sql que atualiza o registro
				echo $sql = "UPDATE especies SET especie = '$especie' WHERE id = $id";		
			else
				$sql = "INSERT INTO especies (especie) VALUES ('$especie') ";

			if (mysqli_query($conn, $sql) ) {
				session_start();	// iniciando a sessão
				
				if (isset($id) && !empty($id))
					$_SESSION["msg_sucesso"] = "Espécie atualizada com sucesso"; // armazena a mensagem de sucesso na variavel de sessão
				else
					$_SESSION["msg_sucesso"] = "Espécie inserida com sucesso"; // armazena a mensagem de sucesso na variavel de sessão

				header("location: mostrar.php");	// faz um redirecionamento para outra página
				
				mysqli_close($conn);	// fecha a conexão com o banco de dados
			} else {
				echo ("Houve um erro ao tentar inserir <br> " . mysqli_error($conn) );
			}

		} else {
			die("Houve um erro ao conectar com o banco de dados");
		}
		
		echo ("Espécie: <b>$especie</b><br>");
	} else {
		// percorrendo o array para mostrar os erros de preenchimento noi formulário
		for ($i=0; $i < count($erros); $i++){
			echo ($erros[$i] . "<br>");	// exibindo cada erro armazenado no array
		}
	}
?>