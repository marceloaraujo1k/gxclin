<?php 
				
				include '../opendb.php';
				include_once('../func.php');
										$id = $_GET["id"];						
										$query = mysqli_query($mysql_conn, "SELECT * FROM pacientes WHERE idpaciente='$id'");
										$row = mysqli_fetch_assoc($query);
										$form = $row;
										//printf("%s", $form['nome']);

										if (isset($_GET["id"])) {
											$id = $_GET["id"];
										  }
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
						
						<!--
						<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
										Inserir Prontuário
								</button>

								
						-->
								<div class="btn-group">
								<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Inserir Prontuário</button>
                
                                </div>
						</div>
					</div>
				</div>

				


     <div class="table-responsive">
				<div class="panel-body">

<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
  <thead>
  <tr>
	<th>Prontuario</th>
	<th>Arquivo</th>
	<th>Data prontuário</th>
	<th>Cod.Paciente</th>
	<th>Atendimento</th>
	<th></th>
	<th></th>
  </tr>
  </thead>

  <tbody>
  <?php
	// Exibe a tabela prontuarios


	$query = mysqli_query($mysql_conn, "SELECT * FROM prontuarios WHERE idpaciente='$id'");

	// Extrai cada linha da tabela clientes
	while ($row = mysqli_fetch_assoc($query)) {
	  $prontuarioID = $row['idprontuario'];
	  ?>

	  <tr style="cursor:pointer">
		<td><?= $row["idprontuario"] ?></td>
		<td><?= $row["arquivo"] ?></td>
		<td> <?= date('d/m/Y', strtotime($row["data"])) ?> </td>
	<!--	<td> //$row["idpaciente"] </td> -->
		<td>

		  <input type="hidden" value="<?php if ($row["locked"] == 1) {
			echo 1;
		  } ?>">

		  <button type="button" class="btn btn-primary" title="Editar dado" onclick="window.open('visualizarProntuario.php?id=<?= $row["idprontuario"] ?>')">

			<i class="glyphicon glyphicon-eye-open">&nbsp;</i>Visualizar
		  </button>

		</td>

		<td>

		  <!-- Abre o modal -->
		  <button class="btn btn-primary editar" data-toggle="modal" data-target="#myModalEdit" value="<?= $row['idprontuario'] ?>" data-text="<?= $row['atendimento'] ?>" data-locked="<?= $row['locked'] ?>">

			<i class="glyphicon glyphicon-edit">&nbsp;</i> Editar

		  </button>


		</td>

		<td>
		  <button type="button" value="deletar" class="btn btn-danger" title="Excluir cliente" onclick="window.open('deleteProntuarios.php?idpaciente=<?= $row["idpaciente"] ?>&id=<?= $row["idprontuario"] ?>')">
			<i class="glyphicon glyphicon-trash  ">&nbsp;</i>Excluir
		  </button>
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
</div>
<!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<!-- /#page-wrapper -->


<!-- /#wrapper -->

<!-- Bootstrap Modal - To Add New Record -->
<!-- Modal INSERIR Prontuário -->
<div class="modal fade" id="myModal" name="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myModalLabel">Prontuário</h4>
</div>
<div class="modal-body">
<form role="form" action="./sqlProntuarios.php" method='post' enctype="multipart/form-data">

<input type="hidden" name="id" id="id" value="<?php print $id ?>"/>

<div class="form-group">
  <label for="nome">Nome</label>
  <input class="form-control" id="nome" name="nome" value="<?= $form["nome"] ?>">
</div>

<div class="form-group">
  <label for="nome">Atendimento</label>
  <textarea class="form-control" id="atendimento" value="<?= $form["atendimento"] ?>" name="atendimento" rows="6"></textarea>
</div>
<div class="form-group">
  <label for="nome">Data</label>
  <input type="date" name="data" id="data" placeholder="data" class="form-control" value="<?= date("d-m-Y") ?>">
</div>

