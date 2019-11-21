<?php 
/* esse bloco de código em php verifica se existe a sessão, pois o usuário pode
 simplesmente não fazer o login e digitar na barra de endereço do seu navegador 
o caminho para a página principal do site (sistema), burlando assim a obrigação de 
fazer um login, com isso se ele não estiver feito o login não será criado a session, 
então ao verificar que a session não existe a página redireciona o mesmo
 para a index.php.*/
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
			<!-- INCLUSÃO DO ARQUIVO MENU -->
		<?php include_once('../menu.php'); ?>
        <div id="page-wrapper">
			
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Convênios</h1>
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
							<div class="col-lg-2">
								<button  type="button" class="btn btn-primary" title="Editar dado" onclick="location.assign('inserirConvenios.php')">
										Novo Convenio</button>
									
							</div>
							<div class="col-lg-10">
							</div>
						</div>
					</div>

									<div class="row">	
													<div class="form-group col-md-12">
													<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-convenio">
													<thead>
														<tr>
															<th>CNPJ</th>
															<th>Descrição</th>
															<th></th>
															<th></th>
															<th></th>
														</tr>
													</thead>
													<tbody>
													   <?php
															// Exibe a tabela 
															$query = mysqli_query($mysql_conn, "SELECT * FROM  convenio");
															
															// Extrai cada linha da tabela clientes
															while ($form = mysqli_fetch_assoc($query))
														
															{
														?>
														<tr style="cursor:pointer">
															<td><?=$form["cnpj"]?></td>
															<td><?=$form["descricao"]?></td>
															<td><button type="button" id="btnAlterar" class="btn btn btn-primary" data-id=<?=$form["idconvenio"]?> > <i class="glyphicon glyphicon-pencil  ">&nbsp;</i>Editar</button></td>
															<td><button type="button" id="btnExcluir" class="btn btn btn-primary" data-id=<?=$form["idconvenio"]?> > <i class="glyphicon glyphicon-trash  ">&nbsp;</i>Excluir</button></td>
															<td><button type="button" id="btnProcedimentos" class="btn btn btn-primary" data-id=<?=$form["idconvenio"]?> > <i class="glyphicon glyphicon-pencil  ">&nbsp;</i>Procedimentos</button></td>
														
														</tr>
														<?php
															}
															
														?>
												</tbody>
												</table>
												</div>
											</div>
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
        <!-- /#page-wrapper -->

 
    <!-- /#wrapper -->

	
			


	<!-- jQuery -->
    <script src="../../vendor/jquery/jquery.min.js"></script> 

    <!-- Bootstrap Core JavaScript -->
   <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script> 

    <!-- Metis Menu Plugin JavaScript  -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>
	
	<!-- DataTables JavaScript  --> 
    <script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
	<script src="../../dist/js/sb-admin-2.js"></script>

		
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
 
	<script>
		$(document).on('click','#btnAlterar',function(e){
            e.preventDefault();
		var id = $(this).data('id');
		location.assign("inserirConvenios.php?edit&id="+id);
		});
	</script>	
		
	<script>
		$(document).on('click','#btnExcluir',function(e){
            e.preventDefault();
		var id = $(this).data('id');
		 confirm("Excluir o convênio ?" +id);
		location.assign("deleteConvenios.php?id="+id);
		});
	</script>	
		
		
	<script>
		$(document).on('click','#btnProcedimentos',function(e){
            e.preventDefault();
		var id = $(this).data('id');
		window.open("procedimentos.php?id="+id,"procedimentos");
		});
		</script>
		
</body>

</html>
