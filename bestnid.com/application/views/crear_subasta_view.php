<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet" media="screen">
    	<title> Crear Subasta </title>
	</head>
	<body>
		<p align="center">
			<a href="<?= base_url(index_page().'/index') ?>">
				<img src="<?= base_url('images/logo.png') ?>" title="Volver al inicio de Bestnid">
			</a>
		</p>
		<!-- form_open_multipart es para la carga de archivos -->
		<?= form_open_multipart('crear_subasta/agregarSubasta', "onSubmit='return(crear_subasta());'") ?>
		<?php
			$nombreSubasta = array(
				'name' => 'nombreSubasta',
				'value' => @set_value('nombreSubasta'),
				'class' => 'form-control',
	 			'placeholder' => 'Ingrese el nombre del producto',
	 			'required' => 'required',
	 			'pattern' => '.{3,30}',
	 			'title' => 'Por favor, ingrese un mínimo de 3 caractéres. Maximo 30.'
			);
			$descripcion = array(
				'name' => 'descripcion',
				'value' => @set_value('descripcion'),
				'class' => 'form-control',
	 			'placeholder' => 'Ingrese la descripción del producto',
	 			'required' => 'required',
	 			'pattern' => '.{5,250}',
	 			'title' => 'Por favor, ingrese un mínimo de 5 caractéres. Maximo 250.'
			);
		?>
		<div class="row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<p align="center">
						<?= form_label('Nombre del producto', 'nombreSubasta') ?>
					</p>
					<?= form_input($nombreSubasta) ?>
				</div>
			</div>
			<div class="col-md-4">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<p align="center">
						<?= form_label('Descripción del producto', 'descripcion') ?>
					</p>
					<?= form_input($descripcion) ?>
				</div>
			</div>
			<div class="col-md-4">
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<p align="center">
						<?= form_label('Seleccione una imagen') ?>
					</p>
					<input type="file" name="userfile" id="upload" size="20" accept=".jpg,.jpeg,.gif,.png"/>
				</div>
			</div>
			<div class="col-md-4">
			</div>
		</div>
		<!-- Contenido del dropdown de categorias -->
		<?php
			foreach($categorias->result() as $tuplaCategoria) {
				$categoria[$tuplaCategoria->idCategoria] = $tuplaCategoria->nombreCategoria;
    		}
    	?>
        <br>
        <div class="row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<p align="center">
						<?= form_label('Seleccione una categoría') ?>
					</p>
					<p align="center">
						<?= form_dropdown('categoria', $categoria); ?>
					</p>
				</div>
			</div>
			<div class="col-md-4">
			</div>
		</div>
		<!-- Contenido del dropdown de la cantidad de días de la subasta -->
		<?php $cantDias = array(
	            15 => '15',
	            16 => '16',
	            17 => '17',
	            18 => '18',
	            19 => '19',
	            20 => '20',
	            21 => '21',
                22 => '22',
                23 => '23',
                24 => '24',
                25 => '25',
                26 => '26',
                27 => '27',
                28 => '28',
                29 => '29',
                30 => '30'
                ); ?>
        <br>
        <div class="row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<p align="center">
						<?= form_label('Seleccione la cantidad de días que se encontrará publicada la subasta') ?>
					</p>
					<p align="center">
						<?= form_dropdown('cantDias', $cantDias); ?>
					</p>
				</div>
			</div>
			<div class="col-md-4">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<p align="center">
						<!-- Boton submit -->
						<br>
						<?= form_submit('', 'Publicar Subasta', "class='btn btn-darkest'") ?>
						<a href="<?= base_url(index_page().'/index') ?>">
							<button type="button" class="btn btn-darkest"> Cancelar </button>
						</a>
					</p>
				</div>
			</div>
			<div class="col-md-4">
			</div>
		</div>
		<?= form_close() ?>
	</body>
	<script type="text/javascript">
		function crear_subasta() {
			var archivo = document.getElementById('upload').value;
			if(archivo == null || archivo == "") {
				alert('No ha elegido ninguna imagen para la subasta');
				return false;
			}
			/*else {
				alert('¡Subasta publicada con éxito!');
				return true;
			}*/
		}
	</script>
</html>