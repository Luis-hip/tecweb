<?php
class Tabla{
    private $matriz = array();
    private $numFilas;
    private $numColumnas;
    private $estilo;

    public function __construct($row, $cols, $style){
        $this->numFilas = $row;
        $this->numColumnas = $cols;
        $this->estilo = $style;
    }

    public function cargar($row, $cols, $val){
        $this->matriz[$row][$cols] = $val;
    }

    private function inicio_Tabla(){
        echo '<table style="'.$this->estilo.'">';   
    }

    private function mostrar_Dato($row, $cols){
        echo '<td style="'.$this->estilo.'">';
            echo $this->matriz[$row][$cols];
        echo '</td>';
    }
    private function inicio_Fila(){
        echo '<tr>';
    }

    private function fin_Fila(){
        echo '</tr>';
    }

    private function fin_Tabla(){
        echo '</table>';
    }

    public function graficar(){
        $this->inicio_Tabla();
        for($i=0; $i < $this->numFilas; $i++){
            $this->inicio_Fila();
            for($j=0; $j < $this->numColumnas; $j++){
                $this->mostrar_Dato($i, $j);
            }
            $this->fin_Fila();
        }
        $this->fin_Tabla();
    }
}
?>