<?php 
    require_once '../Backend/Controllers/cuentasController.php';
    session_start();
    if(isset($_SESSION['correo'])){
        header('Location: index.php');
        exit();
    }

    $f = 0;
    if($_POST){
        $cuenta = new cuenta;
        $resultado = $cuenta->validar($_POST['email']);

        if(!empty($resultado['cuenta'])){
            if(password_verify($_POST['password'], $resultado['cuenta'][0]['contrasena'] )){
                $_SESSION["correo"]=$_POST['email'];
                header('Location: index.php');
                exit();
            }
            else{
                $f = 2;
            }

        }
        else
            $f=1;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
</head>
<body>
    <h1>Inicia sesión con tu usuario y contraseña</h1>
    <form action="login.php" method="post">
        Correo:
        <input type="email" name="email" id="">
        <br>
        <br>
        Contraseña
        <input type="password" name="password" id="">
        <br>
        <br>
        <button type="submit">Iniciar sesión</button>
        <br>
        <br>
        <?php if($f==1){
            echo '
                 <div id="" class="modal">
                     <div class="modal-content">
                         <p>Usuario <strong>no encontrado</strong></p>
                         <span class="close-button" onclick="closeModal()">Cerrar</span>
                     </div>
                 </div>
             ';
        } ?>
        <?php if($f==2){
            echo '
                <div id="" class="modal">
                    <div class="modal-content">
                        <p>Usuario o contraseña <strong>incorrectos</strong></p>
                        <span class="close-button" onclick="closeModal()">Cerrar</span>
                    </div>
                </div>
            ';
        } ?>
    </form>
</body>
</html>


<script>
    function closeModal() {
        window.location.href = 'login.php';
    }
</script>

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