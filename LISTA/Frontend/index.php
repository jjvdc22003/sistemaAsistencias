<?php
      session_start();
      if(!isset($_SESSION["correo"])){
        header('Location: login.php');
        exit();
    }
    elseif (isset($_SESSION["matricula"])) {
      header('Location: indexA.php');
      exit();
  }
    require_once '../Backend/Controllers/asistenciasController.php';
    require_once '../Backend/generateList.php';
    $conexion= new asistencia;

    if($_GET){
      $generate = new generateList;
      $generate->generar($_GET['fecha']);
    }

    if($_POST){
      $fecha = $_POST['fecha'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista</title>
</head>
<body>
    <h2>Seleccione el día para generar la lista</h2>
    <br/>
    <form action="getLista.php" method="post">
        <input type="date" name="fecha" id="fecha" value="<?php echo isset($fecha)?$fecha:date('Y-m-d'); ?>">
        <input type="hidden" name="flag" value="0">
        <button class ="green-button" type="submit">Seleccionar fecha</button>
        <a href="index.php" class ="azul-button">Regresar</a>
        
      </form>

    <?php
      if ($_POST) {
        ?>
          <form action="getLista.php" method="get">
            <input type="hidden" name="fecha" value="<?php echo $fecha ?>">
            <input type="submit" value="Generar lista">
          </form>
        <?php
        if (isset($_POST['flag'])) {
          $result = $conexion->listFecha($fecha); 
          $resultado = $result['lista'];
        ?>

          <table>
            <thead>
              <th>Matricula</th>
              <th>Nombre</th>
              <th>Carrera</th>
              <th>Grupo</th>
              <th>Hora de entrada</th>
              <th>Hora de salida</th>
              <th></th>
              <th></th>
            </thead>
            <tbody>
                <?php foreach($resultado as $alumno){ ?>
                <tr>
                    <td><?php echo $alumno['matricula']; ?></td>
                    <td><?php echo $alumno['nombre']; ?></td>
                    <td><?php echo $alumno['carrera']; ?></td>
                    <td><?php echo $alumno['grupo']; ?></td>
                    <td><?php echo $alumno['hora_entrada']; ?></td>
                    <td><?php echo $alumno['hora_salida']; ?></td>
                    <td class="centered">
                        <form action="updateLista.php" method="get"> 
                            <input type="hidden" name="id" value="<?php echo $alumno[0] ?>">
                            <input type="submit" value="Actualizar">
                        </form>
                    </td>
                    <td class="centered">
                        <form action="deleteAsistencia.php" method="get"> 
                            <input type="hidden" name="id" value="<?php echo $alumno[0] ?>">
                            <input type="submit" value="Eliminar">
                        </form>
                    </td>
                </tr> 
                <?php } ?>
            </tbody>
          </table>
       <?php }
      }
      else{
        
      }
    ?>
</body>
</html>

<style>
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
    .green-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #52B830;
      color: white;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
    }
    .green-button:hover {
      background-color: darkgreen;
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

    
</style>