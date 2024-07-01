<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'User.php';
    require_once 'Database.php';

    $username = $_POST['User'];
    $password = $_POST['Password'];
    $email = $_POST['Email'];

    $db = new Database();
    $conn = $db->getConnection();

    $user = new User($conn);

    // Verificar si el usuario ya existe en la base de datos
    $existing_user = $user->read($username);

    if ($existing_user !== null) {
        // El usuario ya existe
        echo "  <script>
                    alert('El usuario ya existe en la base de datos.');
                    window.location.href = 'CrearUsuario.php'; // Redirigir de vuelta al formulario de login
                </script>";
    } else {
        // Crear nuevo usuario
        try {
            if ($user->create($username, $password, $email)) {
                echo "  <script>
                            alert('Usuario creado correctamente.');
                            window.location.href = 'CrearUsuario.php'; // Redirigir de vuelta al formulario de login
                        </script>";
            } else {
                echo "  <script>
                            alert('Error al crear el usuario.');
                            window.location.href = 'CrearUsuario.php'; // Redirigir de vuelta al formulario de login
                        </script>";
            }
        } catch (Exception $e) {
            echo 'Error al crear el usuario: ' . $e->getMessage();
        }
    }
    $conn->close();
}
?>