<?php
/* Informa o nível dos erros que serão exibidos */
error_reporting(E_ALL);

/* Habilita a exibição de erros */
ini_set("display_errors", 1);

/* Valida usuário - empresa - função */
session_start();
if((!isset ($_SESSION['user']) == true) and (!isset ($_SESSION['idempresa']) == true))
{
  unset($_SESSION['user']);
  unset($_SESSION['idempresa']);
  session_destroy();
  header('location:../login.php');
  }
 
include '../opendb.php';
include_once('../func.php');

$empresa = getItensTable($mysql_conn,"empresa");
$hospital = getItensTable($mysql_conn,"hospital");
$pacientes = getItensTable($mysql_conn,"pacientes");
$medicos = getItensTable($mysql_conn,"medicos");
$convenios = getItensTable($mysql_conn,"convenio");

$form["nome"]=null;
$form["descricao"]=null;
$form["dataRecebimento"]=null;
$form["valor"]=null;
$form["valorRecebido"]=null;
$form["desconto"]=null;
$form["saldoDevedor"]=null;

//teste
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
                    <h1 class="page-header">Produção Médica</h1>
				
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
					<!-- FILTRAR POR FILIAL - DATA  -->
					<div class="row">
						<div class="input-daterange">
							<div class="form-group col-lg-2"> 
								<br>
								<label class="control-label">Data Inicial</label>
								<div class='input-group date' id="start_date">
								 <input type='text' name="start_date" class="form-control"/>
								 <span class="input-group-addon">
								 <span class="glyphicon glyphicon-calendar"></span>
								 </span>
							  </div>
							</div> 
							
							<div class="form-group col-lg-2"> 
								<br>
								<label class="control-label">Data Final</label>
								<div class='input-group date' id="end_date">
								 <input type='text' name="end_date" class="form-control"/>
								 <span class="input-group-addon">
								 <span class="glyphicon glyphicon-calendar"></span>
								 </span>
							  </div>
							</div>
						</div>
						
						<div class="form-group col-lg-2">
									<br>
									  <label for="filtroData">Filtrar por</label>
										<select id="filtroData" name="filtroData" class="form-control"> 
												<option value="0">Data de Realização</option>
												<option value="1">Data de Cobrança</option>
												<option value="2">Data de Pagamento</option>
												<option value="3">Data de Repasse</option>
										</select>
						</div>
						<div class="form-group col-lg-2">
									<br>
									  <label for="filtroConvenico">Filtrar convênio</label>
									  <select id="filtroConvenio" name="filtroConvenio" class="form-control"> 
											<option value=""></option>
											<?php
											for($i=0; $i<count($convenios); $i++)
											{
											if($form["idconvenio"] == $convenios[$i]['idconvenio'])
											{	
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

						<div class="form-group col-lg-2"> 
								<br>
								<p id="resultado"></p>
								<br>
								<input type="button" name="search" id="search" value="Filtrar" class="btn btn-default" />
						</div>
						
					</div>
					</div>
					</div>
				</div>
			</div>
			
			<div class="panel-body">
				<div class="well">	
						<form role="form" id="formProducao" method="post">				
						<div class="row">
						<input type="hidden" name="idempresa" id="idempresa" value="1">
						<input type="hidden" name="idproducao" id="idproducao">
								<div class="form-group col-lg-2"> 
									<label class="control-label">Data Realização</label>
										<div class='input-group date' id='datetimepicker1'> 
											<input type='text' class="form-control" id="dataRealizacao" name="dataRealizacao"/>
											<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
								</div>
								
								<div class="form-group   col-lg-2">
										<label for="nome">No.Carteira</label>
										<input class="form-control"  id="searchNoCarteira" placeholder="Num. Carteira" />
								</div>
								
								<div class="form-group   col-lg-3">
										<label for="nome">Paciente</label>
										<input class="form-control"  id="searchPaciente" placeholder="Nome do paciente" />
								</div>
								
								<input type="hidden" name="idpaciente" id="idpaciente">
								<input type="hidden" name="paciente" id="paciente">
								
								<div class="form-group col-lg-2">
										<label for="convenio">Hospital/Clínica</label>
											<select id="hospital" name="idhospital" class="form-control">
											<option value=""></option>
											<?php
											for($i=0; $i<count($hospital); $i++)
											{
											if($form["idhospital"] == $hospital[$i]['idhospital'])
											{	
											?>
											<option value="<?=$hospital[$i]['idhospital']?>" selected><?=$hospital[$i]['hospital']?></option>
											<?php
											}
											else
											{
											?>
											<option value="<?=$hospital[$i]['idhospital']?>" ><?=$hospital[$i]['hospital']?></option>
											<?php
											}
											}
											?>
										</select>
									</div>
								
								
								<div class="form-group   col-lg-3">
										<label for="nome">Médico</label>
										<input class="form-control"  id="searchMedico" placeholder="Nome do médico" />
								</div>
								<input type="hidden" name="idmedico" id="idmedico">
								<input type="hidden" name="medico" id="medico">
								
						</div>
						<div class="row"> 
								<div class="form-group col-lg-2">
										<label for="convenio">Convênio</label>
											<select id="convenio" name="idconvenio" class="form-control"> 
											<option value=""></option>
											<?php
											for($i=0; $i<count($convenios); $i++)
											{
											if($form["idconvenio"] == $convenios[$i]['idconvenio'])
											{	
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
														
									<div class="form-group col-lg-1">
										<label for="nome">Cód.</label>
										<input class="form-control"  id="searchCodProcedimento" placeholder="Código Procedimento" />
									</div>
									<div class="form-group col-lg-3">
									
										<label for="nome"> Procedimento</label>
									
											<input class="form-control"  id="searchProcedimento" placeholder="Descrição do procedimento" />
									</div>									
									
									
									<div class="form-group col-lg-1">
										<label for="nome">Quantidade</label>
										<input class="form-control" type="text" name="quantidade" id="quantidade"  value="1" onchange="getSaldoDevedor(this.value)" >
                        			</div>
									
									<div class="form-group col-lg-1">
										<label for="nome">Ad.%</label>
										<input class="form-control" type="text" name="ajuste" id="adicional"  value="0" onchange="getSaldoDevedor(this.value)" >
                        			</div>
									

									<div class="form-group col-lg-1">
										<label for="nome">Red.%</label>
										<input class="form-control" type="text" name="ajuste" id="redutor"  value="0" onchange="getSaldoDevedor(this.value)" >
                        			</div>
									
									<div class="form-group col-lg-1">
											<label for="nome">Valor R$</label>
											<input class="form-control" name="valor" id="valor">
                        			</div>
									
									<div class="form-group col-lg-1">
										<label for="nome">Receb.R$</label>
										<input class="form-control" type="text" name="valorRecebido" id="valorRecebido"  value="0" onchange="getSaldo(this.value)">
									</div>
							
								<div class="form-group col-lg-1">
									<label for="nome">Glosa R$</label>
									<input class="form-control" type="text" style="background-color:pink;" name="glosa" id="glosa">
                        		</div>
								
								
							 	<!--<div class="form-group col-lg-1">
									<label for="nome">Saldo R$</label> -->
 									<input type="hidden" class="form-control" type="text" style="background-color:yellow;" name="saldo" id="saldo" value=0>
								<!--</div> -->

							
								<input type="hidden" name="idprocedimentos" id="idprocedimentos">
								<input type="hidden" name="codigoProcedimento" id="codigoProcedimento">
								<input type="hidden" name="descricaoProcedimento" id="descricaoProcedimento">
								<input type="hidden" name="valorProcedimento" id="valorProcedimento">	
								<!-- lançar o valor recebido anterior para somar com o valor atual -->
								<input type="hidden" name="valorRecebidoAnt" id="valorRecebidoAnt" value="0">
							</div>
					
							<div class="row">
									<div class="form-group col-lg-3">
										<label for="nome">Observação</label>
										<input class="form-control" type="text" name="observacao" id="observacao">
									</div>

									<div class="form-group col-lg-3">
										<label for="nome">Cirurgião</label>
										<input class="form-control" type="text" name="medicoCirurgiao" id="medicoCirurgiao">
									</div>
								
										<div class="form-group col-lg-2">
										<br>
										<button type="button" id="adicionarProcedimentos" class="btn btn btn-default btn-primary" onclick="teste()"><i class="glyphicon glyphicon-plus"></i> Adicionar </button> 
									</div>
										<div class="form-group col-lg-2">
											<p>Total Procedimentos R$ <span style="color:black" id="totalProcedimentos"></span></p>
											<p>Total Recebido R$ <span style="color:black" id="totalRecebido"></span></p>
										</div>
									
								</div>

						
								<div class="row" >
										<div class="form-group col-lg-12">
											<table class="table table-striped table-bordered table-hover" id="tblprocedimentos">
												<thead>
														<tr>
															<th>Cód.</th>
															<th>Procedimento</th>
															<th>Qtd.</th>
															<th>% Ad.</th>
															<th >% Red.</th>
															<th >Valor</th>
															<th >Receb.</th>
															<th>Glosa</th>
															<th>Observação</th>
															<th>Medico Cirurgião</th>
															<th></th>
														</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
								</div>
					
					
						
						<div class="row"> 
								<div class="form-group col-lg-2"> 
										<label class="control-label">Data Cobrança</label>
											<div class='input-group date' id='datetimepicker3'>
											 <input type='text' class="form-control" name="dataCobranca" id="dataCobranca"/>
											<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
											</span>
										  </div>
								</div>
								<div class="form-group col-lg-2"> 
										<label class="control-label">Data Pagamento</label>
											<div class='input-group date' id='datetimepicker4'>
											 <input type='text' class="form-control" name="dataPagamento" id="dataPagamento"/>
											<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
											</span>
										  </div>
								</div>  

								<input type="hidden" name="dataPrevisaoPagamento" id="dataPrevisaoPagamento">
											
								<div class="form-group col-lg-2"> 
										<label class="control-label">Data Repasse</label>
											<div class='input-group date' id='datetimepicker6'>
											 <input type='text' class="form-control" name="dataRepasse" id="dataRepasse">
											<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
											</span>
										  </div>
								</div>
								<div class="form-group col-lg-2">
										<label for="nome">Nota Fiscal</label>
										<input class="form-control" type="text" name="notaFiscal" id="notaFiscal">
                        			</div>								
								
  								
								<div class="form-group  col-lg-2">
										<label for="nome">Forma de Pagamento</label>
									  <select id="formaPagamento" name="formaPagamento" class="form-control" required> 
									  		<option>Dinheiro</option>
											<option>Cartão de Crédito</option>
											<option>Cartão Débito</option>
											<option>Cheque</option>	
											<option>Boleto</option>	
											<option>Transferência</option>												
									</select>
                        		</div>
									
								<div class="form-group col-lg-1">
									  <label for="inputStatusPagamento">Status</label>
									  <select id="statusPagamento" name="statusPagamento" class="form-control" required> 
											<option>Faturar</option>
											<option>Pago</option>
											<option>Glosada</option>
											<option>Pendente</option>									
									</select>
								</div>	

								<div class="form-group col-lg-1">
								<br>
									<button type="button" id="btnEditarConta" value="editarConta" onclick="editarConta()" class="btn btn-success">Editar</button>
									<button type="submit" name="submit" id="inserirConta" value="inserirConta" class="btn btn-success">Lançar</button>
								</div>
							</div>
						</form>	
							<!-- FECHAMENTO DO PAINEL WELL -->
					</div>
					<div class="row">
					<div class="col-lg-12">
				
					     <!-- AS DUAS LINHAS SEGUINTES FAZEM O DATATABLE TRABALHAR CORRETAMENTE NA MUDANÇA DE ZOOM table table-striped table-bordered table-hover -->
							<div class="table-responsive"> 
								
							<table  class="table table-striped table-bordered  table-hover dt-responsive display nowrap" cellspacing="0" id="listar-producao">
							
                                   <thead>
								      <tr>
										<th rowspan="2"></th>
										<th rowspan="2">Data Realização</th>
										<th rowspan="2">Nota Fiscal</th>
										<th colspan="2"><center>Paciente</center></th>
										<th rowspan="2">Médico</th>
										<th rowspan="2">Cirurgião</th>
										<th rowspan="2">Convênio</th>
										<th rowspan="2">Hospital</th>
										<th colspan="4"><center>Procedimento</center></th>
										<th colspan="10"><center>Pagamento</center></th>
									</tr>
                                    <tr>
									<!--  -->
									
										<th>Nome</th>
										<th>No. Carteira</th> 
										<th>Cód.Proc.</th>
										<th>Descrição</th>
										<th>Qtd.</th>
										<th>% Ad.</th>
										<th>% Red.</th>
										<th>Valor R$</th>
										<th>Data Cobrança</th>
										<th>Protocolo Envio</th>
										<th>Data Prevista Pgto.</th>
										<th>Data Pagamento</th>
										<th>Data Repasse</th>
										<th>Valor Recebido R$</th>
										<th>Glosa/Exced. R$</th>
										<th>Saldo R$</th>
										<th>Status</th>
										<th>Observação</th>
										<th></th>
										<th></th>
										<th></th>
									</tr>
                                </thead>
                               
                            </table>
                            <!-- /.table-responsive -->
						</div> <!-- row -->
					</div>
				    <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            </div>
	<!-- /#wrapper -->

	<!-- Bootstrap Modal - To Add New Record -->
			<!-- Modal Operacoes lotes -->
				<div class="modal fade" id="modalOperacoesLote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="myModalLabel">Operações em Lote</h4>
									</div>
									<div class="modal-body">
									<form role="form" id="formOperacoesLote" action="./.php" method='post' enctype="multipart/form-data">
																
									<div class="row">
									<div class="form-group col-md-6">
									  <label for="statusOperacao">Status</label>
									  <select id="statusOperacao" name="statusOperacao" class="form-control"> 
											<option value="0">Pago</option>
											<option value="1">Repasse</option>																								
									</select>
									</div>
										
									<div class="form-group col-md-6">
											<label for="nome">Forma de Pagamento</label>
											<select id="formaPagamentoOp" name="formaPagamento" class="form-control" required> 
													<option>Dinheiro</option>
													<option>Cartão de Crédito</option>
													<option>Cartão Débito</option>
													<option>Cheque</option>	
													<option>Boleto</option>	
													<option>Transferência</option>												
											</select>
										</div>
									</div>	
									<div class="row">
										<div class="form-group col-md-6">
											<label class="control-label">Data</label>
											<div class='input-group date' id='datetimepicker9'>
												 <input type='text' class="form-control" name="dataOperacao" id="dataOperacao"/>
												<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
										<div class="form-group col-md-6">
												<label for="nome">Nota Fiscal</label>
												<input class="form-control" type="text" name="notaFiscal" id="notaFiscalOp">
										</div>								
									</div>
									
								<div class="row">
									<div class="table-responsive"> 
									<table  class="table table-striped table-bordered table-hover" id="tblbaixarproducao">
									<thead>
								    <tr>
										<th>Nome</th>
										<th>No. Carteira</th> 
										<th>Cód.Proc.</th>
										<th>Descrição</th>
										<th>Valor R$</th>
										<th>Data Cobrança</th>
										<th>Data Pagamento</th>
										<th>Data Repasse</th>
										<th>Valor Recebido R$</th>
										<th>Glosa/Exced. R$</th>
										<th>Status</th>
									</tr>
                            	    </thead>
								<tbody>
								</tbody>
                            </table>
							</div>
                            <!-- /.table-responsive -->
						</div>
									
									<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
										<button  type="button" id="btnOperacoesLote" class="btn btn-primary" title="Editar dado" onclick="operacoesLote()">Atualizar </button>
								
								
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>		
			
			
				<!-- Bootstrap Modal - To Add New Record -->
			<!-- Modal Relatorios -->
				<div class="modal fade" id="modalRelatorio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="myModalLabel">Relatório</h4>
									</div>
									<div class="modal-body">
								 <form role="form" action="./.php" method='post' enctype="multipart/form-data">
					
								<div class="row">
									<div class="form-group col-md-6">
									  <label for="tipoRelatorio">Tipo</label>
									  <select id="tipoRelatorio" name="tipoRelatorio" class="form-control"> 
											<option value="0">Produção Médica</option>
											<option value="1">Plano de Saúde</option>
											<option value="2">SUS</option>
											<option value="3">Eletivas</option>
											<option value="4">Particular</option>
											<option value="5">Plantões</option>
																								
									</select>
									</div>
										<div class="form-group col-md-6">
										<label for="medico">Médico</label>
											<select id="medico_report" name="idmedico" class="form-control">
											<option value=""></option>
											<?php
											for($i=0; $i<count($medicos); $i++)
											{
											if($form["idmedico"] == $medicos[$i]['idmedico'])
											{	
											?>
											<option value="<?=$medicos[$i]['idmedico']?>" selected><?=$medicos[$i]['nome']?></option>
											<?php
											}
											else
											{
											?>
											<option value="<?=$medicos[$i]['idmedico']?>" ><?=$medicos[$i]['nome']?></option>
											<?php
											}
											}
											?>
										</select>
									</div>
								</div>

								<div class="row"> 
									<div class="form-group col-md-6">
										<label for="convenio">Convênio</label>
											<select id="convenio0" name="idconvenio" class="form-control"> 
											<option value=""></option>
											<?php
											for($i=0; $i<count($convenios); $i++)
											{
											if($form["idconvenio"] == $convenios[$i]['idconvenio'])
											{	
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
									<div class="form-group col-md-6">
										<label for="hospital">Hospital/Clínica</label>
											<select id="hospital_report" name="idhospital" class="form-control">
											<option value=""></option>
											<?php
											for($i=0; $i<count($hospital); $i++)
											{
											if($form["idhospital"] == $hospital[$i]['idhospital'])
											{	
											?>
											<option value="<?=$hospital[$i]['idhospital']?>" selected><?=$hospital[$i]['hospital']?></option>
											<?php
											}
											else
											{
											?>
											<option value="<?=$hospital[$i]['idhospital']?>" ><?=$hospital[$i]['hospital']?></option>
											<?php
											}
											}
											?>
										</select>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-6">
									  <label for="inputStatusPagamento">Status</label>
										<select id="statusPagamento0" name="statusPagamento" class="form-control" required> 
												<option>Faturar</option>
												<option>Pago</option>
												<option>Glosada</option>
												<option>Pendente</option>									
										</select>
									</div>	
									<div class="form-group col-md-6">
										  <label for="filtroData">Filtrar por</label>
											<select id="filtroData0" name="filtroData" class="form-control"> 
												<option value="0">Data de Realização</option>
												<option value="1">Data de Cobrança</option>
												<option value="2">Data de Pagamento</option>
												<option value="3">Data de Repasse</option>
											</select>
									</div>
								</div>
								<div class="row">
									<div class="input-daterange">
										<div class="form-group col-md-6"> 
											<br>
											<label class="control-label">Data Inicial</label>
											<div class='input-group date' id="start_date_report">
											 <input type='text' name="start_date_report" class="form-control"/>
											 <span class="input-group-addon">
											 <span class="glyphicon glyphicon-calendar"></span>
											 </span>
										  </div>
										</div> 
										  <div class="form-group col-md-6"> 
											<br>
											<label class="control-label">Data Final</label>
											<div class='input-group date' id="end_date_report">
											 <input type='text' name="end_date_report" class="form-control"/>
											 <span class="input-group-addon">
											 <span class="glyphicon glyphicon-calendar"></span>
											 </span>
										  </div>
										</div>
									</div>
								
			
								</div>
									<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
										<button  type="button" id="btnVisualizar" class="btn btn-primary" title="Relatório" onclick="relatorios()">Imprimir </button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>		
				

		<!-- Bootstrap Modal - To Add New Record -->
			<!-- Modal Relatorios Email -->
			<div class="modal fade" id="modalEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="myModalLabel">Enviar Email</h4>
									</div>
									<div class="modal-body">
									
								 <form role="form" action="./.php" method='post' enctype="multipart/form-data">
					
								<div class="row">
									<div class="form-group col-md-6">
									  <label for="tipoRelatorio">Tipo</label>
									  <select id="tipoRelatorio1" name="tipoRelatorio" class="form-control"> 
											<option value="0">Produção Médica</option>
											<option value="1">Plano de Saúde</option>
											<option value="2">SUS</option>
											<option value="3">Eletivas</option>
											<option value="4">Particular</option>
											<option value="5">Plantões</option>
																								
									</select>
									</div>
									<div class="form-group col-md-6">
										<label for="medico">Médico</label>
											<select id="medico_report1" name="idmedico" class="form-control">
											<option value=""></option>
											<?php
											for($i=0; $i<count($medicos); $i++)
											{
											if($form["idmedico"] == $medicos[$i]['idmedico'])
											{	
											?>
											<option value="<?=$medicos[$i]['idmedico']?>" selected><?=$medicos[$i]['nome']?></option>
											<?php
											}
											else
											{
											?>
											<option value="<?=$medicos[$i]['idmedico']?>" ><?=$medicos[$i]['nome']?></option>
											<?php
											}
											}
											?>
										</select>
									</div>
								</div>
								
								<div class="row">
									<div class="form-group col-md-6">
									  <label for="inputStatusPagamento">Status</label>
										<select id="statusPagamento1" name="statusPagamento" class="form-control" required> 
												<option>Faturar</option>
												<option>Pago</option>
												<option>Glosada</option>
												<option>Pendente</option>									
										</select>
									</div>	
									<div class="form-group col-md-6">
										  <label for="filtroData">Filtrar por</label>
											<select id="filtroData1" name="filtroData" class="form-control"> 
												<option value="0">Data de Realização</option>
												<option value="1">Data de Cobrança</option>
												<option value="2">Data de Pagamento</option>
												<option value="3">Data de Repasse</option>
											</select>
									</div>
									
								</div>
								
								<div class="row">
									<div class="input-daterange">
										<div class="form-group col-md-6"> 
											<br>
											<label class="control-label">Data Inicial</label>
											<div class='input-group date' id="start_date_report1">
											 <input type='text' name="start_date_report" class="form-control"/>
											 <span class="input-group-addon">
											 <span class="glyphicon glyphicon-calendar"></span>
											 </span>
										  </div>
										</div> 
										  <div class="form-group col-md-6"> 
											<br>
											<label class="control-label">Data Final</label>
											<div class='input-group date' id="end_date_report1">
											 <input type='text' name="end_date_report" class="form-control"/>
											 <span class="input-group-addon">
											 <span class="glyphicon glyphicon-calendar"></span>
											 </span>
										  </div>
										</div>
										<div class="form-group col-md-6">
												<label for="nome">Nome Documento</label>
												<input class="form-control" type="text" name="pdff" id="pdff">
											</div>
									</div>
								
			
								</div>
									<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
										<button  type="button" id="btnEnviarEmail" class="btn btn-primary" title="Relatório" onclick="email()">Gerar </button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			
				

<!-- Bootstrap Modal - To Add New Record -->
				<!-- Modal -->
				<div class="modal fade" id="modalBaixarProducao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="myModalLabel">Baixar Produção</h4>
									</div>
									<div class="modal-body">
								 <form role="form" action="" method='post' enctype="multipart/form-data">
								<input type="hidden" name="id" id="idproducao1" />
								
								
								<div class="row">
									<div class="form-group col-md-6">
											<label class="control-label">Data Realização</label>
											<div class='input-group date' id='dtBxRealizacao'>
												 <input type='text' class="form-control" name="dtBaixaRealizacao" id="dtBaixaRealizacao"/>
												<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
									<div class="form-group col-md-6">
										<label for="nome">Nome Paciente</label>
												<input class="form-control" type="text" name="nomePaciente" id="nomePaciente">
										</div>
								</div>

								<div class="row">
									<div class="form-group col-md-6">
										<label for="nome">Anestesiologista</label>
												<input class="form-control" type="text" name="nomeMedico" id="nomeMedico">
										</div>
									<div class="form-group col-md-6">
										<label for="nome">Convênio</label>
										<input class="form-control" type="text" name="descricaoConvenio" id="descricaoConvenio">
									</div>
								</div>

								
							<div class="row">
								<div class="form-group col-md-6">
									<label for="nome">Cód.</label>
									<input class="form-control" type="text" name="codProcedimento" id="codProcedimento">
								</div>
								<div class="form-group col-md-6">
									<label for="nome">Descrição</label>
										<input class="form-control" type="text" name="descProcedimento" id="descProcedimento">
								</div>
							</div>


							<div class="row">
								
							<div class="form-group col-md-6">
											<label class="control-label">Data Pagamento</label>
											<div class='input-group date' id='dtBxPagamento'>
												 <input type='text' class="form-control" name="dtBxPagamento" id="dtBaixaPagamento"/>
												<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
								
								
								<div class="form-group col-md-6">
											<label class="control-label">Data Repasse</label>
											<div class='input-group date' id='dtBxRepasse'>
												 <input type='text' class="form-control" name="dtBxRepasse" id="dtBaixaRepasse"/>
												<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
							</div>


									<div class="row">
									<div class="form-group col-md-6">
											<label class="control-label">Data Cobrança</label>
											<div class='input-group date' id='dtBxCobranca'>
												 <input type='text' class="form-control" name="dtBxCobranca" id="dtBaixaCobranca"/>
												<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
									<div class="form-group col-md-6">
												<label for="nome">Nota Fiscal</label>
												<input class="form-control" type="text" name="notaFiscal" id="notaFiscalBx">
										</div>								
									</div>

									<div class="row">
									<div class="form-group col-md-6">
									<label for="nome">Valor Cobrado</label>
										<input class="form-control" type="text" name="valorCobrado" id="valorCobrado">
									</div>
									<div class="form-group col-md-6">
									<label for="nome">Valor Recebido</label>
										<input class="form-control" type="text" name="valorBxRecebido" id="valorBxRecebido" value="0" onchange="getBxSaldo(this.value)">
									</div>
									
									</div>
			
									<div class="row">
									
									<div class="form-group col-md-6">
									<label for="nome">Glosa</label>
										<input class="form-control" type="text" name="glosaBx" id="glosaBx">
									</div>
									<div class="form-group col-md-6">
									  <label for="statusOperacao">Status</label>
									  <select id="statusBxOperacao" name="statusBxOperacao" class="form-control"> 
											<option value="0">Pago</option>
											<option value="1">Pendente</option> 																								
									</select>
									</div>
										
									</div>	



									<div class="modal-footer">
										<button type="button" class="btn btn-default" id="btn-close" data-dismiss="modal">Fechar</button>
										<button  type="button" id="btnAtualizarProducao" class="btn btn-primary" title="Baixar Produção">Atualizar</button>
									
									<!--	<button type="submit" class="btn btn-success">Salvar</button>-->
									</div>	
								</form>
							</div>
						</div>
					</div>
				</div>
	</div>	
	
	<!-- /#page-wrapper -->
	<!-- AUTOCOMPLETE BOOTSTRAP -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	 <!-- jQuery -->
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
	

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script> 
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
		
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>

<!--	<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script> -->
	
	
	<!--  IMPORT PARA UTILIZACAO DOS BOTES DE IMPRIMIR, EXPORTAR EM CSV, PDF, EXCEL -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script> 
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>	
	
	
    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

    <!-- Script -->
    <script type='text/javascript'></script>
	
	<!-- TRABALIHAR COM MOEDAS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
	 

	 <!-- Use with CHECKBOX selected  -->
	<script src="../../js/dataTables.checkboxes.min.js"></script>
	
<script>
// CRIAR TABELA
	$(document).ready(function(){
		 Table = $('#tblprocedimentos').DataTable(
		{
		"scrollY": 		"100px",
	    "paging": 		false,
		"searching":	false,
		
		createdRow:	function(row){ // Toda vez que criar uma row ..
			var td = $(row).find("td").eq(5); // Pega o texto da célula 5
			td.data("value", td.text()); // Coloca no Válue 

			console.log(td);
		}

		});
  	});
		var totalProcedimentos = 0;
		var totalRecebido = 0;
</script>

<script>



function teste(){

// CÓDIGO PARA EDITAR CADA LINHA DA TABELA

$(document).ready(function(){
		$("table#tblprocedimentos").on("dblclick", "td" , function () {
        var cell = Table.cell(this);
		
		console.log(cell.index().column);
		var conteudoOriginal = $(this).text();
        var td = $(this);

        td.addClass("celulaEmEdicao");

		if(cell.index().column == 4){ // Se o index da coluna for igual o 4 .. 
			td.addClass("recalcularPorcentagem");

		}

        td.html("<input type='text' value='" + conteudoOriginal + "' />");
        td.children().first().focus();
			
        td.children().first().keypress(function (e) {
            if (e.which == 13) {
				e.preventDefault();
                var novoConteudo = $(this).val();
                $(this).parent().text(novoConteudo);

				cell.data(novoConteudo).draw(); // Atualiza o conteudo editado.

                $(this).parent().removeClass("celulaEmEdicao");
				
            }

        });
         
		 

		td.children().first().blur(function(){
        td.parent().text(conteudoOriginal);
        td.parent().removeClass("celulaEmEdicao");
		td.removeClass("recalcularPorcentagem");
		
    });



    });

	$("table#tblprocedimentos").on("change", "td.recalcularPorcentagem input", function(){
	 var porcentagem = $(this).val(); //Valor input 
	 
	 //console.log('Porcentagem: ', porcentagem);
	 //console.log(Table.cell(this.parentElement.nextSibling).data());

	 var cell = Table.cell(this.parentElement.nextSibling); // Determina Célula seguinte
	
	//console.log(cell);
	 var valor = parseFloat($(this.parentElement.nextSibling).data("value")); // Pega o valor da Celula
	 console.log('Valor: ', valor);
	 
	conta = valor - valor * (porcentagem/100);
	
	cell.data(conta.toFixed(2)); // Grava o Novo valor

	});

	});

}

</script>
	
<script>	
// adiciona varios procedimentos
		$('#adicionarProcedimentos').on( 'click', function () {

		//var t = $('#tblprocedimentos').DataTable();
		var valor = $("#valor").maskMoney('unmasked')[0];
		var valorRecebido = $("#valorRecebido").maskMoney('unmasked')[0];
		var glosa = $("#glosa").maskMoney('unmasked')[0];
		

        Table.row.add([
			document.getElementById('searchCodProcedimento').value,
            document.getElementById('searchProcedimento').value,
			document.getElementById('quantidade').value,
			document.getElementById('adicional').value,
			document.getElementById('redutor').value,
			valor,
			valorRecebido,
			glosa,
			document.getElementById('observacao').value,

			//Medico Cirurgiao
			document.getElementById('medicoCirurgiao').value,
			
			'<button type="button" id="btnExcluirItemProcedimento" class="btn  btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>',
             ]).draw();
			 	totalProcedimentos = totalProcedimentos + valor;
				totalRecebido = totalRecebido + valorRecebido;	
				$('#totalProcedimentos').html(parseFloat(totalProcedimentos).toFixed(2));
				$('#totalRecebido').html(parseFloat(totalRecebido).toFixed(2));
			});
</script>	

<script>
		$(document).on('click','#btnExcluirItemProcedimento',function(e){
            e.preventDefault();
			var table = $('#tblprocedimentos').DataTable();
			var valor1 = (table.row( $(this).parents('tr') ).data()[5]);
			var total1 = parseFloat($('#totalProcedimentos').html());
			 	
			var valorRecebido1 = (table.row( $(this).parents('tr') ).data()[6]);
			var totalRecebido1 = parseFloat($('#totalRecebido').html());
			//Zerar os valores
			totalProcedimentos = total1-valor1;
			totalRecebido = totalRecebido1 - valorRecebido1;
			
			$('#totalProcedimentos').html(parseFloat(totalProcedimentos).toFixed(2));
			$('#totalRecebido').html(parseFloat(totalRecebido).toFixed(2));
			
			confirm("Excluir procedimento? ");
			table.row( $(this).parents('tr') ).remove().draw();
			});
</script>	


<script>
	function relatorios() {
		$(document).on('click','#btnVisualizar',function(e){
			e.preventDefault();
					var start = $('#start_date_report').data('DateTimePicker').date().toString();
					var date = new Date(start);
					var start_date = date.getFullYear()+'-'+(date.getMonth() + 1) + '-' + date.getDate();
				
					var end = $('#end_date_report').data('DateTimePicker').date().toString();
					var date = new Date(end);
					var end_date = date.getFullYear()+'-'+(date.getMonth() + 1) + '-' + date.getDate();
			
					var idmedico = $("#medico_report").find('option:selected').val();
					var idhospital = $("#hospital_report").find('option:selected').text();
					var filtroDataTipo = $("#filtroData0").find('option:selected').val();
					
				   var id = document.getElementById("tipoRelatorio").value;
					switch (id) {
						case '0':
							window.open("relatorioProducaoMedica.php?id="+idmedico+"&start_date="+start_date+"&end_date="+end_date+"&filtroDataTipo="+filtroDataTipo);
							break;
						
						case '1':
							window.open("relatorioPlanodeSaude.php?id="+idmedico+"&start_date="+start_date+"&end_date="+end_date+"&filtroDataTipo="+filtroDataTipo+"&hospital="+idhospital);
							break;

						case '2':
							window.open("relatorioFaturaSUS.php?id="+idmedico+"&start_date="+start_date+"&end_date="+end_date+"&filtroDataTipo="+filtroDataTipo+"&hospital="+idhospital);
							break;	
							
						case '3':
							window.open("relatorioFaturaEletivas.php?id="+idmedico+"&start_date="+start_date+"&end_date="+end_date+"&filtroDataTipo="+filtroDataTipo+"&hospital="+idhospital);
							break;	
						default:
							text = "No value found";
							}
						});
				}
</script>

<!-- Operaçoes em Lote -->
<script>
	function operacoesLote() {
		
	 	$(document).on('click','#btnOperacoesLote',function(e){
			e.preventDefault();  

		//	var selRows =dataTable.rows('.selected').data();
		//	var t = $('#tblbaixarproducao').DataTable();

		//	for (var i=0; i<selRows.length; i++) {
		//		alert(selRows.data()[i]);
			

			
			/*	t.row.add([this.data()[1],
					   this.data()[2],
					   this.data()[3],
					   this.data()[4],
					   this.data()[5],
					   ]).draw();*/
			
/*			selRows.rows().every(function(){
				alert(this.data()[0]);
			} */
//			for (var i=0; i< selRows.length; i++) {
			//	alert(selRows.length);
					//selRows.rows().every(function() 
//			var t = $('#tblbaixarproducao').DataTable();
		
			/*	$.each(selRows, function(index,tr)
				{
					alert(selRows);
					console.log(index);
					console.log(tr);
		      	/*	  */
				
		

				var rows_selected = dataTable.column(1).checkboxes.selected();
				$.each(rows_selected, function(index, rowId){
				$.ajax({  
				url:"operacoes_lote.php",  
				method:"POST",  
				data: {id : rowId, dataOperacao : $("#dataOperacao").val(), formaPagamento: $("#formaPagamentoOp").val(), statusOperacao : $("#statusOperacao").find('option:selected').text(), notaFiscal : $("#notaFiscalOp").val()},
				beforeSend:function(){  
				},  
				success:function(data){  
				$('#formOperacoesLote')[0].reset(); 
				$('#listar-producao').DataTable().ajax.reload();
				}  
			   });  
				});
			 });
	}	 	
</script>


<script>
	function email() {
		$(document).on('click','#btnEnviarEmail',function(e){
			e.preventDefault();
					var start = $('#start_date_report1').data('DateTimePicker').date().toString();
					var date = new Date(start);
					var start_date = date.getFullYear()+'-'+(date.getMonth() + 1) + '-' + date.getDate();
				
					var end = $('#end_date_report1').data('DateTimePicker').date().toString();
					var date = new Date(end);
					var end_date = date.getFullYear()+'-'+(date.getMonth() + 1) + '-' + date.getDate();
			
					var idmedico = $("#medico_report1").find('option:selected').val();

					var pdff =$("#pdff").val();
					
				   var id = document.getElementById("tipoRelatorio1").value;
					switch (id) {
						case '0':
							window.open("envioEmailProducao.php?id="+idmedico+"&start_date="+start_date+"&end_date="+end_date+"&pdff="+pdff);
							break;
						
						case '1':
							window.open("EnvioEmailPlanoSaude.php?id="+id);
							break;
						default:
							text = "No value found";
							}
						});
				}
</script>



<!-- Inserir Máscara R$ -->
<script>
		$( document ).ready(function() {
			$("#valor").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#valorRecebido").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#glosa").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#saldo").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#valorCobrado").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#valorBxRecebido").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#glosaBX").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			
		});
</script>

<script>
			$(document).ready(function(){
			 $('#formProducao').on("submit", function(event){  
			 event.preventDefault();
		
			// Ler os procedimentos e inserir
		//var table = $('#tblprocedimentos').DataTable();
				Table.rows().every(function(){
				var codigoProcedimento  = this.data()[0];
				var descricao = this.data()[1];
				var quantidade = this.data()[2];
				var adicional = this.data()[3];
				var redutor = this.data()[4];
				var valorProcedimento = this.data()[5];
				var valorRecebido = this.data()[6];
				var glosa = this.data()[7];
				var observacao = this.data()[8];
				var medicoCirurgiao = this.data()[9];
				//console.log(valorProcedimento);
				//return false;
			$.ajax({  
				url:"proc_producao.php",  
				method:"POST",  
			 	dataType: "json",
				data: {submit : $("#inserirConta").val(), idproducao: $("#idproducao").val(), idempresa : $("#idempresa").val(),  dataRealizacao : $("#dataRealizacao").val(), idpaciente: $("#idpaciente").val(), paciente: $("#searchPaciente").val(), 
					  carteiraPaciente: $("#searchNoCarteira").val(), idmedico: $("#idmedico").val(), medico: $("#searchMedico").val(), idconvenio: $("#convenio").find('option:selected').val(), convenio : $('#convenio').find('option:selected').text(),
					  hospital : $('#hospital').find('option:selected').text(),
					  codigoProcedimento:codigoProcedimento, descricaoProcedimento: descricao, quantidade : quantidade,  adicional : adicional, redutor : redutor,
					  valorProcedimento : valorProcedimento, valorRecebido :valorRecebido, glosa : glosa,  saldo : $('#saldo').maskMoney('unmasked')[0],
					  dataCobranca : $("#dataCobranca").val(),  dataPrevisaoPagamento : $("#dataPrevisaoPagamento").val(),  dataRepasse : $("#dataRepasse").val(),  dataPagamento : $("#dataPagamento").val(), 
					  formaPagamento: $("#formaPagamento").val(), statusPagamento : $("#statusPagamento").find('option:selected').text(), notaFiscal : $("#notaFiscal").val(), valorRecebidoAnt : $('#valorRecebidoAnt').val(), observacao: observacao, medicoCirurgiao: medicoCirurgiao},
				beforeSend:function(){
				},  
				success:function(data){
					$('#formProducao')[0].reset();  
		 		 window.parent.location.reload();
				 $('#listar-producao').DataTable().ajax.reload();	
			// Verificar como inserir o IDPACIENTE na 2a. requisição da tabela de procedimentos
				//	alert(data[0]["idp"]);
			//		var idp = data[0]["idp"];
					//alert(idp);
				//	paciente = idp;
			   	},
			   });

				});		
							
				});
			});
</script>


<!-- salvar edição conta médica -->	
	<script>
			$(document).on('click','#btnEditarConta',function(e){
			e.preventDefault();
				$.ajax({  
				url:"proc_producao.php",  
				method:"POST",  
				data: {submit : $("#inserirConta").val(), idproducao: $("#idproducao").val(), idempresa : $("#idempresa").val(),  dataRealizacao : $("#dataRealizacao").val(), idpaciente: $("#idpaciente").val(), paciente: $("#searchPaciente").val(), 
					  carteiraPaciente: $("#searchNoCarteira").val(), idmedico: $("#idmedico").val(), medico: $("#searchMedico").val(), idconvenio: $("#convenio").find('option:selected').val(), convenio : $('#convenio').find('option:selected').text(), hospital : $('#hospital').find('option:selected').text(),
					  codigoProcedimento: $("#searchCodProcedimento").val(), descricaoProcedimento: $("#searchProcedimento").val(), quantidade : $("#quantidade").val(),  adicional : $("#adicional").val(), redutor : $("#redutor").val(),
					  valorProcedimento : $('#valor').maskMoney('unmasked')[0], valorRecebido : $('#valorRecebido').maskMoney('unmasked')[0], glosa : $('#glosa').maskMoney('unmasked')[0],  saldo : $('#saldo').maskMoney('unmasked')[0],
					  dataCobranca : $("#dataCobranca").val(),  dataPrevisaoPagamento : $("#dataPrevisaoPagamento").val(),  dataRepasse : $("#dataRepasse").val(),  dataPagamento : $("#dataPagamento").val(), 
					  formaPagamento: $("#formaPagamento").val(), statusPagamento : $("#statusPagamento").find('option:selected').text(), notaFiscal : $("#notaFiscal").val(), valorRecebidoAnt : $('#valorRecebidoAnt').val(), observacao: $("#observacao").val(), medicoCirurgiao: $("#medicoCirurgiao").val()  },
				beforeSend:function(){  
				},  
				success:function(data){  
					$('#formProducao')[0].reset();  
					window.parent.location.reload();
					$('#listar-producao').DataTable().ajax.reload();
				}  
			   });  
				}); 
			
	</script>	


<script>
		$(document).on('click','#btnExcluir',function(e){
            e.preventDefault();
		var id = $(this).data('id');
		 confirm("Excluir procedimento? " +id);
		location.assign("deleteProducao.php?id="+id);
		});
	</script>	
	
<!-- Editar conta médica -->	
<script>
		$(document).on('click','#btnEditar',function(e){
        e.preventDefault();
		var id = $(this).data('id');
		confirm("Editar conta ? " +id);
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var result = JSON.parse(this.responseText);
				$("#idproducao").val(result[0][0]);
				$('#datetimepicker1').data('DateTimePicker').date(new Date(result[0][1]));
				//$('#dataRealizacao').datetimepicker({defaultDate:  result[0][1], format:'DD/MM/YYYY HH:mm'});
				$("#searchNoCarteira").val(result[0][6]);
				$("#searchPaciente").val(result[0][5]);
				$("#convenio option:contains(" + result[0][8] + ")").attr('selected', 'selected');
				//document.getElementById('convenio').options[document.getElementById('convenio').selectedIndex].text = result[0][8];
				document.getElementById('hospital').options[document.getElementById('hospital').selectedIndex].text = result[0][9];
				$("#searchMedico").val(result[0][7]);
				
				$("#searchCodProcedimento").val(result[0][10]);
				$("#searchProcedimento").val(result[0][11]);
			 
			 	$("#valor").val(result[0][12]);
				$("#valor").maskMoney('mask');
								
				$("#quantidade").val(result[0][13]);
				$("#adicional").val(result[0][14]);
				$("#redutor").val(result[0][15]);
				
				$("#valorRecebidoAnt").val(result[0][16]);
				
				$("#glosa").val(result[0][17]);
				$("#saldo").val(result[0][18]);
				$("#observacao").val(result[0][27]);
				$("#medicoCirurgiao").val(result[0][28]);
				$("#notaFiscal").val(result[0][23]);
				document.getElementById('formaPagamento').options[document.getElementById('formaPagamento').selectedIndex].text = result[0][25];
				document.getElementById('statusPagamento').options[document.getElementById('statusPagamento').selectedIndex].text = result[0][26];
				$('#dataPagamento').datetimepicker({defaultDate:  result[0][19], format:'DD/MM/YYYY HH:mm'});
				$('#dataCobranca').datetimepicker({defaultDate:  result[0][20], format:'DD/MM/YYYY HH:mm'});
				$('#dataRepasse').datetimepicker({defaultDate:  result[0][21], format:'DD/MM/YYYY HH:mm'});
				$('#dataPrevisaoPagamento').datetimepicker({defaultDate:  result[0][22], format:'DD/MM/YYYY HH:mm'});
			}
			
		};
		xmlhttp.open("GET", "operacoes_producao.php?id="+id, true);
		xmlhttp.send(); 
		});
</script>	
	

<script>
	function getSaldo(val) {
		//Calcula quantidade 
		// Recebe o valor do procedimento original importado da base de procedimentos/porte
		var glosa = $('#glosa').maskMoney('unmasked')[0];
			var valor = $("#valor").maskMoney('unmasked')[0];
			var valorRecebido = $("#valorRecebido").maskMoney('unmasked')[0];
			glosa = valorRecebido-valor;
			glosa = glosa.toFixed(2);
			document.getElementById("glosa").value = glosa;
			$("#glosa").maskMoney('mask');	
	}
</script>	
<!--
<script>
function getSaldo(val) {
		//Calcula quantidade 
		// Recebe o valor do procedimento original importado da base de procedimentos/porte
		var glosa = $('#glosa').maskMoney('unmasked')[0];
		
		if (glosa > 0) {
			var valorRecebido = $("#valorRecebido").maskMoney('unmasked')[0];
			glosa = glosa - valorRecebido;
			glosa = glosa.toFixed(2);
			document.getElementById("glosa").value = glosa;
			$("#glosa").maskMoney('mask');	
		}
		
		else {	
			var valor = $("#valor").maskMoney('unmasked')[0];
			var valorRecebido = $("#valorRecebido").maskMoney('unmasked')[0];
			var glosa = $('#glosa').maskMoney('unmasked')[0]; 
	//		var valorRecebidoAnt = $("#valorRecebidoAnt").maskMoney('unmasked')[0]
	//		alert(valor-(valorRecebido+valorRecebidoAnt));

			glosa= valor- valorRecebido;
			glosa = glosa.toFixed(2);
			document.getElementById("glosa").value = glosa;
			$("#glosa").maskMoney('mask');	
			confirm("Confirma glosa do procedimento ?");
		}
	}
</script>	-->

<script>
	function getSaldoDevedor(val) {
		//Calcula quantidade 
		// Recebe o valor do procedimento original importado da base de procedimentos/porte
		var valor = $("#valorProcedimento").val();
		if (valor != 0) {
			//Calculo para procedimentos cadastrados
			var adicional = $('#adicional').val();
			var redutor = $('#redutor').val();
		
			adicional =  ((adicional/100) * ((valor * $('#quantidade').val())));
			redutor = ((redutor/100) * ((valor * $('#quantidade').val())));
			valor = ((valor * $('#quantidade').val())) + adicional - redutor;
			valor = valor.toFixed(2);
			document.getElementById("valor").value = valor;
			$("#valor").maskMoney('mask');
			}
		
		else {
			//Procedimentos lançados manualmente
			valor = $("#valor").maskMoney('unmasked')[0];
			adicional =  ((adicional/100) * ((valor * $('#quantidade').val())));
			redutor = ((redutor/100) * ((valor * $('#quantidade').val())));
			valor = ((valor * $('#quantidade').val())) + adicional - redutor;
			valor = valor.toFixed(2);
			document.getElementById("valor").value = valor;
			$("#valor").maskMoney('mask');
		}
	}
</script>
	
<script>
	$(document).ready(function(){
		 $('#start_date').datetimepicker({
			format:'DD/MM/YYYY'
		});
		
		 $('#end_date').datetimepicker({
			format:'DD/MM/YYYY'
		});
		
		 fetch_data('no');
	function fetch_data(is_date_search, start_date='', end_date='', filterData, filterConvenio)
		 {
		   dataTable = $('#listar-producao').DataTable({
		   "processing" : true,
		   "serverSide" : true,
		   'columnDefs': [
                 {
                    'targets': 0,
                    'checkboxes': {
                       'selectRow': true
					},
                }
              ],
              'select': {
                 'style': 'multi'
              },
             // 'order': [[1, 'asc']]
		   "order" : [],
			   extend: 'collection',
                text: 'Export',
				     dom: 'lBfrtip',
                buttons: [
                     {
					 extend: 'excelHtml5',
                     exportOptions: {
						columns:  [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23],
							format: {
              		 body: function ( data, row, column, node ) {
              		      //Strip $ column to make it numeric
             			     //return (column === 13)  ? //data.replace( /[$,]/g, '' ) :	 data;
							  if ((column ==12) || (column==18) || (column==19) || (column==20)) {
								data = data.replace(/[\D]+/g, "" );
								var tmp = parseInt(data);
								tmp=tmp/100;
								tmp = tmp.toFixed(2);
								$("#tmp").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
								return data=tmp;
							  }
							  else 	
							 { 
								 return data;	
							}
						}	
		            }
					}
					 
					 },
					 {
                    extend: 'pdfHtml5',
                     exportOptions: {
						columns:  [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
					}
					},
					 {
					 extend: 'print',
                     exportOptions: {
						columns:  [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
							 }
					},
					{
						text: 'Op. Lote',
						action: function ( e, dt, node, config ) {
									$("#modalOperacoesLote").modal();
					}
					},					
					{
						text: 'Relatório',
						action: function ( e, dt, node, config ) {
									$("#modalRelatorio").modal();
						},
					},
					{
						text: 'Email',
						action: function ( e, dt, node, config ) {
									$("#modalEmail").modal();
						},
					},
					{
						text: 'Exibir/Ocultar',
						action: function ( e, dt, node, config ) {
							dataTable.column(2).visible( !dataTable.column(2).visible() );
							dataTable.column(4).visible( !dataTable.column(4).visible() );
							dataTable.column(7).visible( !dataTable.column(7).visible() );
							dataTable.column(10).visible( !dataTable.column(10).visible() );
							dataTable.column(11).visible( !dataTable.column(11).visible() );
							dataTable.column(12).visible( !dataTable.column(12).visible() );
							dataTable.column(15).visible( !dataTable.column(15).visible() );
							dataTable.column(16).visible( !dataTable.column(16).visible() );
							dataTable.column(20).visible( !dataTable.column(20).visible() );
							dataTable.column(21).visible( !dataTable.column(21).visible() );
							dataTable.column(23).visible( !dataTable.column(23).visible() );
						},
					}
                  	],
					lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		   "ajax" : {
			url:"fetch_producao.php",
			type:"POST",
			data:{
			 is_date_search:is_date_search, start_date:start_date, end_date:end_date, filterData:filterData, filterConvenio: filterConvenio
			}
		   }
		  });
		 }

		 $('#search').click(function(){
			var start = $('#start_date').data('DateTimePicker').date().toString();
			var date = new Date(start);
			var start_date = date.getFullYear()+'-'+(date.getMonth() + 1) + '-' + date.getDate();
		
			var end = $('#end_date').data('DateTimePicker').date().toString();
			var date = new Date(end);
			var end_date = date.getFullYear()+'-'+(date.getMonth() + 1) + '-' + date.getDate();
	
		if(start_date != '' && end_date !='')
		  {
		   $('#listar-producao').DataTable().destroy();
		   	filterData = document.getElementById("filtroData").value;
			filterConvenio = $("#filtroConvenio").find('option:selected').val();
			fetch_data('yes', start_date, end_date, filterData, filterConvenio);
		  }
		  else
		  {
		   alert("Obrigatório informar o período");
		  }
		 }); 

		});
</script>


<script>

/*$("#searchNoCarteira").keyup(function() {
if (!this.value) {
	alert('The box is empty');
	$("#idpaciente").val("");
}
}); */

</script>


<script>
// search NO CARTEIRA PACIENTES
	 $( function() {
      $( "#searchNoCarteira" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "fetchData.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        searchNoCarteira: request.term
                    },
				    success: function( data ) {
                        response( data );
					 }
					});
            },
		//	appendTo: "#modalReceita",

            select: function (event, ui) {
                $('#searchPaciente').val(ui.item.label); // display the selected text
				$('#searchNoCarteira').val(ui.item.value);	
				$('#paciente').val(ui.item.label);
				$('#idpaciente').val(ui.item.idpaciente);
				return false;
            }
        });

    });	 //TESTANDO COMMIT
</script>

<script>
// search PACIENTES
$( function() {
      $( "#searchPaciente" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "fetchData.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        searchpaciente: request.term
                    },
                    success: function( data ) {
                        response( data );
					 }
					});
            },
		//	appendTo: "#modalReceita",

            select: function (event, ui) {
                $('#searchPaciente').val(ui.item.label); // display the selected text
				$('#idpaciente').val(ui.item.idpaciente);
				$('#searchNoCarteira').val(ui.item.codcarteira);					
				$('#paciente').val(ui.item.label);
			    return false;
            }
        });

    });
