<?php
namespace TECWEB\PROYECTO\RESOURCES;
use TECWEB\PROYECTO\DATA\Database;

class Resources extends Database{
    public function __construct($db){
        parent::__construct($db);
    }

    //Lista todos los recursos activos (status = 0 ). Ordenados desde el mas reciente con id DESC
    public function listar(){
        $sql = "SELECT * FROM recursos WHERE status = 0 ORDER BY id DESC";
        $result = $this->conexion->query($sql);
        //Devuelve todos los resultados como un array asociativo
        $this->data = $result->fetch_all(MYSQLI_ASSOC);
    }

    //Agrega un nuevo recuros. Recibe un JSON desde el frontend, verifica que no exista uno igual y lo inserta
    public function agregar($json){
        $obj = json_decode($json); //Convierte el JSON en un objeto PHP
        $name = $this->conexion->real_escape_string($obj->name); //Escapa el nombre para evitar inyecciones SQL

        //Verifica si ya existe un recurso con el mismo nombre
        $check = $this->conexion->query("SELECT id FROM recursos WHERE nombre='$name' AND status=0");
        //Si no existe lo inserta
        if($check->num_rows == 0){
            $sql = "INSERT INTO recursos (nombre, descripcion, url, formato, lenguaje) VALUES (
                '{$name}',
                '{$this->conexion->real_escape_string($obj->description)}',
                '{$this->conexion->real_escape_string($obj->url)}',
                '{$this->conexion->real_escape_string($obj->format)}',
                '{$this->conexion->real_escape_string($obj->language)}'
            )";

            $this->data['status'] = $this->conexion->query($sql) ? 'success' : 'error';
            $this->data['message'] = $this->data['status'] == 'success' ? 'Recurso agregado' : 'Error en la Base de Datos';
        }else{
            //Si ya existe devuelve un error
            $this->data = ['status' => 'error', 'message' => 'El recurso ya existe'];
        }
    }

    //Elimina un recurso (cambia su status a 1)
    public function eliminar($id){
        $id = intval($id);
        $sql = "UPDATE recursos SET status = 1 WHERE id = $id";
        $this->data['status'] = $this->conexion->query($sql) ? 'success' : 'error';
        $this->data['message'] = $this->data['status'] == 'success' ? 'Recurso eliminado' : 'Error al eliminar el recurso';
    }

    //Edita un recurso, recibe un JSON con todos los campos a actualizar
    public function editar($json) {
        $obj = json_decode($json);
        $id = intval($obj->id);
        $sql = "UPDATE recursos SET 
            nombre = '{$this->conexion->real_escape_string($obj->name)}',
            descripcion = '{$this->conexion->real_escape_string($obj->description)}',
            url = '{$this->conexion->real_escape_string($obj->url)}',
            formato = '{$this->conexion->real_escape_string($obj->format)}',
            lenguaje = '{$this->conexion->real_escape_string($obj->language)}'
            WHERE id = $id";
        
        $this->data['status'] = $this->conexion->query($sql) ? 'success' : 'error';
        $this->data['message'] = 'Recurso actualizado';
    }

    //Obtiene un recurso por su ID, devuelve un solo objeto
    public function single($id) {
        $id = intval($id);
        //Busca el recurso por su ID
        $result = $this->conexion->query("SELECT * FROM recursos WHERE id = $id");
        //devuelve un solo registro como arreglo
        $this->data = $result->fetch_assoc();
    }

    //Busca recursos por nombre, descripcion o lenguaje que contengan el término de búsqueda
    public function buscar($term) {
        $term = $this->conexion->real_escape_string($term);
        //LIKE con condiciones para busqueda parcial en nombre, descripcion o lenguaje
        $sql = "SELECT * FROM recursos WHERE status=0 AND (nombre LIKE '%$term%' OR descripcion LIKE '%$term%' OR lenguaje LIKE '%$term%')";
        $result = $this->conexion->query($sql);
        //Devuelve todos los resultados
        $this->data = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>