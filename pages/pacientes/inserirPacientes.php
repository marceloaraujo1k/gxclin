<?php

session_start();
include '../opendb.php';

include_once('../func.php');


$form=null;

if(isset($_GET["edit"]))
					{
						$id = $_GET["id"];
						$query = mysqli_query($mysql_conn, "SELECT * FROM pacientes WHERE idpaciente='$id'");
						$row = mysqli_fetch_assoc($query);
						$form = $row;
						
			}		

$convenios = getItensTable($mysql_conn,"convenio");
$empresa = getItensTable($mysql_conn,"empresa");
$sexo = array("","MASCULINO","FEMININO");
$estado_civil = array("","SOLTEIRO(A)","CASADO(A)","SEPARADO(A)","DIVORCIADO(A)","VÍUVO(A)");
$estados = array("","ACRE","ALAGOAS","AMAPÁ","AMAZONAS","BAHIA","CEARÁ","DISTRITO FEDERAL","ESPIRITO SANTO","GOIÁS",
				"MARANHÃO","MATO GROSSO DO SUL","MATO GROSSO","MINAS GERAIS","PARÁ","PARAÍBA","PARANÁ","PERNAMBUCO",
				"PIAUÍ","RIO DE JANEIRO","RIO GRANDE DO NORTE","RIO GRANDE DO SUL","RONDÔNIA","RORAIMA","SANTA CATARINA",
				"SÃO PAULO","SERGIPE","TOCANTINS");	
				
