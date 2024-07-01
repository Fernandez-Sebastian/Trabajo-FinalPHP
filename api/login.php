<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'Database.php';

    $username = $_POST['User'];
    $password = $_POST['Password'];

    $db = new Database();
    $conn = $db->getConnection();
    $sql = "SELECT * FROM users WHERE User = ?";

    // Usar sentencias preparadas para evitar inyección SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Verificar si se encontró el usuario
    if ($result->num_rows > 0) {
        // Obtener la fila como un array asociativo
        $user = $result->fetch_assoc();

        // Obtener el hash almacenado de la base de datos
        $pass_hash = $user['Password'];
        $hashed_password = strtoupper(hash('sha1', $password));

        if ($hashed_password === $pass_hash) {
            session_start();
            $_SESSION['User'] = $username;
            header('Location: tabla.php');
            exit;
        } else {
            //usuario o contraseña incorrecto
            echo "  <script>
                        alert('Usuario o contraseña incorrectos');
                        window.location.href = 'index.php'; // Redirigir de vuelta al formulario de login
                    </script>";
        }
    } else {
        // Usuario no encontrado
        echo "  <script>
                    alert('Usuario no encontrado');
                    window.location.href = 'index.php'; // Redirigir de vuelta al formulario de login
                </script>";
    }
    $stmt->close();
    $conn->close();
}
?>