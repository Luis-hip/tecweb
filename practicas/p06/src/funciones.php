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

   function arregloLetras(){
        $arreglo = [];
        for($i=97; $i<=122; $i++){
            $arreglo[$i] = chr($i);
        }
        return $arreglo;
   }

   function evaluarPersona($edad, $sexo){
        if($sexo == "Femenino" && $edad >= 18 && $edad <= 35){
            return "Bienvenida, usted está en el rango de edad aceptado";
        } else {
            return "Lo sentimos, no cumple los requisitos de edad y sexo";
        }
   }

   $parqueVehicular = [
        "ABC1234" => [      //Registro 1
            "Auto" => [
                "marca" => "Honda",
                "modelo" => "2020",
                "tipo" => "Camioneta",
            ],
            "Propietario" => [
                "nombre" => "Ana Perez",
                "ciudad" => "Ciudad de México",
                "direccion" => "Calle Falsa 123",
            ],
        ],
        "DEF5678" => [      //Registro 2
            "Auto" => [
                "marca" => "Toyota",
                "modelo" => "2019",
                "tipo" => "Sedan",
            ],
            "Propietario" => [
                "nombre" => "Luis Gomez",
                "ciudad" => "Guadalajara",
                "direccion" => "Avenida Siempre Viva 456",
            ],
        ],
        "GHI9012" => [     //Registro 3
            "Auto" => [
                "marca" => "Ford",
                "modelo" => "2021",
                "tipo" => "Hatchback",
            ],
            "Propietario" => [
                "nombre" => "Maria Lopez",
                "ciudad" => "Monterrey",
                "direccion" => "Boulevard Central 789",
            ],
        ],
        "JKL3456" => [     //Registro 4
            "Auto" => [
                "marca" => "Chevrolet",
                "modelo" => "2018",
                "tipo" => "SUV",
            ],
            "Propietario" => [
                "nombre" => "Carlos Sanchez",
                "ciudad" => "Puebla",
                "direccion" => "Calle del Sol 101",
            ],
        ],
        "MNO7890" => [      //Registro 5
            "Auto" => [
                "marca" => "Nissan",
                "modelo" => "2022",
                "tipo" => "Convertible",
            ],
            "Propietario" => [
                "nombre" => "Sofia Ramirez",
                "ciudad" => "Tijuana",
                "direccion" => "Avenida del Mar 202",
            ],
        ],
        "PQR2345" => [      //Registro 6
            "Auto" => [
                "marca" => "Volkswagen",
                "modelo" => "2020",
                "tipo" => "Coupe",
            ],
            "Propietario" => [
                "nombre" => "Miguel Torres",
                "ciudad" => "León",
                "direccion" => "Calle Luna 303",
            ],
        ],
        "STU6789" => [      //Registro 7
            "Auto" => [
                "marca" => "Hyundai",
                "modelo" => "2019",
                "tipo" => "Minivan",
            ],
            "Propietario" => [
                "nombre" => "Laura Flores",
                "ciudad" => "Querétaro",
                "direccion" => "Avenida Verde 404",
            ],
        ],
        "VWX0123" => [      //Registro 8
            "Auto" => [
                "marca" => "Kia",
                "modelo" => "2021",
                "tipo" => "Crossover",
            ],
            "Propietario" => [
                "nombre" => "Javier Morales",
                "ciudad" => "San Luis Potosí",
                "direccion" => "Calle Roja 505",
            ],
        ],
        "YZA4567" => [      //Registro 9
            "Auto" => [
                "marca" => "Mazda",
                "modelo" => "2018",
                "tipo" => "Sedan",
            ],
            "Propietario" => [
                "nombre" => "Elena Cruz",
                "ciudad" => "Mérida",
                "direccion" => "Avenida Azul 606",
            ],
        ],
        "BCD8901" => [      //Registro 10
            "Auto" => [
                "marca" => "Subaru",
                "modelo" => "2022",
                "tipo" => "Wagon",
            ],
            "Propietario" => [
                "nombre" => "Andrés Vega",
                "ciudad" => "Cancún",
                "direccion" => "Calle Amarilla 707",
            ],
        ],
        "EFG3456" => [      //Registro 11
            "Auto" => [
                "marca" => "Jeep",
                "modelo" => "2020",
                "tipo" => "4x4",
            ],
            "Propietario" => [
                "nombre" => "Patricia Medina",
                "ciudad" => "Acapulco",
                "direccion" => "Avenida Naranja 808",
            ],
        ],
        "HIJ7890" => [      //Registro 12
            "Auto" => [
                "marca" => "Dodge",
                "modelo" => "2019",
                "tipo" => "Pickup",
            ],
            "Propietario" => [
                "nombre" => "Fernando Rojas",
                "ciudad" => "Zacatecas",
                "direccion" => "Calle Gris 909",
            ],
        ],
        "KLM1234" => [      //Registro 13
            "Auto" => [
                "marca" => "Tesla",
                "modelo" => "2021",
                "tipo" => "Eléctrico",
            ],
            "Propietario" => [
                "nombre" => "Gabriela Silva",
                "ciudad" => "Toluca",
                "direccion" => "Avenida Blanca 111",
            ],
        ],
        "NOP5678" => [      //Registro 14
            "Auto" => [
                "marca" => "Audi",
                "modelo" => "2018",
                "tipo" => "Sedan",
            ],
            "Propietario" => [
                "nombre" => "Ricardo Castillo",
                "ciudad" => "Morelia",
                "direccion" => "Calle Negra 222",
            ],
        ],
        "QRS9012" => [      //Registro 15
            "Auto" => [
                "marca" => "BMW",
                "modelo" => "2022",
                "tipo" => "SUV",
            ],
            "Propietario" => [
                "nombre" => "Valeria Ortega",
                "ciudad" => "Hermosillo",
                "direccion" => "Avenida Rosa 333",
            ],
        ],
    ];

    function mostrarParqueVehicular($parqueVehicular){
        echo "<h2>Parque Vehicular</h2>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<thead>
                <tr>
                    <th>No.</th>
                    <th>Matrícula</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Tipo</th>
                    <th>Nombre Propietario</th>
                    <th>Ciudad</th>
                    <th>Dirección</th>
                </tr>
              </thead>";
        echo "<tbody>";
        $contador = 0;
        foreach($parqueVehicular as $matricula => $info) {
            echo "<tr>";
            echo "<td>".(++$contador)."</td>";
            echo "<td>$matricula</td>";
            echo "<td>".$info['Auto']['marca']."</td>";
            echo "<td>".$info['Auto']['modelo']."</td>";
            echo "<td>".$info['Auto']['tipo']."</td>";
            echo "<td>".$info['Propietario']['nombre']."</td>";
            echo "<td>".$info['Propietario']['ciudad']."</td>";
            echo "<td>".$info['Propietario']['direccion']."</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
?>


