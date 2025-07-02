<?php 
    require_once("../protege.php");
?>

<?php    
    function GeneroParaTexto($gen){
        switch($gen){
            case 'M': return "Masculino";
            case 'F': return "Feminino";
            default: return "Desconhecido";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pets Cadastrados</title>
    <style>
        .mostrar_body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .mostrar_container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 1000px;
            margin: 0 auto;
        }
        .alert {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .mostrar_h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #28a745;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-add {
            background-color:rgb(7, 255, 36); /* verde */
            color: #212529;
        }

        .btn-add:hover {
            background-color:rgb(38, 153, 0);
            color: #fff;
        }

        .btn-edit {
            background-color: #ffc107; /* amarelo */
            color: #212529;
        }

        .btn-edit:hover {
            background-color: #e0a800;
            color: #fff;
        }

        .btn-delete {
            background-color: #dc3545; /* vermelho */
            color: #fff;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
        @media screen and (max-width: 600px) {
            th, td {
                padding: 8px;
                font-size: 14px;
            }
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none; /* remove sublinhado */
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .species-manager {
        display: flex;
        justify-content: space-between;
        padding-left: 10%;
        padding-right: 10%;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
        }

        .species-left {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            width: 40%;
            min-width: 300px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .species-right {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            width: 35%;
            min-width: 250px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .species-left form, .species-right form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .species-left select,
        .species-left input,
        .species-right input {
            padding: 8px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: flex-start;
        }

    </style>
</head>
<body class="mostrar_body">
    <div class="mostrar_container">

        <!-- Mensagem de sucesso -->
        <?php
            // a linha abaixo pode ficar comentada, pois a sessão já é iniciada no arquivo protege.php
            //session_start();    // inicia a sessão
            // testa se existe a variavel de sessão para mostrar a mensagem de sucesso
            if (isset($_SESSION["msg_sucesso"])) :
        ?>
            <div class="alert">
                <?php echo ($_SESSION["msg_sucesso"]); ?>
            </div>
        <?php 
            unset($_SESSION["msg_sucesso"]);    // exclui a variavel de sessão
            endif; // fechamento do if na sintaxe alternativa
        ?>

        <h2 class="mostrar_h2">Pets Cadastrados</h2>

        <?php
            // estabelece a conexão com o banco de dados
	        require_once("../conecta.php");

            $sql = "SELECT pets.id AS id_pet, pets.nome AS nome, DATE_FORMAT(pets.nascimento, '%d/%m/%Y') AS nascimento, prontuario, genero, especie FROM pets JOIN especies ON especies.id = id_especie ORDER BY pets.nome ASC;";

            // ao exececutar uma consulta do tipo select, a função mysqli_query retorna um resultset 
            $resultado = mysqli_query($conn, $sql);

            // mysqli_num_rows conta quantas linhas o resultset tem
            // se há mais de 0 linhas, é porque tem algo para ser exibido
            if (mysqli_num_rows($resultado) > 0) {
                
                // gera a parte inicial da tabela, que exibirá os dados
                echo ('<div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Nascimento</th>
                                <th>Prontuário</th>
                                <th>Gênero</th>
                                <th>Espécie</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>');

            // exibibindo os registro que estão vindos do banco de dados
            // Recupera a próxima linha do resultado da consulta SQL como um array associativo. A função mysqli_fetch_assoc é usada para obter uma linha do resultado de uma consulta SQL 
            
            while ($row = mysqli_fetch_assoc($resultado) ){
                echo ("<tr>");  // abre uma nova linha da tabela
                // adiciona os dados (td) da tabela
                // A função htmlspecialchars() em PHP é usada para converter caracteres especiais em entidades HTML
                echo ("<td>" . htmlspecialchars($row["nome"]) . "</td>");
                echo ("<td>" . htmlspecialchars($row["nascimento"]) . "</td>");
                echo ("<td>" . htmlspecialchars($row["prontuario"]) . "</td>");
                // chama a função tipoParaTexto
                echo ("<td>" . GeneroParaTexto($row["genero"]) . "</td>");
                echo ("<td>" . htmlspecialchars($row["especie"]) . "</td>");
                echo ("<td><a class='btn btn-edit' href='editar.php?id_pet=" . urlencode($row['id_pet'])) . "'>Editar</a>";
                echo ("<a class='btn btn-delete' href='excluir_pet.php?id_pet=" . urlencode($row['id_pet'])) . "'>Excluir</a></td>";
                
                echo ("</tr>"); // fecha uma nova linha da tabela
            }
            
            // ao terminar o while, é necessário fechar as tags da tabela, que foram abertas antes do laço de repetição
            echo ("</tbody></table>"); 
            } else {
                // se a consulta retornou 0 linhas
                echo ("<h1>Não há nada para ser exibido</h1>");
            }

            echo("<div class='btn-container'><a class='btn btn-add' href='cadastrar.php'>+ Adicionar Pet</a></div>");

        ?>

        <h2 class="mostrar_h2">Espécies</h2>
        
            <?php
        echo("<div class='species-manager'>");
            // estabelece a conexão com o banco de dados
	        require_once("../conecta.php");

            $sql = "SELECT id AS id_especie, especie FROM especies ORDER BY especie ASC;";

            $resultado = mysqli_query($conn, $sql);

            if (mysqli_num_rows($resultado) > 0) {
                
                echo ('<div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>');

           
            while ($row = mysqli_fetch_assoc($resultado) ){
                echo ("<tr>");
                echo ("<td>" . htmlspecialchars($row["especie"]) . "</td>");
                echo ("<td><a class='btn btn-edit' href='editar_especie.php?id_especie=" . urlencode($row['id_especie'])) . "'>Editar</a>";
                echo ("<a class='btn btn-delete' href='excluir_especie.php?id_especie=" . urlencode($row['id_especie'])) . "'>Excluir</a></td>";
                
                echo ("</tr>");
            }
            
            echo ("</tbody></table>"); 
            } else {
                echo ("<h1>Não há nada para ser exibido</h1>");
            }

            echo("</div>");
        echo("<div class='btn-container'><a class='btn btn-add' href='cadastrar_especie.php'>+ Adicionar Especie</a></div>");
        ?>

        
    <script>
        // javascript para ocultar a div que contém as mensagens de erro
        setTimeout(function() {

            const alertas = document.querySelectorAll('.alert');

            alertas.forEach(alerta => {
                alerta.style.opacity = '0';
                setTimeout(() => alerta.style.display = 'none', 500);
            })
        }, 5000);
    </script>
</body>
</html>
