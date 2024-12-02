<?php


// Configuración de la base de datos
$host = 'localhost';        // Cambia esto si tu base de datos no está en el mismo servidor
$username = 'cmunoz_focus';         // Usuario con privilegios para administrar conexiones
$password = 'Caq=W~%%0gWu';// Contraseña del usuario
$database = 'cmunoz_fyl_prueba';// Nombre de la base de datos (esto no es necesario para la gestión de conexiones)

// Crear conexión a MySQL
$mysqli = new mysqli($host, $username, $password);

// Verificar conexión
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Obtener la lista de procesos
$query = "SHOW FULL PROCESSLIST";
$result = $mysqli->query($query);

if ($result) {
    $output = [];

    // Iterar sobre los procesos
    while ($row = $result->fetch_assoc()) {
        $id = $row['Id'];
        $user = $row['User'];
        $db = $row['db'];
        $info = $row['Info'];
        $state = $row['State'];

        // Mostrar información sobre el proceso
        $output[] = "ID: $id | Usuario: $user | Base de datos: $db | Estado: $state | Consulta: $info";

        // Si el proceso está bloqueado o tarda mucho tiempo, matarlo
        if (strpos($state, 'Locked') !== false || $row['Time'] > 60) { // Ajusta el tiempo según tus necesidades
            $kill_query = "KILL $id";
            if ($mysqli->query($kill_query)) {
                $output[] = "Proceso ID: $id cerrado con éxito.";
            } else {
                $output[] = "Error al cerrar el proceso ID: $id: " . $mysqli->error;
            }
        }
    }

    $result->free();
    echo implode("\n", $output);
} else {
    echo "Error al obtener procesos: " . $mysqli->error;
}

// Cerrar la conexión
$mysqli->close();
?>