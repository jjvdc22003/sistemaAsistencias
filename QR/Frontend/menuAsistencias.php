<?php 
    session_start();
    if(!isset($_SESSION["correo"])){
        header('Location: login.php');
        exit();
    }
    elseif (isset($_SESSION["matricula"])) {
      header('Location: indexA.php');
      exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú asistencias</title>
</head>
<body>
    <h1>Sistema de asistencias</h1>

    <a href="registrarAsistencia.php" class ="green-button">Registrar asistencia</a>
    <a href="getLista.php" class ="azul-button">Generar lista</a>
    <a href="index.php" class ="close-button">Regresar al menú principal</a>
</body>
</html>

<style>
    .green-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #52B830;
      color: white;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
    }
    .green-button:hover {
      background-color: darkgreen;
    }
    .azul-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #0087D1;
      color: white;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
    }
    .azul-button:hover {
      background-color: darkblue;
    }
    .close-button {
        background-color: #E62E00;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        border-radius: 5px;
    }
    .close-button:hover {
        background-color: #800000;
    }

    
</style>