<?php
   function esMultiploDe5y7($numero) {
        if ($numero%5==0 && $numero%7==0) {
            echo '<h3>R= El número '.$numero.' SÍ es múltiplo de 5 y 7.</h3>';
        } else {
            echo '<h3>R= El número '.$numero.' NO es múltiplo de 5 y 7.</h3>';
        }
   }
   
   function secuenciaImparParImpar() {
        $numeGenerados = 0;
        $iteraciones = 0;
        $filasPrueba = [];

        for($i=0; $i<3; $i++) {
            $num1 = rand(100, 999);
            $num2 = rand(100, 999);
            $num3 = rand(100, 999);

            $filasPrueba[] = [$num1, $num2, $num3];
            $numeGenerados += 3;
            $iteraciones++;
        }

        do{
            $num1 = rand(100, 999);
            $num2 = rand(100, 999);
            $num3 = rand(100, 999);

            $numeGenerados += 3;
            $iteraciones++;
        }while(!($num1%2!=0 && $num2%2==0 && $num3%2!=0));

        $filaValida = [$num1, $num2, $num3];
        
        echo "<pre>";
        foreach($filasPrueba as $fila) {
            printf("%3d %3d %3d\n", $fila[0], $fila[1], $fila[2]);
        }
        printf($filaValida[0]." ".$filaValida[1]." ".$filaValida[2]);
        echo "</pre>";
        echo "<p>Números generados: $numeGenerados en $iteraciones iteraciones.</p>";
   }

   function MultiploWhile($numero){
        $num = rand(1, 999);
        while ($num % $numero != 0){
            $num = rand(1, 999);
        }
        return $num;
   }

   function MultiploDoWhile($numero){
        $num = rand(1, 999);
        do {
            $num = rand(1, 999);
        } while ($num % $numero != 0);
        return $num;
   }
?>


