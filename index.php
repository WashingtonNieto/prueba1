<?php
// Habilitar reporte de errores por si surge alguna anomalía en desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Requerir configuraciones e instancias necesarias
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'controllers/QuizController.php';

// Capturar la acción enviada por la URL. Por defecto cargará 'login'
$action = isset($_GET['action']) ? trim($_GET['action']) : 'login';

switch ($action) {
    case 'login':
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si el alumno ya está logueado, lo mandamos directo al examen
        if (isset($_SESSION['user_id']) && isset($_SESSION['nombre'])) {
            header("Location: index.php?action=quiz");
            exit();
        }

        // 1. CONEXIÓN Y CARGA DE USUARIOS PARA EL SELECTOR
        $database = new Database();
        $db = $database->getConnection();
        $userModel = new User($db);

        // Llamamos a getAll() para poblar el elemento <select> de la vista
        $usuarios = $userModel->getAll();

        // 2. PROCESAR EL FORMULARIO CUANDO EL APRENDIZ DA CLIC EN "INICIAR PRUEBA"
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario_id = isset($_POST['usuario_id']) ? (int)$_POST['usuario_id'] : 0;
            $password_ingresada = isset($_POST['password']) ? trim($_POST['password']) : '';

            if ($usuario_id > 0 && !empty($password_ingresada)) {
                // Obtener los datos del usuario seleccionado para verificar su clave
                $datos_usuario = $userModel->getById($usuario_id);

                if ($datos_usuario) {
                    // CAMBIO APLICADO: Generamos el hash SHA-256 en minúsculas y limpio
                    // para realizar una comparación estricta contra las cadenas de 64 caracteres de la BD
                    if (password_verify($password_ingresada, $datos_usuario['password'])) {
                        // Credenciales correctas: Creamos la sesión oficial
                        $_SESSION['user_id'] = $datos_usuario['id'];
                        $_SESSION['nombre'] = $datos_usuario['nombre'];

                        // Redireccionamos al cuestionario activo
                        header("Location: index.php?action=quiz");
                        exit();
                    } else {
                        // Resuelve el error visual arrojado en el login
                        $error_login = "La contraseña ingresada es incorrecta.";
                    }
                } else {
                    $error_login = "El estudiante seleccionado no existe.";
                }
            } else {
                $error_login = "Por favor, seleccione su nombre e ingrese su contraseña.";
            }
        }

        // Cargar la vista de login pasándole la variable $usuarios llena y los posibles errores
        require_once 'views/login.php';
        break;

    case 'quiz':
        $controller = new QuizController();
        $controller->index();
        break;

    case 'reporte':
        $controller = new QuizController();
        $controller->verReporte();
        break;

    case 'logout':
        $controller = new QuizController();
        $controller->logout();
        break;

    default:
        header("Location: index.php?action=login");
        exit();
        break;
}
