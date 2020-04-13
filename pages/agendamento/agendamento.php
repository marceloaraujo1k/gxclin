<?php
session_start();

include '../opendb.php';
include_once('../func.php');

$empresa = getItensTable($mysql_conn,"empresa");
$agendamentos = getItensTable($mysql_conn,"agendamentos");
$pacientes = getItensTable($mysql_conn,"pacientes");
$profissionais = getItensTable($mysql_conn,"profissionais");
$convenios = getItensTable($mysql_conn,"convenio");

$procedimentos = getItensTable($mysql_conn, "procedimentos");
					
$empresa2 = $_SESSION['idempresa'];
$funcao = $_SESSION['idfuncao'];
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	

				<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
				<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
				<!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->
				<script src='../../js/jquery-ui.min.js'></script>
				<link href='../../css/fullcalendar.min.css' rel='stylesheet' />
				<link href='../../css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
				<script src='../../lib/moment.min.js'></script>

				<script >//src='../../lib/jquery.min.js'</script>
				
				
				

				<script src='../../js/fullcalendar.min.js'></script>
				<link href='../../css/personalizado.css' rel='stylesheet' />
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />

			<script src='../../locale/pt-br.js'></script>

			

			<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<style>

.fc-time-grid .fc-slats td{
	height: 4em !important;
}

