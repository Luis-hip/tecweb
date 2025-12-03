<?php
namespace TECWEB\PROYECTO\STATS;
use TECWEB\PROYECTO\DATA\Database;

class Stats extends Database {
    public function __construct($db) { 
        parent::__construct($db);
    }

    //Obtiene los datos estadísticos para las gráficas del dashboard
    public function getChartsData() {
        // Recursos por Formato
        //Cuneta cuantos recursos hay por cada formato
        $resFormat = $this->conexion->query("SELECT formato as label, COUNT(*) as count FROM recursos WHERE status=0 GROUP BY formato");
        //Guarda los resultados en un arreglo de salida
        $this->data['by_format'] = $resFormat->fetch_all(MYSQLI_ASSOC);

        // Recursos por Lenguaje
        //Cuenta cuantos recursos hay por cada lenguaje
        $resLang = $this->conexion->query("SELECT lenguaje as label, COUNT(*) as count FROM recursos WHERE status=0 GROUP BY lenguaje");
        $this->data['by_language'] = $resLang->fetch_all(MYSQLI_ASSOC);

        // Actividad por fecha (Accesos)
        //Toma los ultimos 7 dias de actividad en la bitacora de accesos
        $resActivity = $this->conexion->query("SELECT DATE(login_time) as label, COUNT(*) as count FROM bitacora_accesos GROUP BY DATE(login_time) ORDER BY label DESC LIMIT 7");
        $this->data['by_activity'] = $resActivity->fetch_all(MYSQLI_ASSOC);
    }
}
?>