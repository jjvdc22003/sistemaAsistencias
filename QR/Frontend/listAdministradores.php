<?php
    require "../../QR_back/Controllers/cuentasController.php";

    session_start();
    if(!isset($_SESSION["correo"])){
        header('Location: login.php');
        exit();
    } 
    elseif (isset($_SESSION["matricula"])) {
        header('Location: indexA.php');
        exit();
    }

    //Listar
    $cuentasController = new cuenta;
    $listar = $cuentasController->listAdmin();
    if($listar['status'] == 200){
        $resultado = $listar['admin'];
    }else{
        $resultado = "";
    }

    if($_GET){
        $qr = new qr;
        $qr -> descargar($_GET['ruta']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de administradores</title>
</head>
<body>
    <h2>Listado de cuentas de administradores registradas</h2>
    <br/>
    <br/>
    <a href="createAdmin.php" class="azul-button">Agregar</a>
    <a href="index.php" class="close-button">Regresar al menú principal</a>

    <!-- Mostrar listado -->
     <table>
        <?php if(!empty($resultado)){?>
            <thead>
                <th>Correo</th>
                <th>Contraseña</th>
                <th>Rol</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach($resultado as $alumno){ ?>
                <tr>
                    <td><?php echo $alumno['correo']; ?></td>
                    <td>**********</td>
                    <td><?php echo $alumno['rol']; ?></td>
                    <td class="centered">
                        <form action="updateAdmin.php" method="get"> 
                            <input type="hidden" name="id" value="<?php echo $alumno['id'] ?>">
                            <input type="submit" value="Actualizar">
                        </form>
                    </td>
                    <td class="centered">
                        <form action="deleteAdmin.php" method="get"> 
                            <input type="hidden" name="id" value="<?php echo $alumno['id'] ?>">
                            <input type="submit" value="Eliminar">
                        </form>
                    </td>
                </tr> 
                <?php } ?>
            </tbody>
        <?php }else{ echo "<strong>¡¡¡No hay datos en la tabla!!!!</strong><br/>"; } ?>
     </table>
     <br/>
</body>
</html>

<style>
    /* Estilos para la tabla */
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    .centered {
        text-align: center; /* Centra el contenido horizontalmente */
        vertical-align: middle; /* Centra el contenido verticalmente */
    }
    form {
        display: inline-block; /* Asegura que el formulario no ocupe toda la celda */
    }
    .centered-image {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 80px;
        height: 80px;
    }
    .azul-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #0087D1;
      color: white;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
    }
    .azul-button:hover {
      background-color: darkblue;
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