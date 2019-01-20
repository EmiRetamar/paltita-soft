<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet" media="screen">
    	<title> Modificar Subasta </title>
	</head>
	<body>
		<p align="center">
			<a href="<?= base_url(index_page().'/index') ?>">
				<img src="<?= base_url('images/logo.png') ?>" title="Volver al inicio de Bestnid">
			</a>
		</p>
		<!-- form_open_multipart es para la carga de archivos -->
		<?= form_open_multipart('subasta/actualizarDatosSubasta?idSubasta='.$subasta[0]->idSubasta, "onSubmit='return(modificar_subasta());'") ?>
		<?php
			$nombreSubasta = array(
				'name' => 'nombreSubasta',
				'value' => $subasta[0]->nombreSubasta,
				'class' => 'form-control',
	 			'placeholder' => 'Ingrese el nombre del producto',
	 			'required' => 'required',
	 			'pattern' => '.{3,30}$',
	 			'title' => 'Por favor, ingrese un mínimo de 3 caractéres. Maximo 30.'
				);

			$descripcion = array(
				'name' => 'descripcion',
				'value' => $subasta[0]->descripcion,
				'class' => 'form-control',
	 			'placeholder' => 'Ingrese la descripción del producto',
	 			'required' => 'required',
	 			'pattern' => '.{5,250}$',
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
						<?= form_label('Descripción', 'descripcion') ?>
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
    	<!-- Tengo que setear selected="selected" en la etiqueta option que corresponda a la categoria de la subasta -->
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
						<?= form_dropdown('categoria', $categoria, $subasta[0]->idCategoria); ?>
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
						<?= form_submit('', 'Aceptar', "class='btn btn-darkest'") ?>
						<a href="<?= base_url(index_page().'/subasta?idSubasta='.$subasta[0]->idSubasta) ?>">
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
		function modificar_subasta() {
			var archivo= document.getElementById('upload').value;
			if(archivo == null || archivo == "") {
				alert('No ha elegido ninguna imagen para la subasta');
				return false;
			}
			else {
				if(confirm('¿Esta seguro que desea modificar la subasta?') == false)
					return false;
			}
		}
	</script>
</html>