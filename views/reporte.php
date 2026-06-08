<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Evaluaciones</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f9; margin: 30px; color: #333; }
        .container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin: 0 auto; max-width: 1200px; }
        h1 { color: #2c3e50; margin-bottom: 5px; }
        .subtitle { color: #7f8c8d; margin-bottom: 25px; }
        
        /* Estilos de la Tabla */
        table.dataTable { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.dataTable th { background-color: #2c3e50 !important; color: white !important; padding: 12px; text-align: left; cursor: pointer; }
        table.dataTable td { padding: 12px; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
        
        /* Resaltado especial para reprobados (< 13 aciertos) */
        .fila-alerta { background-color: #fef2f2 !important; border-left: 4px solid #ef4444; }
        .fila-alerta td { color: #991b1b; }
        
        /* Badges de estado */
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block; }
        .badge-safe { background-color: #d1fae5; color: #065f46; }
        .badge-warning { background-color: #fee2e2; color: #9b1c1c; }
        
        .mensaje-retro { font-style: italic; font-size: 13px; max-width: 350px; display: inline-block; }
        .text-danger { color: #b91c1c; font-weight: bold; }
    </style>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>

<div class="container">
    <h1>Reporte General de Estudiantes</h1>
    <p class="subtitle">Lista consolidada de alumnos. Haz clic en los encabezados (como <strong>Nota Final</strong>) para ordenar la lista.</p>

    <table id="tablaReportes" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Documento</th>
                <th>Nota Final</th>
                <th>Aciertos</th>
                <th>Mensaje de Retroalimentación</th>
                <th>Intentos Fraude</th>
                <th>Fecha de Envío</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reportes)): ?>
                <?php foreach ($reportes as $row): ?>
                    <?php 
                        // Calculamos los aciertos reales multiplicando la nota por el total de preguntas (20)
                        $aciertos_calculados = round($row['nota_final'] * 20);
                        
                        // Determinamos el mensaje dinámico y si requiere resaltar la fila
                        $es_alerta = false;
                        if ($aciertos_calculados < 13) {
                            $mensaje = "El resultado de su prueba indica que los conceptos manejados durante el trimestre no han sido los adecuados. Tiene que colocar más atención en clase y mejorar su compromiso con el resultado de aprendizaje.";
                            $es_alerta = true; // Activamos el resaltado en rojo
                        } elseif ($aciertos_calculados >= 13 && $aciertos_calculados <= 16) {
                            $mensaje = "El test indica que los conocimientos adquiridos son buenos, sin embargo, pueden mejorar. Por favor, continúe estudiando.";
                        } else {
                            $mensaje = "¡Estupendo, buen trabajo! Por favor, siga así.";
                        }
                    ?>
                    <tr class="<?php echo $es_alerta ? 'fila-alerta' : ''; ?>">
                        <td><?php echo $row['id']; ?></td>
                        <td><strong><?php echo $row['nombre']; ?></strong></td>
                        <td><?php echo $row['documento']; ?></td>
                        <td data-order="<?php echo $row['nota_final']; ?>">
                            <strong><?php echo number_format($row['nota_final'], 2); ?></strong>
                        </td>
                        <td>
                            <?php if ($es_alerta): ?>
                                <span class="text-danger"><?php echo $aciertos_calculados; ?> / 20</span>
                            <?php else: ?>
                                <span><?php echo $aciertos_calculados; ?> / 20</span>
                            <?php endif; ?>
                        </td>
                        <td><span class="mensaje-retro"><?php echo $mensaje; ?></span></td>
                        <td>
                            <?php if ($row['intentos_fraude'] > 0): ?>
                                <span class="badge badge-warning">Alerta: <?php echo $row['intentos_fraude']; ?></span>
                            <?php else: ?>
                                <span class="badge badge-safe">Limpio</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['fecha_envio']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    // Inicializar DataTables en español
    $('#tablaReportes').DataTable({
        "order": [[3, "desc"]], // Ordenar por defecto por la columna 'Nota Final' (posición 3) de mayor a menor
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar estudiante:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
});
</script>

</body>
</html>