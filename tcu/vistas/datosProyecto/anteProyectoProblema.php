<?php
  session_start();
  $sesionId = $_SESSION["codigo"];
  $grupo = $_SESSION["grupo"];
    include '../../conection.php'; //Conección a la DB
      $query = "select grupo, identificacion_problema,descripcion_problema from tigrupou_tcu.ante_proyecto where grupo like $grupo;";
      $stmt = $db->prepare($query);
      $stmt -> execute();
      $result = $stmt -> fetchAll();
      $identificacionProblema = "";
      $descripcionProblema = "";
      $codigo = "";
      foreach($result as $row){
      	  $codigo = $row["grupo"];
          $identificacionProblema = $row["identificacion_problema"];
          $descripcionProblema = $row["descripcion_problema"];
      }
 ?>

<label for="identificacionProblema">IDENTIFICACION DEL PROBLEMA</label>
	<input type="hidden" name="hiddenCodigo" id="hiddenCodigo" value="<?php echo $codigo?>">
    <textarea  id="identificacion_problema"
          style="font-size:15px; font-family:Arial; text-align : justify;line-height: 1.6; resize:none;"
                rows="15" cols="87" maxlength="1305"><?php echo $identificacionProblema ?></textarea>

    <label for="identificacionProblema2">DESCRIPCION DEL PROBLEMA</label>
    <textarea  id="descripcion_problema" onkeypress="return limitTextArea(event,this.value,21)"
          style=" overflow:hidden; font-size:15px; font-family:Arial; text-align : justify;line-height: 1.6;"
                rows="21" cols="87" maxlength="1827" > <?php echo $descripcionProblema ?> </textarea>

<br>
    <button class="btn" onclick="cargarFormularios('anteProyectoBeneficiario.php','contenedorAnteProyecto');
                                    aumentarProgress(20); guardar('identificacion_problema',<?php echo $grupo ?>,1);
                                          guardar('descripcion_problema',<?php echo $grupo ?>,1)"
                                              style="margin-left:74% !important">Continuar
                                                  <span class="glyphicon glyphicon-arrow-right"></span></button>
