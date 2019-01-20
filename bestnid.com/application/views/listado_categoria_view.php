<!DOCTYPE html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<!-- Se cargan los estilos de bootstrap -->
    	<link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet" media="screen">
    	<!-- Se cargan los estilos de la libreria dataTables -->
    	<link href="<?= base_url('css/jquery.dataTables.min.css') ?>" rel="stylesheet" type="text/css">
    	<!-- Se cargan los estilos con bootstrap de la libreria dataTables -->
    	<link href="<?= base_url('css/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css">
	    <title> Listado de una Categoría </title>
    </head>
	<body>
        <div class = "navbar navbar-inverse navbar-static-top"> <!-- Otra buena es navbar-fixed-top, la cual se mantiene en la pantalla si scrolleas -->
            <div class="container-fluid">  <!-- Esto hace que el texto esté en los extremos de la pagina -->
                <button class="navbar-toggle" data-toggle"collapse" data-target= "navHeaderCollapse"> <!-- Esto es si se achica la pantalla, hace un cuadradito con 3 lineas -->
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class= "navbar-collapse navHeaderCollapse"> 
                    <a href="<?= base_url(index_page().'/categorias') ?>" class="navbar-brand"> Categorías </a> 
                    <a href="<?= base_url('images/enConstruccion.jpg') ?>" class="navbar-brand"> Ayuda </a>
                    <ul class="nav navbar-nav navbar-right">                                                    
                        <?php
                            if(isset($this->session->userdata['login'])) { ?>
                                <a href="<?= base_url(index_page().'/miPerfil') ?>" class="navbar-brand">
                                    <?= $this->session->userdata['nombre'].' '.$this->session->userdata['apellido'] ?>
                                </a>
                                <a href="<?= base_url(index_page().'/logout') ?>" class="navbar-brand"> Cerrar Sesión </a>
                        <?php
                            }
                            else { ?>
                                <a href="<?= base_url(index_page().'/register') ?>" class="navbar-brand"> Registrarse </a>
                                <a href="<?= base_url(index_page().'/login') ?>" class="navbar-brand"> Iniciar Sesión </a>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
		<p align="center">
        	<a href="<?= base_url(index_page().'/index') ?>">
            	<img src="<?= base_url('images/logo.png') ?>" title="Volver al inicio de Bestnid">
            </a>
        </p>
        <h2 align="center">
        	<?php
        		if($subastas) { ?>
        			Categoria <?= $categoria[0]->nombreCategoria ?>
        	<?php
        		}
        		else { ?>
        			<center>
                        Categoria <?= $categoria[0]->nombreCategoria ?>
        				<h1> No hay subastas disponibles </h1>
        			</center>
        	<?php
        		}
        	?>
        </h2>
        <br>
		<!-- Estos archivos deben cargarse si o si antes de definir la tabla, sino no los toma -->
		<!-- Se carga jquery -->
    	<script src="<?= base_url('js/jquery.js') ?>" type="text/javascript" charset="utf8"></script>
		<!-- Se carga la libreria dataTables -->
    	<script src="<?= base_url('js/jquery.dataTables.min.js') ?>" type="text/javascript" charset="utf8"></script>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="tablaSubastas">
			<thead>
				<tr>
					<th>Imagen</th>
					<th>Nombre</th>
					<th>Descripcion</th>
					<th>Fecha de Finalización</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($subastas) {
						foreach($subastas->result() as $subasta) { ?>
							<tr class="gradeX">
								<td>
									<center>
                                        <a href="<?= base_url(index_page().'/subasta?idSubasta='.$subasta->idSubasta) ?>">
                                            <img src="<?= base_url('images/'.$subasta->nombreImagen) ?>" width="50px" height="50px">
                                        </a>
                                    </center>
								</td>
								<td>
									<center>
                                        <a href="<?= base_url(index_page().'/subasta?idSubasta='.$subasta->idSubasta) ?>">
                                            <?= $subasta->nombreSubasta ?>
                                        </a>
                                    </center>
								</td>
								<td> 
									<center> <?= $subasta->descripcion ?> </center>
								</td>
								<td>
									<center> <?= date('d-m-Y', strtotime($subasta->fechaFin)) ?> </center>
								</td>
							</tr>
				<?php
						}
					}
				?>
			</tbody>
		</table>
		<!-- Configuracion de la dataTable -->
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#tablaSubastas').dataTable( {
					"aaSorting":[],
					"aoColumnDefs":[ { 'bSortable': false, 'aTargets': [0, 2] } ],
        			"language": {
        				"search": "Buscar",
            			"lengthMenu": "Mostrar _MENU_ subastas por página",
            			"zeroRecords": "No se han encontrado subastas",
            			"info": "Mostrando página _PAGE_ de _PAGES_",
            			"infoEmpty": "No hay registros disponibles",
            			"infoFiltered": "(filtrado de un total de _MAX_ registros)",
            			"loadingRecords": "Cargando",
            			"processing":     "Procesando",
            			"zeroRecords":    "No hay subastas coincidentes encontradas",
            			"paginate": {
        					"first":      "Primero",
        					"last":       "Ultimo",
        					"next":       "Siguiente",
        					"previous":   "Anterior"
    					},
    					"aria": {
        					"sortAscending":  ": activar para ordenar columna de forma ascendente",
        					"sortDescending": ": activar para ordenar columna de forma descendente"
    					}
        			}
    			} );
			} );
		</script>
		<!-- Se cargan las funciones javascript de Bootstrap -->
    	<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
    	<!-- Este archivo le da estilo introduciendole bootstrap a la libreria dataTables mediante javascript -->
    	<script src="<?= base_url('js/dataTables.bootstrap.min.js') ?>" type="text/javascript" charset="utf8"></script>
	</body>
</html>