<?php
namespace TECWEB\PROYECTO\AUTH;
use TECWEB\PROYECTO\DATA\Database;

class Auth extends Database{
    public function __construct($db){
        parent::__construct($db);
    }

    public function registrarse($json){
        $data = json_decode($json);
        $email = $this->conexion->real_escape_string($data->email);
        $pass = password_hash($data->password, PASSWORD_DEFAULT);

        $check = $this->conexion->query("SELECT id FROM usuarios WHERE email='$email'");
        if($check->num_rows > 0){
            $this->data = ['status' => 'error', 'message' => 'El correo ya está registrado'];
        }else{
            $sql = "INSERT INTO usuarios (email, password, role) VALUES ('$email', '$pass', 'user')";
            if($this->conexion->query($sql)){
                $this->data = ['status' => 'success', 'message' => 'Usuario registrado correctamente'];
            }else{
                $this->data = ['status' => 'error', 'message' => 'Error al registrar el usuario'];
            }
        }
    }

    public function iniciarSesion($json){
        $data = json_decode($json);
        $email = $this->conexion->real_escape_string($data->email);
        $password = $data->password;

        $result = $this->conexion->query("SELECT * FROM usuarios WHERE email='$email'");
        if($result->num_rows == 1){
            $user = $result->fetch_assoc();
            if(password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                $ip = $_SERVER['REMOTE_ADDR'];
                $this->conexion->query("INSERT INTO access_log (user_id, ip_address) VALUES ({$user['id']}, '$ip')");
                $this->data = ['status' => 'success', 'message' => 'Inicio de sesión exitoso', 'role' => $user['role']];
            }else{
                $this->data = ['status' => 'error', 'message' => 'Contraseña incorrecta'];
            }
        }else{
            $this->data = ['status' => 'error', 'message' => 'Usuario no registrado'];
        }
    }
}
?>