</script>

<script>
// search MÉDICO
$( function() {
      $( "#searchMedico" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "fetchData.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        searchmedico: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
		//	appendTo: "#modalReceita",
		
            select: function (event, ui) {
                $('#searchMedico').val(ui.item.label); // display the selected text
				$('#idmedico').val(ui.item.value);	
				$('#medico').val(ui.item.label);
			    return false;
            }
        });

    });	
</script>


<script>
// search CÓDIGO PROCEDIMENTO
	 $( function() {
      $( "#searchCodProcedimento" ).autocomplete({
		source: function( request, response ) {
                
							$.ajax({
				url: "fetchData.php",
				type: 'post',
				dataType: "json",
				cache: "false",
				beforeSend: function(){
					console.log( "id:" + $('#convenio').val() );
				},
				data: {
					searchprocedimento: request.term,
					idconvenio: $('#convenio').val()
					},

				success: function( data ) {
					console.log(data);
					response( data );
				},
				error: function (data){
					console.log(data);
				}
			});

	},
		//	appendTo: "#modalReceita",
		
            select: function (event, ui) {
                $('#searchCodProcedimento').val(ui.item.codigoProcedimento); // display the selected text
				$('#searchProcedimento').val(ui.item.label);
				$('#idprocedimentos').val(ui.item.value);	
                $('#codigoProcedimento').val(ui.item.codigoProcedimento);	
                $('#descricaoProcedimento').val(ui.item.label);	
				$('#valor').val( ui.item.value1);
			    $("#valor").maskMoney('mask');
				$("#quantidade").val(1);
				$("#valorProcedimento").val(ui.item.value1);
			    return false;
            }
        });

    });	
