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
								<button class="btn btn-primary" data-toggle="modal" data-target="#avaliacao">Inserir Avaliação</button>
                
                                </div>
						</div>
					</div>
				</div>
        <div class="table-responsive">
						  <div class="panel-body">
							<table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="listar-">
                                <thead>
                                    <tr>
									<!-- FILIAL CODIDGO DA UNIDADE - TIPO (RECEITA/DESPESA) - DESCRIÇÃO - CATEGORIA - DATA - VALOR - STATUS - BTN-DETALHES -->
                                        <th>Avaliação</th>
                                        <th>avaliacao</th>
                                        <th></th>
                                        <th>Data</th>
                                        <th></th>
                                        <th></th>
										<th></th>
										
                                       </tr>
                                       
                                </thead>
                            </table>
                                  
                       
                        </div>
                        <!-- /.panel-body -->
                        </div> <!-- Table Responsive -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

<!-- Modal AVALIAÇÃO -->
<div class="modal fade" id="avaliacao" name="avaliacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myModalLabel">Avaliação</h4>
</div>
<div class="modal-body">
<form role="form" action="./sqlAvaliacao.php" method='post' enctype="multipart/form-data">

<input type="hidden" name="id5" id="id5" value="<?php print $id?>"/>



<div class="form-group">
<div id="sample">
  
  <textarea  class="form-control" name="area1" id="area1" style="width:500%;height:300px;">
      
  </textarea>
  
</div>
</div>

<div class="modal-footer">
  <button type="submit" class="btn btn-success">Inserir</button>
  <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
</div>
</form>


</div>
</div>
</div>
</div>

<!-- /Modal AVALIAÇÃO -->

<!-- Modal EDITAR -->
<div class="modal fade" id="avaliacao2" name="avaliacao2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myModalLabel">Editar Avaliação</h4>
</div>
<div class="modal-body">
<form role="form" action="./sqlEditarAvaliacao.php" method='post' enctype="multipart/form-data">

<input type="hidden" name="idpaciente" id="idpaciente" value="<?php print $id ?>"/>
<input type="hidden" name="id6" id="id6" value=""/>

<div class="form-group">

  
  <textarea  class="form-control area"  name="area3" id="area3" rows="6" style="width:500%;height:300px;">
  
  </textarea>
  

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
<!-- /Modal EDITAR -->

<!-- Modal Visualizar -->
<div class="modal fade" id="avaliacao3" name="avaliacao2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myModalLabel">Visualizar Avaliação</h4>
</div>
<div class="modal-body">
<form role="form" action="./sqlEditarAvaliacao.php" method='post' enctype="multipart/form-data">


<input type="hidden" name="id7" id="id7" value=""/>

<div class="form-group">

  
  <textarea  class="form-control area51" readonly  name="area4" id="area4" rows="6" style="width:500%;height:300px;">
  
  </textarea>
  

</div>

<div class="modal-footer">
  
<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
</div>
</form>


</div>
</div>
</div>
</div>
<!-- /Modal Visualizar -->

<script>
    //Cria o DataTable
   	$(document).ready(function() {
			var table = $('#listar-').DataTable({
				"processing": true,
				"serverSide": true,
				 "columnDefs": [
            {
                "targets": [1,2], //
                "visible": false,
                "searchable": false
            }],
				"ajax": {
					"url": "proc_avaliacao.php",
					"type": "POST"
				}
				});
			});
      </script>

<script>
        // Edita a Tabela
		$(document).on('click','#btnEditar2',function(e){
        //e.preventDefault();
		var id = $(this).data('id');
		confirm("Editar USUÁRIO ? " +id);
		
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var result = JSON.parse(this.responseText);
		
        document.getElementById("id6").value = result[0][0];
        console.log(document.getElementById("id6"));

        
        var nicInstance = nicEditors.findEditor('area3');
        var notes = nicInstance.getContent();
        nicInstance.setContent(result[0][1]);

        document.getElementById("area3").innerHTML = result[0][1];
        console.log(document.getElementById("area3"));
        //console.log(result[0][1])
        console.log( nicInstance);
        console.log( notes);
		//document.getElementById("empresa").value = result[0][5];
		
		}
		
		};
		xmlhttp.open("GET", "operacoes_avaliacao.php?id="+id, true);
		xmlhttp.send();
        $("#avaliacao2").modal();
		});

    </script>	


<script>
        // Visualizar Tabela
		$(document).on('click','#btnVisualizar2',function(e){
        //e.preventDefault();
		var id = $(this).data('id');
		//confirm("Editar USUÁRIO ? " +id);
		
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var result = JSON.parse(this.responseText);
		
        document.getElementById("id7").value = result[0][0];
        console.log(document.getElementById("id7"));

        
        var nicInstance = nicEditors.findEditor('area4');
        var notes = nicInstance.getContent();
        nicInstance.setContent(result[0][1]);

        document.getElementById("area4").innerHTML = result[0][1];
        console.log(document.getElementById("area4"));
        //console.log(result[0][1])
        console.log( nicInstance);
        console.log( notes);

        nicInstance.disable();
		}
		
		};
		xmlhttp.open("GET", "operacoes_avaliacao.php?id="+id, true);
		xmlhttp.send();
        $("#avaliacao3").modal();
		});

    </script>	


<script>
//Excluir Avaliação
		$(document).on('click','#btnExcluir2',function(e){
    e.preventDefault();
		var id = $(this).data('id');
		 confirm("Excluir USUÁRIO ? " +id);

     var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		var result = JSON.parse(this.responseText);
		
        var idpaciente = <?php print $id?>;
       
        
        location.assign("deleteAvaliacao.php?id="+id+"&idpaciente="+idpaciente);
		}
    
		};
		xmlhttp.open("GET", "operacoes_avaliacao.php?id="+id, true);
		xmlhttp.send();


		
		});
</script>	



<script type="text/javascript">
         // convert all text areas to rich text editor on that page

        bkLib.onDomLoaded(function() {
             new nicEditor().panelInstance('area1');
        }); // convert text area with id area1 to rich text editor.

        bkLib.onDomLoaded(function() {
             new nicEditor().panelInstance('area3');
        }); // convert text area with id area1 to rich text editor.

        bkLib.onDomLoaded(function() {
             new nicEditor().panelInstance('area4');
        }); // convert text area with id area1 to rich text editor.

</script>

<script type="text/javascript">
//<![CDATA[
  bkLib.onDomLoaded(function() {
        
        new nicEditor({fullPanel : true,maxHeight : 200}).panelInstance('area1');
        new nicEditor({fullPanel : true,maxHeight : 200}).panelInstance('area3');
        new nicEditor({fullPanel : true,maxHeight : 200}).panelInstance('area4');
  });
  //]]>
  </script>