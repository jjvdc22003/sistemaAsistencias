<?php 
    require "../Backend/Controllers/cuentasController.php";

    $id="";
    $correo = "";
    $contrasena = "";
    $rol = "";

    session_start();
    if(!isset($_SESSION["correo"])){
        header('Location: login.php');
        exit();
    }
    elseif ($_SESSION["rol"]!="Admin") {
        header('Location: index.php');
        exit();
    }


    if($_POST){
        $admin = array(
            'correo' => (isset($_POST['correo'])) ? $_POST['correo'] : "",
            'contrasena' => (isset($_POST['contrasena'])) ? $_POST['contrasena'] : "",
            'rol' => (isset($_POST['rol'])) ? $_POST['rol'] : "",
        );
        //Crear
        $cuentaController = new cuenta;
        $buscarCorreo = $cuentaController->listOnePorCorreo($admin['correo']);

        if($buscarCorreo['status'] == 200) {
            if(!empty($buscarCorreo['cuenta'])){
                echo '
                    <div id="errorModal" class="modal">
                        <div class="modal-content">
                            <h1>ERROR</h1>
                            <p>El correo <strong>ya ha sido registrado</strong> anteriormente</p>
                            <span class="close-button" onclick="closeModal2()">Cerrar</span>
                        </div>
                    </div>
                ';
            } else{
                $crear = $cuentaController->create($admin);
                
                 if($crear['status'] == 200){
                     echo '
                         <div id="successModal" class="modal">
                             <div class="modal-content">
                                 <p>Se ha creado correctamente</p>
                                 <span class="close-button" onclick="closeModal()">Cerrar</span>
                             </div>
                         </div>
                     ';
                 } else {
                     echo '
                         <div id="successModal" class="modal">
                             <div class="modal-content">
                                 <h1>ERROR</h1>
                                 <p><strong>Error al crear: </strong>"'.$crear['error'].'"</p>
                                 <span class="close-button" onclick="closeModal()">Cerrar</span>
                             </div>
                         </div>
                     ';
                 }
            }
        }
        else{
            echo '
                    <div id="successModal" class="modal">
                        <div class="modal-content">
                            <h1>ERROR</h1>
                            <p><strong>Error al buscar la existencia del correo: </strong>"'.$buscarCorreo['error'].'"</p>
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
    <title>Crear administrador</title>
</head>
<body>
<h3>Crear cuenta</h3>
    <form action="createAdmin.php" method="post">
        Correo:
        <input type="text" name="correo" id="" required>
        <br/>
        <br/>
        Contraseña:
        <input type="password" name="contrasena" id="" required>
        <br/>
        <br/>
        Rol:
        <select name="rol" id="" required>
            <option value="Admin">Administrador</option>
            <option value="Trabajador" selected>Trabajador</option>
        </select>
        <br/>
        <br/>
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
    function closeModal2() {
        window.location.href = 'createAdmin.php';
    }
</script>