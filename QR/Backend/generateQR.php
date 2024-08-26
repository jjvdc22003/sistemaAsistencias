<?php
//composer require endroid/qr-code //PARA INSTALAR LA LIBRERIA

require 'vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Writer\PngWriter;

class qr{
    private $data;
    public function crear($jsonData){
        try {
            $this->data = json_encode($jsonData);
        
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($this->data)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size(300)
                ->margin(10)
                ->build();
        
            if (!is_dir(__DIR__.'/../assets/QR\'s')) {
                mkdir(__DIR__.'/../assets/QR\'s', 0777, true);
            }
            
            // Extraer el valor de "matricula" del arreglo
            $matricula = $jsonData['matricula'];

            // Construir el nombre del archivo usando el valor de "matricula"
            $filename = __DIR__.'/../assets/QR\'s/' . $matricula . '.png';

            // Guardar el archivo con el nombre construido
            $result->saveToFile($filename);
        } catch (\Throwable $th) {
            return "Error al generar el código QR: ".$th;
        }
    }

    public function eliminar($matricula){
        // Verificar si el archivo existe antes de intentar eliminarlo
        $imagePath = __DIR__.'/../assets/QR\'s/' . $matricula . '.png';
        if (file_exists($imagePath)) {
            // Eliminar el archivo
            if (unlink($imagePath)) {
                return 'La imagen ha sido eliminada exitosamente.';
            } else {
                return 'Hubo un error al intentar eliminar la imagen.';
            }
        } else {
            return 'La imagen no existe.';
        }
    }

    public function descargar($ruta){
        if (file_exists($ruta)) {
          header('Content-Description: File Transfer');
          header('Content-Type: application/octet-stream');
          header('Content-Disposition: attachment; filename=' . basename($ruta));
          header('Expires: 0');
          header('Cache-Control: must-revalidate');
          header('Pragma: public');
          header('Content-Length: ' . filesize($ruta));
          readfile($ruta);
          exit;
      } else {
          echo "El archivo no existe.";
      }
    }
}

?>
