<?php


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

	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
	}
$form=null



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
                    <h1 class="page-header">Procedimentos</h1>
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
						 <div class="col-sm-10">
								<h5> Convênio: </h5> 
									<h3> 
								<?php 
										$query = mysqli_query($mysql_conn, "SELECT * FROM convenio WHERE idconvenio='$id'");
										$row = mysqli_fetch_assoc($query);
										$row;
										printf("%s", $row['descricao']);
								?>
								</h3>
						 </div>
						
						<div class="col-sm-2">
						<br>
					    <button class="btn btn-primary" id="btnInserir">
										Inserir Procedimento
								</button>
						</div>
					</div>
			
                   
				
						</div>

						  <div class="panel-body">
							
                            <table width="100%" class="table table-striped table-bordered table-hover" id="listar-procedimentos">
                                <thead>
                                    <tr>
                                        <th>Procedimento</th>
										<th>Descrição</th>
										<th>Valor</th>
										<th></th>
										
                            		</tr>
                                </thead>
                                <tbody>
                                   <?php
										// Exibe a tabela procedimentos
									
										
										$query = mysqli_query($mysql_conn, "SELECT * FROM procedimentos WHERE idconvenio='$id'");
										
										// Extrai cada linha da tabela clientes
										while ($row = mysqli_fetch_assoc($query))
										{
									?>
									<tr style="cursor:pointer">
										<td><?=$row["idprocedimentos"]?></td>
										<td><?=$row["descricao"]?></td>
										<td><?=$row["valor"]?></td>
										<td><button type="button" id="btnExcluir" class="btn btn btn-primary" data-id='<?php echo $row["idprocedimentos"]?>'> <i class="glyphicon glyphicon-trash  ">&nbsp;</i>Excluir</button></td>
										<td><button type="button" id="btnEditar" class="btn btn btn-primary" data-id='<?php echo $row["idprocedimentos"]?>'><i class="glyphicon glyphicon-pencil">&nbsp;</i>Editar</button></td>
									</tr>
									<?php
										}
										
									?>
							</tbody>
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
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="myModalLabel">Inserir Procedimento</h4>
									</div>
									<div class="modal-body">
								 <form role="form" action="./sqlProcedimentos.php" method='post' enctype="multipart/form-data">
									
									<input type="hidden" name="id" id="id" value="<?php print $id ?>" />
									
									<input type="hidden" name="idprocedimentos" id="idprocedimentos"/>
									
									<div class="form-group">
										<label for="nome">Descrição</label>
										   <input class="form-control" id="descricao" name="descricao" value="">
                        			</div>
									<div class="form-group">
										<label for="valor">Valor</label>
										<input class="form-control" id="valor" name="valor" value="">
                        			</div>
									
									<div class="modal-footer">
										<button type="button" class="btn btn-default" id="btn-close" data-dismiss="modal">Fechar</button>
										<button type="submit" name="submit" id="btnsaveprocedimento" value="inserir" class="btn btn-success">Salvar</button>
										
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
			$(document).on('click','#btnInserir',function(e){
			e.preventDefault();
			$("#myModal").modal();
		});
	</script>
	
		<script>
		$(document).on('click','#btnExcluir',function(e){
            e.preventDefault();
		var id = $(this).data('id');
		 confirm("Excluir o procedimento ?" +id);
		location.assign("deleteProcedimentos.php?id="+id);
		});
	</script>	
	
	<script>
		$(document).on('click','#btnEditar',function(e){
        e.preventDefault();
		var id = $(this).data('id');
		confirm("Editar procedimento? " +id);
			var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var result = JSON.parse(this.responseText);
		document.getElementById("id").value = result[0][1];
		document.getElementById("idprocedimentos").value = id;
		document.getElementById("descricao").value = result[0][2];
		document.getElementById("valor").value = result[0][3];
		}
		
		};
		xmlhttp.open("GET", "operacoes_Procedimentos.php?id="+id, true);
		xmlhttp.send();
			$("#myModal").modal();
		});
	</script>	
	
	<script>
	$('[data-dismiss=modal]').on('click', function (e) {
		$('#myModal').on('hidden.bs.modal', function () {
		document.getElementById("idprocedimentos").value = null;
		$(this).find('form').trigger('reset');
		});
	});
	</script>
	
</body>

</html>
