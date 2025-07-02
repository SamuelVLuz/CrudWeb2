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
        <h2>Adicionar Espécie</h2>
        <form method="POST" action="proc_cad_especie.php">
            <input type="text" name="especie" placeholder="Nome" required>
            <p id="mensagemErro" class="error"></p>
            <button type="submit" name="cadastrar">Cadastrar</button>
        </form>
    </div>
</body>
</html>
