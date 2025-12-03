<?php
namespace TECWEB\PROYECTO\AUTH;
use TECWEB\PROYECTO\DATA\Database;

class Auth extends Database{
    public function __construct($db){
        parent::__construct($db);
    }

    //Registro de usuario. Resive un JSON con email y password, revisa si existe y lo registra
    public function registrarse($json){
        $data = json_decode($json); //convierte el json en un objeto PHP
        $email = $this->conexion->real_escape_string($data->email); //Escape para evitar inyecciones SQL
        $pass = password_hash($data->password, PASSWORD_DEFAULT); //Encripta la contraseña

        $check = $this->conexion->query("SELECT id FROM usuarios WHERE email='$email'"); //Verefica si el email ya está registrado
        if($check->num_rows > 0){
            $this->data = ['status' => 'error', 'message' => 'El correo ya está registrado'];
        }else{
            // Inserta el nuevo usuario en la base de datos con el rol 'user' por defecto
            $sql = "INSERT INTO usuarios (email, password, role) VALUES ('$email', '$pass', 'user')";

            //Si la consulta se ejecuta correctamente, devuelve éxito, si no, error
            if($this->conexion->query($sql)){
                $this->data = ['status' => 'success', 'message' => 'Usuario registrado correctamente'];
            }else{
                $this->data = ['status' => 'error', 'message' => 'Error al registrar el usuario'];
            }
        }
    }

    //Inicio de sesion. Recibe email y contraseña, valida credenciales y crea una nueva sesión
    public function iniciarSesion($json){
        $data = json_decode($json);
        $email = $this->conexion->real_escape_string($data->email); //Escape para evitar inyecciones SQL
        $password = $data->password;

        $result = $this->conexion->query("SELECT * FROM usuarios WHERE email='$email'"); //Busca el usuario por email

        //Encontramos 1 usuario con ese email
        if($result->num_rows == 1){
            $user = $result->fetch_assoc(); //Obtiene los datos del usuario
            //Verifica la contraseña conicide con la encriptada en la base de datos
            if(password_verify($password, $user['password'])){
                //Guardamos los datos en la sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                
                //Obtenemos la ip del usuario que inisició sesión
                $ip = $_SERVER['REMOTE_ADDR'];

                //Guardamos un registro en la bitacora de accesos
                $this->conexion->query("INSERT INTO bitacora_accesos (usuario_id, ip_address) VALUES ({$user['id']}, '$ip')");

                //Respuesta exitosa con datos del usuario
                $this->data = ['status' => 'success', 
                    'message' => 'Inicio de sesión exitoso', 
                    'role' => $user['role'],
                    'email' => $user['email']
                ];
            }else{
                $this->data = ['status' => 'error', 'message' => 'Contraseña incorrecta']; 
            }
        }else{
            $this->data = ['status' => 'error', 'message' => 'Usuario no registrado'];
        }
    }
}
?>
