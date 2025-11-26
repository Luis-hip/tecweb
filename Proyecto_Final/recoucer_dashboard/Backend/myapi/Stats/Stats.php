<?php
namespace TECWEB\PROYECTO\STATS;
use TECWEB\PROYECTO\DATA\Database;

class Stats extends Database {
    public function __construct($db) { 
        parent::__construct($db);
    }

    public function getChartsData() {
        // Recursos por Formato
        $resFormat = $this->conexion->query("SELECT format as label, COUNT(*) as count FROM resources WHERE status=1 GROUP BY format");
        $this->data['by_format'] = $resFormat->fetch_all(MYSQLI_ASSOC);

        // Recursos por Lenguaje
        $resLang = $this->conexion->query("SELECT language as label, COUNT(*) as count FROM resources WHERE status=1 GROUP BY language");
        $this->data['by_language'] = $resLang->fetch_all(MYSQLI_ASSOC);

        // Actividad por fecha (Accesos)
        $resActivity = $this->conexion->query("SELECT DATE(login_time) as label, COUNT(*) as count FROM access_log GROUP BY DATE(login_time) ORDER BY label DESC LIMIT 7");
        $this->data['by_activity'] = $resActivity->fetch_all(MYSQLI_ASSOC);
    }
}
?>