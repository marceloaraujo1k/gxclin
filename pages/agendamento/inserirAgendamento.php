<?php
session_start();
include '../opendb.php';

include_once('../func.php');

$form=null;

if(isset($_GET["add"]))
					{
						$id = $_GET["id"];
						$query = mysqli_query($mysql_conn, "SELECT * FROM pacientes WHERE idpaciente='$id'");
						$row = mysqli_fetch_assoc($query);
						$form = $row;
						$empresa = getItensTable($mysql_conn,"empresa");
						$convenios = getItensTable($mysql_conn,"convenio");
						$profissionais = getItensTable($mysql_conn,"profissionais");
						$procedimentos = getItensTable($mysql_conn,"procedimentos");
						$statusAtendimento = array("","AGENDADO","REALIZADO","NÃO REALIZADO");
		
			}
if(isset($_GET["edit"]))
					{
						$id = $_GET["id"];
						$query = mysqli_query($mysql_conn, "SELECT agendamentos.idconsultas, agendamentos.idpaciente, agendamentos.idempresa, agendamentos.idprofissional, agendamentos.dataInicio, agendamentos.idprocedimentos,
						agendamentos.statusAtendimento, pacientes.idpaciente, pacientes.nome, pacientes.sexo, pacientes.idconvenio,
						pacientes.observacao FROM agendamentos, pacientes WHERE agendamentos.idpaciente = pacientes.idpaciente AND agendamentos.idconsultas='$id'");
						$row = mysqli_fetch_assoc($query);
						$form = $row;
						$empresa = getItensTable($mysql_conn,"empresa");
						$convenios = getItensTable($mysql_conn,"convenio");
						$profissionais = getItensTable($mysql_conn,"profissionais");
						$procedimentos = getItensTable($mysql_conn,"procedimentos");
			
										
						$statusAtendimento = array("","AGENDADO","REALIZADO","NÃO REALIZADO");
						$form["valor"]=null ;
						$form["procedimento"]=null; 
						
						$form["dataRecebimento"]=null;
			}
			
				
?>



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
                    <h1 class="page-header">Agendamento</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
		    <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Agendamento
                        </div>
                       <!-- /.panel-heading -->
						<div class="panel-body">
						<!-- informacoes do paciente -->
						<form role="form" action="./sqlAgendamento.php" method="post">
						<div class="row">
						<input type="hidden" name="idpaciente" value="<?=$form["idpaciente"]?>"> 
						<input type="hidden" name="idconsultas" value="<?=$form["idconsultas"]?>">  
					
						<div class="form-group col-md-6">
								 <label>Nome </label>
                                <input class="form-control" name="nome" value="<?=$form["nome"]?>" readonly>
                              
						</div>
						<div class="form-group col-md-2">
							  <label for="inputEstado">Sexo</label>
							   <input class="form-control" name="sexo" value="<?=$form["sexo"]?>" readonly>
						</div>
						<div class="form-group col-md-2">
						<label for="convenio">Convênio</label>
						<select id="convenio" name="idconvenio" class="form-control" onChange="getProcedimentos(this);">
						
						<option value=""></option>
						<?php
						for($i=0; $i<count($convenios); $i++)
						{
						if($form["idconvenio"] == $convenios[$i]['idconvenio'])
						{	
							$form["convenio"] = $convenios[$i]['descricao'];
						?>
						<option value="<?=$convenios[$i]['idconvenio']?>" selected><?=$convenios[$i]['descricao']?></option>
						<?php
						}
						else
						{
						?>
						<option value="<?=$convenios[$i]['idconvenio']?>" ><?=$convenios[$i]['descricao']?></option>
						<?php
						}
						}
						?>
						</select>
						</div>
								
					</div>		
					
		
						
					<div class="row">
					    <div class="form-group col-md-2">
							  <label for="inputEstado">Procedimento</label>
								<select id="procedimentos" name="idprocedimentos" class="form-control"> 
											<option value=""></option>
											<?php
											for($i=0; $i<count($procedimentos); $i++)
											{
											if (($form["idconvenio"] == $procedimentos[$i]['idconvenio']) AND ($form["idprocedimentos"] == $procedimentos[$i]['idprocedimentos']))
											{	
												$form["valor"] = $procedimentos[$i]['valor'];
												$form["procedimento"] = $procedimentos[$i]['descricao'];
												
											?>
												<option value="<?=$procedimentos[$i]['idprocedimentos']?>" selected><?=$procedimentos[$i]['descricao']?></option>
											<?php
										
											}
											else
											{
												if ($form["idconvenio"] == $procedimentos[$i]['idconvenio'])
												{
												?>
												<option value="<?=$procedimentos[$i]['idprocedimentos']?>"><?=$procedimentos[$i]['descricao']?></option>
												
											<?php
												}
											}
											}
											?>
								</select>
						</div>
						<div class="form-group col-md-2">
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
						
								<div class="form-group col-md-2">
										<label for="convenio">Profissional</label>
											<select id="profissionais"  name="idprofissional" class="form-control">
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
						
						<div class="form-group col-md-2"> 
							<label class="control-label">Data Hora Consulta</label>
							<div class='input-group date' id='datetimepicker1'>
							 <input type='text' name="dataInicio" class="form-control" value="<?=$form['dataInicio']?>" />
							 <span class="input-group-addon">
							 <span class="glyphicon glyphicon-calendar"></span>
							 </span>
						  </div>
						</div>
						<div class="form-group col-md-2">
							  <label for="inputEstado">Status Atendimento</label>
							  <select id="inputEstado" name="statusAtendimento" class="form-control" required> 
								<?php
									for($i=0; $i<count($statusAtendimento); $i++)
									{
										if($form["statusAtendimento"] == $statusAtendimento[$i])
										{
								?>
											<option value="<?=$statusAtendimento[$i]?>" selected><?=$statusAtendimento[$i]?></option>
								<?php
										}
										else
										{
								?>
											<option value="<?=$statusAtendimento[$i]?>"><?=$statusAtendimento[$i]?></option>
								<?php
										}
									}
								?>
							  </select>
							</div>
					</div>

					<div class="row">
						   <div class="form-group col-md-10">
                                            <label>Observações</label>
                                            <textarea class="form-control" name="observacao" rows="3"><?=$form["observacao"]?></textarea>
                            </div>
					    </div>					
					<div class="row"> 
							<div class="form-group col-md-6">
								<input type="submit" name="submit" value="alterar" class="btn btn-success" />
								<input type="submit" name="submit" value="inserir" class="btn btn-success" />
								<button type="button" value="deletar" class="btn btn-danger" title="Excluir Agendamento" onclick="window.open('deleteAgendamentos.php?id=<?=$form["idconsultas"]?>')">
											excluir</button>
								<?php
									if (!empty($form["idconsultas"])) {
										?>
									<button type="button" id="btnCaixa" class="btn btn btn-primary" data-id=<?=$form["idconsultas"]?> > <i class="glyphicon glyphicon-usd">&nbsp;</i>caixa</button>
								<?php 
									}
								?>
							</div>				
					</div>
					</form>
						
                </div>
                        <!-- /.panel-body -->
                </div>
		
		            <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        <!-- /#page-wrapper -->
		 </div>
    <!-- /#wrapper -->

				<div class="modal fade" id="modalReceita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="myModalLabel">Receber Pagamento</h4>
									</div>
									<div class="modal-body">
									<form role="form" action="../financeiro/sqlFinanceiro.php" method='post'>
																	
									<?php
								
									$form["valorRecebido"]=null; 
									$statusPagamento = array("EM ABERTO","RECEBIDA","SALDO DEVEDOR","CANCELADA");
									?>
								
									<input type="hidden" name="idconsultas" id="idconsultas" value="" >
									<input type="hidden" name="idempresa" id="idempresa" value="<?=$form["idempresa"]?>">
									<input type="hidden" name="tipo" id="tipo" value="RECEITA">
									
									<div class="form-group">
										<label for="nome">Cliente</label>
										   <input class="form-control" disabled name="nome" value="<?=$form["nome"]?>">
                        			</div>
									
									
									<div class="form-group">
										<label for="nome">Procedimento</label>
										   <input class="form-control"  name="procedimento" id="procedimento" value="<?=$form["procedimento"]?>">
                        			</div>
									
									<div class="form-group">
										<label for="nome">Convênio</label>
										   <input class="form-control" disabled name="convenio" value="<?=$form["convenio"]?>">
                        			</div>
									
									
									<div class="form-group">
										<label for="nome">Profissional</label>
										   <input class="form-control"  id="nomeProfissional" name="nomeProfissional" value="<?=$form['idprofissional']?>">
                        			</div>
									
											
						
								
								<div class="row">
									<div class="form-group col-sm-3">
								
										<label for="nome">Valor R$ </label>
										   <input class="form-control" 	 name="valor" id="valor" value="<?=$form["valor"]?>">
                        			</div>	
																
									<div class="form-group col-sm-3 offset-md-1">
										<label for="nome">Recebido R$ </label>
										   <input class="form-control" type="text" name="valorRecebido" id="valorRecebido" value="0"  onchange="getSaldoDevedor(this.value)">
                        			</div>
							
									<div class="form-group col-sm-3">
										<label for="nome">Desconto R$ </label>
										   <input class="form-control" type="text" name="desconto" id="desconto" value="0" onchange="getSaldoDevedor(this.value)" >
                        			</div>
									
									<div class="form-group col-sm-3">
										<label for="nome">Saldo R$ </label>
										   <input class="form-control" type="text" style="background-color:pink;" name="saldoDevedor" id="saldoDevedor" value="0">
                        			</div>
								</div>
								
								<div class="row">
										<div class="form-group col-md-6"> 
										<label class="control-label">Data Pagamento</label>
											<div class='input-group date' id='datetimepicker2'/>
											 <input type='text' class="form-control" name="dataRecebimento"/>
											<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
											</span>
										  </div>
										 </div>
										
										<div class="form-group col-md-6"> 
										<label class="control-label">Data Vencimento</label>
											<div class='input-group date' id='datetimepicker3'/>
											 <input type='text' class="form-control" name="dataVencimento"/>
											<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
											</span>
										  </div>
									 </div>  
								
								</div>
								<div class="row">
									<div class="form-group  col-md-6">
										<label for="nome">Forma de Pagamento</label>
									  <select id="formaPagamento" name="formaPagamento" class="form-control" required> 
											<option>DINHEIRO</option>
											<option>CARTÃO CRÉDITO</option>
											<option>CARTÃO DÉBITO</option>
											<option>CHEQUE</option>	
											<option>BOLETO</option>	
											<option>TRANSFERÊNCIA</option>												
									</select>
                        			</div>
									
									<div class="form-group col-md-6">
									  <label for="inputStatusPagamento">Status Pagamento</label>
									  <select id="inputStatusPagamento" name="statusPagamento" class="form-control" required> 
											<option>EM ABERTO</option>
											<option>RECEBIDA</option>
											<option>SALDO DEVEDOR</option>
											<option>CANCELADA</option>									
									</select>
									</div>
									
								</div>
								
									<div class="modal-footer">
										<button type="submit" name="submit" value="receberPagamento" class="btn btn-success">Receber</button>
										
									</form>
									</div>
									</div>
								</div>
							</div>
				
	
	
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
	
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
		
    <!-- jQuery -->
    
	    <!-- <script src="../vendor/jquery/jquery.min.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
    <!--  <script src="../vendor/bootstrap/js/bootstrap.min.js"></script> -->

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
			$('#datetimepicker1').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
     });
 });
	  </script>	
	
	
		
	<script>
		$(document).ready(function() {
			$('#datetimepicker2').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
     });
 });
	  </script>	
	
		<script>
		$(document).ready(function() {
			$('#datetimepicker3').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
     });
 });
	  </script>	
	
	<script>
		function getSaldoDevedor(val) {
		var saldo_devedor = document.getElementById("valor").value  - document.getElementById("valorRecebido").value - document.getElementById("desconto").value ;
		if (saldo_devedor > 0 ) {
			var txt;
			var r = confirm("Gerar SALDO DEVEDOR? "+saldo_devedor);
				if (r == true) {
				    document.getElementById("saldoDevedor").value = saldo_devedor;
					document.getElementById('inputStatusPagamento').selectedIndex = 2;
				} else {
					txt = "CANCELADA";
				}
			}
			else {
				document.getElementById("saldoDevedor").value = saldo_devedor;
				document.getElementById('inputStatusPagamento').selectedIndex = 1;
			}
		}
	</script>
	
		<script>
		function getDesconto(val) {
		var saldo_devedor = document.getElementById("saldo_devedor").value - val;
		if (saldo_devedor != 0 ) {
			var txt;
			var r = confirm("Gerar SALDO DEVEDOR? "+saldo_devedor);
				if (r == true) {
						document.getElementById("saldo_devedor").value = saldo_devedor;
						document.getElementById('inputStatusPagamento').selectedIndex = 2;
				} else {
					txt = "CANCELADA";
				}
			}
			else {
				
				document.getElementById('inputStatusPagamento').selectedIndex = 1;
			}
		}
	</script>
	
<script>
		$(document).on('click','#btnCaixa',function(e){
            e.preventDefault();
			var x = document.getElementById('profissionais').options[document.getElementById('profissionais').selectedIndex].text;
			document.getElementById("nomeProfissional").value = x;
			var id = $(this).data('id');
			$('#modalReceita').modal('show');
			document.getElementById('idconsultas').value=id;
		});
	</script>
</body>
</html>
