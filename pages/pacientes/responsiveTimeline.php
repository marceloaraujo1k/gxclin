<?php 

session_start();
if((!isset ($_SESSION['user']) == true) and (!isset ($_SESSION['idempresa']) == true))
{
  unset($_SESSION['user']);
  unset($_SESSION['idempresa']);
  session_destroy();
  header('location:../login.php');
  }
  
include '../opendb.php';
?>

<html>


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>responsiveTimeline</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

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

</body>

</html>