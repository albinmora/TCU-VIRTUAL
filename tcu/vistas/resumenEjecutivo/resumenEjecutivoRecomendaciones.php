<?php
  session_start();
  $sesionId = $_SESSION["codigo"];
  $grupo = $_SESSION["grupo"]; 
 
?>

<?php 
    include '../../conection.php'; //Conección a la DB

      $query = "SELECT codigo, recomendaciones FROM tigrupou_tcu.resumen_ejecutivo where grupo like $grupo;";
      $stmt = $db->prepare($query);
      $stmt -> execute();
      $result = $stmt -> fetchAll();

      $recomendaciones = "";
      $codigo = "";
      foreach($result as $row){
      	  $codigo = $row["codigo"];
          $recomendaciones = $row["recomendaciones"];
      }
 ?>


<label for="recomendaciones">RECOMENDACIONES</label>
	<input type="hidden" name="hiddenCodigo" id="hiddenCodigo" value="<?php echo $codigo?>">
    <textarea  id="recomendaciones" style=" overflow:hidden; font-size:15px; font-family:Arial; text-align : justify;line-height: 1.6; resize:none;" rows="20" cols="87"><?php echo $recomendaciones  ?></textarea>

<br>
      
  <div class="row">
    <div class="col-md-6">
      <button class="btn btn-warning" onclick="guardar('recomendaciones',<?php echo $grupo ?>,2); cargarFormularios('resumenEjecutivoConclusion.php','contenedorResumenEjecutivo'); disminuirProgress(25);"><span class="glyphicon glyphicon-arrow-left"> </span>Atrás</button>
    </div>
    <div class="col-md-6">
      <button class="btn" onclick="cargarModal(null,'mostrarModalConclusion','modalAdjuntarConclusion','modalAdjuntarConclusion.php');" style="margin-left:50% !important">ENVIAR</button>
    </div>
  </div>