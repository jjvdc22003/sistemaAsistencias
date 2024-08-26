<?php 
    require "../Backend/Controllers/alumnosController.php";

    $id="";

    session_start();
    if(!isset($_SESSION["correo"])){
        header('Location: login.php');
        exit();
    }
    
    if($_GET){
        $id = $_GET['id'];
        $alumnoController = new alumno;
        $buscar = $alumnoController->listOne($id);
        $alumno = $buscar['alumno'][0];
        $nombre=$alumno['nombre'];
        $eliminar = $alumnoController->delete($id);
        if($eliminar['status'] == 200){
            echo '
                <div id="successModal" class="modal">
                    <div class="modal-content">
                        <p>Se ha eliminado correctamente a: <strong>"'.$nombre.'"</strong></p>
                        <span class="close-button" onclick="closeModal()">Cerrar</span>
                    </div>
                </div>
            ';
        } else {
            echo '
                <div id="successModal" class="modal">
                    <div class="modal-content">
                        <h1>ERROR</h1>
                        <p><strong>Error al eliminar: </strong>"'.$eliminar['error'].'"</p>
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
    <title>Eliminar alumno</title>
</head>
<body>
</body>
</html>

<!-- CSS para el modal -->
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

<!-- JavaScript para cerrar el modal y redirigir -->
<script>
    function closeModal() {
        window.location.href = 'listAlumnos.php';
    }
</script>