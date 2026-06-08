<?php
// 1. Preparar y ejecutar la consulta en tu controlador o modelo
$sql = "SELECT r.id, u.nombre, u.documento, r.nota_final, r.intentos_fraude, r.fecha_envio 
        FROM resultados r 
        INNER JOIN usuarios u ON r.usuario_id = u.id 
        ORDER BY r.fecha_envio DESC";

$stmt = $this->db->prepare($sql);
$stmt->execute();
$reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; font-family: Arial, sans-serif;">
    <thead>
        <tr style="background-color: #2c3e50; color: white;">
            <th>ID Prueba</th>
            <th>Estudiante</th>
            <th>Documento</th>
            <th>Nota Final</th>
            <th>Intentos de Fraude</th>
            <th>Fecha de Envío</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reportes as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><strong><?php echo $row['nombre']; ?></strong></td>
                <td><?php echo $row['documento']; ?></td>
                <td><?php echo $row['nota_final']; ?></td>
                <td><?php echo $row['intentos_fraude']; ?></td>
                <td><?php echo $row['fecha_envio']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>