<?php 
    require_once '../Backend/Controllers/cuentasController.php';
    session_start();
    if(isset($_SESSION['correo'])){
        if(isset($_SESSION['matricula']))
            header('Location: indexA.php');
        else
            header('Location: getLista.php');
        exit();
    }

    $f = 0;
    if($_POST){
        $cuenta = new cuenta;
        $resultado = $cuenta->validar($_POST['email']);

        if(!empty($resultado['cuenta'])){
            if(password_verify($_POST['password'], $resultado['cuenta'][0]['contrasena'] )){
                if($resultado['cuenta'][0]['rol']=="Alumno"){
                    $_SESSION["correo"]=$_POST['email'];
                    $_SESSION["matricula"]=$resultado['cuenta'][0]['matricula'];
                    header('Location: indexA.php');
                    exit();
                }
                else{
                    $_SESSION["correo"]=$_POST['email'];
                    header('Location: getLista.php');
                    exit();
                }
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
        <?php echo ($f==1)?"Usuario no encontrado<br>":""; ?>
        <?php echo ($f==2)?"Usuario o contraseña incorrectos<br>":""; ?>
        <p>¿No estás registrado? <a href="signup.php">Registrate aquí</a> </p>
    </form>
</body>
</html>