$cid = getItensTable($mysql_conn,"cid");

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
                    <h1 class="page-header">Pacientes</h1>
                </div>
                <!-- /.col-lg-12 -->
				</div>
		
		          <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pacientes
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
						<!-- informacoes do paciente -->
                        <form role="form" action="./sqlPacientes.php" method='post'>
						<div class="row">
						<input type="hidden" name="idpaciente" id="idpaciente" value="<?=$form["idpaciente"]?>"> 
						<div class="form-group col-md-4">
								 <label>Nome </label>
                                <input class="form-control" name="nome" id="nome" value="<?=$form["nome"]?>" required>
                                <p class="help-block"></p>
						</div>
						<div class="form-group col-md-2">
							  <label for="inputEstado">Sexo</label>
							  <select id="inputEstado" name="sexo" class="form-control" required> 
								<?php
									for($i=0; $i<count($sexo); $i++)
									{
										if($form["sexo"] == $sexo[$i])
										{
								?>
											<option value="<?=$sexo[$i]?>" selected><?=$sexo[$i]?></option>
								<?php
										}
										else
										{
								?>
											<option value="<?=$sexo[$i]?>"><?=$sexo[$i]?></option>
								<?php
										}
									}
								?>
							  </select>
							</div>
						
						 <div class="form-group col-md-2">
							  <label for="datanascimento">Data Nascimento</label>
							  <input type="date" class="form-control" name="nascimento" value="<?=$form["nascimento"]?>">
							</div>
						</div>
						
						<!-- dados pessoais paciente -->
					<div class="row">
						<div class="form-group col-md-2">
							  <label for="inputEstCivil">Estado Civil</label>
							 <select id="inputEst_Civil" name="estado_civil" class="form-control"> 
								<?php
									for($i=0; $i<count($estado_civil); $i++)
									{
										if($form["estado_civil"] == $estado_civil[$i])
										{
								?>
											<option value="<?=$estado_civil[$i]?>" selected><?=$estado_civil[$i]?></option>
								<?php
										}
										else
										{
								?>
											<option value="<?=$estado_civil[$i]?>"><?=$estado_civil[$i]?></option>
								<?php
										}
									}
								?>
							  </select>
						</div>
						<div class="form-group col-md-1">
							  <label for="inputCity">Identidade</label>
							 <input class="form-control" name="rg" value="<?=$form["rg"]?>">
							</div>
						<div class="form-group col-md-1">
							  <label for="inputCity">CPF</label>
							 <input class="form-control" name="cpf" value="<?=$form["cpf"]?>">
						</div>

						 <div class="form-group col-md-2">
							  <label for="inputCity">Código</label>
							 <input class="form-control" name="codigo" value="<?=$form["codigo"]?>">
						</div>
						
						<div class="form-group col-md-2">
							  <label for="inputCity">CID</label>
								 <select id="input_cid" name="cid" class="form-control"> 
								<?php
						for($i=0; $i<count($cid); $i++)
						{
						if($form["cid"] == $cid[$i]['cat'])
						{	
						?>
						<option value="<?=$cid[$i]['cat']?>" selected><?=$cid[$i]['descrabrev']?></option>
						<?php
						}
						else
						{
						?>
						<option value="<?=$cid[$i]['cat']?>" ><?=$cid[$i]['descrabrev']?></option>
						<?php
						}
						}
						?>
							  </select>
						</div>
						
							
					</div>
								
						<!--filiacao-->
					<div class="row">
							<div class="form-group col-md-4">
								<label for="inputCity">Pai</label>
							   <input class="form-control" name="pai" value="<?=$form["pai"]?>">
							</div>
						    <div class="form-group col-md-4">
							  <label for="inputCity">Mãe</label> 
							  <input class="form-control" name="mae" value="<?=$form["mae"]?>">
							</div>
					</div>
					<div class="row">
						   <div class="form-group col-md-3">
							  <label for="inputCity">Endereço</label>
							 <input class="form-control" name="endereco" value="<?=$form["endereco"]?>">
							</div>
							 <div class="form-group col-md-2">
							  <label for="inputCity">Bairro</label> 
							  <input class="form-control" name="bairro" value="<?=$form["bairro"]?>">
							</div>
						    <div class="form-group col-md-2">
							  <label for="inputCity">Munícipio</label>
							  <input class="form-control" name="municipio" value="<?=$form["municipio"]?>">
							</div>
						
								<div class="form-group col-md-1">
							  <label for="inputCEP">CEP</label>
							 <input class="form-control" name="cep" value="<?=$form["cep"]?>">
							</div>
					</div>
					<div class="row"> 
								<div class="form-group col-md-2">
							  <label for="inputEstado">Estado</label>
							  <select id="inputEstado"  name="estado" class="form-control">
									<?php
									for($i=0; $i<count($estados); $i++)
									{		
									if($form["estado"] == $estados[$i])
									{
									?>
									<option value="<?=$estados[$i]?>" selected><?=$estados[$i]?></option>
									<?php
									}
									else
									{
									?>
									<option value="<?=$estados[$i]?>"><?=$estados[$i]?></option>
									<?php
									}
									}
									?>		
							</select>
							</div>
						
								<div class="form-group col-md-2">
									<label for="inputCEP">Tel. Resid.</label>
									<input class="form-control" name="telefone" value="<?=$form["telefone"]?>">
								</div>
								<div class="form-group col-md-2">
									<label for="inputCEP">Celular</label>
									<input class="form-control" name="celular" value="<?=$form["celular"]?>">	
								</div>
								<div class="form-group col-md-2">
									<label for="inputCEP">Tel. Trabalho</label>
									<input class="form-control" name="tel_trabalho" value="<?=$form["tel_trabalho"]?>">	
							</div>
							
					</div>
					<div class="row"> 
						<div class="form-group col-md-3">
						<label for="convenio">Convênio</label>
						<select id="convenio" name="idconvenio" class="form-control" required>
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
						
							
						<div class="form-group col-md-3">
							<label for="inputCodCarteira">Número da Carteira</label>
							<input class="form-control" name="cod_carteira" value="<?=$form["cod_carteira"]?>">	
						</div>
						
						<div class="form-group col-md-2">
							<label for="labelValidadeCarteira">Validade Carteira</label>
							<div class='input-group date' id='validade_carteira'>
							<input type='text' class="form-control"  name="validade_carteira">
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
							</span>
							</div>
						</div>
					</div>
			
					<div class="row"> 
						<div class="form-group col-md-4">
						<label for="empresa">Filial</label>
						<select id="empresa" name="idempresa" class="form-control" required>
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
						
							
						<div class="form-group col-md-4">
							<label for="inputCodCarteira">Responsável</label>
							<input class="form-control" name="responsavel" value="<?=$form["responsavel"]?>">	
						</div>
			
						</div>
					
					<div class="row"> 	
						<div class="form-group col-md-2">
									<label for="inputCEP">Email</label>
									<input class="form-control" name="email" value="<?=$form["email"]?>">	
							</div>
						
						 <div class="form-group col-md-2">
							  <label for="inputCity">Login</label>
							 <input class="form-control" name="login" value="<?=$form["login"]?>">
							</div>
							
						
						 <div class="form-group col-md-2">
							  <label for="inputCity">Senha</label>
							 <input class="form-control" name="senhaweb" value="<?=$form["senhaweb"]?>">
							</div>
				
					
					<div class="form-group col-md-2">
					<label for="labelDataCadastro">Data Cadastro</label>
							<div class='input-group date' id='data_cadastro'>
							<input type='text' class="form-control"  name="data_cadastro">
							<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
						</div>
					</div>
					</div>
				
					<div class="row">
						   <div class="form-group col-md-8">
                                <label>Observações</label>
                                <textarea class="form-control" name="observacao" rows="2" ><?=$form["observacao"]?></textarea>
                            </div>
					</div>
						
						 <div class="row"> 
							<div class="form-group col-md-6">
								<input type="submit" name="submit" value="alterar" class="btn btn-success" />
								<input type="submit" name="submit" value="inserir" class="btn btn-success" />
							</div>				
						</div>
						
					</form>
						</div>
                       </div>	
                        </div>
                        <!-- /.panel-body -->
                    </div>
		
		            <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
       
            <!-- /.row -->
			 <!-- /.row -->
            </div>
			
        </div>
        <!-- /#page-wrapper -->

 
    <!-- /#wrapper -->

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
	
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
	
	<script>
		$( document ).ready(function() {
			if (document.getElementById('nome').value=="" ) {
			$('#data_cadastro').datetimepicker({
				defaultDate: new Date(),			
				format:'DD/MM/YYYY'
			});
			}
			else {
			var data = "<?php echo $form["data_cadastro"]?>";
			$('#data_cadastro').datetimepicker({			
				defaultDate: data,			
				format:'DD/MM/YYYY'
			});
			}
		});
	</script>

	<script>
		$( document ).ready(function() {
			if (document.getElementById('nome').value=="" ) {
			$('#validade_carteira').datetimepicker({
				defaultDate: new Date(),			
				format:'DD/MM/YYYY'
			});
			}
			else {
		
			var data = "<?php echo $form["validade_carteira"]?>";
			$('#validade_carteira').datetimepicker({			
				defaultDate: data,			
				format:'DD/MM/YYYY'
			});
			}
		});
	</script>
	

</body>

</html>
