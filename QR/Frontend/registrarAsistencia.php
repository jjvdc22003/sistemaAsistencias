<?php
require "../Backend/Controllers/asistenciasController.php";

  session_start();
  if(!isset($_SESSION["correo"])){
    header('Location: login.php');
    exit();
  } 
  elseif (isset($_SESSION["matricula"])) {
    header('Location: indexA.php');
    exit();
}

if($_POST){
    $stopTick = true;
    $qrData=(isset($_POST['qrData'])) ? $_POST['qrData']:"";
    $alumno = json_decode($qrData, true);

    // Verificar que todos los campos estén presentes para ver que es un QR de alumno
    $requiredFields = ['matricula', 'sexo', 'correo', 'carrera', 'grupo', 'nombre'];
    $allFieldsPresent = true;

    foreach ($requiredFields as $field) {
        if (!isset($alumno[$field])) {
            $allFieldsPresent = false;
        }
    }

    if ($allFieldsPresent) {
        //Obetner fecha
        date_default_timezone_set('Etc/GMT+6');
        $fecha = date("Y-m-d");
        $horaActual = date('H:i:s');

        //Comprobar si el alumno ya tiene asistencia
        $asistenciasController = new asistencia;
        $existencia = $asistenciasController->existe($alumno['matricula'], $fecha);
        $comprobar = $existencia['asistencia'];
        if(!empty($comprobar)){
           if (isset($comprobar[0]['hora_salida'])) {
            echo '
                <div id="errorModal" class="modal">
                    <div class="modal-content">
                        <p>El alumno ya tiene asistencia el día de hoy.</p>
                        <span class="reload-button" onclick="reloadModal()">Escanear otro QR</span>
                        <span class="redirect-button" onclick="closeModal()">Volver al menú</span>
                    </div>
                </div>
            ';
           } else {
                $asistenciaNueva = array(
                    'matricula_alumno' => $comprobar[0]['matricula_alumno'],
                    'fecha' => $comprobar[0]['fecha'],
                    'hora_entrada' => $comprobar[0]['hora_entrada'],
                    'hora_salida' => $horaActual
                );
                $actualizar = $asistenciasController->update($comprobar[0]['id'], $asistenciaNueva);
                if($actualizar['status'] == 200) {
                    echo '
                        <div id="successModal" class="modal">
                            <div class="modal-content">
                                <p>Se ha registrado la salida del alumno.</p>
                                <span class="reload-button" onclick="reloadModal()">Escanear otro QR</span>
                                <span class="redirect-button" onclick="closeModal()">Volver al menú</span>
                            </div>
                        </div>
                    ';
                } else {
                    echo '
                        <div id="successModal" class="modal">
                            <div class="modal-content">
                                <h1>ERROR</h1>
                                <p><strong>Error al registrar la salida: </strong>"'.$actualizar['error'].'"</p>
                                <span class="close-button" onclick="closeModal()">Cerrar</span>
                            </div>
                        </div>
                    ';
                }
           }
        } else{
            $asistenciaNueva = array(
                'matricula_alumno' => $alumno['matricula'],
                'fecha' => $fecha,
                'hora_entrada' => $horaActual
            );
            $agregar = $asistenciasController->create($asistenciaNueva);
            if($agregar['status'] == 200) {
                echo '
                    <div id="successModal" class="modal">
                        <div class="modal-content">
                            <p>Se ha registrado la entrada del alumno.</p>
                            <span class="reload-button" onclick="reloadModal()">Escanear otro QR</span>
                            <span class="redirect-button" onclick="closeModal()">Volver al menú</span>
                        </div>
                    </div>
                ';
            } else {
                echo '
                    <div id="successModal" class="modal">
                        <div class="modal-content">
                            <h1>ERROR</h1>
                            <p><strong>Error al registrar la entrada: </strong>"'.$agregar['error'].'"</p>
                            <span class="close-button" onclick="closeModal()">Cerrar</span>
                        </div>
                    </div>
                ';
            }
        }

    } else {
        echo '
            <div id="qrAjenoModal" class="modal">
                <div class="modal-content">
                    <p>El código QR <strong>NO PERTENECE</strong> a un alumno de la universidad.</p>
                    <span class="reload-button" onclick="reloadModal()">Escanear otro QR</span>
                    <span class="close-button" onclick="closeModal()">Volver al menú</span>
                </div>
            </div>
        ';
    }

}else {
    $stopTick = false;
    echo '
        <div class="container">
            <div class="video-container">
                <video id="video" width="600" height="400" style="border: 1px solid black"></video>
            </div>
            <div>
                <a href="registrarPorMatricula.php" class="blue-button">Registrar por matricula</a>
                <a href="index.php" class="close-button">Regresar al menú</a>
            </div>
        </div>
    ';
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar asistencia</title>
  <script src="../Backend/QR.js"></script>
</head>
<body>

    <!-- <video id="video" width="300" height="200" style="border: 1px solid black"></video> -->
    
    <form action="registrarAsistencia.php" method="post">
        <input type="hidden" name="qrData" id="qrDataInput">
        <input type="submit" value="Enviar" id="submitBtn">
    </form>
</body>
</html>

<script>
    const video = document.getElementById('video');
    let stopTick = <?php echo json_encode($stopTick); ?>;

    if (!stopTick){
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } }).then(stream => {
          video.srcObject = stream;
          video.setAttribute('playsinline', true); // required to tell iOS safari we don't want fullscreen
          video.play();
          requestAnimationFrame(tick);
        });
    }

    function tick() {
        if (stopTick) return;

        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height);

            if (code) {
                console.log('Código QR detectado:', code.data);
                document.getElementById('qrDataInput').value = code.data;
                document.getElementById('submitBtn').click();
            }
        }
        setTimeout(() => {
            requestAnimationFrame(tick);
        }, 1000);
    }

    //Script para modales
    function closeModal() {
        window.location.href = 'index.php';
    }
    function reloadModal() {
        window.location.href = 'registrarAsistencia.php';
    }
</script>

<style>
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100vh;
    }
    .video-container {
        padding: 20px;
    }
    #submitBtn {
        display: none;
    }
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
    }
    .close-button:hover {
        background-color: #CB1D11;
    }
    .blue-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #0087D1;
      color: white;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
    }
    .blue-button:hover {
      background-color: darkblue;
    }
    .reload-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }
    .reload-button:hover {
        background-color: #45A049;
    }
    .redirect-button {
        background-color: #0087D1;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }
    .redirect-button:hover {
        background-color: #5564EB;
    }
</style>
