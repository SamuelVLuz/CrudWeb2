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
        <h2>Cadastro de Pets</h2>
        <form method="POST" action="proc_cad_pet.php">
            <input type="text" name="nome" placeholder="Nome Completo" required>
            <input type="date" name="nascimento" placeholder="Nascimento" >
            <textarea name="prontuario" placeholder="Prontuário" required rows="4" cols="40"></textarea>

            <div class="radio-group">
                <label><input type="radio" name="genero" value="M"> Masculino</label>
                <label><input type="radio" name="genero" value="F"> Feminino</label>
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
            
            <p id="mensagemErro" class="error"></p>
            <button type="submit" name="cadastrar">Cadastrar</button>
        </form>
    </div>
</body>
</html>
