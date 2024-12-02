<?php
    $logfile = '/home/usuario/scripts/debug.log';
    file_put_contents($logfile, "Script iniciado\n", FILE_APPEND);
    // Configuración de la conexión
    $servername = "localhost";
    $username = "cmunoz_fyl_prueba";
    $password = "fyl_prueba";
    $dbname = "cmunoz_fyl_prueba";
    
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    
    // Consultar conexiones inactivas
    $sql = "SHOW PROCESSLIST";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $time = $row["Time"];
            $id = $row["Id"];
            if ($time > 7200) { // Si la conexión ha estado inactiva por más de 2 horas
                $conn->query("KILL $id");
                echo "Conexión con ID $id cerrada por inactividad.\n";
            }
        }
    }
    
    $conn->close();
    
    file_put_contents($logfile, "Conexiones revisadas\n", FILE_APPEND);
?>
