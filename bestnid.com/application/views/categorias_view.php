<!DOCTYPE html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<!-- Se cargan los estilos de bootstrap -->
        <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet" media="screen">
	    <title> Categorías </title>
    </head>
    <body>
       <p align="center">
            <a href="<?= base_url(index_page().'/index') ?>">
                <img src="<?= base_url('images/logo.png') ?>" title="Volver al inicio de Bestnid">
            </a>
        </p>
        <h1 align="center">
            Categorias
        </h1>
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
                            <a href="<?= base_url(index_page().'/categorias/listado?id='.$categoria->idCategoria) ?>">
                                <img src="<?= base_url('images/'.$categoria->nombreImagen) ?>" class="img-rounded" width="300" height="200">
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
        <!-- Se cargan las funciones javascript de Bootstrap -->
        <script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
        <!-- Este archivo le da estilo introduciendole bootstrap a la libreria dataTables mediante javascript -->
        <script src="<?= base_url('js/dataTables.bootstrap.min.js') ?>" type="text/javascript" charset="utf8"></script>
    </body>
</html>