<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>GxClin</title>
		
</head>

            <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <a class="navbar-brand" href="login.php">GxFisio</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="../gerencial/configuracoes.php"><i class="fa fa-gear fa-fw"></i> Configurações</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../login.php"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

         <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
						 <li>
                            <a href="../gerencial/dashboard.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard </a>
                        </li>
						 <li>
                            <a href="../pacientes/pacientes.php"><i class="fa fa-user fa-fw"></i> Pacientes </a>
                        </li>
                        <li>
                            <a href="../agendamento/agendamento.php"><i class="fa fa-calendar fa-fw"></i> Agendamento </a>
                        </li>
					<li>
                            <a href="#"><i class="fa fa-bar-chart-o"></i> Financeiro<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                             <li>
                                    <a href="../financeiro/financeiro.php">Receitas/Despesas</a>
                             </li>
				
							</ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="#"><i class="fa fa-archive"></i> Administrativo<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../usuarios/usuarios.php">Usuários</a>
                                </li>
								<li>
                                    <a href="../gerencial/documentos.php">Documentos</a>
                                </li>
								<li>
                                    <a href="../profissionais/profissionais.php">Profissionais</a>
								</li>
								<li>
                                    <a href="../empresa/empresa.php">Filial</a>
								</li>
                                <li>
                                    <a href="../convenios/convenios.php">Convênios</a>
								</li>
								<li>
                                    <a href="../hospital/hospital.php">Clínicas/Hospitais</a>
								</li>
								<li>
                                    <a href="../cid/cid.php">CID</a>
								</li>
							</ul>
                            <!-- /.nav-second-level -->
                        </li>
						
						
                    </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
	  </nav>
</html>
