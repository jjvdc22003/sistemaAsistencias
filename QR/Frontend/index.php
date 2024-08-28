<?php
  session_start();
  if(!isset($_SESSION["correo"])){
    header('Location: login.php');
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
</head>
<body>
    <h1>Sistema de asistencias</h1>

    <a href="registrarAsistencia.php" class ="green-button">Registrar asistencias</a>
    <a href="listAlumnos.php" class ="blue-button">Gestionar alumnos</a>
    <?php if($_SESSION["rol"]=='Admin'){ ?><a href="listAdministradores.php" class ="purple-button">Gestionar administradores</a> <?php } ?>
    <a href="logout.php" class ="red-button">Cerrar sesión</a>
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
    .blue-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #0087D1;
      color: white;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
    }
    .blue-button:hover {
      background-color: darkblue;
    }
    .red-button {
        background-color: #E62E00;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        border-radius: 5px;
    }
    .red-button:hover {
        background-color: #CB1D11;
    }
    .purple-button {
        background-color: #A11C55;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        border-radius: 5px;
    }
    .purple-button:hover {
        background-color: #800040;
    }
</style>