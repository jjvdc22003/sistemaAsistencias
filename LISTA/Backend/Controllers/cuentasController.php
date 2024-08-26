<?php
    class cuenta{
        private $conexion;

        public function __construct() {
            require_once __DIR__."/../BD.php";

            // Conexión a la base de datos
            $this->conexion = new Conexion();
        }

        public function create($cuenta){
            try {
                $options = [
                    'cost' => 12,
                ];
                // Generar el hash de la contraseña con la configuración de costo
                $hashed_password = password_hash($cuenta['contrasena'], PASSWORD_BCRYPT, $options);
                // Agregar persona
                $sql = "INSERT INTO cuentas (`id`,`correo`,`contrasena`,`rol`,`matricula`) VALUES (NULL, '".$cuenta['correo']."', '".$hashed_password."', '".$cuenta['rol']."', '".$cuenta['matricula']."')";
                $agregar = $this->conexion->ejecutar($sql);
        
                if ($agregar) {
                    $jsonData = [
                        "correo" => $cuenta['correo'],
                        "contrasena" => $cuenta['contrasena'],
                        "rol" => $cuenta['rol'],
                        "matricula" => $cuenta['matricula']
                    ];
        
                    $jsonResponse = [
                        'message' => 'cuenta creado',
                        'cuenta' => $jsonData,
                        'status' => '200'
                    ];
                } else {
                    throw new Exception("Error al ejecutar la consulta.");
                }
            } catch (Exception $e) {
                $jsonResponse = [
                    'message' => 'Error al crear cuenta',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }

            return $jsonResponse;
        }

        public function createAdmin($cuenta){
            try {
                $options = [
                    'cost' => 12,
                ];
                // Generar el hash de la contraseña con la configuración de costo
                $hashed_password = password_hash($cuenta['contrasena'], PASSWORD_BCRYPT, $options);
                // Agregar persona
                $sql = "INSERT INTO cuentas (`id`,`correo`,`contrasena`,`rol`,`matricula`) VALUES (NULL, '".$cuenta['correo']."', '".$hashed_password."', '".$cuenta['rol']."', NULL)";
                $agregar = $this->conexion->ejecutar($sql);
        
                if ($agregar) {
                    $jsonData = [
                        "correo" => $cuenta['correo'],
                        "contrasena" => $cuenta['contrasena'],
                        "rol" => $cuenta['rol']
                    ];
        
                    $jsonResponse = [
                        'message' => 'cuenta creado',
                        'cuenta' => $jsonData,
                        'status' => '200'
                    ];
                } else {
                    throw new Exception("Error al ejecutar la consulta.");
                }
            } catch (Exception $e) {
                $jsonResponse = [
                    'message' => 'Error al crear cuenta',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }

            return $jsonResponse;
        }

        public function listOne($id) {
            try {
                $sqlListar = "SELECT * FROM cuentas WHERE id=".$id;
                $lista=$this->conexion->ejecutar($sqlListar);
                $resultado=$lista->fetchALL();
                if(!empty($resultado)){
                    $response = [
                        'message' => 'Cuenta encontrado',
                        'cuenta' => $resultado,
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

        public function validar($email){
            try{
                $sql="SELECT * FROM cuentas WHERE correo='".$email."'";
                $lista=$this->conexion->ejecutar($sql);
                $resultado=$lista->fetchALL();
                $jsonResponse = [
                    'message' => 'cuenta creado',
                    'cuenta' => $resultado,
                    'status' => '200'
                ];
            }catch (Exception $e) {
                $jsonResponse = [
                    'message' => 'Error al crear cuenta',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }
            return $jsonResponse;
        }

        public function listAdmin(){
            $sqlListar = "SELECT * FROM cuentas WHERE rol = 'Admin' OR rol = 'Trabajador' ";
            $lista=$this->conexion->ejecutar($sqlListar);
            $resultado=$lista->fetchALL();

            $resultados = [
                'mensaje' => 'Listado de asistencias',
                'admin' => $resultado,
                'status' => '200'
            ];

            return $resultados;
        }

        public function listOnePorCorreo($correo){
            try {
                $sql = "SELECT * FROM cuentas WHERE correo = '".$correo."'";
                $lista=$this->conexion->ejecutar($sql);
                $resultado=$lista->fetchALL();
                if(!empty($resultado)){
                    $response = [
                        'message' => 'Correo encontrado',
                        'cuenta' => $resultado,
                        'status' => '200'
                    ];
                } else {
                    $response = [
                        'message' => 'Correo no registrado',
                        'cuenta' => $resultado,
                        'status' => '200'
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al listar una cuenta',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }
            return $response;
        }
                  
        public function update($id, $cuenta){
            try {
                $options = [
                    'cost' => 12,
                ];
                // Generar el hash de la contraseña con la configuración de costo
                $hashed_password = password_hash($cuenta['contrasena'], PASSWORD_BCRYPT, $options);
                //Borrar QR antes de actualizar (Para los casos donde se actualiza la matricula)
                $sql = "SELECT * FROM cuentas WHERE id=".$id;
                $snt = $this->conexion->ejecutar($sql);
                $res = $snt->fetchAll();
                // Actualizar persona
                $sql = "UPDATE cuentas SET correo='".$cuenta['correo']."', contrasena='".$hashed_password."', rol='".$cuenta['rol']."' WHERE id=".$id;
                $actualizar = $this->conexion->ejecutar($sql);
        
                if ($actualizar) {
                    $jsonData = [
                        "correo" => $cuenta['correo'],
                        "contrasena" => $cuenta['contrasena'],
                        "rol" => $cuenta['correo']
                    ];
        
                    $response = [
                        'message' => 'Cuenta actualizado',
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
                $sql = "SELECT * FROM cuentas WHERE id=".$id;
                $snt = $this->conexion->ejecutar($sql);
                $res = $snt->fetchAll();
                if($res){
                    $sql="DELETE FROM cuentas WHERE id=".$id;
                    $delete=$this->conexion->ejecutar($sql);
                    $response = [
                        'message' => 'Cuenta eliminada',
                        'datos' => $delete,
                        'status' => '200'
                    ];
                } else {
                    $response = [
                        'message' => 'La cuenta no está registrada',
                        'status' => '200'
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'message' => 'Error al eliminar cuenta',
                    'error' => $e->getMessage(),
                    'status' => '404'
                ];
            }

            return $response;
        }

    }
?>