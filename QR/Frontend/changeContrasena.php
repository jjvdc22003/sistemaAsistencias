<?php
    require "../Backend/Controllers/cuentasController.php";

    if($_GET) {
        $id = $_GET['id'];
    }

    if($_POST) {
        $id = (isset($_POST['id'])) ? $_POST['id']:"";
        $contrasenaNueva = (isset($_POST['contrasenaNueva'])) ? $_POST['contrasenaNueva']:"";
        $contrasenaConfirmada = (isset($_POST['contrasenaConfirmada'])) ? $_POST['contrasenaConfirmada']:"";

        //Comparación de las contraseñas
        if (strcmp($contrasenaNueva, $contrasenaConfirmada) == 0) {
            $cuentaController = new cuenta;
            $actualizar = $cuentaController->changePassword($id,$contrasenaNueva);
            if($actualizar['status'] == 200){
                echo '
                    <div id="" class="modal">
                        <div class="modal-content">
                            <p>Se ha cambiado correctamente la contraseña</p>
                            <span class="close-button" onclick="closeModal()">Cerrar</span>
                        </div>
                    </div>
                ';
            } else {
                echo '
                    <div id="" class="modal">
                        <div class="modal-content">
                            <h1>ERROR</h1>
                            <p><strong>Error al cambiar contraseña: </strong>"'.$actualizar['error'].'"</p>
                            <span class="close-button" onclick="closeModal()">Cerrar</span>
                        </div>
                    </div>
                ';
            }
        } else {
            echo '
                <div id="" class="modal">
                    <div class="modal-content">
                        <h1>ERROR</h1>
                        <p>Las contraseñas <strong>no</strong> son iguales</p>
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
    <title>Cambiar contraseña</title>
</head>
<body>
    <h1>Cambiar contraseña</h1>
    <form action="changeContrasena.php" method="post">
        Contraseña nueva:
        <input type="password" name="contrasenaNueva">
        <br/>
        <br/>
        Confirmar contraseña nueva:
        <input type="password" name="contrasenaConfirmada">
        <br/>
        <br/>
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <a href="listAdministradores.php">Volver</a>
        <input type="submit" value="Guardar">
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
        window.location.href = 'listAdministradores.php';
    }
</script>