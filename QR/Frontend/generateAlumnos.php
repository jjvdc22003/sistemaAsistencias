<?php
    require "../Backend/generateList.php";
    if($_POST){
        if (isset($_FILES['archivoExcel'])) {
            $nombreArchivo = $_FILES['archivoExcel']['name'];
            $tipoArchivo = $_FILES['archivoExcel']['type'];
            $tamañoArchivo = $_FILES['archivoExcel']['size'];
            $rutaTemporal = $_FILES['archivoExcel']['tmp_name'];
            $directorioDestino = '../assets/uploads/'; // Asegúrate de que esta carpeta exista y tenga permisos de escritura
    
            // Crear el directorio si no existe
            if (!is_dir($directorioDestino)) {
                mkdir($directorioDestino, 0777, true);
            }
    
            // Mover el archivo a la carpeta de destino
            $rutaDestino = $directorioDestino . basename($nombreArchivo);
            if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                echo "El archivo se ha subido correctamente.";
            } else {
                echo "Error al mover el archivo.";
            }
        } else {
            echo "Error al subir el archivo.";
        }
        $generate = new generateList;
        $num=$generate->generateAlumnos($directorioDestino.$nombreArchivo);
        if ($num>=0) {
            echo '
                <div id="errorModal" class="modal">
                    <div class="modal-content">
                        <h1>Hecho</h1>
                        <p>Se han registrado exitosamente a '.$num.' alumnos <strong>Exitosamente</strong></p>
                        <span class="close-button" onclick="closeModal()">Cerrar</span>
                    </div>
                </div>
            ';
        }
        else{
            echo '
                <div id="errorModal" class="modal">
                    <div class="modal-content">
                        <h1>Error</h1>
                        <p>Error al registrar</p>
                        <span class="close-button" onclick="closeModal()">Cerrar</span>
                    </div>
                </div>
            ';
        }
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
    <form action="generateAlumnos.php" enctype="multipart/form-data" method="post">
        <label for="archivoExcel">Subir archivo Excel:</label>
        <input type="file" id="archivoExcel" name="archivoExcel" accept=".xls,.xlsx">
        <br>
        <input type="submit" name="enviar" value="Enviar información">
        <a href="listAlumnos.php">Volver</a>
    </form>
</body>
</html>

<style>
    .modal {
        display: block; /* Mostrar el modal */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 40%;
        text-align: center;
    }
    .close-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        border-radius: 5px;
    }
    .close-button:hover {
        background-color: #45a049;
    }
</style>

<!-- JavaScript para cerrar el modal y redirigir -->
<script>
    function closeModal() {
        window.location.href = 'listAlumnos.php';
    }
</script>