</style>

	<script>
		$(document).ready(function() {
				$('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},

					defaultDate: Date.now(),
					navLinks: true, // can click day/week names to navigate views
					editable: true,
					eventLimit: true, // allow "more" link when too many events
					events: [	
						<?php
							 
							if(isset($_GET['idempresa2']) && !empty($_GET['idempresa2'])){
								
								if($_GET['idempresa2']!=null){
								$idempresa = $_GET['idempresa2'];	
								$query = "SELECT a.idpaciente,a.idempresa, a.idconsultas, a.dataInicio, a.dataFim, a.cor, b.nome, c.profissional, d.empresa FROM agendamentos AS a INNER JOIN pacientes AS b 
								ON a.idpaciente = b.idpaciente INNER JOIN profissionais AS c 
								ON a.idprofissional = c.idprofissional INNER JOIN empresa AS d ON a.idempresa = d.idempresa WHERE a.idempresa = $idempresa";
								$result = mysqli_query($mysql_conn, $query);
								while($row = mysqli_fetch_assoc($result))
								{
									if($funcao == 0){

									
									
								?>
								{ 
								id: '<?php echo $row['idpaciente']; ?>',
								
											
								title: '<?php echo $row['nome']; ?>',
								description: ' <?php echo $row['profissional']; ?>',
								subtitle:'<?php echo $row['empresa'];?>',
								
								url: './inserirAgendamento.php?edit&id='+'<?php  echo $row['idconsultas']; ?>',
								start: '<?php echo date("D, d M Y H:i:s O", strtotime($row['dataInicio']));?>',
								end: '<?php echo date("D, d M Y H:i:s O", strtotime($row['dataFim'])); ?>',
								
								color: '<?php echo $row['cor']; ?>'
								
								},

								<?php
								}else if($empresa2 == $row['idempresa']){

								?>	
								{
								id: '<?php echo $row['idpaciente']; ?>',
								
											
								title: '<?php echo $row['nome']; ?>',
								description: ' <?php echo $row['profissional']; ?>',
								subtitle:'<?php echo $row['empresa'];?>',
								
								url: './inserirAgendamento.php?edit&id='+'<?php  echo $row['idconsultas']; ?>',
								start: '<?php echo date("D, d M Y H:i:s O", strtotime($row['dataInicio']));?>',
								end: '<?php echo date("D, d M Y H:i:s O", strtotime($row['dataFim'])); ?>',
								
								color: '<?php echo $row['cor']; ?>'
								
								},
								<?php
								}
							}
							}
						} else if(isset($_GET['idprofissional2']) && !empty($_GET['idprofissional2'])){
								if($_GET['idprofissional2']!=null){
								$idempresa = $_GET['idprofissional2'];	
								$query = "SELECT a.idpaciente,a.idempresa, a.idconsultas, a.dataInicio, a.dataFim, a.cor, b.nome, c.profissional, d.empresa FROM agendamentos AS a INNER JOIN pacientes AS b 
								ON a.idpaciente = b.idpaciente INNER JOIN profissionais AS c 
								ON a.idprofissional = c.idprofissional INNER JOIN empresa AS d ON a.idempresa = d.idempresa WHERE a.idprofissional = $idempresa";
								$result = mysqli_query($mysql_conn, $query);
								while($row = mysqli_fetch_assoc($result))
								{
									if($funcao == 0){

									
									
								?>
								{ 
								id: '<?php echo $row['idpaciente']; ?>',
								
											
								title: '<?php echo $row['nome']; ?>',
								description: ' <?php echo $row['profissional']; ?>',
								subtitle:'<?php echo $row['empresa'];?>',
								
								url: './inserirAgendamento.php?edit&id='+'<?php  echo $row['idconsultas']; ?>',
								start: '<?php echo date("D, d M Y H:i:s O", strtotime($row['dataInicio']));?>',
								end: '<?php echo date("D, d M Y H:i:s O", strtotime($row['dataFim'])); ?>',
								
								color: '<?php echo $row['cor']; ?>'
								
								},

								<?php
								}else if($empresa2 == $row['idempresa']){

								?>	
								{
								id: '<?php echo $row['idpaciente']; ?>',
								
											
								title: '<?php echo $row['nome']; ?>',
								description: ' <?php echo $row['profissional']; ?>',
								subtitle:'<?php echo $row['empresa'];?>',
								
								url: './inserirAgendamento.php?edit&id='+'<?php  echo $row['idconsultas']; ?>',
								start: '<?php echo date("D, d M Y H:i:s O", strtotime($row['dataInicio']));?>',
								end: '<?php echo date("D, d M Y H:i:s O", strtotime($row['dataFim'])); ?>',
								
								color: '<?php echo $row['cor']; ?>'
								
								},
								<?php
								}
							}
							}
						} 
							else{
								$query = "SELECT a.idpaciente,a.idempresa, a.idconsultas, a.dataInicio, a.dataFim, a.cor, b.nome, c.profissional, d.empresa FROM agendamentos AS a 
								INNER JOIN pacientes AS b ON a.idpaciente = b.idpaciente INNER JOIN profissionais AS c ON a.idprofissional = c.idprofissional INNER JOIN empresa AS d ON a.idempresa = d.idempresa";
								$result = mysqli_query($mysql_conn, $query);
								while($row = mysqli_fetch_assoc($result))
								{
									if($funcao == 0){

									
									
								?>
								{ 
								id: '<?php echo $row['idpaciente']; ?>',
								
											
								title: '<?php echo $row['nome']; ?>',
								description: ' <?php echo $row['profissional']; ?>',
								subtitle:'<?php echo $row['empresa'];?>',
								
								url: './inserirAgendamento.php?edit&id='+'<?php  echo $row['idconsultas']; ?>',
								start: '<?php echo date("D, d M Y H:i:s O", strtotime($row['dataInicio']));?>',
								end: '<?php echo date("D, d M Y H:i:s O", strtotime($row['dataFim'])); ?>',
								
								color: '<?php echo $row['cor']; ?>'
								
								},

								<?php
								}else if($empresa2 == $row['idempresa']){

								?>	
								{
								id: '<?php echo $row['idpaciente']; ?>',
								
											
								title: '<?php echo $row['nome']; ?>',
								description: ' <?php echo $row['profissional']; ?>',
								subtitle:'<?php echo $row['empresa'];?>',
								
								url: './inserirAgendamento.php?edit&id='+'<?php  echo $row['idconsultas']; ?>',
								start: '<?php echo date("D, d M Y H:i:s O", strtotime($row['dataInicio']));?>',
								end: '<?php echo date("D, d M Y H:i:s O", strtotime($row['dataFim'])); ?>',
								
								color: '<?php echo $row['cor']; ?>'
								
								},
								<?php
								}
							}
						}
						?>
					],
					
					

					eventRender: function(event, element) { 
					element.find('.fc-title').append("<br/>" + event.description);
            		element.find('.fc-title').append("<br/>" + event.subtitle); 
					


					
					}
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

<style>
.ui-autocomplete {
	z-index: 2000;
}
</style>


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
							  <div class="col-lg-5">
								<button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgendamento">
									Novo Agendamento</button>

									
										<button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFiltragem">
									Filtrar</button>
								</div>

								<div class="col-lg-10">
  									
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
	
					<!-- Modal Agendamento -->
					<div class="modal fade" id="modalAgendamento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="myModalLabel">Inserir agendamento</h4>
									</div>
									<div class="modal-body">
								 <form role="form" action="proc_agendamento.php" method='post' enctype="multipart/form-data">
					
								<div class="row">
								
									<div class="form-group">
										<div class="form-group col-md-5"> 
										<label for="nome">CPF</label>
										   <input class="form-control" id="searchCpf" placeholder="CPF" name="searchCpf" value="">
										   
									</div>
									
									<input type="hidden" id="idpaciente" name="idpaciente">
									
									<div class="form-group col-md-6"> 
										<label for="nome">Nome</label>
										   <input class="form-control" id="searchNome" placeholder="Nome" name="nome" value="">
										   
									</div>
									
										<div class="form-group col-md-5"> 
										<label for="telefone">Telefone</label>
										   <input class="form-control" id="searchTelefone" name="telefone" placeholder="Telefone" value="">
										</div>
										
										<div class="form-group col-md-6">
											<label for="convenio">Procedimento</label>
											<select id="procedimento" name="idprocedimento" class="form-control" onChange="getProcedimentos(this);">
											
											<option value=""></option>
											<?php
											for($i=0; $i<count($procedimentos); $i++)
											{
											
											?>
											<option value="<?=$procedimentos[$i]['idprocedimentos']?>" selected><?=$procedimentos[$i]['descricao']?></option>
											<?php
											
											
											?>
											
											<?php
											
											}
											?>
											</select>
									</div>
  									</div>
								</div>


								<div class="row">
								<div class="form-group">
								
										<div class="input-daterange">
										<div class="form-group col-md-5"> 
											<label class="control-label">Data Hora consulta</label>
											<div class='input-group date' id="start_date_report">
											 <input type='text' name="start_date_report" class="form-control"/>
											 <span class="input-group-addon">
											 <span class="glyphicon glyphicon-calendar"></span>
											 </span>
										  </div>
										</div>
											<div class="form-group col-md-6">
												<label for="convenio">Clínica</label>
												<select id="empresa" name="idempresa" class="form-control">
													<option value=""></option>
													<?php
													for($i=0; $i<count($empresa); $i++)
													{
													if($form["idempresa"] == $empresa[$i]['idempresa'])
													{	
													?>
													<option value="<?=$empresa[$i]['idempresa']?>" selected><?=$empresa[$i]['empresa']?></option>
													<?php
													}
													else
													{
													?>
													<option value="<?=$empresa[$i]['idempresa']?>" ><?=$empresa[$i]['empresa']?></option>
													<?php
													}
													}
													?>
												</select>
											</div>
									</div>
								</div>						
							
								</div> 

								<div class="row">
									<div class="form-group">
									<div class="form-group col-md-5">
										<label for="convenio">Profissional</label>
											<select id="profissionais" name="idprofissional" class="form-control">
											<option value=""></option>
											<?php
											for($i=0; $i<count($profissionais); $i++)
											{
											if($form["idprofissional"] == $profissionais[$i]['idprofissional'])
											{	
											?>
											<option value="<?=$profissionais[$i]['idprofissional']?>" selected><?=$profissionais[$i]['profissional']?></option>
											<?php
											}
											else
											{
											?>
											<option value="<?=$profissionais[$i]['idprofissional']?>" ><?=$profissionais[$i]['profissional']?></option>
											<?php
											}
											}
											?>
										</select>
									</div>
									<div class="form-group col-md-6">
											<label for="convenio">Convênio</label>
											<select id="convenio" name="idconvenio" class="form-control" onChange="getProcedimentos(this);">
											
											<option value=""></option>
											<?php
											for($i=0; $i<count($convenios); $i++)
											{
											
											?>
											<option value="<?=$convenios[$i]['idconvenio']?>" selected><?=$convenios[$i]['descricao']?></option>
											<?php
											
											
											?>
											
											<?php
											
											}
											?>
											</select>
											</div>

											
									</div>
								</div>

								
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Agendar</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>	

			<!-- /Modal Agendamento -->


			<!-- Modal Filtragem -->
			<div class="modal fade" id="modalFiltragem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="myModalLabel">Filtrar por Clínica ou Profissional</h4>
									</div>
									<div class="modal-body">
								 <form role="form" action="agendamento.php" method='GET' enctype="multipart/form-data">
								 <?php if($funcao == 0){ ?>
								<div class="row">
								<div class="form-group">
								
										<div class="input-daterange">
										
											<div class="form-group col-md-6">
												<label for="convenio">Clínica</label>
												<select id="empresa2" name="idempresa2" class="form-control">
													<option value="">Todos</option>
													<?php
													for($i=0; $i<count($empresa); $i++)
													{
													if($form["idempresa"] == $empresa[$i]['idempresa'])
													{	
													?>
													<option value="<?=$empresa[$i]['idempresa']?>" selected><?=$empresa[$i]['empresa']?></option>
													<?php
													}
													else
													{
													?>
													<option value="<?=$empresa[$i]['idempresa']?>" ><?=$empresa[$i]['empresa']?></option>
													<?php
													}
													}
													?>
												</select>
											</div>
									</div>
								</div>						
							
								</div> 
												<?php } ?>
							
								<div class="row">
									<div class="form-group">
									<div class="form-group col-md-6">
										<label for="convenio">Profissional</label>
											<select id="profissionais2" name="idprofissional2" class="form-control">
											<option value="0">Todos</option>
											<?php
											for($i=0; $i<count($profissionais); $i++)
											{
											if($form["idprofissional"] == $profissionais[$i]['idprofissional'])
											{	
											?>
											<option value="<?=$profissionais[$i]['idprofissional']?>" selected><?=$profissionais[$i]['profissional']?></option>
											<?php
											}
											else
											{
											?>
											<option value="<?=$profissionais[$i]['idprofissional']?>" ><?=$profissionais[$i]['profissional']?></option>
											<?php
											}
											}
											?>
										</select>
									</div>
									</div>
								</div>
										
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Filtrar</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>		
			<!-- /Modal Filtragem -->

			
	
			
		<!-- AUTOCOMPLETE BOOTSTRAP -->
	
		
	
		

			<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
			

    <!-- jQuery - NECESSÁRIO DESABILITAR O JQUERY PERTENCENTE AO BOOTSTRAP -->
	
	<!--   <script src="../vendor/jquery/jquery.min.js"></script>-->

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

<script>
		$(document).ready(function() {
			$('#start_date_report').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
     });
 });
	  </script>	

<script type="text/javascript">

	$(document).ready(function($){
		$("#searchCpf").mask("999.999.999-99");
	});

</script>

<script>
// search Paciente by CPF
$( function() {
      $( "#searchCpf" ).autocomplete({
		
			minLength: 3,
			delay: 300,
            source: function( request, response ) {
                $.ajax({
                    url: "fetchData.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        searchcpf: request.term
                    },
                    success: function( data ) {
						let a = [];
						
						for (let result of data) {
							let cpf = result.cpf ;
							//console.log(result.convenio);
							a.push({
								label: cpf +'<br><small class="text-muted">' + result.nome + '</small>',
								value: cpf,
								nome: result.nome,
								telefone: result.telefone,
								id: result.idpaciente,
								convenio: result.convenio
								
							});
							
						}
						response(a);
					}
						
                    
                });
            },
		//	appendTo: "#modalReceita",
		
            select: function (event, ui) {
				
				$('#searchCpf').val(ui.item.value); // display the selected text
				console.log("Evento:", event);
				console.log("UI:", ui);
				$('#idpaciente').val(ui.item.id);	
				$('#searchNome').val(ui.item.nome);
				$('#searchTelefone').val(ui.item.telefone);
				$('#convenio').val(ui.item.convenio);
			    return false;
            }
        });

    });	
</script>


	  

<script>
	function relatorios() {
		$(document).on('click','#btn',function(e){
			e.preventDefault();
					var start = $('#start_date_report').data('DateTimePicker').date().toString();
					var date = new Date(start);
					var start_date = date.getFullYear()+'-'+(date.getMonth() + 1) + '-' + date.getDate();
				
					var end = $('#end_date_report').data('DateTimePicker').date().toString();
					var date = new Date(end);
					var end_date = date.getFullYear()+'-'+(date.getMonth() + 1) + '-' + date.getDate();
				//	var statusPagamento = $("#statusPagamento").find('option:selected').text();
				//	window.open("relatorioFinanceiro.php?statusPagamento="+statusPagamento+"&start_date="+start_date+"&end_date="+end_date);
					window.open("relatorioFinanceiro.php?start_date="+start_date+"&end_date="+end_date);
					
					});
				}
</script>
	
</body>

</html>
