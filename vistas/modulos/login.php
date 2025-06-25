<div class="login-box">
  <div class="login-logo">
    <img src="vistas/Img/plantilla/Logo-plano.png" class="img-responsive" style="padding: 10px 10px 0px 10px;">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Ingresar al sistema</p>

    <form method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      
      <div class="row"> <!-- Añade esta fila -->
        <div class="col-xs-4 col-xs-offset-4"> <!-- Añade offset para centrar -->
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
        </div>
      </div>
    </form>
  </div>
</div>