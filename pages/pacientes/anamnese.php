<?php 
				include '../opendb.php';
				include_once('../func.php');
										$id = $_GET["id"];						
										$query = mysqli_query($mysql_conn, "SELECT * FROM pacientes WHERE idpaciente='$id'");
										$row = mysqli_fetch_assoc($query);
										$form = $row;
										//printf("%s", $form['nome']);
								?>
			
          

						<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 <!-- /.panel-heading -->
                      	<div class="row">
						 <div class="col-sm-10">
								
						 </div>
						
						<div class="col-sm-2">
						<br>
					
								<div class="btn-group">
								<button class="btn btn-primary" data-toggle="modal" data-target="#anamnese">Inserir Anamnese</button>
                
                                </div>
						</div>
					</div>
				</div>

				<div class="table-responsive">
						  <div class="panel-body">
							<table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="listar-usuarios">
                                <thead>
                                    <tr>
									<!-- FILIAL CODIDGO DA UNIDADE - TIPO (RECEITA/DESPESA) - DESCRIÇÃO - CATEGORIA - DATA - VALOR - STATUS - BTN-DETALHES -->
                                        <th>Anamnese</th>
                                        <th>paciente</th>
                                        <th>Q.P</th>
                                        <th>H.D.A</th>
                                        <th>A.P</th>
                                        <th>A.F</th>
                                        <th>Data</th>
                                        <th></th>
										<th></th>
										<th></th>
									   </tr>
                                </thead>
                            </table>
                                  <!-- /.table-responsive -->
                       
                        </div>
                        <!-- /.panel-body -->
						</div> <!-- Table Responsive -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

<!-- Modal INSERIR ANAMNESE -->
<div class="modal fade" id="anamnese" name="anamnese" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myModalLabel">Anamnese</h4>
</div>
<div class="modal-body">
<form role="form" action="./sqlAnamnese.php" method='post' enctype="multipart/form-data">

<input type="hidden" name="id3" id="id3" value="<?php print $id ?>"/>

<div class="form-group">
  <label for="nome">Q.P:</label>
  <textarea class="form-control" id="qp" value="<?= $form["atendimento"] ?>" name="qp" rows="6"></textarea>
</div>

<div class="form-group">
  <label for="nome">H.D.A:</label>
  <textarea class="form-control" id="hda" value="<?= $form["atendimento"] ?>" name="hda" rows="6"></textarea>
</div>

<div class="form-group">
  <label for="nome">A.P:</label>
  <textarea class="form-control" id="ap" value="<?= $form["atendimento"] ?>" name="ap" rows="6"></textarea>
</div>

<div class="form-group">
  <label for="nome">A.F:</label>
  <textarea class="form-control" id="af" value="<?= $form["atendimento"] ?>" name="af" rows="6"></textarea>
</div>


<div class="modal-footer">
  <button type="submit" class="btn btn-success">Salvar</button>
  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
</div>
</form>


</div>
</div>
</div>
</div>

<!-- MODAL EDITAR -->
<div class="modal fade" id="anamnese2" name="anamnese2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myModalLabel">Editar Anamnese</h4>
</div>
<div class="modal-body">
<form role="form" action="./sqlEditarAnamnese.php" method='post' enctype="multipart/form-data">

<input type="hidden" name="id4" value="" id="id4">
<input type="hidden" name="idpaciente" id="idpaciente" value="<?php print $id ?>">
<div class="form-group">
  <label for="nome">Q.P:</label>
  <textarea class="form-control" id="qp2"  name="qp2" rows="6"></textarea>
  
</div>

<div class="form-group">
  <label for="nome">H.D.A:</label>
  <textarea class="form-control" id="hda2"  name="hda2" rows="6"></textarea>
</div>

<div class="form-group">
  <label for="nome">A.P:</label>
  <textarea class="form-control" id="ap2"  name="ap2" rows="6"></textarea>
</div>

<div class="form-group">
  <label for="nome">A.F:</label>
  <textarea class="form-control" id="af2"  name="af2" rows="6"></textarea>
