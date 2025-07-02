<?php
    require("./conecta.php");

    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE (email = '$usuario' OR nome = '$usuario') AND senha = '$senha'";

    $resultado = mysqli_query($conn, $sql);

    session_start();

    if (mysqli_num_rows($resultado) > 0){
        $_SESSION["usuario"] = $usuario;
        header("location: pets/mostrar.php");
    } else {
        $_SESSION["erro"] = "Usuario ou senha incorretos";
        header("location: login.php");
    }
?>