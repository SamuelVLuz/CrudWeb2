<?php

	// arquivo responsável por fazer a conexão com o banco de dados
	$conn = mysqli_connect("127.0.0.1", "root", "", "pets_db");

	if (!$conn){
		die("Houve um erro ao conectar com o banco de dados");
	}
?>