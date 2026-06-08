<?php

class AuthController
{
    private $db;
    private $user;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function login()
    {
        // Si el alumno ya está logueado, no puede volver a ver el Login
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?action=quiz");
            exit();
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';

            if ($user_id && !empty($password)) {
                $userData = $this->user->getById($user_id);

                // Verificar contraseña usando bcrypt
                if ($userData && password_verify($password, $userData['password'])) {
                    $_SESSION['user_id'] = $userData['id'];
                    $_SESSION['nombre'] = $userData['nombre'];

                    header("Location: index.php?action=quiz");
                    exit();
                } else {
                    $error = "La contraseña ingresada es incorrecta.";
                }
            } else {
                $error = "Por favor, seleccione su nombre y digite su clave.";
            }
        }

        // Obtener el listado de los estudiantes para renderizarlos en la vista
        $students = $this->user->getAll();

        // Cargar la vista del login
        require_once 'views/login.php';
    }
}
