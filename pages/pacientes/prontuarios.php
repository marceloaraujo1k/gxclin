<?php
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
                    <h1 class="page-header">Prontuários</h1>
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
								<h5> Paciente: </h5> 
									<h3> 
								<?php 
										$query = mysqli_query($mysql_conn, "SELECT * FROM pacientes WHERE idpaciente='$id'");
										$row = mysqli_fetch_assoc($query);
										$form = $row;
										printf("%s", $form['nome']);
								?>
								</h3>
						 </div>
						
						<div class="col-sm-2">
						<br>
					    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
										Inserir Prontuário
								</button>
						</div>
					</div>
			
                   
				
						</div>

						  <div class="panel-body">
							
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Prontuario</th>
										<th>Arquivo</th>
										<th>Data prontuário</th>
										<th>Cod.Paciente</th>
										<th></th>
										<th></th>
										<th></th>
                            		</tr>
                                </thead>
                                <tbody>
                                   <?php
										// Exibe a tabela prontuarios
									
										
										$query = mysqli_query($mysql_conn, "SELECT * FROM prontuarios WHERE idpaciente='$id'");
										
										// Extrai cada linha da tabela clientes
										while ($row = mysqli_fetch_assoc($query))
										{
									?>
									<tr style="cursor:pointer">
										<td><?=$row["idprontuario"]?></td>
										<td><?=$row["arquivo"]?></td>
										<td><?=date('d/m/Y', strtotime($row["data"]))?></td>
										<td><?=$row["idpaciente"]?></td>
										<td><button  type="button" class="btn btn-primary" title="Editar dado" onclick="window.open('visualizarProntuario.php?id=<?=$row["idprontuario"]?>')">
											<i class="glyphicon glyphicon-file">&nbsp;</i>Visualizar</button>
										</td>
										<td><button type="button" value="deletar" class="btn btn-danger" title="Excluir cliente" onclick="window.open('deleteProntuarios.php?id=<?=$row["idprontuario"]?>')">
											<i class="glyphicon glyphicon-trash  ">&nbsp;</i>Excluir</button>
										</td>
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
										<h4 class="modal-title" id="myModalLabel">Inserir Prontuário</h4>
									</div>
									<div class="modal-body">
								 <form role="form" action="./sqlProntuarios.php" method='post' enctype="multipart/form-data">
									
									<input type="hidden" name="id" id="id" value="<?php print $id ?>" />
									
									<div class="form-group">
										<label for="nome">Nome</label>
										   <input class="form-control" name="nome" value="<?=$form["nome"]?>">
                        			</div>
									<div class="form-group">
										<label for="nome">Atendimento</label>
										   <textarea class="form-control" name="atendimento" rows="6" ></textarea>
                        			</div>
									<div class="form-group">
										<label for="nome">Data</label>
										<input type="date" name="data"  placeholder="data" class="form-control" value="<?= date("d-m-Y")?>">
									</div>
									
									<div class="form-group">
										<label>Anexo</label>
										<input type="file" name="userfile" value="<?=$form["arquivo"]?>"> 
									</div>
								
									<div class="modal-footer">
										<button type="submit" class="btn btn-success">Enviar</button>
										
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
	

	
</body>

</html>
