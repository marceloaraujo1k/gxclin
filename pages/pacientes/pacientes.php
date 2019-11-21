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
					
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 <!-- /.panel-heading -->
                      	<div class="row">
							<div class="col-lg-2">
								<button  type="button" class="btn btn-primary" title="Editar dado" onclick="location.assign('inserirPacientes.php')">
										Novo Paciente</button>
									
							</div>
							<div class="col-lg-10">
						 
							</div>
						</div>
				
						</div>

						  <div class="panel-body">
						  <!-- AS DUAS LINHAS SEGUINTES FAZEM O DATATABLE TRABALHAR CORRETAMENTE NA MUDANÇA DE ZOOM -->
							<div class="table-responsive"> 
								<table  class="table table-striped  table-bordered  table-hover dt-responsive display nowrap" cellspacing="0" id="listar-pacientes">
                        
                           <!-- <table width="100%" class="table table-striped table-bordered table-hover" id="listar-pacientes"> -->
                                <thead>
                                    <tr>
										<th>Código</th>
										<th>Nome</th>
										<th>Nascimento</th>
										<th>Cidade</th>
                                    	<th>Filial</th>
										<th> </th>
										<th> </th>
										<th> </th>
										<th> </th>
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
        <!-- /#page-wrapper -->
	</div>
 
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
    	$(document).ready(function() {
			$('#listar-pacientes').DataTable({			
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "proc_pesq_user.php",
					"type": "POST"
				}
			});
		} );
    </script>
	
	
	<script>
		$(document).on('click','#btnProntuario',function(e){
            e.preventDefault();
		var id = $(this).data('id');
		window.open("prontuarios.php?id="+id,"prontuario");
		});
		</script>
		
	<script>
		$(document).on('click','#btnEditar',function(e){
            e.preventDefault();
		var id = $(this).data('id');
		location.assign("inserirPacientes.php?edit&id="+id);
		});
	</script>	
		
	<script>
		$(document).on('click','#btnExcluir',function(e){
            e.preventDefault();
		var id = $(this).data('id');
		 confirm("Excluir o paciente ?" +id);
		location.assign("deletePacientes.php?id="+id);
		});
	</script>	
	
	<script>
		$(document).on('click','#btnAgendar',function(e){
            e.preventDefault();
		var id = $(this).data('id');
		location.assign("../agendamento/inserirAgendamento.php?add&id="+id);
		});
	</script>	
	
	
	
	
</body>

</html>
