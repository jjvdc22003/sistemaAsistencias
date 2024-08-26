<?php 
    require "../Backend/Controllers/cuentasController.php";

    $id="";
    $correo = "";
    $rol = "";

    session_start();
    if(!isset($_SESSION["correo"])){
        header('Location: login.php');
        exit();
    }
    
    if($_GET){
        $id = $_GET['id'];
        $cuentaController = new cuenta;
        $buscar = $cuentaController->listOne($id);
        $admin = $buscar['cuenta'][0];
    }

    if($_POST){
        $correo = "";
        $rol = "";
        $id=(isset($_POST['id'])) ? $_POST['id']:"";
        $admin = array(
            'correo' => (isset($_POST['correo'])) ? $_POST['correo'] : "",
            'rol' => (isset($_POST['rol'])) ? $_POST['rol'] : ""
        );
        //Actualizar
        $cuentaController = new cuenta;
        $actualizar = $cuentaController->update($id,$admin);
        if($actualizar['status'] == 200){
            echo '
                <div id="successModal" class="modal">
                    <div class="modal-content">
                        <p>Se ha actualizado correctamente</p>
                        <span class="close-button" onclick="closeModal()">Cerrar</span>
                    </div>
                </div>
            ';
        } else {
            echo '
                <div id="successModal" class="modal">
                    <div class="modal-content">
                        <h1>ERROR</h1>
                        <p><strong>Error al actualizar: </strong>"'.$actualizar['error'].'"</p>
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
    <title>Actualizar administrador</title>
</head>
<body>
<h1>Actualizar cuenta</h1>
    <form action="updateAdmin.php" method="post">
        Correo:
        <input  value="<?php echo $admin['correo']; ?>" type="text" name="correo" id="" required>
        <br/>
        <br/>
        Rol:
        <select name="rol" id="" required>
            <option value="Admin" <?php echo ($admin['rol']=='Admin')?"selected":""; ?> >Administrador</option>
            <option value="Trabajador" <?php echo ($admin['rol']=='Trabajador')?"selected":""; ?> >Trabajador</option>
        </select>
        <br/>
        <br/>
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <a href="listAdministradores.php">Volver</a>
        <input type="submit" value="Guardar">
    </form>
    <br>
    <br>
    <form action="changeContrasena.php" method="get">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <input type="submit" value="Cambiar contraseña">
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