</div>


<div class="modal-footer">
  <button type="submit" class="btn btn-success">Salvar</button>
  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
</div>

</form>


</div>
</div>
</div>
</div>
<!-- /MODAL EDITAR -->

<!-- MODAL VISUALIZAR -->
<div class="modal fade" id="anamnese3" name="anamnese2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myModalLabel">Visualizar Anamnese</h4>
</div>
<div class="modal-body">
<form role="form" action="./sqlEditarAnamnese.php" method='post' enctype="multipart/form-data">



<div class="form-group">
  <label for="nome">Q.P:</label>
  <textarea class="form-control" readonly id="qp3"  name="qp3" rows="6"></textarea>
  
</div>

<div class="form-group">
  <label for="nome">H.D.A:</label>
  <textarea class="form-control" readonly id="hda3"  name="hda3" rows="6"></textarea>
</div>

<div class="form-group">
  <label for="nome">A.P:</label>
  <textarea class="form-control" readonly id="ap3"  name="ap3" rows="6"></textarea>
</div>

<div class="form-group">
  <label for="nome">A.F:</label>
  <textarea class="form-control" readonly id="af3"  name="af3" rows="6"></textarea>
</div>

<div class="modal-footer">
  
  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
</div>


</form>


</div>
</div>
</div>
</div>

<!-- /MODAL VISUALIZAR -->

<script>
    //Cria o DataTable
   	$(document).ready(function() {
			var table = $('#listar-usuarios').DataTable({
				"processing": true,
				"serverSide": true,
				 "columnDefs": [
            {
                "targets": [1,2,3,4,5], //Deixa a coluna 2,3,4 e 5 invisíveis
                "visible": false,
                "searchable": false
            }],
				"ajax": {
					"url": "proc_anamnese.php",
					"type": "POST"
				}
				});
			});
      </script>
      


      <script>
        // Edita a Tabela
		$(document).on('click','#btnEditar',function(e){
        e.preventDefault();
		var id = $(this).data('id');
		confirm("Editar USUÁRIO ? " +id);
		
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var result = JSON.parse(this.responseText);
		
        document.getElementById("id4").value = result[0][0];
        console.log(document.getElementById("id4"));
		document.getElementById("qp2").value = result[0][1];
		document.getElementById("hda2").value = result[0][2];
		document.getElementById("ap2").value = result[0][3];
		document.getElementById("af2").value = result[0][4];
		//document.getElementById("empresa").value = result[0][5];
		
		}
		
		};
		xmlhttp.open("GET", "operacoes_anamnese.php?id="+id, true);
		xmlhttp.send();
		$("#anamnese2").modal();
		});

    </script>	
    
    <script>
        // Visualiza a Tabela
		$(document).on('click','#btnVisualizar',function(e){
        e.preventDefault();
		var id = $(this).data('id');
		//confirm("Visualizar Anamnese ? " +id);
		
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var result = JSON.parse(this.responseText);
		
        
        
		document.getElementById("qp3").value = result[0][1];
		document.getElementById("hda3").value = result[0][2];
		document.getElementById("ap3").value = result[0][3];
		document.getElementById("af3").value = result[0][4];
		//document.getElementById("empresa").value = result[0][5];
		
		}
		
		};
		xmlhttp.open("GET", "operacoes_anamnese.php?id="+id, true);
		xmlhttp.send();
		$("#anamnese3").modal();
		});

	</script>	


<script>
//Excluir Anamnese
		$(document).on('click','#btnExcluir3',function(e){
    e.preventDefault();
		var id = $(this).data('id');
		 confirm("Excluir USUÁRIO ? " +id);

     var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var result = JSON.parse(this.responseText);
		
        var idpaciente = <?php print $id?>;
       
        
        location.assign("deleteAnamnese.php?id="+id+"&idpaciente="+idpaciente);
		}
    
		};
		xmlhttp.open("GET", "operacoes_anamnese.php?id="+id, true);
		xmlhttp.send();


		
		});
</script>	






		