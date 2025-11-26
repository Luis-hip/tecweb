<?php
namespace TECWEB\PROYECTO\RESOURCES;
use TECWEB\PROYECTO\DATA\Database;

class Resources extends Database{
    public function __construct($db){
        parent::__construct($db);
    }

    public function listar(){
        $sql = "SELECT * FROM recursos WHERE status = 0 ORDER BY id DESC";
        $result = $this->conexion->query($sql);
        $this->data = $result->fetch_all(MYSQLI_ASSOC);
    }

    public function agregar($json){
        $obj = json_decode($json);
        $name = $this->conexion->real_escape_string($obj->name);

        $check = $this->conexion->query("SELECT id FROM recursos WHERE name='$name' AND status=0");
        if($check->num_rows == 0){
            $sql = "INSERT INTO recursos (name, descripcion, url, formato, lenguaje) VALUES (
                '{$name}',
                '{$this->conexion->real_escape_string($obj->descripcion)}',
                '{$this->conexion->real_escape_string($obj->url)}',
                '{$this->conexion->real_escape_string($obj->formato)}',
                '{$this->conexion->real_escape_string($obj->lenguaje)}'
            )";
            $this->data['status'] = $this->conexion->query($sql) ? 'success' : 'error';
            $this->data['message'] = $this->data['status'] == 'success' ? 'Recurso agregado' : 'Error en la Base de Datos';
        }else{
            $this->data = ['status' => 'error', 'message' => 'El recurso ya existe'];
        }
    }

    public function eliminar($id){
        $id = intval($id);
        $sql = "UPDATE recursos SET status = 1 WHERE id = $id";
        $this->data['status'] = $this->conexion->query($sql) ? 'success' : 'error';
        $this->data['message'] = $this->data['status'] == 'Recurso eliminado';
    }

    public function editar($json) {
        $obj = json_decode($json);
        $id = intval($obj->id);
        $sql = "UPDATE resources SET 
            name = '{$this->conexion->real_escape_string($obj->name)}',
            description = '{$this->conexion->real_escape_string($obj->description)}',
            url = '{$this->conexion->real_escape_string($obj->url)}',
            format = '{$this->conexion->real_escape_string($obj->format)}',
            language = '{$this->conexion->real_escape_string($obj->language)}'
            WHERE id = $id";
        
        $this->data['status'] = $this->conexion->query($sql) ? 'success' : 'error';
        $this->data['message'] = 'Recurso actualizado';
    }

    public function single($id) {
        $id = intval($id);
        $result = $this->conexion->query("SELECT * FROM resources WHERE id = $id");
        $this->data = $result->fetch_assoc();
    }

    public function buscar($term) {
        $term = $this->conexion->real_escape_string($term);
        $sql = "SELECT * FROM resources WHERE status=1 AND (name LIKE '%$term%' OR description LIKE '%$term%' OR language LIKE '%$term%')";
        $result = $this->conexion->query($sql);
        $this->data = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>