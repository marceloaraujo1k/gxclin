<?php
session_start();
include '../opendb.php';
include_once('../func.php');



$totalPacientes=count(getItensTable($mysql_conn,"pacientes"));
$totalAgendamentos=count(getItensTable($mysql_conn,"agendamentos"));




$totalProntuarios = count(getItensTable($mysql_conn, "prontuarios"));
//$totalProntuarios=is_array((count(getItensTable($mysql_conn,"prontuarios"))) ? ($totalProntuarios=count(getItensTable($mysql_conn,"prontuarios"))) : $totalProntuarios=0);
 //if(isset($totalProntuarios->num_rows) && $totalProntuarios->num_rows > 0){
 //       $totalProntuarios = $totalProntuarios->fetch_array(MYSQLI_ASSOC);
 //}
 
$documentos=null;
$documentos=(getItensTable($mysql_conn,"documentos"));


$query = mysqli_query($mysql_conn, "SELECT format(SUM(valorRecebido),2,'de_DE') AS total FROM financeiro WHERE tipo='RECEITA' AND statusPagamento='RECEBIDA' AND DAY(dataRecebimento)=DAY(NOW()) AND MONTH(dataRecebimento)=MONTH(NOW()) GROUP BY DAY(dataRecebimento);");
$row = mysqli_fetch_assoc($query);
$totalFaturamentoDia = $row['total'];


$query = mysqli_query($mysql_conn, "SELECT format(SUM(valorRecebido),2,'de_DE') AS total FROM financeiro WHERE tipo='RECEITA' AND statusPagamento='RECEBIDA' AND MONTH(dataRecebimento)=MONTH(NOW()) GROUP BY MONTH(dataRecebimento);");
$row = mysqli_fetch_assoc($query);
$totalFaturamento = $row['total'];

$query = mysqli_query($mysql_conn, "SELECT format(SUM(valorRecebido),2,'de_DE') AS total FROM financeiro WHERE tipo='DESPESA' AND statusPagamento='RECEBIDA' AND MONTH(dataRecebimento)=MONTH(NOW()) GROUP BY MONTH(dataRecebimento);");
$row = mysqli_fetch_assoc($query);
$totalDespesas = $row['total'];



?>


<!-- LINKS UTEIS
 https://www.webslesson.info/2017/03/morrisjs-chart-with-php-mysql.html -->


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

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

   <div id="wrapper">
    <!-- Navigation -->
	<!-- INCLUSÃO DO ARQUIVO MENU -->
		<?php include_once('../menu.php'); ?>
	       
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$totalPacientes?></div>
                                    <div>Pacientes</div>
                                </div>
                            </div>
                        </div>
                        <a href="../pacientes/pacientes.php">
                            <div class="panel-footer">
                                <span class="pull-left">Detalhar</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-calendar fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$totalAgendamentos?></div>
                                    <div>Agendamentos</div>
                                </div>
                            </div>
                        </div>
                        <a href="../agendamento/agendamento.php">
                            <div class="panel-footer">
                                <span class="pull-left">Detalhar</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$totalProntuarios?></div>
                                    <div>Prontuários</div>
                                </div>
                            </div>
                        </div>
                        <a href="">
                            <div class="panel-footer">
                                <span class="pull-left">        </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                		 <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Notificações
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
								<?php
							
								if (!empty($documentos)) {
								for($i=0; $i<count($documentos); $i++)
								{
								?>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-comment fa-fw"></i><?=$documentos[$i]['descricao']?>
                                    <span class="pull-right text-muted small"><em><?=$documentos[$i]['data']?></em>
                                    </span>
                                </a>
								<?php
								}
								}
								else 
								{ 
								?>
								  <a href="#" class="list-group-item">
                                    <i class="fa fa-comment fa-fw"></i> SEM NOTIFICAÇÕES
                                    <span class="pull-right text-muted small"><em></em>
                                    </span>
                                </a>
								<?php
								}
								
								?>
                            </div>
                            <!-- /.list-group -->
                            <a href="documentos.php" class="btn btn-default btn-block">Ver Documentos</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
            </div>
            </div>
			     <div class="row">
				         <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-3x"><b> R$</b> </i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"> <?php echo $totalFaturamentoDia?></div>
                                    <div>Faturamento/dia</div>
                                </div>
                            </div>
                        </div>
                        <a href="../financeiro/financeiro.php">
                            <div class="panel-footer">
                                <span class="pull-left">Detalhar</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                   <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-3x"><b>R$</b> </i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"> <?php echo $totalFaturamento?></div>
                                    <div>Faturamento/mês</div>
                                </div>
                            </div>
                        </div>
                        <a href="../financeiro/financeiro.php">
                            <div class="panel-footer">
                                <span class="pull-left">Detalhar</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
         
           
             <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-3x"><b>R$</b> </i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"> <?php echo $totalDespesas?></div>
                                    <div>Despesas/mês</div>
                                </div>
                            </div>
                        </div>
                        <a href="../financeiro/financeiro.php">
                            <div class="panel-footer">
                                <span class="pull-left">Detalhar</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
				  <div id="bar-example">
				 
				  </div>
                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
		
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

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

	<script>
	$(document).ready(function() {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var result = JSON.parse(this.responseText);
	}
		
		};
		xmlhttp.open("GET", "proc_dashboard.php");
		xmlhttp.send();
		});
    </script>
 
	
</body>

</html>