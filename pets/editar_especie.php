<!DOCTYPE html>
<html lang="pt-br">
<title>Cadastro de Pets</title>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pets</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="container">

            <?php
            $id_especie = $_GET["id_especie"]; // pegando o parametro de usuário que vem da url

	        require_once("../conecta.php");

            if ($conn) {

                // string da consulta responsável por recuperar o registro a ser editado
               $sql = "SELECT * FROM especies WHERE id = $id_especie";

               $resultado = mysqli_query($conn, $sql);

               if (mysqli_num_rows( $resultado) == 1) {
                    // encontrou o registro 
                    $especie = mysqli_fetch_array($resultado);
                    $nome = $especie["especie"];

               } else {
                    // não encontrou nenhum registro
                    header("location: mostrar.php");
               }
            }
            
            echo("<h2>Editando $nome</h2>");
        ?>
        <form method="POST" action="proc_cad_especie.php">
            <input type="text" name="especie" placeholder="Nome" value="<?= $nome ?>" required>
            <input type="hidden" name="id_especie" value="<?=  $id_especie ?>">
            <p id="mensagemErro" class="error"></p>
            <button type="submit" name="cadastrar">Cadastrar</button>
        </form>
    </div>
</body>
</html>
