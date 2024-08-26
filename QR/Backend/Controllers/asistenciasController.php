<?php
    class asistencia{

        public function __construct() {
            require_once __DIR__."/../generateQR.php";
            require_once __DIR__."/../BD.php";

            // Conexión a la base de datos
            $this->conexion = new conexion();
        }

        public function create($asistencia){
            try {
                $sql="INSERT INTO asistencias (`id`,`matricula_alumno`,`fecha`,`hora_entrada`) VALUES (NULL, '".$asistencia['matricula_alumno']."', '".$asistencia['fecha']."', '".$asistencia['hora_entrada']."')";
                $agregar=$this->conexion->ejecutar($sql);

                $response = [
                    "matricula" => $asistencia['matricula_alumno'],
                    "fecha" => $asistencia['fecha'],
                    'status' => '200'
                ];
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al crear asistencia',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];

            }
            return $response;
        }

        public function createWithMatricula($asistencia) {
            try {
                $sql="INSERT INTO asistencias (`id`,`matricula_alumno`,`fecha`,`hora_entrada`) VALUES (NULL, '".$asistencia['matricula_alumno']."', '".$asistencia['fecha']."', '".$asistencia['hora_entrada']."')";
                $agregar=$this->conexion->ejecutar($sql);

                $response = [
                    "matricula" => $asistencia['matricula_alumno'],
                    "fecha" => $asistencia['fecha'],
                    'status' => '200'
                ];
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al crear asistencia',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];

            }
            return $response;
        }
        
        public function listFecha($fecha){
            $sqlListar = "SELECT * FROM asistencias, alumnos WHERE asistencias.fecha='".$fecha."' AND alumnos.matricula = asistencias.matricula_alumno ORDER BY grupo, nombre";
            $lista=$this->conexion->ejecutar($sqlListar);
            $resultado=$lista->fetchALL();

            $resultados = [
                'mensaje' => 'Listado de asistencias',
                'lista' => $resultado,
                'status' => '200'
            ];

            return $resultados;
        }
        public function listOneId($id){
            try {
                $sqlListar = "SELECT * FROM asistencias WHERE id=".$id;
                $lista=$this->conexion->ejecutar($sqlListar);
                $resultado=$lista->fetchALL();
                if(!empty($resultado)){
                    $response = [
                        'message' => 'Asistencia encontrada',
                        'asistencia' => $resultado,
                        'status' => '200'
                    ];
                } else {
                    $response = [
                        'message' => 'Asistencia no encontrada',
                        'asistencia' => $resultado,
                        'status' => '200'
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al listar uno',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }
            return $response;
        }
        public function listOne($id){
            try {
                $sqlListar = "SELECT * FROM asistencias WHERE matricula_alumno='".$id."'";
                $lista=$this->conexion->ejecutar($sqlListar);
                $resultado=$lista->fetchALL();
                if(!empty($resultado)){
                    $response = [
                        'message' => 'Asistencia encontrada',
                        'asistencia' => $resultado,
                        'status' => '200'
                    ];
                } else {
                    $response = [
                        'message' => 'Asistencia no encontrada',
                        'asistencia' => $resultado,
                        'status' => '200'
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al listar uno',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }
            return $response;
        }

        public function existe($matricula, $fecha){
            try{
                $sqlComprobar = "SELECT * FROM asistencias WHERE matricula_alumno = '".$matricula."' AND fecha = '".$fecha."'";
                $resultado = $this->conexion->ejecutar($sqlComprobar);
                $comprobar=$resultado->fetchALL();
                if(!empty($comprobar)){
                    $response = [
                        'message' => 'Asistencia encontrada',
                        'asistencia' => $comprobar,
                        'status' => '200'
                    ];
                } else {
                    $response = [
                        'message' => 'Asistencia no encontrada',
                        'asistencia' => $comprobar,
                        'status' => '200'
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al listar comprobar existencia',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }
            return $response;
        }

        public function update($id, $asistencia){
            try{
                $sql="UPDATE asistencias SET matricula_alumno='".$asistencia['matricula_alumno']."', fecha='".$asistencia['fecha']."', hora_entrada='".$asistencia['hora_entrada']."', hora_salida='".$asistencia['hora_salida']."' WHERE id=".$id;
                $actualizar = $this->conexion->ejecutar($sql);

                if($actualizar){
                    $response = [
                        "matricula_alumno"=>$asistencia['matricula_alumno'],
                        "fecha"=>$asistencia['fecha'],
                        'status' => '200'
                    ];
                }
                else{
                    throw new Exception("Error al ejecutar la consulta.");
                }
            }catch (Exception $e) {
                $response = [
                    'message' => 'Error al actualizar',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }

            return $response;
        }

        public function delete($id){
            try {
                $sql="DELETE FROM asistencias WHERE id=".$id;
                $agregar=$this->conexion->ejecutar($sql);
                $response = [
                    'message' => 'Asistencia eliminada',
                    'datos' => $agregar,
                    'status' => '200'
                ];
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al eliminar asistencia',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }

            return json_encode($response);
        }
        
    }
?>