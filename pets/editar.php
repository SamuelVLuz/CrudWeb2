<!DOCTYPE html>
<html lang="pt-br">
<title>Cadastro de Pets</title>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="container">

        <?php
            $id_pet = $_GET["id_pet"]; // pegando o parametro de usuário que vem da url

	        require_once("../conecta.php");

            if ($conn) {

                // string da consulta responsável por recuperar o registro a ser editado
               $sql = "SELECT * FROM pets WHERE id = $id_pet";

               $resultado = mysqli_query($conn, $sql);

               if (mysqli_num_rows( $resultado) == 1) {
                    // encontrou o registro 
                    $pet = mysqli_fetch_array($resultado);

                    $nome = $pet["nome"];
                    $nasc = $pet["nascimento"];
                    $prontuario = $pet["prontuario"];
                    $genero = $pet["genero"];
                    $especie = $pet["id_especie"];

               } else {
                    // não encontrou nenhum registro
                    header("location: mostrar.php");
               }
            }
            
            echo("<h2>Editando $nome</h2>");
        ?>
        <form method="POST" action="proc_cad_pet.php">
            <input type="text" name="nome" placeholder="Nome Completo" value="<?= $nome ?>" required>
            <input type="date" name="nascimento" placeholder="Nascimento" value="<?= $nasc ?>">
            <textarea name="prontuario" placeholder="Prontuário" required rows="4" cols="40"> <?= $prontuario ?> </textarea>

            <div class="radio-group">
                <label><input type="radio" name="genero" value="M" <?= $genero == 'M' ? 'checked' : '' ?>> Masculino</label>
                <label><input type="radio" name="genero" value="F" <?= $genero == 'F' ? 'checked' : '' ?>> Feminino</label>
            </div>
            
            <!-- criando um select dinamico para escolha da especie -->
            <select name="especie">
                <?php
                    require_once("../conecta.php");

                    $sql = "SELECT * FROM especies";

                    $resultado = mysqli_query($conn, $sql);

                    // usando a sintaxe alternativa do php para não ficar concatenando strings...
                    while ($row = mysqli_fetch_assoc($resultado) ):

                ?>

                    <option value="<?= $row['id']?>"><?= $row["nome"] ?></option>

                <?php
                    endwhile;
                ?>
            
            </select>
            
            <input type="hidden" name="id_pet" value="<?=  $id_pet ?>">
            <p id="mensagemErro" class="error"></p>
            <button type="submit" name="cadastrar">Cadastrar</button>
        </form>
    </div>
</body>
</html>
