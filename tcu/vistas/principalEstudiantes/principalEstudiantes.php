<!doctype html>
<html class="no-js" lang="">
<head>
  <title>
   TCU
 </title>
 <link rel="stylesheet" href="../../css/datosProyecto.css">
</head>
<body>
 <?php
    session_start(); //iniciamos el manejo de sesiones
    if(!isset($_SESSION["codigo"])) //si la variable de sesion codigo no existe, entonces redireccionamos a la pagina de principal de invitados
    {
      header("Location: ../../index.php");
    }

    $sesionId = $_SESSION["codigo"];
    $grupo = $_SESSION["grupo"];

    include '../../header.php';
    include '../../subHeaderEstudiantes.php';
    include '../../conection.php'; //Conección a la DB


    $queryHistorialAP = "SELECT RA.version AS version, RA.ante_proyecto as cod, DATE_FORMAT(RA.fecha_revision,'%d-%m-%y / %h:%i:%s') AS fecha, E.descripcion, RA.version FROM tigrupou_tcu.grupos AS G JOIN tigrupou_tcu.revision_ante_proyecto AS RA ON G.codigo LIKE RA.ante_proyecto JOIN tigrupou_tcu.estado AS E ON E.codigo LIKE RA.estado WHERE G.codigo LIKE $grupo AND RA.rol like 1 AND RA.estado NOT LIKE 6";

    $queryHistorialRE = "SELECT  RA.version AS version, RA.resumen_ejecutivo as cod, DATE_FORMAT(RA.fecha_revision,'%d-%m-%y / %h:%i:%s') AS fecha, E.descripcion, RA.version FROM tigrupou_tcu.grupos AS G JOIN tigrupou_tcu.revision_resumen_ejecutivo AS RA ON G.codigo LIKE RA.resumen_ejecutivo JOIN tigrupou_tcu.estado AS E ON E.codigo LIKE RA.estado WHERE G.codigo LIKE $grupo AND RA.rol like 1 AND RA.estado NOT LIKE 6";

    $stmt = $db->prepare($queryHistorialAP);
    $stmt -> execute();
    $resultHistorialAP = $stmt -> fetchAll();

    $stmt = $db->prepare($queryHistorialRE);
    $stmt -> execute();
    $resultHistorialRE = $stmt -> fetchAll();

    $queryStatus = "SELECT estado FROM tigrupou_tcu.ante_proyecto WHERE grupo LIKE $grupo";
    $stmt = $db->prepare($queryStatus);
    $stmt -> execute();
    $resultStatus = $stmt -> fetchAll();

    $estado = -1;
    foreach($resultStatus as $row){
          $estado = $row["estado"];

    }

    $statusProyecto = "Sin documentos";
    if($estado == 0){
      $statusProyecto = "Ante Proyecto Creado";
    }elseif($estado == 1){
      $statusProyecto = "Ante Proyecto en Revisión";
    }elseif($estado == 3){
      $statusProyecto = "Ante Proyecto Aprobado con observaciones";
    }elseif($estado == 4){
      $statusProyecto = "Ante Proyecto Reprobado";
    }elseif($estado == 2){
      $statusProyecto = "Ante Proyecto Aprobado";
    }

    $queryStatus = "SELECT estado FROM tigrupou_tcu.resumen_ejecutivo WHERE grupo LIKE $grupo";
    $stmt = $db->prepare($queryStatus);
    $stmt -> execute();
    $resultStatus = $stmt -> fetchAll();

    $estado = -1;
    foreach($resultStatus as $row){
      $estado = $row["estado"];
    }

    $statusProyectoR = "Sin documentos";
    if($estado == 0){
      $statusProyectoR = "Resumen Ejecutivo Creado";
    }elseif($estado == 1){
      $statusProyectoR = "Resumen Ejecutivo en Revisión";
    }elseif($estado == 3){
      $statusProyectoR = "Resumen Ejecutivo Aprobado con observaciones";
    }elseif($estado == 4){
      $statusProyectoR = "Resumen Ejecutivo Reprobado";
    }elseif($estado == 2){
      $statusProyectoR = "Resumen Ejecutivo Aprobado";
    }
 ?>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
          <![endif]-->

          <!-- Add your site or application content here -->


          <main class="site-main">
            <section class="seccion-informacion">
              <div class="contenedor clearfix">
                <div class="">
                  <h2>Estatus del TCU</h2>
                  <div  class="ingreso ingresoTamano">

                      <form class="formulario">
                        <!--<li>
                           <span class="h3 orange">Estatus:</span> <span class="h2">Revisado</span>
                        </li> -->
                        <hr>
                        <p><span class="h3 orange">Revisión Ante Proyecto:</span> <b style="color: #337ab7"><?php echo $statusProyecto ?></b></p>
                        <br>
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th> Fechas     /     Hora</th>
                              <th>Estatus</th>
                              <th>Versión de Revisión</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              foreach($resultHistorialAP as $row){ ?>
                                  <tr>
                                    <td ><a class="hoverA" href="#" onclick="cargarModal({'id': <?php echo $row['cod']; ?>, 'version':<?php echo $row['version']; ?>,'tipo':1},'calificacionDiv','verCalificacion-modal','modalVerCalificacion.php')"><?php echo $row["fecha"];?></a></td>
                                    <td><?php echo $row["descripcion"];?></td>
                                    <td><?php echo $row["version"];?></td>
                                  </tr> <?php
                              }
                            ?>
                          </tbody>
                        </table>

                        <hr>
                        <p><span class="h3 orange">Revisión Resumen Ejecutivo:</span> <b style="color: #337ab7"><?php echo $statusProyectoR ?></b></p>
                        <br>
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th> Fecha     /     Hora</th>
                              <th>Estatus</th>
                              <th>Versión de Revisión</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              foreach($resultHistorialRE as $row){ ?>
                                  <tr>
                                    <td><a class="hoverA" href="#" onclick="cargarModal({'id': <?php echo $row['cod']; ?>, 'version':<?php echo $row['version']; ?>,'tipo':2},'calificacionDiv','verCalificacion-modal','modalVerCalificacion.php')"><?php echo $row["fecha"];?></a></td>
                                    <td><?php echo $row["descripcion"];?></td>
                                    <td><?php echo $row["version"];?></td>
                                  </tr> <?php
                              }
                            ?>
                          </tbody>
                        </table>
                      </form>
                  </div>
                </div><!--.programa-evento-->
              </div><!--.contenedor-->

            </section><!--.section programa-->
          </main>

          <div class="modal fade" id="verCalificacion-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content" id="addModal_content">
                <div class="modal-header" align="center">
      
                <div class="modal-body">
                  <div id="calificacionDiv"> <!--Div donde se carga el form para ingresar los datos de logueo-->
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Moda para Buscar Nombres de estudiantes-->
        <div class="modal fade bd-example-modal-xl" id="termsConditions-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:80%;">
              <div class="modal-content" id="modal_content">
                <div id="termsConditionsDiv"> <!--Div donde se carga el form para ingresar los datos -->
                </div>
              </div>
            </div>
          </div>

          <?php
            include '../../footer.php';
          ?>
          <script src="../../js/principalEstudiantes.js"></script>
          
          <script src="../../js/datosProyecto.js"></script>

          <?php
            $queryReglamento = "SELECT reglamento FROM tigrupou_tcu.estudiantes where codigo like $sesionId;";
            $stmt = $db->prepare($queryReglamento);
            $stmt -> execute();
            $resultReglamento = $stmt -> fetchAll();
            foreach($resultReglamento as $row){
                $reglamento = $row["reglamento"];
            }
            if(!$reglamento){
          ?>
            <script type="text/javascript">
                 cargarModal(null,'termsConditionsDiv','termsConditions-modal','../../vistas/reglamento/TerminosCondiciones.php');
             </script>
          <?php 
            }
          ?>
        </body>
        </html>