</script>

<script>
// search PROCEDIMENTO
	 $( function() {
      $( "#searchProcedimento" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "fetchData.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                        searchprocedimento: request.term, 
						idconvenio : $('#convenio').val()
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
			//appendTo: "#modalReceita",
		
            select: function (event, ui) {
				$('#searchCodProcedimento').val(ui.item.codigoProcedimento); // display the selected text
                $('#searchProcedimento').val(ui.item.label); // display the selected text
				$('#idprocedimentos').val(ui.item.value);	
                $('#codigoProcedimento').val(ui.item.codigoProcedimento);	
                $('#descricaoProcedimento').val(ui.item.label);	
				$('#valor').val( ui.item.value1);
			    $("#valor").maskMoney('mask');
				$("#quantidade").val(1);
				$("#valorProcedimento").val(ui.item.value1);
			  	return false;
            }
        });

    });	
</script>

<script>
	$('[data-dismiss=modal]').on('click', function (e) {
		$('#modalAdicionaProcedimentos').on('hidden.bs.modal', function () {
		document.getElementById("idproducao").value = null;
		 var table = $('#tblprocedimentos').DataTable();
			table.clear();
			table.draw();
		 
		$(this).find('form').trigger('reset');
		});
	});
</script>
	

	
<!-- START DATE FUNCTIONS -->
 <script>
		$( document ).ready(function() {
			$('#start_date_report').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
 </script>
 
  <script>
		$( document ).ready(function() {
			$('#end_date_report').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
 </script>

<script>
		$( document ).ready(function() {
			$('#start_date_report1').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
 </script>
 
  <script>
		$( document ).ready(function() {
			$('#end_date_report1').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
 </script>


 <script>
		$( document ).ready(function() {
			$('#datetimepicker1').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
 </script>
	
<script>
		$( document ).ready(function() {
			$('#datetimepicker3').datetimepicker({
		//	defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
	  </script>
	  
<script>
		$( document ).ready(function() {
			$('#datetimepicker4').datetimepicker({
		//	defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
	</script>
	
<script>
		$( document ).ready(function() {
			$('#datetimepicker5').datetimepicker({
			//defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
 </script>	 
  	  
<script>
		$( document ).ready(function() {
			$('#datetimepicker6').datetimepicker({
		//	defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
</script>	 

<script>
		$( document ).ready(function() {
			$('#datetimepicker7').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
	  </script>	
	  	  
<script>
		$( document ).ready(function() {
			$('#datetimepicker8').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
</script>	

<script>
		$( document ).ready(function() {
			$('#datetimepicker9').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
</script>	

<script>
		$( document ).ready(function() {
			$('#dtBxRealizacao').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY'
			});
		});
</script>	

<script>
		$( document ).ready(function() {
			$('#dtBxRepasse').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY'
			});
		});
</script>	

<script>
		$( document ).ready(function() {
			$('#dtBxCobranca').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY'
			});
		});
</script>	

<script>
		$( document ).ready(function() {
			$('#dtBxPagamento').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY'
			});
		});
</script>	
	  
<script>
		$(document).on('click','#btnBaixarProducao',function(e){
        e.preventDefault();
		var id = $(this).data('id');
		confirm("Baixar produção ? " +id);
		
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var result = JSON.parse(this.responseText);
			document.getElementById("idproducao1").value = id;	
			$('#dtBxRealizacao').data('DateTimePicker').date(new Date(result[0][1]));
			document.getElementById("nomePaciente").value = result[0][5];	
			document.getElementById("nomeMedico").value = result[0][7];
			document.getElementById("descricaoConvenio").value = result[0][8];
			document.getElementById("codProcedimento").value = result[0][10];		
			document.getElementById("descProcedimento").value = result[0][11];
			$("#valorCobrado").val(result[0][12]);
			$("#valorCobrado").maskMoney('mask');
			$("#valorBxRecebido").val(result[0][16]);
			$("#valorBxRecebido").maskMoney('mask');
			$("#glosaBx").val(result[0][17]);
			$("#glosaBx").maskMoney('mask');
			

			$('#dtBxPagamento').data('DateTimePicker').date(new Date(result[0][19]));
			$('#dtBxCobranca').data('DateTimePicker').date(new Date(result[0][20]));

			$('#dtBxRepasse').data('DateTimePicker').date(new Date(result[0][21]));
			document.getElementById("notaFiscalBx").value = result[0][23];
			
			}
		};
		xmlhttp.open("GET", "operacoes_producao.php?id="+id, true);
		xmlhttp.send();
		$("#modalBaixarProducao").modal();
		});

	</script>	

<script>
			$(document).on('click','#btnAtualizarProducao',function(e){
			e.preventDefault();
			$.ajax({  
				url:"operacoes_baixar_producao.php",  
				method:"POST",  
				data: {id: $("#idproducao1").val(), 
				    dataRealizacao : $("#dtBaixaRealizacao").val(),
					valorRecebido : $('#valorBxRecebido').maskMoney('unmasked')[0], 
					glosa : $('#glosaBx').maskMoney('unmasked')[0], 
					dataPagamento : $("#dtBaixaPagamento").val(), 
					dataRepasse : $("#dtBaixaRepasse").val(), 
					dataCobranca : $("#dtBaixaCobranca").val(), 
			 	    statusPagamento : $("#statusBxOperacao").find('option:selected').text(),
			  	    notaFiscal : $("#notaFiscalBx").val()},
				beforeSend:function(){  
				},  
				success:function(data){ 
					alert("Operação realizada com suscesso!");
					$('#listar-producao').DataTable().ajax.reload();

				}  
			   });   
			}); 
</script>	

<script>
	function getBxSaldo(val) {
		//Calcula quantidade 
		// Recebe o valor do procedimento original importado da base de procedimentos/porte
		var glosaBx = $('#glosaBx').maskMoney('unmasked')[0];
			var valorBx = $("#valorCobrado").maskMoney('unmasked')[0];
			var valorRecebidoBx = $("#valorBxRecebido").maskMoney('unmasked')[0];
			glosaBx = valorRecebidoBx-valorBx;
			glosaBx = glosaBx.toFixed(2);
			document.getElementById("glosaBx").value = glosaBx;
			$("#glosaBx").maskMoney('mask');	
	}
</script>	

<script>
		$('[data-dismiss=modal]').on('click', function (e) {
			$('#modalBaixarProducao').on('hidden.bs.modal', function () {
			document.getElementById("idproducao1").value = null;
			$(this).find('form').trigger('reset');
			});
		});
</script>


<!-- END DATE FUNCTIONS -->	  

</body>

</html>