<div class="form-group">
  <label>Anexo</label>
  <input type="file" name="userfile" id="anexo" value="<?= $form["arquivo"] ?>">
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









<?php


//echo $row2['idprontuario'];


?>

<!-- Modal EDITAR Prontuário -->


<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myModalLabel">Editar Prontuário</h4>
</div>
<div class="modal-body">

<form role="form" id="blockButton" action="./updateProntuarios.php" method='post' enctype="multipart/form-data">

<input type="hidden" name="id2" id="id2" value="<?php print $id ?>"/>
<input type="hidden" name="idprontuarioo" id="idprontuarioo"/>

<div class="form-group">
<label for="nome">Nome</label>
<input class="form-control" id="nome2" name="nome2" value="<?= $form["nome"] ?>">
</div>

<div class="form-group">

<label for="nome">Atendimento</label>


<textarea class="form-control" value="" id="atendimento2" name="atendimento2" rows="6">

			</textarea>

</div>

<div class="form-group">
<label for="nome">Data</label>
<input type="date" name="data2" id="data2" placeholder="" class="form-control" value="">
</div>


<div class="form-group">
<label>Anexo</label>
<input type="file" name="userfile2" id="anexo2" value="">
</div>


<div class="modal-footer">
<button type="submit" id="editar2" class="btn btn-success testee">Salvar</button>

</div>
</form>


<div class="modal-footer">
<button type="button" class="btn btn-danger lockar">Trancar</button>
</div>

</div>
</div>
</div>
</div>



<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
<!-- jQuery -->
<script src="../../vendor/jquery/jquery.min.js"></script>
<script src="_root/js/vendors/jquery-3.4.1.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="_root/js/vendors/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../../vendor/metisMenu/metisMenu.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<!-- DataTables JavaScript -->
<script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../../dist/js/sb-admin-2.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
$(document).ready(function () {
$('#dataTables-example').DataTable({
responsive: true
});
});

</script>




<script>
    // Freeze all labels  with readonly
    /*function readonly(){



      //alert(localStorage.setItem('teste', 'blue'));
      //alert(localStorage.getItem('bgcolor'));

      var nome = document.getElementById('nome2');
      nome.setAttribute("disabled", "readonly");

      var atendimento = document.getElementById('atendimento2');
      atendimento.setAttribute("disabled", "readonly");

      var data = document.getElementById('data2');
      data.setAttribute("disabled", "readonly");

      var anexo = document.getElementById('anexo2');
      anexo.setAttribute("disabled", "readonly");

      var editar = document.getElementById('editar2');
      editar.setAttribute("disabled", "disabled");

      //var button = document.getElementById('lock2');
      //button.setAttribute("disabled", "disabled");


  }*/
</script>

<script>

    /*
      function setCookie(name, value, days) {
        if (days) {
          var date = new Date();
          date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
          var expires = "; expires=" + date.toGMTString();
        }
        else var expires = "";
        document.cookie = name + "=" + value + expires + "; path=/";
      }

      function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') c = c.substring(1, c.length);
          if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
      }
    */
    /*
    $("#dataTables-example tr").each( function(){
      $(this).find("button.editar").on("click", function(evt){
        evt.stopPropagation();


        $('#myModalEdit #lock2').click(function(){
          $(this).attr('disabled',true);
          setCookie('DisableBtn', true, null);

        });

        if(getCookie('DisableBtn')){
            $('#lock2').attr('disabled',true);

        }

        $('#myModalEdit').modal('show');
      })
    });
  */

    function fetchResponse(url, obj) {
        // define config iniciais
        const init = {
            method: 'post',
            body: obj
        };
        // posta a variável na url e pega uma resposta em formato json
		return fetch(url, init).then((response) => response.json());
		
    }
    // define o elemento modal
    var modal = $('#myModalEdit');
    // quando clicar no elemento .lockar, que está dentro da modal
    modal.find('.lockar').click(function () {
        // define o botão clicado
        var button = $(this),

            // define um formdata
            obj = new FormData(),

            // define o form dentro da modal
            form = modal.find('form'),

            // define id do prontuário
            idProntuario = form.find('input#idprontuarioo').val();

        // adiciona a id ao obj formdata
		obj.append('id', idProntuario);

		
		
        // envia a id pro arquivo que vai salvar no database
        fetchResponse('set-lock-status.php', obj).then(function (response) {
            // se houve sucesso
			
            // desativa todos os elementos dentro do form
            form.find('input, select, textarea, button').prop('disabled', true);

            // desativa também este botão
            button.prop('disabled', true);

            $('button[data-toggle][value="' + idProntuario + '"]').data('locked', 1);

           
            setTimeout(function () {
				modal.modal('hide');
				$('body').removeClass('modal-open');
				$('.modal-backdrop').remove();
            }, 1000);

        });
    });

