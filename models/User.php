<?php
class User {
    private $conn;
    private $table_name = "usuarios";

    /**
     * Constructor: Recibe la conexión PDO de la base de datos
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Obtiene todos los usuarios ordenados alfabéticamente por nombre
     */
    public function getAll() {
        $query = "SELECT id, nombre, documento FROM " . $this->table_name . " ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        // Agregamos fetchAll para retornar el array real de estudiantes
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un usuario específico por su ID único
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Trae el banco de preguntas desde la base de datos para el cuestionario
     */
    public function getQuestions() {
        $query = "SELECT id, pregunta, opcion_a, opcion_b, opcion_c, opcion_d, respuesta_correcta FROM preguntas ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Guarda el resultado final del cuestionario en la tabla 'resultados'.
     * Mapeado estrictamente con las columnas de tu script SQL.
     */
    public function saveQuizResult($usuario_id, $respuestas, $nota, $intentos_fraude = 0) {
        // Estructura idéntica a tu tabla física: usuario_id, respuestas_json, nota_final, intentos_fraude
        $query = "INSERT INTO resultados (usuario_id, respuestas_json, nota_final, intentos_fraude, fecha_envio) 
                  VALUES (:usuario_id, :respuestas, :nota, :intentos_fraude, NOW())";
                  
        $stmt = $this->conn->prepare($query);
        
        // 1. Serializar el arreglo asociativo de respuestas del alumno a JSON plano
        $respuestas_json = json_encode($respuestas);
        
        // 2. Formatear la nota final como decimal decimal(4,2) usando punto como separador
        $nota_limpia = number_format((float)$nota, 2, '.', '');

        // 3. Vinculación estricta de parámetros para prevenir inyecciones SQL
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':respuestas', $respuestas_json, PDO::PARAM_STR);
        $stmt->bindParam(':nota', $nota_limpia, PDO::PARAM_STR); 
        $stmt->bindParam(':intentos_fraude', $intentos_fraude, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>