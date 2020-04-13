<?php


/* Informa o nível dos erros que serão exibidos */
error_reporting(E_ALL);

/* Habilita a exibição de erros */
ini_set("display_errors", 1);

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



$form["nome"]=null;
$form["descricao"]=null;
$form["dataRecebimento"]=null;
$form["valor"]=null;
$form["valorRecebido"]=null;
$form["desconto"]=null;
$form["saldoDevedor"]=null;


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Clinise</title>

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
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <a class="navbar-brand" href="login.php">Clinise</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="../gerencial/configuracoes.php"><i class="fa fa-gear fa-fw"></i> Configurações</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../login.php"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

         <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
						 <li>
                            <a href="../gerencial/dashboard.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard </a>
                        </li>
						 <li>
                            <a href="../pacientes/pacientes.php"><i class="fa fa-user fa-fw"></i> Pacientes </a>
                        </li>
                        <li>
                            <a href="../agendamento/agendamento.php"><i class="fa fa-calendar fa-fw"></i> Agendamento </a>
                        </li>
						
						<li>
                            <a href="../financeiro/financeiro.php"><i class="fa fa-bar-chart-o fa-fw"></i> Financeiro </a>
						</li>
						<li>
                            <a href="#"><i class="fa fa-archive"></i> Administrativo<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../usuarios/usuarios.php">Usuários</a>
                                </li>
                                <li>
                                    <a href="../gerencial/documentos.php">Documentos</a>
                                </li>
								<li>
                                    <a href="../medicos/medicos.php">Médicos</a>
								</li>
								<li>
                                    <a href="../empresa/empresa.php">Filial</a>
								</li>
                                <li>
                                    <a href="../convenios/convenios.php">Convênios</a>
								</li>
                            <li>
                                    <a href="../cid/cid.php">CID</a>
								</li>
							</ul>
                            <!-- /.nav-second-level -->
                        </li>
						
						
                    </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
         <div id="page-wrapper">
			
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Financeiro</h1>
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
						<div class="col-lg-10 ">
						
					    <button class="btn btn-success" data-toggle="modal" data-target="#modalReceita">
										Receitas
								</button>
													
					    <button class="btn btn-danger" data-toggle="modal" data-target="#modalDespesa">
										Despesas
								</button>
						</div>
							<div class="col-lg-2">
									<p id="resultado"> </p>
							</div>
						</div>
						
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
						<br>
							<input type="button" name="search" id="search" value="Filtrar" class="btn btn-default" />
						</div>
				
							<div class="col-lg-8">
						
							</div>
						</div>
						</div>
				
						</div>	
					<div class="panel-body">
					<!-- Divisão responsavel pela tabela ser ajustada na tela -->
						  <div class="table-responsive">
						    <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="listar-financeiro">
                                <thead>
                                    <tr>
									<!-- FILIAL CODIDGO DA UNIDADE - TIPO (RECEITA/DESPESA) - DESCRIÇÃO - CATEGORIA - DATA - VALOR - STATUS - BTN-DETALHES -->
										<th>ID</th>
										<th>ID Consulta</th>
										<th>FIlial</th>
										<th>Tipo</th> 
										<th>Descrição</th>
										<th>Vencimento</th>
										<th>Recebimento</th>
										<th>Valor R$</th>
										<th>Valor Recebido R$</th>
										<th>Desconto R$</th>
										<th>Saldo R$</th>
										<th>Status Conta</th>
										<th></th>
										<th></th>
									</tr>
                                </thead>
                               
                            </table>
                            <!-- /.table-responsive -->
					</div>
				    <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            </div>
		</div>
    
 
    <!-- /#wrapper -->

			<!-- Bootstrap Modal - To Add New Record -->
			<!-- Modal -->
			<div class="modal fade" id="modalReceita" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										 <button type="button" class="close" data-dismiss="modal">&times;</button>
    									<h4 class="modal-title" id="myModalLabel">Inserir Receita</h4>
									</div>
									<div class="modal-body">
									<form name="formReceita" id="formReceita" role="form" method="post">
									<?php
									$statusPagamento = array("EM ABERTO","RECEBIDA","SALDO DEVEDOR","CANCELADA");
									$saldoDevedorAnt = $form["saldoDevedor"];
									?>
									<input type="hidden" name="tipo" id="tipo" value="RECEITA">
									
									<div class="form-group">
										<label for="convenio">Filial</label>
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
						
									
								
									<div class="form-group">
										<label for="nome">Descrição</label>
										   <input class="form-control"  name="descricao" id="descricao" value="<?=$form["descricao"]?>">
                        			</div>
								
								
								<input type="hidden" name="saldoDevedorAnt" id="saldoDevedorAnt" value="<?=$saldoDevedorAnt?>">
								
								<div class="row">
									<div class="form-group col-sm-3">
								
									<label for="nome">Valor R$ </label>
										   <input class="form-control" 	 name="valor" id="valor" onchange="getSaldoDevedor(this.value)">
                        			</div>	
																
									<div class="form-group col-sm-3 offset-md-1">
										<label for="nome">Recebido R$ </label>
										   <input class="form-control" type="text" name="valorRecebido" id="valorRecebido"  value="0" onchange="getSaldoDevedor(this.value)">
                        			</div>
							
									<div class="form-group col-sm-3">
										<label for="nome">Desconto R$ </label>
										   <input class="form-control" type="text" name="desconto" id="desconto"  value="0" onchange="getSaldoDevedor(this.value)" >
                        			</div>
									
									<div class="form-group col-sm-3">
										<label for="nome">Saldo R$ </label>
										   <input class="form-control" type="text" style="background-color:pink;" name="saldoDevedor" id="saldoDevedor">
                        			</div>
								</div>
								
								<div class="row">
										<div class="form-group col-md-6"> 
										<label class="control-label">Data Pagamento</label>
											<div class='input-group date' id='datetimepicker3'/>
											 <input type='text' class="form-control" id="dataRecebimento" name="dataRecebimento"/>
											<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
											</span>
										  </div>
										 </div>
										
										<div class="form-group col-md-6"> 
										<label class="control-label">Data Vencimento</label>
											<div class='input-group date' id='datetimepicker4'/>
											 <input type='text' class="form-control" id="dataVencimento" name="dataVencimento"/>
											<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
											</span>
										  </div>
									 </div>  
								
								</div>
								<div class="row">
									<div class="form-group  col-md-6">
										<label for="nome">Forma de Pagamento</label>
									  <select id="formaPagamento" name="formaPagamento"  class="form-control" required> 
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
									  <select id="inputStatusPagamento" name="statusPagamento"  class="form-control" required> 
											<option>EM ABERTO</option>
											<option>RECEBIDA</option>
											<option>SALDO DEVEDOR</option>
											<option>CANCELADA</option>									
									</select>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
									<button type="submit" name="submit" id="inserirReceita" value="inserirConta" class="btn btn-success">Lançar</button>
								<!--	<input type="submit" name="insert" id="insert" value="Lançar" class="btn btn-success" /> -->
									</form>
								</div>
							</div>
						</div>
					</div>
			</div>
			<!-- Modal DESPESAS -->
			<div class="modal fade" id="modalDespesa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">	
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title" id="myModalLabel">Inserir Despesa</h4>
									</div>
									<div class="modal-body">
									<form name="formDespesa" id="formDespesa" role="form" method='post'>
									<?php
									$statusPagamento = array("EM ABERTO","RECEBIDA","SALDO DEVEDOR","CANCELADA");
									$saldoDevedorAnt = $form["saldoDevedor"];
									?>
									<input type="hidden" name="tipo" id="tipo1" value="DESPESA">
									
									<div class="form-group">
										<label for="convenio">Filial</label>
											<select id="empresa1" name="idempresa" class="form-control">
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
									<div class="form-group">
										<label for="nome">Descrição</label>
										   <input class="form-control"  name="descricao" id="descricao1" value="<?=$form["descricao"]?>">
                        			</div>
									
										<input type="hidden" name="saldoDevedorAnt" id="saldoDevedorAnt1" value="<?=$saldoDevedorAnt?>">
									
								<div class="row">
									<div class="form-group col-sm-3">
								
										<label for="nome">Valor R$ </label>
										   <input class="form-control" name="valor" id="valor1" onchange="getSaldoDevedor1(this.value)">
                        			</div>	
																
									<div class="form-group col-sm-3 offset-md-1">
										<label for="nome">Pago R$ </label>
										   <input class="form-control" type="text" name="valorRecebido" id="valorRecebido1"  value="0" onchange="getSaldoDevedor1(this.value)">
                        			</div>
							
									<div class="form-group col-sm-3">
										<label for="nome">Desconto R$ </label>
										   <input class="form-control" type="text" name="desconto" id="desconto1"  value="0" onchange="getSaldoDevedor1(this.value)" >
                        			</div>
									
									<div class="form-group col-sm-3">
										<label for="nome">Saldo R$ </label>
										   <input class="form-control" type="text" style="background-color:pink;" name="saldoDevedor" id="saldoDevedor1">
                        			</div>
								</div>
								
								<div class="row">
										<div class="form-group col-md-6"> 
										<label class="control-label">Data Pagamento</label>
											<div class='input-group date' id='datetimepicker5'/>
											 <input type='text' class="form-control"  id="dataRecebimento1" name="dataRecebimento"/>
											<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
											</span>
										  </div>
										 </div>
										
										<div class="form-group col-md-6"> 
										<label class="control-label">Data Vencimento</label>
											<div class='input-group date' id='datetimepicker6'/>
											 <input type='text' class="form-control"  id="dataVencimento1" name="dataVencimento"/>
											<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
											</span>
										  </div>
										 </div>  
								
								</div>
								<div class="row">
									<div class="form-group  col-md-6">
										<label for="nome">Forma de Pagamento</label>
									  <select id="formaPagamento1" name="formaPagamento" class="form-control" required> 
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
									  <select id="inputStatusPagamento1" name="statusPagamento" class="form-control" required> 
											<option>EM ABERTO</option>
											<option>RECEBIDA</option>
											<option>SALDO DEVEDOR</option>
											<option>CANCELADA</option>									
									</select>
									</div>
								</div>
														
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
										<button type="submit" name="submit" id="inserirDespesa" value="inserirConta" class="btn btn-success">Lançar</button>
									</form>
									</div>
									</div>
								</div>
			</div>
			</div>
			<!-- Modal UPDATE CONTA -->
			<div class="modal fade" id="modalAtualizaConta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
									 <button type="button" class="close" data-dismiss="modal">&times;</button>
    			
										<h4 class="modal-title" id="myModalLabel">Editar conta</h4>
									</div>
									<div class="modal-body">
									<form role="form" id="formAtualizaConta" method='post'>
									<?php
									$statusPagamento = array("EM ABERTO","RECEBIDA","SALDO DEVEDOR","CANCELADA");
									?>
								<!-- PASSAGEM DE PARAMETROS -->
									<input type="hidden" name="idfinanceiro" id="idfinanceiro">
								
									<div class="form-group">
										<label for="nome">Cliente</label>
										   <input class="form-control"  name="nome" id="nome" value="<?=$form["nome"]?>">
                        			</div>
									
									<div class="form-group">
										<label for="nome">Descricao</label>
										   <input class="form-control" name="descricao" id="descricao2">
                        			</div>
									
									<div class="form-group">
										<label for="nome">Convênio</label>
										   <input class="form-control" name="convenio" id="convenio">
                        			</div>
									
									
									<div class="form-group">
										<label for="nome">Profissional</label>
										   <input class="form-control" id="nomeProfissional" name="nomeProfissional">
                        			</div>
											
							<input type="hidden" name="saldoDevedorAnt" id="saldoDevedorAnt2" value="<?=$saldoDevedorAnt?>">
							<input type="hidden" name="valorRecebidoAnt" id="valorRecebidoAnt2" value="<?=$valorRecebidoAnt?>">
							<input type="hidden" name="descontoAnt" id="descontoAnt2" value="<?=$descontoAnt?>">	
							
							<div class="row">
									<div class="form-group col-sm-3">
								
										<label for="nome">Valor R$ </label>
										   <input class="form-control" 	 name="valor" id="valor2" value="<?=$form["valor"]?>">
                        			</div>	
																
									<div class="form-group col-sm-3 offset-md-1">
										<label for="nome">Recebido R$ </label>
										   <input class="form-control" type="text" name="valorRecebido" id="valorRecebido2"  onchange="getAtualizaSaldo(this.value)">
                        			</div>
							
									<div class="form-group col-sm-3">
										<label for="nome">Desconto R$ </label>
										   <input class="form-control" type="text" name="desconto" id="desconto2"  onchange="getAtualizaSaldo(this.value)" >
                        			</div>
									
									<div class="form-group col-sm-3">
										<label for="nome">Saldo R$ </label>
										   <input class="form-control" type="text" style="background-color:pink;" name="saldoDevedor" id="saldoDevedor2">
                        			</div>
								</div>
								
									
								<div class="row">
										<div class="form-group col-md-6"> 
										<label class="control-label">Data Pagamento</label>
											<div class='input-group date' id='datetimepicker7'/>
											 <input type='text' class="form-control" id="dataRecebimento2" name="dataRecebimento"/>
											<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
											</span>
										  </div>
										 </div>
										
										<div class="form-group col-md-6"> 
										<label class="control-label">Data Vencimento</label>
											<div class='input-group date' id='datetimepicker8'/>
											 <input type='text' class="form-control"  id="dataVencimento2" name="dataVencimento"/>
											<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
											</span>
										  </div>
										 </div>  
								
								</div>
								<div class="row">
									<div class="form-group  col-md-6">
										<label for="nome">Forma de Pagamento</label>
									  <select id="formaPagamento2" name="formaPagamento" class="form-control" required> 
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
									  <select id="inputStatusPagamento2" name="statusPagamento" class="form-control" required> 
											<option>EM ABERTO</option>
											<option>RECEBIDA</option>
											<option>SALDO DEVEDOR</option>
											<option>CANCELADA</option>									
									</select>
									</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
										<button type="submit" name="submit" id="atualizaConta" value="atualizaConta" class="btn btn-success">Receber</button>
										
									</form>
									</div>
									</div>
								</div>
			
	<!-- /#page-wrapper -->

 <!-- jQuery -->
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

	<!--  IMPORT PARA UTILIZACAO DOS BOTES DE IMPRIMIR, EXPORTAR EM CSV, PDF, EXCEL -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script> 
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
	
	<!-- SOMAR COLUNAS DATATABLES -->
	<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

	<!-- TRABALIHAR COM MOEDAS DATATABLES -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>


	 
	<script>
	// idempresa, descricao, dataRecebimento, dataVecto, valor, valorRecebido, desconto, saldoDevedor, formaPagamento, 	statusPagamento, tipo
			$(document).ready(function(){
			 $('#formReceita').on("submit", function(event){  
			 event.preventDefault();
				$.ajax({  
				url:"proc_financeiro.php",  
				method:"POST",  
				data: {submit : $("#inserirReceita").val(), idempresa : $("#empresa").val(), descricao : $("#descricao").val(), dataRecebimento : $("#dataRecebimento").val(),  dataVencimento : $("#dataVencimento").val(),  valor : $('#valor').maskMoney('unmasked')[0],
					valorRecebido : $('#valorRecebido').maskMoney('unmasked')[0], desconto : $('#desconto').maskMoney('unmasked')[0], saldoDevedor : $('#saldoDevedor').maskMoney('unmasked')[0], formaPagamento : $("#formaPagamento").val(),
					 statusPagamento : $("#inputStatusPagamento").val(),  tipo : $("#tipo").val()},
				beforeSend:function(){  
				// $('#insert').val("Inserindo");  
				},  
				success:function(data){  
				 $('#formReceita')[0].reset();  
				 $('#modalReceita').modal('hide'); 
				 $('#listar-financeiro').DataTable().ajax.reload();
				 $('#resultado').html(data); 
				}  
			   });  
				}); 
			 });
	</script>
	
		<script>
			$(document).ready(function(){
				// INSERIR DESPESAS 
			 $('#formDespesa').on("submit", function(event){  
			 event.preventDefault();
				$.ajax({  
				url:"proc_financeiro.php",  
				method:"POST",  
				data: {submit : $("#inserirDespesa").val(), idempresa : $("#empresa1").val(), descricao : $("#descricao1").val(), dataRecebimento : $("#dataRecebimento1").val(),  dataVencimento : $("#dataVencimento1").val(),  valor : $('#valor1').maskMoney('unmasked')[0],
					valorRecebido : $('#valorRecebido1').maskMoney('unmasked')[0], desconto : $('#desconto1').maskMoney('unmasked')[0], saldoDevedor : $('#saldoDevedor1').maskMoney('unmasked')[0], formaPagamento : $("#formaPagamento1").val(),
					 statusPagamento : $("#inputStatusPagamento1").val(),  tipo : $("#tipo1").val()},
				beforeSend:function(){  
				// $('#insert').val("Inserindo");  
				},  
				success:function(data){  
				 $('#formDespesa')[0].reset();  
				 $('#modalDespesa').modal('hide'); 
				 $('#listar-financeiro').DataTable().ajax.reload();
				 $('#resultado').html(data); 
				}  
			   });  
				}); 
			 });
	</script>
	
			<script>
			$(document).ready(function(){
				// ATUALIZAR CONTAS 
				//UPDATE financeiro SET valorRecebido='$form[valorRecebido]'+'$form[valorRecebidoAnt]', desconto='$form[desconto]'+'$form[descontoAnt]', saldoDevedor='$form[saldoDevedor]', formaPagamento='$form[formaPagamento]', statusPagamento='$form[statusPagamento]'  where idfinanceiro='$form[idfinanceiro]'";	
			 $('#formAtualizaConta').on("submit", function(event){  
			 event.preventDefault();
				$.ajax({  
				url:"proc_financeiro.php",  
				method:"POST",  
				data: {submit : $("#atualizaConta").val(), idfinanceiro : $("#idfinanceiro").val(), descricao : $("#descricao2").val(),
				dataRecebimento : $("#dataRecebimento2").val(),  dataVencimento : $("#dataVencimento2").val(),  valorRecebido : $('#valorRecebido2').maskMoney('unmasked')[0], valorRecebidoAnt : $('#valorRecebidoAnt2').val(),
				desconto : $('#desconto2').maskMoney('unmasked')[0], descontoAnt : $('#descontoAnt2').val(), saldoDevedor : $('#saldoDevedor2').maskMoney('unmasked')[0], saldoAntDevedor : $('#saldoAntDevedor2').val(),
				dataRecebimento : $('#dataRecebimento2').val(), formaPagamento : $("#formaPagamento2").val(), statusPagamento : $("#inputStatusPagamento2").val()},
				beforeSend:function(){  
				// $('#insert').val("Inserindo");  
				},  
				success:function(data){  
				 $('#formAtualizaConta')[0].reset();  
				 $('#modalAtualizaConta').modal('hide'); 
				 $('#listar-financeiro').DataTable().ajax.reload();
				 $('#resultado').html(data); 
				}  
			   });  
				}); 
			 });
	</script>
	<script>
		$( document ).ready(function() {
			$("#valor").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#valorRecebido").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#desconto").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#saldoDevedor").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			
			$("#valor1").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#valorRecebido1").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#desconto1").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#saldoDevedor1").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			
			$("#valor2").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#valorRecebido2").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#desconto2").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			$("#saldoDevedor2").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: true});
			
		});
	</script>
	
	
	  	<script>
		$( document ).ready(function() {
			$('#datetimepicker3').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
	  </script>
	  
	    <script>
		$( document ).ready(function() {
			$('#datetimepicker4').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
	  </script>
	 	  
	    <script>
		$( document ).ready(function() {
			$('#datetimepicker5').datetimepicker({
			defaultDate: new Date(),
			format:'DD/MM/YYYY HH:mm'
			});
		});
	  </script>

	  
	    <script>
		$( document ).ready(function() {
			$('#datetimepicker6').datetimepicker({
			defaultDate: new Date(),
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
		$(document).on('click','#btnEditar',function(e){
        e.preventDefault();
		var id = $(this).data('id');
		confirm("Editar conta ? " +id);
		
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var result = JSON.parse(this.responseText);
		document.getElementById("idfinanceiro").value = result[0][0];
		document.getElementById("valor2").value = result[0][1];
		
		// VALOR RECEBIDO ANTERIOR
		document.getElementById("valorRecebidoAnt2").value = result[0][2];
		// DESCONTO ANTERIOR
		document.getElementById("descontoAnt2").value = result[0][3];
		
		//SALDO DEVEDOR
		document.getElementById("saldoDevedorAnt2").value = result[0][4];
		document.getElementById("saldoDevedor2").value = result[0][4];
		var saldo_devedor_anterior = result[0][4];
		
		document.getElementById("descricao2").value = result[0][5];
		document.getElementById("nome").value = result[0][7];
		document.getElementById("empresa").value = result[0][8];
		document.getElementById("convenio").value = result[0][10];
		}
		
		};
		xmlhttp.open("GET", "operacoes_financeiro.php?id="+id, true);
		xmlhttp.send();
		$("#modalAtualizaConta").modal();
		});

	</script>	
		
	<script>
		$(document).on('click','#btnExcluir',function(e){
            e.preventDefault();
		var id = $(this).data('id');
		 confirm("Excluir avaliação ? " +id);
		location.assign("deleteFinanceiro.php?id="+id);
		});
	</script>	
	
	
	<script>
		function getAtualizaSaldo(val) {
		var saldo_devedor = (($('#saldoDevedorAnt2').maskMoney('unmasked')[0]) - ($('#valorRecebido2').maskMoney('unmasked')[0]) - ($('#desconto2').maskMoney('unmasked')[0]));
		saldo_devedor = saldo_devedor.toFixed(2);	
		if (saldo_devedor > 0 ) {
			var txt;
			var r = confirm("Gerar SALDO DEVEDOR? "+saldo_devedor);
				if (r == true) {
				    document.getElementById("saldoDevedor2").value = saldo_devedor;
					document.getElementById('inputStatusPagamento2').selectedIndex = 2;
				} else {
					txt = "CANCELADA";
				}
			}
			else {
				document.getElementById("saldoDevedor2").value = saldo_devedor;
				document.getElementById('inputStatusPagamento2').selectedIndex = 1;
			}

		if (saldo_devedor < 0 ) {
			var txt;
			var r = confirm("Gerar SALDO CREDOR? "+saldo_devedor);
				if (r == true) {
					document.getElementById("saldoDevedor2").value = saldo_devedor;
					document.getElementById('inputStatusPagamento2').selectedIndex = 1;
				} else {
					txt = "CANCELADA";
				}
			}
			}		
	</script>
	
	
	<script>
		function getSaldoDevedor(val) {
		var saldo_devedor = (($('#valor').maskMoney('unmasked')[0]) - ($('#valorRecebido').maskMoney('unmasked')[0]) - ($('#desconto').maskMoney('unmasked')[0]));
		saldo_devedor = saldo_devedor.toFixed(2);
		if (saldo_devedor > 0 ) {
			var txt;
			var r = confirm("Gerar SALDO DEVEDOR? "+saldo_devedor);
				if (r == true) {
					$("#saldoDevedor").val(saldo_devedor);
					$("#saldoDevedor").maskMoney('mask');
					document.getElementById('inputStatusPagamento').selectedIndex = 2;
				} else {
					txt = "CANCELADA";
				}
			}
		else {
					$("#saldoDevedor").val(saldo_devedor);
					$("#saldoDevedor").maskMoney('mask');
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
		function getSaldoDevedor1(val) {
		var saldo_devedor = (($('#valor1').maskMoney('unmasked')[0]) - ($('#valorRecebido1').maskMoney('unmasked')[0]) - ($('#desconto1').maskMoney('unmasked')[0]));
		saldo_devedor = saldo_devedor.toFixed(2);
		if (saldo_devedor > 0 ) {
			var txt;
			var r = confirm("Gerar SALDO DEVEDOR? "+saldo_devedor);
				if (r == true) {
				    document.getElementById("saldoDevedor1").value = saldo_devedor;
					document.getElementById('inputStatusPagamento1').selectedIndex = 2;
				} else {
					txt = "CANCELADA";
				}
			}
			else {
				document.getElementById("saldoDevedor1").value = saldo_devedor;

				document.getElementById('inputStatusPagamento1').selectedIndex = 1;
			}
		}
	</script>
	
	<script>
		function getDesconto1(val) {
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
		$(document).ready(function(){
		 $('#start_date').datetimepicker({
			format:'DD/MM/YYYY'
		});
		
		 $('#end_date').datetimepicker({
			format:'DD/MM/YYYY'
		});
		
		 fetch_data('no');

		 function fetch_data(is_date_search, start_date='', end_date='')
		 {
		  var dataTable = $('#listar-financeiro').DataTable({
			"language" : {
			"decimal" : ",",
			"thousands" : "."
				},
		   "processing" : true,
		   "serverSide" : true,
		   "order" : [],
			   extend: 'collection',
                text: 'Export',
				    dom: 'lBfrtip',
                buttons: [
                     {
					 extend: 'excel',
                     exportOptions: {
				    columns: [0,1,2,3,4,5,6,7,8,9,10,11 ]
					 }
					 },
					 {
                    extend: 'pdf',
                     exportOptions: {
                    columns: [3,4,5,6,7,8,9,10,11 ]
					}
					},
					 {
					 extend: 'print',
                     exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10,11]
					 }
					}
                  	],
					lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		
					
		   "ajax" : {
			url:"fetch_financeiro.php",
			type:"POST",
			data:{
			 is_date_search:is_date_search, start_date:start_date, end_date:end_date
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
		   $('#listar-financeiro').DataTable().destroy();
		   fetch_data('yes', start_date, end_date);
		  }
		  else
		  {
		   alert("Obrigatório informar o período");
		  }
		 }); 
		 
		}); 
</script>

<script>
	$('[data-dismiss=modal]').on('click', function (e) {
		$('#modalReceita').on('hidden.bs.modal', function () {
		$(this).find('form').trigger('reset');
		});
	});
</script>

<script>
	$('[data-dismiss=modal]').on('click', function (e) {
		$('#modalDespesa').on('hidden.bs.modal', function () {
		$(this).find('form').trigger('reset');
		});
	});
</script>
	
<script>
	$('[data-dismiss=modal]').on('click', function (e) {
		$('#modalAtualizaConta').on('hidden.bs.modal', function () {
		$(this).find('form').trigger('reset');
		});
	});
</script>
	
</body>

</html>