/*
    $("#dataTables-example tr").each(function () {
        $(this).find("button.editar").on("click", function (evt) {
            evt.stopPropagation();

            console.log($(this).closest("tr").hasClass("locked"));

            if ($(this).closest("tr").hasClass("locked")) {
                $("#myModalEdit input").attr("disabled", true);
                $("#myModalEdit .testee").attr("disabled", true);
                $("#myModalEdit .lockar").attr("disabled", true);

            } else {
                $("#myModalEdit input").removeAttr("disabled");
                $("#myModalEdit .testee").removeAttr("disabled");
                $("#myModalEdit .lockar").removeAttr("disabled");
            }


            var c_line = $(this).closest("tr");


            console.log($('#myModalEdit input#idprontuarioo').val($(this).val()));


        })

        //

    });
*/

    $('#myModalEdit').on('shown.bs.modal', function () {
        $('#myModalEdit input').trigger('focus');
    });

    /*
      $.ajax({
          'type' : 'POST',

          'url'       : 'lockButton.php',

          'data'      :  {lock: $('#myModalEdit input#idprontuarioo').val( $(this).val())},

          'success' : function (response) {
            alert('Alterado com sucesso');
          },
          error: function () {
          alert('Erro');
          }
        });
      */


    //toma el conteudo de data-text y escribes en la textarea
    $("#dataTables-example").find("button.editar").on("click", function () {
        var button = $(this),
        form = modal.find('form');

        modal.find('textarea#atendimento2').html(button.data('text'));

        modal.find('input#idprontuarioo').val(button.val());

        // se data-locked = 1
        if (button.data('locked') == 1) {
            // desativa todos os elementos dentro do form
            form.find('input, select, textarea, button').prop('disabled', true);
            modal.find('.lockar').prop('disabled', true);
        } else {
            // ativa todos os elementos dentro do form
            form.find('input, select, textarea, button').removeAttr('disabled');
            modal.find('.lockar').removeAttr('disabled');
        }

        // mostra a modal
        modal.modal('show');

    });
</script>


<script>

$("#dataTables-example tr").each(function () {
$(this).find("button.editar").on("click", function (evt) {
evt.stopPropagation();
var curr_data = $(this).closest("tr").find("td:nth-child(3)").text();
$("#myModalEdit #data2").val(curr_data.split("/").reverse().join("-").replace(/ /g, ""));
$('#myModalEdit').modal('show');
})

});

$('#myModalEdit').on('shown.bs.modal', function () {
$('#myModalEdit input').trigger('focus');
});




</script>


<script>


function FileListItem(a) {
a = [].slice.call(Array.isArray(a) ? a : arguments)
for (var c, b = c = a.length, d = !0; b-- && d;) d = a[b] instanceof File
if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(a[c])
return b.files
}

$("#dataTables-example tr").each(function () {

$(this).find("button.editar").on("click", function (evt) {
evt.stopPropagation();
var nomeQueQuero = $(this).closest("tr").find("td:nth-child(2)").text();
var files = [
	new File(['content'], nomeQueQuero)
];

document.querySelector("#anexo2").files = new FileListItem(files);
})
});
</script>