<?php
// Requerir la configuración de la base de datos y el modelo del Usuario
require_once 'config/database.php';
require_once 'models/User.php'; 

class QuizController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Verificación de autenticación de sesión básica
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['nombre'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $student_id = $_SESSION['user_id'];
        $student_name = $_SESSION['nombre'];

        // =========================================================================
        // 🔒 FILTRO PREVIO: BLOQUEO ABSOLUTO PARA QUE NO VUELVA A VER LAS PREGUNTAS
        // =========================================================================
        
        // Control A: Bloqueo rápido por sesión activa
        if (isset($_SESSION['prueba_terminada']) && $_SESSION['prueba_terminada'] === true) {
            die("<div style='font-family:Segoe UI, Arial; text-align:center; margin-top:100px; color:#2c3e50;'>
                    <div style='background:#fff; max-width:500px; margin:0 auto; padding:30px; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.05); border-left:5px solid #ef4444;'>
                        <h2>Evaluación Finalizada</h2>
                        <p style='color:#7f8c8d;'>Ya has presentado y enviado tus respuestas de manera formal. No está permitido repetir la prueba.</p>
                        <a href='index.php?action=logout' style='display:inline-block; margin-top:15px; padding:10px 20px; background:#2c3e50; color:#fff; text-decoration:none; border-radius:4px;'>Volver al Inicio</a>
                    </div>
                 </div>");
        }

        // Control B: Verificación estricta en Base de Datos (Mapeado con tu .sql relacional)
        $sqlCheck = "SELECT id FROM resultados WHERE usuario_id = :usuario_id LIMIT 1";
        $stmtCheck = $this->db->prepare($sqlCheck);
        $stmtCheck->bindParam(':usuario_id', $student_id, PDO::PARAM_INT);
        $stmtCheck->execute();
        
        if ($stmtCheck->rowCount() > 0) {
            // Sincronizamos la bandera de sesión para futuros bloqueos rápidos
            $_SESSION['prueba_terminada'] = true;
            die("<div style='font-family:Segoe UI, Arial; text-align:center; margin-top:100px; color:#2c3e50;'>
                    <div style='background:#fff; max-width:500px; margin:0 auto; padding:30px; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.05); border-left:5px solid #ef4444;'>
                        <h2>Evaluación Finalizada</h2>
                        <p style='color:#7f8c8d;'>El sistema detectó que ya cuentas con una calificación registrada en este cuestionario.</p>
                        <a href='index.php?action=logout' style='display:inline-block; margin-top:15px; padding:10px 20px; background:#2c3e50; color:#fff; text-decoration:none; border-radius:4px;'>Volver al Inicio</a>
                    </div>
                 </div>");
        }

        // =========================================================================
        // 2. SI ES UNA PETICIÓN POST: PROCESAR, CALIFICAR Y GUARDAR
        // =========================================================================
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Recuperar las preguntas en el orden exacto de la sesión
            $questions = isset($_SESSION['examen_actual_orden']) ? $_SESSION['examen_actual_orden'] : $this->user->getQuestions();

            $respuestas_alumno = [];
            $respuestas_correctas_totales = 0;
            $total_preguntas = 20; 

            // Capturar la cantidad de fraudes del cliente JavaScript
            $intentos_fraude = isset($_POST['intentos_fraude']) ? (int)$_POST['intentos_fraude'] : 0;

            foreach ($questions as $q) {
                $input_name = 'q_' . $q['id'];
                
                $respuesta_marcada = isset($_POST[$input_name]) ? trim($_POST[$input_name]) : '';
                $respuestas_alumno[$input_name] = $respuesta_marcada;

                $texto_alumno = strtolower(stripslashes(trim($respuesta_marcada)));
                $texto_correcto = strtolower(stripslashes(trim($q['respuesta_correcta'])));

                if ($texto_alumno !== '' && $texto_alumno === $texto_correcto) {
                    $respuestas_correctas_totales++;
                }
            }

            // Nota final calculada a escala sobre 20 preguntas
            $nota_final = ($respuestas_correctas_totales * 1.0) / $total_preguntas;

            // Guardar en la base de datos limpia
            $this->user->saveQuizResult($student_id, $respuestas_alumno, $nota_final, $intentos_fraude);

            // 🔏 ACTIVAR BLOQUEO INMEDIATO: Registramos en la sesión que la prueba ha sido entregada
            $_SESSION['prueba_terminada'] = true;

            // Preparar las variables para la vista de resultados
            $aciertos = $respuestas_correctas_totales;
            $fallas = $total_preguntas - $aciertos;
            $mensaje_retroalimentacion = "";
            $clase_alerta = ""; 

            if ($aciertos < 13) {
                $mensaje_retroalimentacion = "El resultado de su prueba indica que los conceptos manejados durante el trimestre no han sido los adecuados. Tiene que colocar más atención en clase y mejorar su compromiso con el resultado de aprendizaje.";
                $clase_alerta = "resultado-bajo";
            } elseif ($aciertos >= 13 && $aciertos <= 16) {
                $mensaje_retroalimentacion = "El test indica que los conocimientos adquiridos son buenos, sin embargo, pueden mejorar. Por favor, continúe estudiando.";
                $clase_alerta = "resultado-medio";
            } else {
                $mensaje_retroalimentacion = "¡Estupendo, buen trabajo! Por favor, siga así.";
                $clase_alerta = "resultado-alto";
            }

            // Limpiamos los datos de control del examen activo para liberar memoria
            unset($_SESSION['quiz_end_time']);
            unset($_SESSION['examen_actual_orden']);
            
            // Cargar la vista de resultados y congelar el flujo con exit()
            require_once 'views/resultado.php';
            exit(); 
        }

        // =========================================================================
        // 3. SI ES UNA PETICIÓN GET: CARGA INICIAL O RECUPERACIÓN TRAS CORTE/ACCIDENTE
        // =========================================================================
        
        // Si el orden de las preguntas no existe, se baraja de forma aleatoria única
        if (!isset($_SESSION['examen_actual_orden'])) {
            $questions = $this->user->getQuestions();
            shuffle($questions); 
            $_SESSION['examen_actual_orden'] = $questions; 
        } else {
            // 🔄 CASO REFRESCO/ACCIDENTE: Si recarga o reabre la pestaña, mantiene el mismo orden exacto
            $questions = $_SESSION['examen_actual_orden'];
        }

        $tiempo_total_segundos = (1 * 3600) + (21 * 60); 

        if (!isset($_SESSION['quiz_end_time'])) {
            $_SESSION['quiz_end_time'] = time() + $tiempo_total_segundos;
        }

        // 🔄 CASO REFRESCO/ACCIDENTE: El reloj descuenta de forma real según el tiempo del servidor
        $segundos_restantes = $_SESSION['quiz_end_time'] - time();

        if ($segundos_restantes <= 0) {
            $segundos_restantes = 0;
        }

        require_once 'views/quiz.php';
    }

    // =========================================================================
    // 4. ACCIÓN DE REPORTES GENERALES (VINCULADO CON DATATABLES)
    // =========================================================================
    public function verReporte() {
        $sql = "SELECT r.id, u.nombre, u.documento, r.nota_final, r.intentos_fraude, r.fecha_envio 
                FROM resultados r 
                INNER JOIN usuarios u ON r.usuario_id = u.id 
                ORDER BY r.fecha_envio DESC";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al generar el reporte en el Controlador: " . $e->getMessage());
        }

        require_once 'views/reporte.php';
    }

    // =========================================================================
    // 5. ACCIÓN DE CIERRE COMPLETO 
    // =========================================================================
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header("Location: index.php?action=login");
        exit();
    }
}
?>