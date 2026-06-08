<?php
// Aseguramos que las variables existan para evitar errores de PHP Notice
// Si por alguna razón no vienen del controlador, les asignamos valores por defecto
$aciertos = isset($aciertos) ? $aciertos : 0;
$total_preguntas = isset($total_preguntas) ? $total_preguntas : 20;

// 1. Cálculo matemático de las fallas
$fallas = $total_preguntas - $aciertos;

// 2. Lógica de mensajes según el rendimiento solicitado
$mensaje_retroalimentacion = "";
$clase_alerta = ""; // Para darle un diseño visual con CSS (opcional)

if ($aciertos < 13) {
    $mensaje_retroalimentacion = "El resultado de su prueba indica que los conceptos manejados durante el trimestre no han sido los adecuados. Tiene que colocar más atención en clase y mejorar su compromiso con el resultado de aprendizaje.";
    $clase_alerta = "resultado-bajo"; // Color rojo o naranja
} elseif ($aciertos >= 13 && $aciertos <= 16) {
    $mensaje_retroalimentacion = "El test indica que los conocimientos adquiridos son buenos, sin embargo, pueden mejorar. Por favor, continúe estudiando.";
    $clase_alerta = "resultado-medio"; // Color azul o amarillo
} else {
    // Rango entre 17 y 20 aciertos
    $mensaje_retroalimentacion = "¡Estupendo, buen trabajo! Por favor, siga así.";
    $clase_alerta = "resultado-alto"; // Color verde
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la Evaluación</title>
    <style>
        /* Estilos básicos para que la interfaz se vea ordenada y profesional */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card-resultado {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        h1 { color: #2c3e50; margin-bottom: 20px; }
        .metricas {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
        }
        .dato { font-size: 18px; font-weight: bold; }
        .dato span { display: block; font-size: 24px; margin-top: 5px; }
        .aciertos { color: #27ae60; }
        .fallas { color: #c0392b; }
        
        /* Estilos dinámicos para los mensajes de retroalimentación */
        .mensaje-box {
            margin-top: 25px;
            padding: 15px;
            border-radius: 6px;
            font-size: 16px;
            line-height: 1.5;
        }
        .resultado-bajo { background-color: #fde8e8; color: #9b1c1c; border-left: 5px solid #e11d48; }
        .resultado-medio { background-color: #eef2ff; color: #1e40af; border-left: 5px solid #3b82f6; }
        .resultado-alto { background-color: #ecfdf5; color: #065f46; border-left: 5px solid #10b981; }
        
        .btn-inicio {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 20px;
            background-color: #2c3e50;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .btn-inicio:hover { background-color: #34495e; }
    </style>
</head>
<body>

    <div class="card-resultado">
        <h1>Resumen de tu Prueba</h1>
        
        <div class="metricas">
            <div class="dato aciertos">
                Correctas
                <span><?php echo $aciertos; ?></span>
            </div>
            <div class="dato fallas">
                Incorrectas
                <span><?php echo $fallas; ?></span>
            </div>
        </div>

        <p>Puntaje total procesado: <strong><?php echo $aciertos; ?> / <?php echo $total_preguntas; ?></strong></p>

        <div class="mensaje-box <?php echo $clase_alerta; ?>">
            <?php echo $mensaje_retroalimentacion; ?>
        </div>

        <a href="index.php?action=logout" class="btn-inicio">Volver al Inicio</a>
    </div>

</body>
</html>