<?php

  include '../../conection.php'; //Conección a la DB


  $_Date = $_POST["fecha"];
  $_Id =  $_POST["codigo"];
  $_Perm =  $_POST["tipo"]; // 0: estudiante; N: Funcionario

  $fecha = "";
  $horaIn = "";
  $horaEnd = "";
  $cantidadHoras = 0;
  $actividades = "";

  $queryActividad = "SELECT * FROM tigrupou_tcu.horas_tcu WHERE  codigo like $_Id;";
  $stmt = $db->prepare($queryActividad);
  $stmt -> execute();
  $result = $stmt -> fetchAll();
  foreach($result as $row){
      $_Date = $row["fecha"];
      $horaIn = $row["hora_entrada"];
      $horaEnd = $row["hora_salida"];
      $cantidadHoras = $row["numero_horas"];
      $actividades = $row["actividades_realizadas"];
  }
 ?>

 <form>
   <input type="hidden"  id="Codigo" value="<?php echo $_Id; ?>">

   <div class="form-group">
     <label for="exampleInputEmail1">Fecha</label>
     <input type="text" class="form-control" id="Fecha" value="<?php echo $_Date; ?>" readonly>
   </div>

   <div class="form-group">
     <label for="inTime">Hora de Entrada</label>
     <input type="time" onchange="computeHour()" class="form-control" value="<?php echo $horaIn; ?>" id="inTime">
   </div>

   <div class="form-group">
     <label for="outTime">Hora de Salida</label>
     <input type="time" onchange="computeHour()" class="form-control" value="<?php echo $horaEnd;?>" id="outTime">
   </div>

   <div class="form-group">
     <label for="quantity">Cantidad de Horas</label>
     <input type="number" class="form-control" value="<?php echo $cantidadHoras; ?>"id="quantity" readonly>
   </div>

   <div class="form-group">
     <label for="actividadesR">Actividades</label>
     <textarea class="form-control" id="actividadesR" rows="3"><?php echo $actividades ?></textarea>
   </div>
   
   <?php 
    if($_Perm == 0){
      if ($_Id != 0){?>
        <p align="right">
          <a  class="btn btn-danger" onclick="eliminarActividad(<?php echo $_Perm ?>)"><i class="fas fa-times"></i> Eliminar</a>
          <a  class="btn btn-primary" onclick="agregarActividad(<?php echo $_Perm ?>)"><i class="fas fa-edit"></i> Editar</a>
        </p>
       <?php }else{ ?>
        <p align="right">
          <a  class="btn btn-primary" onclick="agregarActividad(<?php echo $_Perm ?>)"><i class="far fa-save"></i> Confirmar</a>
        </p>
       <?php }
    }else{ ?> 
      <p align="right">
          <a  class="btn btn-danger" class="close" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</a>
      </p>  <?php
    } ?>
    


 </form>
