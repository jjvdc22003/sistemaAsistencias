<?php
//composer require phpoffice/phpspreadsheet
require 'vendor/autoload.php';
require "BD.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class generateList {
    public function generar($fecha){
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

      $conexion= new Conexion;

      $sqlListar = "SELECT * FROM asistencias, alumnos WHERE asistencias.fecha='".$fecha."' AND alumnos.matricula = asistencias.matricula_alumno ORDER BY grupo, nombre";
      $lista=$conexion->ejecutar($sqlListar);
      $resultado=$lista->fetchALL();

      $sheet->setCellValue('A1', 'Lista de asistencia del dia '.$fecha);
      $sheet->mergeCells('A1:F1');
      $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      // Escribir datos en la hoja de cálculo
      $sheet->setCellValue('A2', 'Matricula');
      $sheet->setCellValue('B2', 'Nombre');
      $sheet->setCellValue('C2', 'Carrera');
      $sheet->setCellValue('D2', 'Grupo');
      $sheet->setCellValue('E2','Hora de entrada');
      $sheet->setCellValue('F2','Hora de salida');

      $row = 3;

      foreach ($resultado as $key) {
          $sheet -> setCellValue('A'.$row, $key['matricula']);
          $sheet -> setCellValue('B'.$row, $key['nombre']);
          $sheet -> setCellValue('C'.$row, $key['carrera']);
          $sheet -> setCellValue('D'.$row, $key['grupo']);
          $sheet -> setCellValue('E'.$row, $key['hora_entrada']);
          $sheet -> setCellValue('F'.$row, $key['hora_salida']);
          $row ++;
      }

      $sheet->getColumnDimension('A')->setAutoSize(true);
      $sheet->getColumnDimension('B')->setAutoSize(true);
      $sheet->getColumnDimension('C')->setAutoSize(true);
      $sheet->getColumnDimension('D')->setAutoSize(true);
      $sheet->getColumnDimension('E')->setAutoSize(true);
      $sheet->getColumnDimension('F')->setAutoSize(true);

      // Guardar la hoja de cálculo en un archivo
      $ruta = __DIR__.'/../assets/listas/';
      if (!is_dir($ruta)) {
          mkdir($ruta, 0777, true);
      }
      $writer = new Xlsx($spreadsheet);
      $writer->save($ruta.'asistencia'.$fecha.'.xlsx'); 

      $rutaArchivo = $ruta.'asistencia'.$fecha.'.xlsx';
      if (file_exists($rutaArchivo)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($rutaArchivo));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($rutaArchivo));
        readfile($rutaArchivo);
        exit;
    } else {
        echo "El archivo no existe.";
    }
  }

  public function generateAlumnos($ruta){
    $spreadsheet = IOFactory::load($ruta);
    
    do {
      $a = 2;
      $matricula = $sheet->getCell('A'.$a)->getValue();
      $nombre = $sheet->getCell('B'.$a)->getValue();
      $sexo = $sheet->getCell('C'.$a)->getValue();
      $correo = $sheet->getCell('D'.$a)->getValue();
      $carrera = $sheet->getCell('E'.$a)->getValue();
      $grupo = $sheet->getCell('F'.$a)->getValue();
      
    } while ($a <= 10);
  }
}


?>