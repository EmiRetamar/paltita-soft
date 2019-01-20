<!DOCTYPE html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet" media="screen">
		<title> Iniciar Sesión </title>
	</head>
	<body>
		<p align="center">
			<a href="<?= base_url(index_page().'/index') ?>">
				<img src="<?= base_url('images/logo.png') ?>" title="Volver al inicio de Bestnid">
			</a>
		</p>
		<h1 align="center">Bestnid</h1>
		<h2 align="center">Elegí con el corazón</h2>
		<br>
		<?php
			if(isset($cuenta_desactivada)) { ?>
				<h4>
					<p align="center">
						<font color="blue"> <?= $cuenta_desactivada ?> </font>
					</p>
				</h4>
		<?php
			}
			else {
				if(isset($datos_error)) { ?>
					<h4>
						<p align="center">
							<font color="red"> <?= $datos_error ?> </font>
						</p>
					</h4>
		<?php
				}
			}
		?>
		<br>
		<?php $atributos = array('class' => 'form-horizontal', 'role' => 'form'); ?>
		<?= form_open("/login/verificar_datos", $atributos) ?>
		<?php
			$email = array(
				'name' => 'email',
				'class' => 'form-control',
				'type' => 'email',
				'placeholder' => 'Email',
				'required' => 'required'
			);
			$password = array(
				'name' => 'password',
				'class' => 'form-control',
				'type' => 'password',
				'placeholder' => 'Contraseña',
				'required' => 'required'
			);
		?>
		<div class="row">
			<div class="col-md-5">
			</div>
			<div class="col-md-2">
				<div class="form-group">	
					<?= form_input($email) ?>
				</div>
				<div class="form-group">
					<?= form_input($password) ?>
				</div>
			</div>
			<div class="col-md-5">
            </div>
		</div>
		<p align="center">
			<a href="#">Recuperar mi contraseña</a>
		</p>
		<p align="center">
			<?= form_submit('', 'Iniciar Sesión', "class='btn btn-darkest'") ?>
		</p>
		<?= form_close() ?>
		<h5 align="center">
			Si no tienes una cuenta <a href="<?= base_url(index_page().'/register') ?>">registrate</a>
		</h5>
		<!-- JQuery cargado de forma local (sin conexion a internet) -->
    	<script src="<?= base_url('js/jquery.js') ?>"></script>
    	<!-- Se cargan las funciones javascript de Bootstrap -->
    	<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
	</body>
</html>