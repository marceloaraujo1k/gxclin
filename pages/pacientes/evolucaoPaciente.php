<?php 
				include '../opendb.php';
				include_once('../func.php');
										$id = $_GET["id"];						
										$query = mysqli_query($mysql_conn, "SELECT * FROM pacientes WHERE idpaciente='$id'");
										$row = mysqli_fetch_assoc($query);
										$form = $row;
										//printf("%s", $form['nome']);
								?>


<div class="row">

<!-- /.panel -->
<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Timeline 
                        </div>
                <div class="table-responsive">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="timeline">

                            <?php 
                            
                            

                                $query = mysqli_query($mysql_conn, "SELECT * FROM evolucao AS a INNER JOIN pacientes AS b ON a.idpaciente = b.idpaciente and a.idpaciente = $id 
                                ORDER BY data DESC");
                                //$num_rows = mysqli_num_rows($query);
                                while($row = mysqli_fetch_assoc($query)){
                       
                            ?>
                                <li class="<?php if($row['idevolucao']  % 2 == 0)
                                     { echo 'timeline-inverted';} else {echo 'timeline-badge';} ?>">
                                    <?php if($row['idevolucao']  % 2 == 0)
                                     {
                                        
                                     }

                                    ?>
                                    <div class="timeline-badge"><i class="fa fa-check"></i>
                                    </div>

                                     <?php if($row['tipoNome'] == 'anamnese'){

                                     ?>   

                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><?php echo $row['tipoNome']?></h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo date('d/m/Y', strtotime($row["data"])); ?> </small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $row['qp']; ?></p>
                                            <p><?php echo $row['hda']; ?></p>
                                            <p><?php echo $row['ap']; ?></p>
                                            <p><?php echo $row['af']; ?></p>
                                            
                                        </div>   
                                    </div>
                                     <?php }?>

                                     <?php if($row['tipoNome'] == 'avaliacao'){

                                     ?>   

                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><?php echo $row['tipoNome']?></h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo date('d/m/Y', strtotime($row["data"])); ?> </small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $row['avaliacao']; ?></p>
                                            
                                            
                                        </div>   
                                    </div>
                                     <?php }?>

                                     <?php if($row['tipoNome'] == 'prontuario'){

                                     ?>   

                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><?php echo $row['tipoNome']?></h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo date('d/m/Y', strtotime($row["data"])); ?> </small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $row['atendimento']; ?></p>
                                            
                                            
                                        </div>   
                                    </div>
                                     <?php }?>
                                </li>
                                
                                <?php }?>
                      
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                </div>



<!-- jQuery -->
<script src="../../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="../../vendor/raphael/raphael.min.js"></script>
<script src="../../vendor/morrisjs/morris.min.js"></script>
<script src="../../data/morris-data.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../../dist/js/sb-admin-2.js"></script>



