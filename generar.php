<?php

$resultado = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $password = trim($_POST['password'] ?? '');

    if (!empty($password)) {
        $resultado = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $resultado = 'Debe ingresar una contraseña.';
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generador de Hash Bcrypt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        input[type=text] {
            width: 400px;
            padding: 8px;
        }

        textarea {
            width: 100%;
            height: 100px;
            margin-top: 10px;
        }

        button {
            padding: 10px 20px;
        }
    </style>
</head>
<body>

    <h2>Generador de Contraseñas Bcrypt</h2>

    <form method="post">
        <label>Contraseña:</label><br><br>

        <input
            type="text"
            name="password"
            placeholder="Ingrese la contraseña"
            required
        >

        <br><br>

        <button type="submit">Generar Hash</button>
    </form>

    <?php if (!empty($resultado)) : ?>
        <h3>Hash generado:</h3>

        <textarea readonly><?= htmlspecialchars($resultado) ?></textarea>
    <?php endif; ?>

</body>
</html>