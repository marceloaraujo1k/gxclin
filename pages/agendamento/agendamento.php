<?php

include '../opendb.php';
include_once('../func.php');

$empresa = getItensTable($mysql_conn,"empresa");
$agendamentos = getItensTable($mysql_conn,"agendamentos");
$pacientes = getItensTable($mysql_conn,"pacientes");
		
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

				<link href='../../css/fullcalendar.min.css' rel='stylesheet' />
				<link href='../../css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
				<script src='../../lib/moment.min.js'></script>
				<script src='../../lib/jquery.min.js'></script>
				<script src='../../js/fullcalendar.min.js'></script>
				<link href='../../css/personalizado.css' rel='stylesheet' />
							
			<script src='../../locale/pt-br.js'></script>
	
	<script>
	
		$(document).ready(function() {
				$('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},

					defaultDate: Date(),
					navLinks: true, // can click day/week names to navigate views
					editable: true,
					eventLimit: true, // allow "more" link when too many events
					events: [
						<?php
							for($i=0; $i<count($agendamentos); $i++)
								{
								?>
								{
								id: '<?php echo $agendamentos[$i]['idpaciente']; ?>',
								<?php for($j=0; $j<count($pacientes); $j++)
											{
												if($agendamentos[$i]['idpaciente'] == $pacientes[$j]['idpaciente'])
												{ 
											?>	
												title: '<?php echo $pacientes[$j]['nome']; ?>',
										<?php	
												} 
											}
										?>
								url: './inserirAgendamento.php?edit&id='+'<?php  echo $agendamentos[$i]['idconsultas']; ?>',
								start: '<?php echo $agendamentos[$i]['dataInicio']; ?>',
								end: '<?php echo $agendamentos[$i]['dataFim']; ?>',
								color: '<?php echo $agendamentos[$i]['cor']; ?>'
								},
								<?php
							}
						?>
					]
				});
			})

</script>

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


<style>

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>	

 
<body>
   <div id="wrapper">
							
            <!-- Navigation -->
     <!-- INCLUSÃO DO ARQUIVO MENU -->
	<?php include_once('../menu.php'); ?>
	<div id="page-wrapper">

		<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Agenda</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
					
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 <!-- /.panel-heading -->
                      	<div class="row">
						 <div class="col-lg-12">
							<br>
							<br>
						 </div>
						
						</div>
				
						</div>
				<div class="row">
                <div class="col-lg-12">
					<br>
					<div id='calendar'>
					</div>
		        </div>
                <!-- /.col-lg-12 -->
            </div>
			<!-- /#wrapper -->
	</div>
	
			
    <!-- jQuery - NECESSÁRIO DESABILITAR O JQUERY PERTENCENTE AO BOOTSTRAP -->
	
	<!--   <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>


	
</body>

</html>
