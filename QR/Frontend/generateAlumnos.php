<?php

    if($_POST){
        print_r($_POST);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar alumnos</title>
</head>
<body>
    <form action="generateAlumnos.php" method="post">
        <label for="archivoExcel">Subir archivo Excel:</label>
        <input type="file" id="archivoExcel" name="archivoExcel" accept=".xls,.xlsx">
        <br>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>