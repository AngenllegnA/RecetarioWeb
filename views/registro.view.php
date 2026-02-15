<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <title>Login</title>
</head>
<body class="bg-image">
  <div class="cart-container">
    <div class="cart-header">
            <p class="cart-title">Registrar</p>
        </div>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="input-group">
        <i class="fa fa-envelope-o icons" aria-hidden="false"></i>
        <input type="email" name="usuario" placeholder="usuario@correo.com" class="form-control">
      </div>

      <div class="input-group">
        <i class="fa fa-lock icons" aria-hidden="false"></i>
        <input type="password" name="password" placeholder="Contraseña" class="form-control">
      </div>

      <div class="input-group">
        <select hidden class="form-control" name="rol">
          <option value="usuario">Usuario</option>
          <option value="administrador">Administrador</option>
        </select>
      </div>

      <?php if (!empty($errores)): ?>
        <ul>
          <?php echo $errores; ?>
        </ul>
      <?php endif; ?>

      <button type="submit" name="submit" class="btn btn-flat-green">Registrar</button>
    </form>

    <div class="form-footer">
    <a href="<?php echo RUTA.'login.php' ?>" class="login-link">Ir a iniciar sesion</a>
    </div>

  </div>
</body>
</html>