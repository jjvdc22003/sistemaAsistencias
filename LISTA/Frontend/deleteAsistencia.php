<?php 
    require_once '../Backend/Controllers/asistenciasController.php';
    $id="";

    session_start();
    if(!isset($_SESSION["correo"])){
        header('Location: login.php');
        exit();
    }
    
    if($_GET){
        $id = $_GET['id'];
        $asistencia = new asistencia;
        $resp = $asistencia->listOneId($id);
        $res = $resp['asistencia'];
        $fecha = $res[0]['fecha'];
        $resp = $asistencia->delete($id); ?>
            <div id="successModal" class="modal">
                <div class="modal-content">
                    <p>Se ha eliminado correctamente</p>
                    <form action="index.php" method="post">
                        <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                        <input type="hidden" name="flag" value="0">
                        <button type="submit" class="close-button">Cerrar</button>
                    </form>
                </div>
            </div>
    <?php }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar asistencia</title>
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
