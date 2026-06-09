<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXAMEN</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); width: 100%; max-width: 420px; text-align: center; box-sizing: border-box; }
        h1 { color: #1a365d; font-size: 24px; margin-bottom: 5px; }
        h2 { color: #2b6cb0; font-size: 20px; margin-top: 0; margin-bottom: 25px; }
        .subtitle { color: #718096; font-size: 14px; margin-bottom: 30px; }
        .form-group { text-align: left; margin-bottom: 20px; }
        label { display: block; color: #4a5568; font-weight: 600; margin-bottom: 8px; font-size: 14px; }
        select, input[type="password"] { width: 100%; padding: 12px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 15px; color: #2d3748; box-sizing: border-box; background-color: #fff; }
        select:focus, input[type="password"]:focus { outline: none; border-color: #2b6cb0; box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15); }
        .btn-submit { width: 100%; padding: 14px; background-color: #1a365d; color: #fff; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; margin-top: 10px; transition: background-color 0.2s; }
        .btn-submit:hover { background-color: #2a4365; }
        .alert-error { background-color: #fff5f5; color: #c53030; border-left: 4px solid #f56565; padding: 12px; font-size: 14px; border-radius: 4px; text-align: left; margin-bottom: 20px; }
        .footer { margin-top: 30px; color: #a0aec0; font-size: 12px; border-top: 1px solid #e2e8f0; padding-top: 20px; }
    </style>
</head>
<body>

<div class="login-card">
    <h1>EXAMEN</h1>
    <h2>(Codificación)</h2>
    <p class="subtitle">Seleccione su nombre y espere indicaciones para iniciar</p>

    <?php if (isset($error_login)): ?>
        <div class="alert-error">
            <strong>Error:</strong> <?php echo $error_login; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?action=login" method="POST">
        <div class="form-group">
            <label for="usuario_id">Aprendiz:</label>
            <select name="usuario_id" id="usuario_id" required>
                <option value="">-- Seleccione su nombre --</option>
                <?php if (!empty($usuarios) && is_array($usuarios)): ?>
                    <?php foreach ($usuarios as $u): ?>
                        <option value="<?php echo htmlspecialchars($u['id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($u['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="" disabled>No hay estudiantes cargados en el sistema</option>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" required>
        </div>

        <button type="submit" class="btn-submit">Iniciar Prueba</button>
    </form>

    <div class="footer">
        Ingeniero Luis Enrique Arias (C) 2026
    </div>
</div>

</body>
</html>