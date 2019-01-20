<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Se cargan los estilos de bootstrap -->
        <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet" media="screen">
        <title> Subasta </title>
    </head>
    <body>
        <p align="center">
            <a href="<?= base_url(index_page().'/index') ?>">
                <img src="<?= base_url('images/logo.png') ?>" title="Volver al inicio de Bestnid">
            </a>
        </p>
        <h1 align="center">
            <?= $subasta[0]->nombreSubasta ?>
        </h1>
        <br>
        <center>
            <img src="<?= base_url('images/'.$subasta[0]->nombreImagen) ?>" class="img-rounded" width="300" height="200" />
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <h4>
                        <br>
                        <?= 'Descripción: '.$subasta[0]->descripcion ?>
                        <br>
                        <br>
                        <?= 'Categoría: '.$categoria[0]->nombreCategoria ?>
                        <br>
                        <br>
                        <?php
                            if(mdate('%Y-%m-%d') < $subasta[0]->fechaFin) { ?>
                                <?= 'La subasta finaliza el día: '.date('d-m-Y', strtotime($subasta[0]->fechaFin)) ?>
                        <?php
                            }
                            else { ?>
                                Subasta Finalizada
                                <br>
                                <br>
                                <?= 'La subasta finalizo el día: '.date('d-m-Y', strtotime($subasta[0]->fechaFin)) ?>
                        <?php
                            }
                        ?>
                    </h4>
                </div>
            </div>
        </center>
        <br>
        <?php
        if(mdate('%Y-%m-%d') < $subasta[0]->fechaFin) { // Si la fecha actual es menor a la fecha de finalizacion de la subasta significa que no esta vencida
            if(isset($this->session->userdata['login'])) {
                if($this->session->userdata['idUsuario'] == $subasta[0]->idUsuario) { ?> <!-- Si la subasta le pertenece, el usuario puede modificarla o eliminarla en caso de que no tenga ofertas -->
                    <center>
                        <a href="<?= base_url(index_page().'/subasta/modificar_subasta?idSubasta='.$subasta[0]->idSubasta) ?>">
                            <?php
                                if($ofertas) { ?>  <!-- Si tiene ofertas, no puede modificar la subasta -->
                                    <button type="button" class="btn btn-darkest btn-lg" onClick="return(alerta_modificar_subasta());"> Modificar Subasta </button>
                            <?php
                                }
                                else { ?> <!-- En caso de que no tenga ofertas, puede modificarla -->
                                    <button type="button" class="btn btn-darkest btn-lg"> Modificar Subasta </button>
                            <?php
                                }
                            ?>
                        </a>
                    </center>
                    <br>
                    <center>
                        <a href="<?= base_url(index_page().'/subasta/eliminarSubasta?idSubasta='.$subasta[0]->idSubasta) ?>">
                            <?php
                                if($ofertas) { ?>  <!-- Si tiene ofertas, no puede eliminar la subasta -->
                                    <button type="button" class="btn btn-danger btn-lg" onClick="return(alerta_eliminar_subasta());"> Eliminar Subasta </button>
                            <?php
                                }
                                else { ?> <!-- En caso de que no tenga ofertas, puede eliminarla -->
                                    <button type="button" class="btn btn-danger btn-lg" onClick="return(eliminar_subasta());"> Eliminar Subasta </button>
                            <?php
                                }
                            ?>
                        </a>
                    </center>
            <?php
                }
                else { ?> <!-- Si la subasta no le pertenece, el usuario puede ofertar o modificar su oferta -->
                    <div class="container">
                        <!-- Trigger the modal with a button -->
                        <p align="center">
                            <?php
                                if(!$oferto) { ?> <!-- Si el usuario no oferto, puede ofertar por primera vez -->
                                    <button type="button" class="btn btn-darkest btn-lg" data-toggle="modal" data-target="#myModal"> Ofertar </button>
                            <?php
                                }
                                else { ?> <!-- Sino, el usuario solo puede modificar su oferta -->
                                    <button type="button" class="btn btn-darkest btn-lg" data-toggle="modal" data-target="#myModal"> Modificar Oferta </button>
                            <?php
                                }
                            ?>
                        </p>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"> Ofertar </h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                            if(!$oferto) { ?> <!-- El usuario oferta por primera vez -->
                                                <?php $atributos = array('class' => 'form-horizontal', 'role' => 'form', 'onSubmit' => 'return(enviar_oferta());'); ?>
                                                <?= form_open("/subasta/agregarOferta?idSubasta=".$subasta[0]->idSubasta, $atributos) ?>
                                                <?php
                                                    $argumento = array(
                                                        'name' => 'argumento',
                                                        'class' => 'form-control',
                                                        'rows' => '2',
                                                        'maxlength' => '140',
                                                        'required' => 'required',
                                                        'placeholder' => 'Ingrese necesidad...'
                                                    );
                                                    $monto = array(
                                                        'name' => 'monto',
                                                        'class' => 'form-control',
                                                        'type' => 'number',
                                                        'min' => '1',
                                                        'max' => '1000000000000',
                                                        'required' => 'required',
                                                        'placeholder' => 'Ingrese un monto',
                                                    );
                                            }
                                            else { // El usuario modifica la oferta
                                                ?>
                                                <?php $atributos = array('class' => 'form-horizontal', 'role' => 'form', 'onSubmit' => 'return(modificar_oferta());'); ?>
                                                <?= form_open("/subasta/modificarOferta?idSubasta=".$subasta[0]->idSubasta, $atributos) ?>
                                                <?php
                                                    $argumento = array(
                                                        'name' => 'argumento',
                                                        'value' => $ofertaDelUsuario[0]->argumento,
                                                        'class' => 'form-control',
                                                        'rows' => '2',
                                                        'maxlength' => '140',
                                                        'required' => 'required',
                                                        'placeholder' => 'Ingrese necesidad...'
                                                    );
                                                    $monto = array(
                                                        'name' => 'monto',
                                                        'value' => $ofertaDelUsuario[0]->monto,
                                                        'class' => 'form-control',
                                                        'type' => 'number',
                                                        'min' => '1',
                                                        'max' => '1000000000000',
                                                        'required' => 'required',
                                                        'placeholder' => 'Ingrese un monto',
                                                    );
                                            }
                                                ?>
                                        <?= form_label('Necesidad') ?>
                                        <?= form_textarea($argumento) ?>
                                        <br>
                                        <?= form_label('Monto') ?>
                                        <?= form_input($monto) ?>
                                        <br>
                                        <?= form_submit('', 'Enviar', "class='btn btn-darkest' ") ?>
                                        <?= form_close() ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"> Cerrar </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php
                }
            }
        ?>
        <?php $atributos = array('class' => 'form-horizontal', 'role' => 'form'); ?>
        <?= form_open("subasta/comentario?idSubasta=".$subasta[0]->idSubasta, $atributos) ?>
        <?php
            $pregunta = array(
                'name' => 'comentario',
                'class' => 'form-control',
                'type' => 'text',
                'placeholder' => 'Realice su pregunta',
                'required' => 'required'
            );
        ?>
        <?php
            if(isset($this->session->userdata['login']) && ($this->session->userdata['idUsuario'] != $subasta[0]->idUsuario)) { ?> <!-- Si el usuario esta logueado y no es el dueño de la subasta puede comentar -->
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <br>
                        <?= form_input($pregunta) ?>
                        <br>
                        <center>
                            <?= form_submit('', 'Preguntar', "class='btn btn-darkest'") ?>
                        </center>
                    </div>
                </div>
        <?php
            }
        ?>
        <?= form_close() ?>
        <?php
            if($comentarios) { ?>
                <br>
                <h4 align="center"> Preguntas realizadas </h4>
                <?php
                    foreach($comentarios->result() as $comentario) {  ?>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <table border="1" style="background-color:#FFFFCC;border-collapse:collapse;border:1px solid #FFCC00;color:#000000" cellpadding="3" cellspacing="0" width="315">
                                    <tr>
                                        <td>
                                            Pregunta: <br> <label type="text"> <?= $comentario->texto ?> </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Respuesta: <br> <label type="text"> <?= $comentario->respuesta ?> </label>
                                        <?php
                                            if(isset($this->session->userdata['login'])) {
                                                if($this->session->userdata['idUsuario'] == $subasta[0]->idUsuario) { ?> <!-- Si el usuario es el dueño de la subasta puede responder comentarios -->
                                                    <?= form_open("subasta/respuesta?idSubasta=".$subasta[0]->idSubasta."&idComentario=".$comentario->idComentario); ?>
                                                    <?php
                                                        $respuesta = array(
                                                            'name' => 'respuesta'.$comentario->idComentario,
                                                            'class' => 'form-control',
                                                            'type' => 'text',
                                                            'placeholder' => 'Escriba su respuesta...',
                                                            'required' => 'required'
                                                        );
                                                    ?>
                                                    <?= form_input($respuesta); ?>
                                                    <?= form_submit('', 'Responder', "class='btn btn-darkest'"); ?>
                                                    <?= form_close() ?>
                                            <?php
                                                }
                                                else { // Caso contrario, si el usuario no es el dueño de la subasta puede eliminar sus propios comentarios
                                                    if($this->session->userdata['idUsuario'] == $comentario->idUsuario && !$comentario->respuesta) { ?> <!-- Si el comentario le pertenece al usuario actualmente logueado y no tiene respuesta puede eliminarlo -->
                                                        <?php $atributos = array('onSubmit' => 'return(eliminar_comentario());'); ?>
                                                        <?= form_open("/subasta/eliminarComentario?idSubasta=".$subasta[0]->idSubasta."&idComentario=".$comentario->idComentario, $atributos); ?>
                                                        <?= form_submit('', 'Eliminar Comentario', "class='btn btn-danger btn-xs'"); ?>
                                                        <?= form_close() ?>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <br>
            <?php
                    }
            }
            else {
            ?>
                <h3>
                    <center> No existen preguntas todavia </center>
                </h3>
                <br>
        <?php
            }
        }
        ?>

        <!-- Se carga jquery -->
        <script src="<?= base_url('js/jquery.js') ?>" type="text/javascript" charset="utf8"></script>
        <!-- Se cargan las funciones javascript de Bootstrap -->
        <script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
    </body>
    <script type="text/javascript">
        function enviar_oferta() {
            if(confirm('¿Confirma los datos ingresados?') == true) {
                alert('¡Oferta creada exitosamente!');
                return (true);
            }
            else {
                return (false);
            }
        }

        function modificar_oferta() {
            if(confirm('¿Esta seguro que desea modificar la oferta?') == true) {
                alert('¡Oferta modificada exitosamente!');
                return (true);
            }
            else {
                return (false);
            }
        }

        function eliminar_subasta() {
            if(confirm('¿Esta seguro que desea eliminar la subasta?') == true) {
                alert('¡Subasta eliminada exitosamente!');
                return (true);
            }
            else {
                return (false);
            }
        }

        function alerta_eliminar_subasta() {
            alert('La subasta no puede eliminarse debido a que tiene ofertas');
            return (false);
        }

        function eliminar_comentario() {
            if(confirm('¿Esta seguro que desea eliminar el comentario?') == true) {
                alert('¡Comentario eliminado exitosamente!');
                return (true);
            }
            else {
                return (false);
            }
        }

        function alerta_modificar_subasta() {
            alert('La subasta no puede modificarse debido a que tiene ofertas');
            return (false);
        }
    </script>
</html>