<?php
session_start();
include '../opendb.php';
include_once('../func.php');

$empresa = getItensTable($mysql_conn,"empresa");
?>


<!DOCTYPE html>
<html lang="pt">

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
                    <h1 class="page-header">Profissionais</h1>
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
						
					    <button class="btn btn-primary" data-toggle="modal" data-target="#modalUsuario">Inserir Profissional</button>
						</div>
						 <div class="col-lg-10">
						</div>
					</div>
					</div>
					<div class="panel-body">
							<table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="listar-profissionais">
                                <thead>
                                    <tr>
									<!-- FILIAL CODIDGO DA UNIDADE - TIPO (RECEITA/DESPESA) - DESCRIÇÃO - CATEGORIA - DATA - VALOR - STATUS - BTN-DETALHES -->
										<th>ID</th>
										<th>Nome</th>
										<th>RG</th>
										<th>CPF</th>
										<th>Conselho</th>
										<th>Especialidade</th>
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
        <!-- /#page-wrapper -->

 
    <!-- /#wrapper -->

			<!-- Bootstrap Modal - To Add New Record -->
									<!-- Modal -->
				<div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="myModalLabel">Inserir Profissional</h4>
									</div>
								<div class="modal-body">
							    <form role="form" action="./sqlProfissionais.php" method='post' enctype="multipart/form-data">
									<input type="hidden" name="id" id="idprofissional" />
								<div class="row">
									<div class="form-group col-md-12">
										<label for="nome">Nome</label>
										   <input class="form-control" name="nome" id="nome">
                        			</div>
								</div>
								
								<div class="row">
									<div class="form-group col-md-6">
										<label>RG</label>
										 <input class="form-control" name="rg" id="rg">
									</div>
									<div class="form-group col-md-6">
										<label>CPF</label>
										 <input class="form-control" name="cpf" id="cpf">
									</div>
							</div>
									
								<div class="row">
									<div class="form-group col-md-6">
										<label>Conselho</label>
										 <input class="form-control" name="conselho" id="conselho">
									</div>
									<div class="form-group col-md-6">
										<label>Especialidade</label>
										 <input class="form-control" name="especialidade" id="especialidade">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-6">
										<label>Tipo Repasse</label>
										<select id="tipoRepasse" name="tipoRepasse" class="form-control"> 
											<option value="percentual">Percentual</option>
											<option value="valorFixo">Valor Fixo</option>								
									</select>
									</div>
									<div class="form-group col-md-6">
										<label>Valor</label>
										 <input class="form-control" name="valorRepasse" id="valorRepasse">
									</div>
								</div>
									<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
								
										<button type="submit" class="btn btn-success">Salvar</button>
									</div>	
								</form>
							</div>
						</div>
					</div>
				</div>
									
	</div>
    <!-- jQuery -->
    <script src="../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>
	
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    
<!--	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
<!--		<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>  -->

<!--  IMPORT PARA UTILIZACAO DOS BOTES DE IMPRIMIR, EXPORTAR EM CSV, PDF, EXCEL -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script> 
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
	
    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

    </script>
	
	
		<script>
   	$(document).ready(function() {
			var table = $('#listar-profissionais').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": {
					"url": "proc_profissionais.php",
					"type": "POST"
				}
				});
			});
	  </script>
	  
	
	<script>
		$(document).on('click','#btnExcluir',function(e){
            e.preventDefault();
		var id = $(this).data('id');
		 confirm("Excluir PROFISSIONAL ? " +id);
		location.assign("deleteProfissionais.php?id="+id);
		});
	</script>	
	
	
	<script>
		$(document).on('click','#btnEditar',function(e){
        e.preventDefault();
		var id = $(this).data('id');
		confirm("Editar PROFISSIONAL ? " +id);
		
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var result = JSON.parse(this.responseText);
		document.getElementById("idprofissional").value = id;
		document.getElementById("nome").value = result[0][1];
		document.getElementById("rg").value = result[0][2];
		document.getElementById("cpf").value = result[0][3];
		document.getElementById("conselho").value = result[0][4];
		document.getElementById("especialidade").value = result[0][5];
		document.getElementById("tipoRepasse").value = result[0][6];
		document.getElementById("valorRepasse").value = result[0][7];
		
		}
		
		};
		xmlhttp.open("GET", "operacoes_profissionais.php?id="+id, true);
		xmlhttp.send();
		$("#modalUsuario").modal();
		});

	</script>	

<script>
	$('[data-dismiss=modal]').on('click', function (e) {
		$('#modalUsuario').on('hidden.bs.modal', function () {
			document.getElementById("idprofissional").value = null;
		$(this).find('form').trigger('reset');
		});
	});
</script>	

</body>

</html>
