<?php
    session_start();
    if(!isset($_SESSION["correo"])){
        header('Location: login.php');
        exit();
    }

    require_once '../../QR_back/Controllers/asistenciasController.php';

    if($_GET){
        $id = $_GET['id'];
        $asistencia = new asistencia;
        $resp = $asistencia->listOneId($id);
        $res = $resp['asistencia'];
        $matricula=$res[0]['matricula_alumno'];
        $fecha=$res[0]['fecha'];
        $hora_entrada=$res[0]['hora_entrada'];
        $hora_salida=$res[0]['hora_salida'];
    }
    if($_POST){
        $asistencia = new asistencia;
        $resp = $asistencia->update($_POST['id'],$_POST);
        $fecha = $_POST['fecha'];
        ?>
            <div id="successModal" class="modal">
                <div class="modal-content">
                    <p>Se ha actualizado la asistencia</p>
                    <form action="getLista.php" method="post">
                        <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">
                        <input type="hidden" name="flag" value="0">
                        <button type="submit" class="close-button">Cerrar</button>
                    </form>
                </div>
            </div>
    <?php
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar asistencia</title>
</head>
<body>
    <h3>Editar asistencia</h3>
    <form action="updateLista.php" method="post">
        Matricula:
        <input  value="<?php echo isset($matricula)?$matricula:""; ?>" type="text" name="matricula_alumno" id="">
        <br/>
        <br/>
        Fecha:
        <input  value="<?php echo isset($fecha)?$fecha:""; ?>" type="date" name="fecha" id="">
        <br/>
        <br/>
        Hora de entrada:
        <input  value="<?php echo isset($hora_entrada)?$hora_entrada:"00:00"; ?>" type="time" name="hora_entrada" id="">
        <br/>
        <br/>
        Hora de salida:
        <input  value="<?php echo isset($hora_salida)?$hora_salida:"00:00"; ?>" type="time" name="hora_salida" id="">
        <br/>
        <br/>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="submit" value="Guardar">
        <a href="getLista.php" class="azul-button">Regresar</a>
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
    }
    .close-button:hover {
        background-color: #45a049;
    }
</style>

<script>
    function closeModal() {
        window.location.href = 'getLista.php';
    }
</script>