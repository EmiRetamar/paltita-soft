<!DOCTYPE html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<!-- Se cargan los estilos de bootstrap -->
    	<link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet" media="screen">
    	<!-- Se cargan los estilos del elegant accordion menu ==> http://cssmenumaker.com/blog/free-css-sidebar-menu-navigations -->
    	<link href="<?= base_url('css/elegantAccordionMenu.css') ?>" rel="stylesheet" type="text/css">
		<!-- Se cargan los estilos de la libreria dataTables -->
        <link href="<?= base_url('css/jquery.dataTables.min.css') ?>" rel="stylesheet" type="text/css">
        <!-- Se cargan los estilos con bootstrap de la libreria dataTables -->
        <link href="<?= base_url('css/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css">
        <!-- JQuery cargado de forma local (sin conexion a internet) -->
        <script src="<?= base_url('js/jquery.js') ?>"></script>
		<title> Perfil </title>
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
						<a href="<?= base_url(index_page().'/perfil') ?>" class="navbar-brand">
							<?= $this->session->userdata['nombre'].' '.$this->session->userdata['apellido'] ?>
						</a>
						<a href="<?= base_url(index_page().'/logout') ?>" class="navbar-brand"> Cerrar Sesión </a>
					</ul>
				</div>
			</div>
		</div>
		<div id="wrapper">
			<table>
				<tr>
					<td>
		  				<!-- INICIO Elegant Accordion Menu -->
						<div id='cssmenu'>
							<ul>
				   				<li class=''>
				   					<a href="<?= base_url(index_page().'/perfil/informacion') ?>"><span> Informacion Personal </span></a>
				   				</li>
				   				<li class='has-sub'><a href="#"><span> Mis subastas </span></a>
				      				<ul>
				         				<li><a href="<?= base_url(index_page().'/perfil/subastas_vigentes') ?>"><span> --> Vigentes </span></a></li>
				         				<li><a href="<?= base_url(index_page().'/perfil/subastas_finalizadas') ?>"><span> --> Finalizadas </span></a></li>
				      				</ul>
				   				</li>
				   				<li class='has-sub'><a href="#"><span> Mis ofertas </span></a>
                                    <ul>
                                        <li><a href="<?= base_url(index_page().'/perfil/ofertas_pendientes') ?>"><span> --> Pendientes </span></a></li>
                                        <li><a href="<?= base_url(index_page().'/perfil/ofertas_ganadas') ?>"><span> --> Ganadas </span></a></li>
                                        <li><a href="<?= base_url(index_page().'/perfil/ofertas_perdidas') ?>"><span> --> Perdidas </span></a></li>
                                    </ul>
                                </li>
				   				<li class='has-sub'><a href="#"><span> Cuenta </span></a>
				    				<ul>
				        				<li class='last'><a href="<?= base_url(index_page().'/perfil/modificar_datos_personales') ?>"><span> --> Modificar mis datos </span></a></li>
				        				<li class='last'><a href="<?= base_url(index_page().'/perfil/cambiar_password') ?>"><span> --> Cambiar contraseña </span></a></li>
                                        <?php
				         					if($this->session->userdata('subastasPublicadas') || $this->session->userdata('subastasOfertadas')) { ?>
				         						<li class='last'><a href="<?= base_url(index_page().'/perfil/desactivarCuenta') ?>" onClick="return(alerta_desactivar_cuenta());"><span> --> Desactivar cuenta </span></a></li>
				      					<?php
				      						}
				      						else { ?>
				      							<li class='last'><a href="<?= base_url(index_page().'/perfil/desactivarCuenta') ?>" onClick="return(desactivar_cuenta());"><span> --> Desactivar cuenta </span></a></li>	
				      					<?php
				      						}
				      					?>
									</ul>
								</li>
							</ul>
						</div>
						<!-- FIN Elegant Accordion Menu -->
					</td>
					<td width="100%">
						<div id="page-content-wrapper">
            				<div class="container-fluid">
            					<p align="center">
									<a href="<?= base_url(index_page().'/index') ?>">
										<img src="<?= base_url('images/logo.png') ?>" title="Volver al inicio de Bestnid">
									</a>
								</p>
								<?php
									if(isset($opcion)) { // Si existe la variable opcion 
										switch ($opcion) {
											case 'informacion_personal':
								?>
												<h1 align="center"> Información Personal </h1>
		 										<br>
		 										<div class="row">
		 											<div class="col-md-4">
		 											</div>
		 											<div class="col-md-5">
		        										<dt> Nombre: <?= $usuario[0]->nombre ?> </dt>
		        										<dt> Apellido: <?= $usuario[0]->apellido ?> </dt>
		        										<dt> Email: <?= $usuario[0]->email ?> </dt>
		        										<dt> DNI: <?= $usuario[0]->DNI ?> </dt>
		        										<dt> Dirección: <?= $usuario[0]->direccion ?> </dt>
		        										<dt> Teléfono: <?= $usuario[0]->telefono ?> </dt>
		        									</div>
		        								</div>
		        				<?php
		        								break;
		 									case 'subastas_vigentes':
		 						?>
		 										<h3 align="center">
                                        			Subastas Vigentes
                                    			</h3>
                                    			<br>
                                    			<br>
                                    			<!-- Se carga la libreria dataTables -->
                                    			<script src="<?= base_url('js/jquery.dataTables.min.js') ?>" type="text/javascript" charset="utf8"></script>
                                    			<table cellpadding="0" cellspacing="0" border="0" class="display" id="tablaSubastas">
                                        			<thead>
                                            			<tr>
                                                			<th>Imagen</th>
                                                			<th>Nombre</th>
                                                			<th>Descripción</th>
                                                			<th>Fecha de Finalización</th>
                                            			</tr>
                                        			</thead>
                                        			<tbody>
                                            			<?php
                                                			if($subastasVigentes) {
                                                    			foreach($subastasVigentes->result() as $subasta) { ?>
                                                        			<tr class="gradeX">
                                                            			<td>
                                                                			<a href="<?= base_url(index_page().'/subasta?idSubasta='.$subasta->idSubasta) ?>">
																				<img src="<?= base_url('images/'.$subasta->nombreImagen) ?>" width="50px" height="50px">
																			</a>
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
                                                			"aoColumnDefs":[ { 'bSortable': false } ],
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
			 					<?php
		 										break;
		 									case 'subastas_finalizadas':
		 						?>
		 										<h3 align="center">
                                        			Subastas Finalizadas
                                    			</h3>
                                    			<br>
                                    			<br>
                                    			<!-- Se carga la libreria dataTables -->
                                    			<script src="<?= base_url('js/jquery.dataTables.min.js') ?>" type="text/javascript" charset="utf8"></script>
                                    			<table cellpadding="0" cellspacing="0" border="0" class="display" id="tablaSubastas">
                                        			<thead>
                                            			<tr>
                                                			<th>Imagen</th>
                                                			<th>Nombre</th>
                                                			<th>Descripción</th>
                                                			<th>Fecha de Finalización</th>
                                                			<th>Estado</th>
                                            			</tr>
                                        			</thead>
                                        			<tbody>
                                            			<?php
                                                			if($subastasFinalizadas) {
                                                                $i = 0;
                                                    			foreach($subastasFinalizadas->result() as $subasta) { ?>
                                                        			<tr class="gradeX">
                                                            			<td>
                                                                			<a href="<?= base_url(index_page().'/subasta?idSubasta='.$subasta->idSubasta) ?>">
																				<img src="<?= base_url('images/'.$subasta->nombreImagen) ?>" width="50px" height="50px">
																			</a>
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
                                                                        <td>
                                                                            <?php
                                                                                if($subasta->ganador == NULL) { ?>
                                                                                    <a href="<?= base_url(index_page().'/perfil/elegir_ganador?idSubasta='.$subasta->idSubasta) ?>">
                                                                                        <center>
                                                                                            <button type="button" class="btn btn-darkest"> Elegir Ganador </button>   
                                                                                        </center>
                                                                                    </a>
                                                                            <?php
                                                                                }
                                                                                else {
                                                                                    if($subasta->pagada == true) { ?>
                                                                                        <center> Pagada. Ganancia: $<?= 70 * $subastasVendidas[$i]->monto / 100 ?> </center>
                                                                            <?php
                                                                                        $i = $i + 1;
                                                                                    }
                                                                                    else { ?>
                                                                                        <center> Esperando Pago </center>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
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
                                                			"aoColumnDefs":[ { 'bSortable': false } ],
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
			 					<?php
		 										break;
		 									case 'ofertas_pendientes':
		 						?>
                                                <h3 align="center">
                                                    Ofertas Pendientes
                                                </h3>
                                                <br>
                                                <br>
                                                <!-- Se carga la libreria dataTables -->
                                                <script src="<?= base_url('js/jquery.dataTables.min.js') ?>" type="text/javascript" charset="utf8"></script>
                                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="tablaSubastas">
                                                    <thead>
                                                        <tr>
                                                            <th>Subasta</th>
                                                            <th>Argumento de la Oferta</th>
                                                            <th>Monto</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if($ofertasPendientes) {
                                                                foreach($ofertasPendientes->result() as $oferta) { ?>
                                                                    <tr class="gradeX">
                                                                        <td>
                                                                            <a href="<?= base_url(index_page().'/subasta?idSubasta='.$oferta->idSubasta) ?>">
                                                                                <?= $oferta->nombreSubasta ?>
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <center>
                                                                                <?= $oferta->argumento ?>
                                                                            </center>
                                                                        </td>
                                                                        <td> 
                                                                            <center> <?= $oferta->monto ?> </center>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                                if($oferta->ganador == NULL) { // Solo se mostraran las ofertas pendientes, es decir, que no tengan ganador
                                                                                    if(mdate('%Y-%m-%d') < $oferta->fechaFin) { ?> <!-- Si la fecha de actual es menor a la fecha de finalizacion significa que la oferta esta vigente porque la subasta aun no vencio -->
                                                                                        <center>
                                                                                            Vigente
                                                                                        </center>
                                                                                <?php
                                                                                    }
                                                                                    else { ?> <!-- Si la fecha de actual es mayor o igual a la fecha de finalizacion significa que la oferta esta en espera de un ganador porque la subasta ya vencio -->
                                                                                        <center>
                                                                                            En espera de un ganador
                                                                                        </center>
                                                                            <?php
                                                                                    }
                                                                                }
                                                                            ?>
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
                                                            "aoColumnDefs":[ { 'bSortable': false } ],
                                                            "language": {
                                                                "search": "Buscar",
                                                                "lengthMenu": "Mostrar _MENU_ ofertas por página",
                                                                "zeroRecords": "No se han encontrado ofertas",
                                                                "info": "Mostrando página _PAGE_ de _PAGES_",
                                                                "infoEmpty": "No hay registros disponibles",
                                                                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                                                                "loadingRecords": "Cargando",
                                                                "processing":     "Procesando",
                                                                "zeroRecords":    "No existen ofertas coincidentes",
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
			 					<?php
		 										break;
                                            case 'ofertas_ganadas':
                                ?>
                                                <h3 align="center">
                                                    Ofertas Ganadas
                                                </h3>
                                                <br>
                                                <br>
                                                <!-- Se carga la libreria dataTables -->
                                                <script src="<?= base_url('js/jquery.dataTables.min.js') ?>" type="text/javascript" charset="utf8"></script>
                                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="tablaSubastas">
                                                    <thead>
                                                        <tr>
                                                            <th>Subasta</th>
                                                            <th>Argumento de la Oferta</th>
                                                            <th>Monto</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if($ofertasGanadas) {
                                                                foreach($ofertasGanadas->result() as $oferta) { ?>
                                                                    <tr class="gradeX">
                                                                        <td>
                                                                            <a href="<?= base_url(index_page().'/subasta?idSubasta='.$oferta->idSubasta) ?>">
                                                                                <?= $oferta->nombreSubasta ?>
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <center>
                                                                                <?= $oferta->argumento ?>
                                                                            </center>
                                                                        </td>
                                                                        <td> 
                                                                            <center> <?= $oferta->monto ?> </center>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                                if($oferta->pagada == false) { ?> <!-- Si la subasta no esta pagada aparecera el boton de pagar -->
                                                                                    <center>
                                                                                        <button type="button" class="btn btn-darkest" data-toggle="modal" data-target="#myModal1"> Pagar Subasta </button>
                                                                                    </center>
                                                                            <?php
                                                                                }
                                                                                else { ?> <!-- Si la subastas esta pagada apareceran los datos del subastador -->
                                                                                    <center>
                                                                                        <button type="button" class="btn btn-darkest" data-toggle="modal" data-target="#myModal2"> Ver datos del subastador </button>
                                                                                    </center>
                                                                            <?php
                                                                                }
                                                                            ?>
                                                                        </td>
                                                                        <!-- Modal -->
                                                                        <div class="modal fade" id="myModal1" role="dialog">
                                                                            <div class="modal-dialog">-->
                                                                                <!-- Modal content-->
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>                
                                                                                        <h4 class="modal-title"> Ingrese los datos de su tarjeta </h4>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <?php $atributos = array('class' => 'form-horizontal', 'role' => 'form', 'onSubmit' => 'return(pagar_subasta());'); ?>
                                                                                        <?= form_open("/perfil/pagarSubasta?idSubasta=".$oferta->idSubasta, $atributos) ?>
                                                                                        <?php
                                                                                            $nombre = array(
                                                                                                'name' => 'nombre',
                                                                                                'class' => 'form-control',
                                                                                                'placeholder' => 'Ingrese su nombre',
                                                                                                'required' => 'required',
                                                                                                'pattern' => '[A-Za-z]{2,20}',
                                                                                                'title' => 'Ingrese un mínimo de 2 letras, máximo 20'
                                                                                            );
                                                                                            $apellido = array(
                                                                                                'name' => 'apellido',
                                                                                                'class' => 'form-control',
                                                                                                'placeholder' => 'Ingrese su apellido',
                                                                                                'required' => 'required',
                                                                                                'pattern' => '[A-Za-z]{2,20}',
                                                                                                'title' => 'Ingrese un mínimo de 2 letras, máximo 20'
                                                                                            );
                                                                                            $DNI = array(
                                                                                                'name' => 'DNI',
                                                                                                'class' => 'form-control',
                                                                                                'placeholder' => 'Ingrese su DNI',
                                                                                                'required' => 'required',
                                                                                                'pattern' => '[0-9]{7,8}',
                                                                                                'title' => 'Ingrese un mínimo de 7 digitos, máximo 8'
                                                                                            );
                                                                                            $numeroTarjeta = array(
                                                                                                'name' => 'numeroTarjeta',
                                                                                                'class' => 'form-control',
                                                                                                'placeholder' => 'Ingrese el número de su tarjeta',
                                                                                                'required' => 'required',
                                                                                                'pattern' => '[0-9]{16}',
                                                                                                'title' => 'El número de tarjeta debe tener 16 digitos'
                                                                                            );
                                                                                            $codigoSeguridad = array(
                                                                                                'name' => 'codigoSeguridad',
                                                                                                'class' => 'form-control',
                                                                                                'placeholder' => 'Ingrese el código de seguridad',
                                                                                                'required' => 'required',
                                                                                                'pattern' => '[0-9]{3}',
                                                                                                'title' => 'El código de seguridad debe tener 3 digitos'
                                                                                            );
                                                                                        ?>
                                                                                        <?= form_label('Nombre') ?>
                                                                                        <?= form_input($nombre) ?>
                                                                                        <br>
                                                                                        <?= form_label('Apellido') ?>
                                                                                        <?= form_input($apellido) ?>
                                                                                        <br>
                                                                                        <?= form_label('DNI') ?>
                                                                                        <?= form_input($DNI) ?>
                                                                                        <br>
                                                                                        <?= form_label('Número de tarjeta') ?>
                                                                                        <?= form_input($numeroTarjeta) ?>
                                                                                        <br>
                                                                                        <?= form_label('Código de seguridad de la tarjeta') ?>
                                                                                        <?= form_input($codigoSeguridad) ?>
                                                                                        <br>
                                                                                        <h4 align="center">
                                                                                            <?= form_label('Monto a pagar: $'.$oferta->monto) ?>
                                                                                        </h4>
                                                                                        <br>
                                                                                        <center>
                                                                                            <?= form_submit('', 'Efectuar Pago', "class='btn btn-darkest'") ?>
                                                                                        </center>
                                                                                        <?= form_close() ?>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal"> Cerrar </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Modal -->
                                                                        <div class="modal fade" id="myModal2" role="dialog">
                                                                            <div class="modal-dialog">
                                                                                <!-- Modal content -->
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>                
                                                                                        <h4 class="modal-title"> Datos del subastador </h4>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <?= form_label('Nombre: '.$oferta->nombre) ?>
                                                                                        <br>
                                                                                        <?= form_label('Apellido: '.$oferta->apellido) ?>
                                                                                        <br>
                                                                                        <?= form_label('Correo Electrónico: '.$oferta->email) ?>
                                                                                        <br>
                                                                                        <?= form_label('Teléfono: '.$oferta->telefono) ?>
                                                                                        <br>
                                                                                        <?= form_label('Dirección: '.$oferta->direccion) ?>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal"> Cerrar </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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
                                                            "aoColumnDefs":[ { 'bSortable': false } ],
                                                            "language": {
                                                                "search": "Buscar",
                                                                "lengthMenu": "Mostrar _MENU_ ofertas por página",
                                                                "zeroRecords": "No se han encontrado ofertas",
                                                                "info": "Mostrando página _PAGE_ de _PAGES_",
                                                                "infoEmpty": "No hay registros disponibles",
                                                                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                                                                "loadingRecords": "Cargando",
                                                                "processing":     "Procesando",
                                                                "zeroRecords":    "No existen ofertas coincidentes",
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
                                <?php
		 									    break;
                                            case 'ofertas_perdidas':
                                ?>
                                                <h3 align="center">
                                                    Ofertas Perdidas
                                                </h3>
                                                <br>
                                                <br>
                                                <!-- Se carga la libreria dataTables -->
                                                <script src="<?= base_url('js/jquery.dataTables.min.js') ?>" type="text/javascript" charset="utf8"></script>
                                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="tablaSubastas">
                                                    <thead>
                                                        <tr>
                                                            <th>Subasta</th>
                                                            <th>Argumento de la Oferta</th>
                                                            <th>Monto</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if($ofertasPerdidas) {
                                                                foreach($ofertasPerdidas->result() as $oferta) { ?>
                                                                    <tr class="gradeX">
                                                                        <td>
                                                                            <a href="<?= base_url(index_page().'/subasta?idSubasta='.$oferta->idSubasta) ?>">
                                                                                <?= $oferta->nombreSubasta ?>
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <center>
                                                                                <?= $oferta->argumento ?>
                                                                            </center>
                                                                        </td>
                                                                        <td> 
                                                                            <center> <?= $oferta->monto ?> </center>
                                                                        </td>
                                                                        <td>
                                                                            <center> Perdida </center>
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
                                                            "aoColumnDefs":[ { 'bSortable': false } ],
                                                            "language": {
                                                                "search": "Buscar",
                                                                "lengthMenu": "Mostrar _MENU_ ofertas por página",
                                                                "zeroRecords": "No se han encontrado ofertas",
                                                                "info": "Mostrando página _PAGE_ de _PAGES_",
                                                                "infoEmpty": "No hay registros disponibles",
                                                                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                                                                "loadingRecords": "Cargando",
                                                                "processing":     "Procesando",
                                                                "zeroRecords":    "No existen ofertas coincidentes",
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
                                <?php
                                                break;
                                            case 'modificar_datos_personales':
		 						?>
		 									    <h3 align="center">
                                                    Modificar Datos Personales
                                                </h3>
                                                <br>
                                                <?php
                                                    if(isset($datos_error)) { ?>
                                                        <h4>
                                                            <p align="center">
                                                                <font color="red"> <?= $datos_error ?> </font>
                                                            </p>
                                                        </h4>
                                                <?php
                                                    }
                                                ?>
                                                <br>
                                                <?= form_open('perfil/verificar_datos', "onSubmit='return(modificar_datos_personales())'") ?>
                                                <?php
                                                    $nombre = array(
                                                        'name' => 'nombre',
                                                        'value' =>  $usuario[0]->nombre,
                                                        'class' => 'form-control',
                                                        'placeholder' => 'Nombre',
                                                        'required' => 'required',
                                                        'pattern' => '[A-Za-z]{2,20}',
                                                        'title' => 'Ingrese un mínimo de 2 letras, máximo 20'
                                                    );
                                                    $apellido = array(
                                                        'name' => 'apellido',
                                                        'value' =>$usuario[0]->apellido,
                                                        'class' => 'form-control',
                                                        'placeholder' => 'Apellido',
                                                        'required' => 'required',
                                                        'pattern' => '[A-Za-z]{2,20}',
                                                        'title' => 'Ingrese un mínimo de 2 letras, máximo 20'
                                                    );
                                                    $DNI = array(
                                                        'name' => 'DNI',
                                                        'value' => $usuario[0]->DNI,
                                                        'class' => 'form-control',
                                                        'placeholder' => 'DNI',
                                                        'required' => 'required',
                                                        'pattern' => '[0-9]{7,8}',
                                                        'title' => 'Ingrese un mínimo de 7 digitos, máximo 8'
                                                    );
                                                    $email = array(
                                                        'name' => 'email',
                                                        'type' => 'email',
                                                        'value' => $usuario[0]->email,
                                                        'class' => 'form-control',
                                                        'placeholder' => 'Email',
                                                        'required' => 'required',
                                                        'pattern' => '.{3,30}',
                                                        'title' => 'Ingrese un mínimo de 3 caracteres, máximo 30'
                                                    );  
                                                    $direccion = array(
                                                        'name' => 'direccion',
                                                        'value' => $usuario[0]->direccion,
                                                        'class' => 'form-control',
                                                        'placeholder' => 'Dirección',
                                                        'required' => 'required',
                                                        'pattern' => '.{2,30}',
                                                        'title' => 'Ingrese un mínimo de 2 caracteres, maximo 30'
                                                    );
                                                    $telefono = array(
                                                        'name' => 'telefono',
                                                        'value' => $usuario[0]->telefono,
                                                        'class' => 'form-control',
                                                        'placeholder' => 'Teléfono',
                                                        'required' => 'required',
                                                        'pattern' => '[0-9]{8,15}',
                                                        'title' => 'Ingrese un mínimo de 8 números, máximo 15'
                                                    );
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <?= form_label('Correo Electrónico') ?>
                                                        <?= form_input($email) ?>
                                                        <br>
                                                        <?= form_label('DNI') ?>
                                                        <?= form_input($DNI) ?>
                                                        <br>
                                                        <?= form_label('Nombre') ?>
                                                        <?= form_input($nombre) ?>
                                                        <br>
                                                        <?= form_label('Apellido') ?>
                                                        <?= form_input($apellido) ?>
                                                        <br>
                                                        <?= form_label('Dirección') ?>
                                                        <?= form_input($direccion) ?>
                                                        <br>
                                                        <?= form_label('Teléfono') ?>
                                                        <?= form_input($telefono) ?>
                                                        <p align="center">
                                                            <br>
                                                            <br>
                                                            <?= form_submit('', 'Guardar', "class='btn btn-darkest'") ?>
                                                            <a href="<?= base_url(index_page().'/perfil') ?>">
                                                                <button type="button" class="btn btn-darkest"> Cancelar </button>
                                                            </a>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                    </div>
                                                </div>
                                                <?= form_close() ?>
			 					<?php
		 										break;
                                            case 'cambiar_contraseña':
                                ?>
                                                <h3 align="center">
                                                    Cambiar Contraseña
                                                </h3>
                                                <br>
                                                <?php
                                                    if(isset($datos_error)) { ?>
                                                        <h4>
                                                            <p align="center">
                                                                <font color="red"> <?= $datos_error ?> </font>
                                                            </p>
                                                        </h4>
                                                <?php
                                                    }
                                                ?>
                                                <br>
                                                <?= form_open('perfil/verificar_passwords', "onSubmit='return(cambiar_password())'") ?>
                                                <?php
                                                    $password1 = array(
                                                        'name' => 'password1',
                                                        'type' => 'password',
                                                        'class' => 'form-control',
                                                        'placeholder' => 'Contraseña actual',
                                                        'required' => 'required',
                                                        'pattern' => '.{6,15}',
                                                        'title' => 'Ingrese un mínimo de 6 caracteres, máximo 15'
                                                    );
                                                    $password2 = array(
                                                        'name' => 'password2',
                                                        'type' => 'password',
                                                        'class' => 'form-control',
                                                        'placeholder' => 'Contraseña nueva',
                                                        'required' => 'required',
                                                        'pattern' => '.{6,15}',
                                                        'title' => 'Ingrese un mínimo de 6 caracteres, máximo 15'
                                                    );
                                                    $password3 = array(
                                                        'name' => 'password3',
                                                        'type' => 'password',
                                                        'class' => 'form-control',
                                                        'placeholder' => 'Repetir contraseña nueva',
                                                        'required' => 'required',
                                                        'pattern' => '.{6,15}',
                                                        'title' => 'Ingrese un mínimo de 6 caracteres, máximo 15'
                                                    );
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <?= form_label('Contraseña actual') ?>
                                                        <?= form_input($password1) ?>
                                                        <br>
                                                        <?= form_label('Contraseña nueva') ?>
                                                        <?= form_input($password2) ?>
                                                        <br>
                                                        <?= form_label('Repetir contraseña nueva') ?>
                                                        <?= form_input($password3) ?>
                                                        <p align="center">
                                                            <br>
                                                            <br>
                                                            <?= form_submit('', 'Guardar', "class='btn btn-darkest'") ?>
                                                            <a href="<?= base_url(index_page().'/perfil') ?>">
                                                                <button type="button" class="btn btn-darkest"> Cancelar </button>
                                                            </a>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                    </div>
                                                </div>
                                                <?= form_close() ?>
                                <?php
                                                break;
                                            case 'elegir_ganador':
                                ?>
                                                <h3 align="center">
                                                    Seleccione la oferta ganadora
                                                </h3>
                                                <br>
                                                <br>
                                                <!-- Se carga la libreria dataTables -->
                                                <script src="<?= base_url('js/jquery.dataTables.min.js') ?>" type="text/javascript" charset="utf8"></script>
                                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="tablaSubastas">
                                                    <thead>
                                                        <tr>
                                                            <th>Argumento</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if($ofertas) {
                                                                foreach($ofertas->result() as $oferta) { ?>
                                                                    <tr class="gradeX">
                                                                        <td> 
                                                                            <center> <?= $oferta->argumento ?> </center>
                                                                        </td>
                                                                        <td>
                                                                            <a href="<?= base_url(index_page().'/perfil/guardarGanador?idSubasta='.$oferta->idSubasta.'&idUsuario='.$oferta->idUsuario) ?>"> <!-- Paso como parametro el idSubasta para buscar la subasta a la que pertenece esta oferta y paso el idUsuario para setearlo en esa subasta como ganador -->
                                                                                <center>
                                                                                    <button type="button" class="btn btn-darkest" onClick="return(elegir_ganador());"> Seleccionar </button>   
                                                                                </center>
                                                                            </a>
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
                                                            "aoColumnDefs":[ { 'bSortable': false } ],
                                                            "language": {
                                                                "search": "Buscar",
                                                                "lengthMenu": "Mostrar _MENU_ ofertas por página",
                                                                "zeroRecords": "No se han encontrado ofertas",
                                                                "info": "Mostrando página _PAGE_ de _PAGES_",
                                                                "infoEmpty": "No hay registros disponibles",
                                                                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                                                                "loadingRecords": "Cargando",
                                                                "processing":     "Procesando",
                                                                "zeroRecords":    "No existen ofertas coincidentes",
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
                                <?php
                                                break;
		 								}
		 							}
		 							else {
		 						?>
		 								<h1 align="center"> ¡Bienvenido a su perfil! </h1>
                                <?php
                                        if(isset($datos_modificados)) { ?>
                                            <script>
                                                alert('Sus datos han sido modificados correctamente')
                                            </script>
                                <?php
                                        }
                                        if(isset($password_cambiado)) { ?>
                                            <script>
                                                alert('Su contraseña ha sido cambiada correctamente')
                                            </script>
                                <?php
                                        }
		 							}
			 					?>
            				</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<!-- Se cargan las funciones javascript de Bootstrap --> 
		<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
    	<!-- Este archivo hace que se pueda desplegar submenú al sidebar -->
  		<script src="<?= base_url('js/elegantAccordionMenu.js') ?>"></script>
  		<!-- Este archivo le da estilo introduciendole bootstrap a la libreria dataTables mediante javascript -->
        <script src="<?= base_url('js/dataTables.bootstrap.min.js') ?>" type="text/javascript" charset="utf8"></script>
	</body>
	<script type="text/javascript">
        function elegir_ganador() {
            if(confirm('¿Esta seguro que desea seleccionar esta oferta?') == true) {
                alert('¡Ganador elegido con exito!');
                return (true);
            }
            else {
                return (false);
            }
        }

        function pagar_subasta() {
            alert('Subasta pagada exitosamente');
            return (true);
        }

        function modificar_datos_personales() {
            if(confirm('¿Esta seguro que desea modificar sus datos?') == true) {
                return (true);
            }
            else {
                return (false);
            }
        }

        function cambiar_password() {
            if(confirm('¿Esta seguro que desea cambiar su contraseña?') == true) {
                return (true);
            }
            else {
                return (false);
            }
        }

		function desactivar_cuenta() {
            if(confirm('¿Esta seguro que desea desactivar su cuenta?') == true) {
                alert('¡Su cuenta ha sido desactivada!');
                return (true);
            }
            else {
                return (false);
            }
        }

        function alerta_desactivar_cuenta() {
        	alert('La cuenta no pudo ser desactivada debido a que tiene subastas publicadas o subastas ofertadas vigentes');
        	return (false);
        }
	</script>  
</html>