<?php
  session_start();
  include '../../conection.php'; //Conección a la DB

  $sesionId = $_SESSION["codigo"];
  $grupo = $_SESSION["grupo"];

  /**
   * Codigo para verificar el estado del resumen Ejecutivo y así 
   * dar acceso al usuario a las distintas opciones del menú.
   */
  $queryResumenEjecutivoStatus = "SELECT estado FROM tigrupou_tcu.resumen_ejecutivo WHERE grupo LIKE $grupo";
  $stmt = $db->prepare($queryResumenEjecutivoStatus);
  $stmt -> execute();
  $resultResumenEjecutivoStatus = $stmt -> fetchAll();
  $estatusResumenEjecutivo = "";
  foreach ($resultResumenEjecutivoStatus as $row) {
    $estatusResumenEjecutivo = $row["estado"];
  }
  if($estatusResumenEjecutivo == '1' or $estatusResumenEjecutivo == '2'){
    ?>
      <script>
        setReadOnly('resumen_actividades');
      </script>
      <?php
  }

      $query = "SELECT grupo, resumen_actividades FROM tigrupou_tcu.resumen_ejecutivo where grupo like $grupo;";
      $stmt = $db->prepare($query);
      $stmt -> execute();
      $result = $stmt -> fetchAll();

      $resumen_actividades = "";
      $codigo = "";
      foreach($result as $row){
      	  $codigo = $row["grupo"];
          $resumen_actividades = $row["resumen_actividades"];
      }

 ?>


<label for="identificacionProblema">RESUMEN DE LAS ACTIVIDADES REALIZADAS DURANTE EL TCU</label>
<input type="hidden" name="hiddenCodigo" id="hiddenCodigo" value="<?php echo $codigo?>">
<textarea  id="resumen_actividades"
          style=" overflow:hidden; font-size:15px; font-family:Arial; text-align : justify;line-height: 1.6; resize:none;"
                rows="84" cols="87" maxlength="7308"><?php echo $resumen_actividades ?></textarea>
<br>

<a class="btn btn" href="#"
      onclick="guardar('resumen_actividades',<?php echo $grupo ?>,2,'resumenEjecutivoEvaluacion.php','contenedorResumenEjecutivo');
                    aumentarProgress(25);"
              style="margin-left:74% !important">Continuar  <span class="glyphicon glyphicon-arrow-right"></span></a>
