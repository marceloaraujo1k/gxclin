<?php
session_start();
include '../opendb.php';
include_once('../func.php');


// Status Documentos = (OK,SOLICITAR VALIDAÇÃO,DOCUMENTO INVÁLIDO) - Incluir o prazo de validade por meses DT ATUALIZAÇÃO, DT VALIDADE


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

    <!-- INCLUSÃO DO ARQUIVO MENU -->
	<?php include_once('../menu.php'); ?>
		

        <div id="page-wrapper">
			
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Documentos</h1>
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
							<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
										Inserir Documento
							</button>
							</div>
							<div class="col-lg-10">
							</div>
						</div>
			
                   
				
						</div>

						  <div class="panel-body">
							
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
										<th>Data Criação</th>
										<th>Validade</th>
										<th>Status</th>
										<th>Arquivo</th>

												
										<th></th>
										<th></th>
										<th></th>
                            		</tr>
                                </thead>
                                <tbody>
                                   <?php
										// Exibe a tabela prontuarios
									
										
										$query = mysqli_query($mysql_conn, "SELECT * FROM documentos");
										
										// Extrai cada linha da tabela clientes
										while ($row = mysqli_fetch_assoc($query))
										{
									?>
									<tr style="cursor:pointer">
										<td><?=$row["descricao"]?></td>
										<td><?=date('d/m/Y', strtotime($row["data"]))?></td>
										<td><?=date('d/m/Y', strtotime($row["validade"]))?></td>
										<td><?=""?></td>
								
										<td><?=$row["arquivo"]?></td>
										<td><button  type="button" class="btn btn-primary" title="Editar dado" onclick="window.open('visualizarDocumentos.php?id=<?=$row["iddocumentos"]?>')">
											<i class="glyphicon glyphicon-pencil  ">&nbsp;</i>Visualizar</button>
										</td>
										<td><button type="button" value="deletar" class="btn btn-primary" onclick="window.open('deleteDocumentos.php?id=<?=$row["iddocumentos"]?>')"><i class="glyphicon glyphicon-trash  ">&nbsp;</i>Excluir</button>
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
										<h4 class="modal-title" id="myModalLabel">Inserir Documentos</h4>
									</div>
									<div class="modal-body">
								 <form role="form" action="./sqlDocumentos.php" method='post' enctype="multipart/form-data">
									
									<input type="hidden" name="id" id="id" value="<?php print $row["$iddocumentos"] ?>" />
									
									<div class="form-group">
										<label for="nome">Descrição</label>
											<input class="form-control" name="descricao" value="<?=$row["descricao"]?>">
                        			</div>
									<div class="form-group">
										<label for="nome">Data</label>
										<input type="date" id="dataInicio" name="dataInicio"  placeholder="data" class="form-control" value="<?= date("d-m-Y")?>">
									</div>
									<div class="form-group">
										<label for="nome">Prazo de validade (meses)</label>
										   <input class="form-control" id="prazo" name="prazo" value="">
                        			</div>
									<div class="form-group">
										<label for="nome">Validade</label>
										<input type="date" id="limiteFim" name="limiteFim"  placeholder="data" class="form-control" value="<?= date("d-m-Y")?>">
									</div>
									<div class="form-group">
										<label>Documento</label>
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
	
	<script>
	
	</script>

	<script>
	document.getElementById("prazo").onblur = function() {calculeData()};
	function calculeData() {
	
	function dateZero(data){
		var aux = data.split('-');
		data = (aux[0].replace(/^0+/, '')+'-'+aux[1].replace(/^0+/, '')+'-'+aux[2].replace(/^0+/, ''));
		return data;
	}
	
	var dataInicio = document.getElementById("dataInicio").value;
	
	dataInicio2=(dateZero(dataInicio));
	var dataInicio2 = new Date(dataInicio2);
	var prazo = document.getElementById("prazo").value;
	prazo=prazo-1;
	var limiteFim = new Date(dataInicio2.getFullYear(),
                        dataInicio2.getMonth(),
                         dataInicio2.getDate());
						
	 document.getElementById("limiteFim").value=limiteFim.getFullYear()+"-"+limiteFim.getMonth()+"-"+limiteFim.getDate();
	}
	</script>
	
	
</body>

</html>
