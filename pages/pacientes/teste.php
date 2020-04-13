
<div class="row">

<!-- /.panel -->
<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Timeline Prontuários
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="timeline">

                            <?php 
                            
                            

                                $query = mysqli_query($mysql_conn, "SELECT a.data, a.idprontuario, a.idpaciente, a.atendimento, b.nome, b.idpaciente FROM prontuarios AS A 
                                INNER JOIN pacientes as B ON a.idpaciente = b.idpaciente");
                                //$num_rows = mysqli_num_rows($query);
                                while($row = mysqli_fetch_assoc($query)){
                       
                            ?>
                                <li class="<?php if($row['idprontuario']  % 2 == 0)
                                     { echo 'timeline-inverted';} else {echo 'timeline-badge';} ?>">
                                    <?php if($row['idprontuario']  % 2 == 0)
                                     {
                                        
                                     }

                                    ?>
                                    <div class="timeline-badge"><i class="fa fa-check"></i>
                                    </div>
                                        
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><?php echo $row['nome']; ?></h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo $row['data']; ?></small>
                                            </p>
                                        </div>

                                        <div class="timeline-body">
                                            <p><?php echo $row['atendimento']; ?></p>
                                        </div>

                                    </div>

                                </li>
                                
                                <?php }?>
                      
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                



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



