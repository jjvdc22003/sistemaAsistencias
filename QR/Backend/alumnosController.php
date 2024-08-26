<?php
    class alumno{
        private $conexion;

        public function __construct() {
            require_once __DIR__."/../generateQR.php";
            require_once __DIR__."/../BD.php";

            // Conexión a la base de datos
            $this->conexion = new Conexion();
        }

        public function create($alumno) {
            try {
                // Agregar persona
                $sql = "INSERT INTO alumnos (`id`,`matricula`,`nombre`,`sexo`,`correo`,`carrera`,`grupo`) VALUES (NULL, '".$alumno['matricula']."', '".$alumno['nombre']."', '".$alumno['sexo']."', '".$alumno['correo']."', '".$alumno['carrera']."', '".$alumno['grupo']."')";
                $agregar = $this->conexion->ejecutar($sql);
        
                if ($agregar) {
                    $jsonData = [
                        "matricula" => $alumno['matricula'],
                        "sexo" => $alumno['sexo'],
                        "correo" => $alumno['correo'],
                        "carrera" => $alumno['carrera'],
                        "grupo" => $alumno['grupo'],
                        "nombre" => $alumno['nombre']
                    ];
        
                    // Generar QR
                    $qr = new qr;
                    $qr->crear($jsonData);
        
                    $response = [
                        'message' => 'Alumno creado',
                        'alumno' => $jsonData,
                        'status' => '200'
                    ];
                } else {
                    throw new Exception("Error al ejecutar la consulta.");
                }
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al crear alumno',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }

            return $response;
        }
        
        public function list() {
            //Listar
            try {
                $sqlListar = "SELECT * FROM alumnos ORDER BY grupo, nombre";
                $lista=$this->conexion->ejecutar($sqlListar);
                $resultado=$lista->fetchALL();
                if(!empty($resultado)){
                    $response = [
                        'message' => 'Listado',
                        'alumnos' => $resultado,
                        'status' => '200'
                    ];
                } else {
                    $response = [
                        'message' => 'No hay alumnos registrado',
                        'status' => '200'
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al listar alumnos',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }
            return $response;
        }

        public function listOne($id) {
            try {
                $sqlListar = "SELECT * FROM alumnos WHERE id=".$id;
                $lista=$this->conexion->ejecutar($sqlListar);
                $resultado=$lista->fetchALL();
                if(!empty($resultado)){
                    $response = [
                        'message' => 'Alumno encontrado',
                        'alumno' => $resultado,
                        'status' => '200'
                    ];
                } else {
                    $response = [
                        'message' => 'El alumno no está registrado',
                        'status' => '200'
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al listar un alumno',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }
            return $response;
        }

        public function listOneMatricula($matricula){
            try {
                $sqlListaOne = "SELECT * FROM alumnos WHERE matricula='".$matricula."'";
                $lista=$this->conexion->ejecutar($sqlListaOne);
                $resultado=$lista->fetchALL();
                if(!empty($resultado)){
                    $response = [
                        'message' => 'Alumno encontrado',
                        'alumno' => $resultado,
                        'status' => '200'
                    ];
                } else {
                    $response = [
                        'message' => 'Alumno no registrado',
                        'alumno' => $resultado,
                        'status' => '200'
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al listar un alumno',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }
            return $response;
        }

        public function update($id, $alumno){
            try {
                //Borrar QR antes de actualizar (Para los casos donde se actualiza la matricula)
                $sql = "SELECT * FROM alumnos WHERE id=".$id;
                $snt = $this->conexion->ejecutar($sql);
                $res = $snt->fetchAll();
                if($res){
                    $matricula=$res[0]['matricula'];
                    $qr = new qr;
                    $qr->eliminar($matricula);
                }
                // Actualizar persona
                $sql = "UPDATE alumnos SET matricula='".$alumno['matricula']."', nombre='".$alumno['nombre']."', sexo='".$alumno['sexo']."', correo='".$alumno['correo']."', carrera='".$alumno['carrera']."', grupo='".$alumno['grupo']."' WHERE id=".$id;
                $actualizar = $this->conexion->ejecutar($sql);
        
                if ($actualizar) {
                    $jsonData = [
                        "matricula" => $alumno['matricula'],
                        "sexo" => $alumno['sexo'],
                        "correo" => $alumno['correo'],
                        "carrera" => $alumno['carrera'],
                        "grupo" => $alumno['grupo'],
                        "nombre" => $alumno['nombre']
                    ];
        
                    // Generar QR
                    $qr = new qr;
                    $qr->crear($jsonData);
        
                    $response = [
                        'message' => 'Alumno actualizado',
                        'alumno' => $jsonData,
                        'status' => '200'
                    ];
                } else {
                    throw new Exception("Error al ejecutar la consulta.");
                }
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al actualizar alumno',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }

            return $response;
        }
        
        public function delete($id){
            try {
                $sql = "SELECT * FROM alumnos WHERE id=".$id;
                $snt = $this->conexion->ejecutar($sql);
                $res = $snt->fetchAll();
                if($res){
                    $matricula=$res[0]['matricula'];
                    $qr = new qr;
                    $qr->eliminar($matricula);
                    $sql="DELETE FROM alumnos WHERE id=".$id;
                    $agregar=$this->conexion->ejecutar($sql);
                    $response = [
                        'message' => 'Alumno eliminado',
                        'datos' => $agregar,
                        'status' => '200'
                    ];
                } else {
                    $response = [
                        'message' => 'El alumno no está registrado',
                        'status' => '200'
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al eliminar alumno',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }

            return $response;
        }

    }
?>