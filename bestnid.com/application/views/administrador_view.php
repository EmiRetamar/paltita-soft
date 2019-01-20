<!DOCTYPE html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<!-- Se cargan los estilos de bootstrap -->
    	<link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet" media="screen">
    	<!-- Se cargan los estilos para la sidebar -->
    	<link href="<?= base_url('css/simple-sidebar.css') ?>" rel="stylesheet" media="screen">
        <!-- Se cargan los estilos de la libreria dataTables -->
        <link href="<?= base_url('css/jquery.dataTables.min.css') ?>" rel="stylesheet" type="text/css">
        <!-- Se cargan los estilos con bootstrap de la libreria dataTables -->
        <link href="<?= base_url('css/dataTables.bootstrap.css') ?>" rel="stylesheet" type="text/css">
        <!-- JQuery cargado de forma local (sin conexion a internet) -->
        <script src="<?= base_url('js/jquery.js') ?>"></script>
        <title> Administrador </title>   
    </head>
	<body>
		<div id="wrapper">
            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <li class="sidebar-brand">
                        <a href="<?= base_url(index_page().'/administrador') ?>"> Administrador </a>
                    </li>
                    <li>
                        <a href="<?= base_url(index_page().'/administrador/consultar_usuarios') ?>"> Consultar usuarios registrados </a>
                    </li>
                    <li>
                        <a href="<?= base_url(index_page().'/administrador/consultar_subastas') ?>"> Consultar subastas vendidas </a>
                    </li>
                    <li>
                        <a href="<?= base_url(index_page().'/administrador/crear_categoria') ?>"> Crear una categoria </a>
                    </li>
                    <li>
                        <a href="<?= base_url(index_page().'/administrador/eliminar_categoria') ?>"> Eliminar una categoria </a>
                    </li>
                </ul>
            </div>
            <!-- /#sidebar-wrapper -->
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <?php
                        if(isset($opcion)) { // Si existe la variable opcion
                            switch($opcion) { // Verifica que opcion se eligio y carga la vista correspondiente
                                case 'consultar_usuarios': 
                    ?>
                                    <p align="left">
                                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Deslizar Menu</a>
                                    </p>
                                    <h2 align="center">
                                        Consultar usuarios registrados
                                    </h2>
                                    <h3 align="center">
                                        Ingrese un rango de fechas
                                    </h3>
                                    <br>
                                    <br>
                                    <?= form_open('/administrador/usuarios_registrados') ?>
                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-4">
                                                <?= form_label('Desde:') ?>
                                                <input type="date" name="fecha1" class="form-control" value="2015-05-01" min="2015-05-01" max="<?= $fechaActual ?>" required="required">
                                                <br>
                                                <?= form_label('Hasta:') ?>
                                                <input type="date" name="fecha2" class="form-control" value="<?= $fechaActual ?>" min="2015-05-01" max="<?= $fechaActual ?>" required="required">
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <center>
                                            <?= form_submit('', 'Consultar', "class='btn btn-darkest'") ?>
                                            <a href="<?= base_url(index_page().'/administrador') ?>">
                                                <button type="button" class="btn btn-darkest"> Cancelar </button>
                                            </a>
                                        </center>
                                    <?= form_close() ?>
                                    <?php
                                        if(isset($error)) { ?>
                                            <script type="text/javascript">
                                                alert('<?= $error ?>');
                                            </script>
                                    <?php
                                        }
                                    ?>
                    <?php
                                    break;
                                case 'usuarios_registrados':
                    ?>
                                    <p align="left">
                                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Deslizar Menu</a>
                                    </p>
                                    <h3 align="center">
                                        <?= 'Usuarios registrados entre el '.date('d-m-Y', strtotime($fecha1)).' y el '.date('d-m-Y', strtotime($fecha2)) ?>
                                    </h3>
                                    <br>
                                    <br>
                                    <!-- Se carga la libreria dataTables -->
                                    <script src="<?= base_url('js/jquery.dataTables.min.js') ?>" type="text/javascript" charset="utf8"></script>
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="tablaSubastas">
                                        <thead>
                                            <tr>
                                                <th>Nombre y Apellido</th>
                                                <th>Email</th>
                                                <th>Estado</th>
                                                <th>Fecha de Registro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($usuariosRegistrados) {
                                                    foreach($usuariosRegistrados->result() as $usuario) { ?>
                                                        <tr class="gradeX">
                                                            <td>
                                                                <center>
                                                                    <?= $usuario->nombre.' '.$usuario->apellido ?>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <?= $usuario->email ?>    
                                                                </center>
                                                            </td>
                                                            <td> 
                                                                <center>
                                                                    <?php 
                                                                        if($usuario->activo) {
                                                                            echo 'Activo';
                                                                        }
                                                                        else {
                                                                            echo 'No activo';
                                                                        }
                                                                    ?>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <?= date('d-m-Y', strtotime($usuario->fechaRegistro)) ?>
                                                                </center>
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
                                                    "lengthMenu": "Mostrar _MENU_ usuarios por página",
                                                    "zeroRecords": "No se han encontrado usuarios",
                                                    "info": "Mostrando página _PAGE_ de _PAGES_",
                                                    "infoEmpty": "No hay registros disponibles",
                                                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                                                    "loadingRecords": "Cargando",
                                                    "processing":     "Procesando",
                                                    "zeroRecords":    "No hay usuarios coincidentes encontrados",
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
                                case 'consultar_subastas': 
                    ?>
                                    <p align="left">
                                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Deslizar Menu</a>
                                    </p>
                                    <h2 align="center">
                                        Consultar subastas vendidas
                                    </h2>
                                    <h3 align="center">
                                        Ingrese un rango de fechas
                                    </h3>
                                    <br>
                                    <br>
                                    <?= form_open('/administrador/subastas_vendidas') ?>
                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-4">
                                                <?= form_label('Desde:') ?>
                                                <input type="date" name="fecha1" class="form-control" value="2015-05-01" min="2015-05-01" max="<?= $fechaActual ?>" required="required">
                                                <br>
                                                <?= form_label('Hasta:') ?>
                                                <input type="date" name="fecha2" class="form-control" value="<?= $fechaActual ?>" min="2015-05-01" max="<?= $fechaActual ?>" required="required">
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <center>
                                            <?= form_submit('', 'Consultar', "class='btn btn-darkest'") ?>
                                            <a href="<?= base_url(index_page().'/administrador') ?>">
                                                <button type="button" class="btn btn-darkest"> Cancelar </button>
                                            </a>
                                        </center>
                                    <?= form_close() ?>
                                    <?php
                                        if(isset($error)) { ?>
                                            <script type="text/javascript">
                                                alert('<?= $error ?>');
                                            </script>
                                    <?php
                                        }
                                    ?>
                    <?php
                                    break;
                                case 'subastas_vendidas':
                    ?>                 
                                    <p align="left">
                                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Deslizar Menu</a>
                                    </p>
                                    <h3 align="center">
                                        <?= 'Subastas vendidas entre el '.date('d-m-Y', strtotime($fecha1)).' y el '.date('d-m-Y', strtotime($fecha2)) ?>
                                    </h3>
                                    <br>
                                    <h4 align="center">
                                        <?php
                                            if($ganadores) {
                                                $gananciaTotal = 0;
                                                foreach($ganadores as $ganador) {
                                                    $gananciaTotal += 30 * $ganador->monto / 100;
                                                }
                                                echo 'La ganancia total de bestnid entre estas fechas es: $'.$gananciaTotal;
                                            }
                                        ?>
                                    </h4>
                                    <br>
                                    <br>
                                    <!-- Se carga la libreria dataTables -->
                                    <script src="<?= base_url('js/jquery.dataTables.min.js') ?>" type="text/javascript" charset="utf8"></script>
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="tablaSubastas">
                                        <thead>
                                            <tr>
                                                <th>Nombre de la Subasta</th>
                                                <th>Subastador</th>
                                                <th>Ganador</th>
                                                <th>Fecha de Finalización</th>
                                                <th>Ganancia de Bestnid</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($subastadores && $ganadores) {
                                                    for($i = 0; $i < count($subastadores); $i++) { ?>
                                                        <tr class="gradeX">
                                                            <td>
                                                                <center>
                                                                    <?= $subastadores[$i]->nombreSubasta ?>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <?= $subastadores[$i]->nombre.' '.$subastadores[$i]->apellido ?>    
                                                                </center>
                                                            </td>
                                                            <td> 
                                                                <center>
                                                                    <?= $ganadores[$i]->nombre.' '.$ganadores[$i]->apellido ?>
                                                                </center>
                                                            </td>
                                                            <td>
                                                                <center>
                                                                    <?= date('d-m-Y', strtotime($subastadores[$i]->fechaFin)) ?>
                                                                </center>
                                                            <td>
                                                                <center>
                                                                    <?= '$'. 30 * $ganadores[$i]->monto / 100 ?>
                                                                </center>
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
                                case 'crear_categoria': 
                    ?>
                                    <p align="left">
                                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Deslizar Menu</a>
                                    </p>
                                    <h2 align="center">
                                        Crear una categoría
                                    </h2>
                                    <br>
                                    <br>
                                    <?= form_open_multipart('administrador/agregarCategoria', "onSubmit='return(crear_categoria());'") ?>
                                        <?php
                                            $nombreCategoria = array(
                                                'name' => 'nombreCategoria',
                                                'value' => @set_value('nombreCategoria'),
                                                'class' => 'form-control',
                                                'placeholder' => 'Nombre de la categoría',
                                                'required' => 'required',
                                                'pattern' => '.{3,30}$',
                                                'title' => 'Ingrese un mínimo de 3 caracteres, máximo 30'
                                            );
                                        ?>
                                        <div class="row">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-4">
                                                <p align="center">
                                                    <?= form_label('Ingrese el nombre de la categoría') ?>
                                                </p>
                                                <?= form_input($nombreCategoria) ?>
                                            </div>
                                            <div class="col-md-4">
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-4">
                                                <p align="center">
                                                    <?= form_label('Seleccione una imagen') ?>
                                                </p>
                                                <input type="file" name="userfile" id="upload" size="20" accept=".jpg,.jpeg,.gif,.png"/>
                                            </div>
                                            <div class="col-md-4">
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <center>
                                            <?= form_submit('', 'Crear Categoría', "class='btn btn-darkest'") ?>
                                            <a href="<?= base_url(index_page().'/administrador') ?>">
                                                <button type="button" class="btn btn-darkest"> Cancelar </button>
                                            </a>
                                        </center>
                                    <?= form_close() ?>
                    <?php
                                    break;
                                case 'eliminar_categoria': 
                    ?>
                                    <p align="left">
                                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Deslizar Menu</a>
                                    </p>
                                    <h2 align="center">
                                        Seleccione la categoría que desee eliminar 
                                    </h2>
                                    <br>
                                    <br>
                                    <div table-responsive>
                                        <table class="table table-condensed">
                                            <?php
                                                $i = 0;
                                                foreach($categorias->result() as $categoria) {
                                                    if($i == 0) { ?>
                                                        <tr>
                                                    <?php
                                                        $i = 3;
                                                    }
                                                    ?>
                                                    <td>
                                                        <p align="center"> 
                                                            <a href="<?= base_url(index_page().'/administrador/eliminarDatosCategoria?idCategoria='.$categoria->idCategoria) ?>" onClick="return(eliminar_categoria());">
                                                                <img src="<?= base_url('images/'.$categoria->nombreImagen) ?>" class="img-rounded" width="180" height="100">
                                                                <p align="center" > 
                                                                    <label>
                                                                        <?= $categoria->nombreCategoria ?>
                                                                    </label>
                                                                </p>
                                                            </a>
                                                        </p>
                                                    </td>
                                                <?php
                                                    $i--;
                                                    if($i == 0) { ?>
                                                        </tr>
                                                <?php
                                                    }
                                                ?>
                                            <?php
                                                }
                                                if($i > 0) { ?> <!-- Si i es mayor a 0 significa que salio del foreach sin cerrar la fila (el <tr>) -->
                                                    </tr>
                                            <?php
                                                }
                                            ?>
                                        </table>
                                    </div> 
                    <?php
                                    break;
                            }
                        }
                        else { // En caso de que no exista la variable opcion significa que se accede a la vista por primera vez y se cargan los datos por default
                    ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p align="center">
                                        <a href="<?= base_url(index_page().'/index') ?>">
                                            <img src="<?= base_url('images/logo.png') ?>" title="Volver al inicio de Bestnid">
                                        </a>
                                    </p>
                                    <h2 align="center"> ¡Bienvenido a la sección administrador de Bestnid! </h2>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <center>
                                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Deslizar Menu</a>
                                    </center>
                                </div>
                            </div>
                    <?php
                            if(isset($this->session->userdata['categoriaCreada'])) { ?>
                                <script type="text/javascript">
                                    alert('¡Categoría creada con éxito!');
                                </script>
                    <?php
                                $this->session->unset_userdata('categoriaCreada');
                            }
                        }
                    ?>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
		<!-- Se cargan las funciones javascript de Bootstrap -->
    	<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
        <!-- Este archivo le da estilo introduciendole bootstrap a la libreria dataTables mediante javascript -->
        <script src="<?= base_url('js/dataTables.bootstrap.min.js') ?>" type="text/javascript" charset="utf8"></script>
	</body>
	<script type="text/javascript">
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        function crear_categoria() {
            var archivo = document.getElementById('upload').value;
            if(archivo == null || archivo == "") {
                alert('No ha elegido ninguna imagen para la categoría');
                return false;
            }
            /*else {
                alert('¡Categoría creada con éxito!');
                return true;
            }*/
        }

        function eliminar_categoria() {
            if(confirm('¿Esta seguro que desea eliminar la categoría?') == true) {
                alert('¡Categoría eliminada exitosamente!');
                return (true);
            }
            else {
                return (false);
            }
        }
    </script>
</html>