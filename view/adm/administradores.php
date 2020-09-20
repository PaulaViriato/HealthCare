<?php
session_start();
if ((isset($_SESSION["healthcare-type-user"]))&&(isset($_SESSION["healthcare-login"]))&&(isset($_SESSION["healthcare-password"]))){
	if (intval($_SESSION["healthcare-type-user"]) != 0){ header("Location: ../../util/logout.php"); }
} else { header("Location: ../../util/logout.php"); }
session_commit();

require_once('../../dao/administrador_DAO.php');
$DAOAdministrador = new Administrador_DAO();

$hasMessage = false;
$message = "";
if (isset($_POST["permitexec"])){
	if (strcasecmp ("".$_POST["permitexec"], "true") == 0){
		if (intval($_POST["typeoperation"]) == 0){
			$newadministrador = new Administrador();
			$newadministrador->set_nome ($_POST["vnome"]);
			$newadministrador->set_email ($_POST["vemail"]);
			$newadministrador->set_login ($_POST["vlogin"]);
			$newadministrador->set_senha ($_POST["vsenha"]);

			if (!$DAOAdministrador->exist_login ($newadministrador->get_login())){ $DAOAdministrador->insert ($newadministrador); }
			else {
				$hasMessage = true;
				$message = "Não foi possível adicionar o novo administrador!\\nO login utilizado já existe no sistema!";
			}
		}
		if (intval($_POST["typeoperation"]) == 1){
			$newadministrador = new Administrador();
			$newadministrador->set_id ($_POST["id"]);
			$newadministrador->set_nome ($_POST["vnome"]);
			$newadministrador->set_email ($_POST["vemail"]);
			$newadministrador->set_login ($_POST["vlogin"]);
			$newadministrador->set_senha ($_POST["vsenha"]);
			$DAOAdministrador->update ($newadministrador);
		}
		if (intval($_POST["typeoperation"]) == 2){ $DAOAdministrador->delete ($_POST["excludeid"]); }
	}
}
?>

<head>
	<title>HealthCare</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="../assets/vendor/chartist/css/chartist-custom.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../assets/css/mainn.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../assets/img/logo.png">
	<link href="../assets/htmls/modals.html" rel="import" />

	<style type="text/css">
		.btnlarge{ width: 100%; }
		input{ width: 100%; }
	</style>
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href=""><img style="height:20px;" src="../assets/img/new_logo.png" alt="Klorofil Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>

				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="lnr lnr-question-circle"></i> <span>Ajuda&nbsp&nbsp</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a data-toggle="modal" data-target="#modalContatoLemon" href="#">Contato Lemon Inteligência</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>Administrador: <?php echo $_SESSION["healthcare-user"]["nome"]; ?>&nbsp&nbsp</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="../../util/logout.php"><i class="lnr lnr-exit"></i> <span>Sair</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="administradores.php" class="active"><i class="lnr lnr-star"></i> <span>Administradores</span></a></li>
						<li><a href="operadoras.php" class=""><i class="lnr lnr-heart-pulse"></i> <span>Operadoras</span></a></li>
						<li><a href="simple_prestadores.php" class=""><i class="lnr lnr-license"></i> <span>Prestadores</span></a></li>
						<li><a href="prestadores.php" class=""><i class="lnr lnr-users"></i> <span>Prestadores Operando</span></a></li>
						<li><a href="upload.php" class=""><i class="lnr lnr-upload"></i> <span>Upload de Tabelas</span></a></li>
						<li><a href="medicamentos.php" class=""><i class="lnr lnr-drop"></i> <span>Medicamentos</span></a></li>
						<li><a href="materiais.php" class=""><i class="lnr lnr-cart"></i> <span>Materiais</span></a></li>
						<li><a href="configuracoes.php" class=""><i class="lnr lnr-cog"></i> <span>Configurações</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="main">
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Administradores do Sistema HealthCare</h3>
								</div>
								<div class="panel-body">
									<table id="table-materiais" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>Nome</th>
												<th>E-mail</th>
												<th>Login</th>
												<th style="width:10%;">Editar</th>
												<th style="width:10%;padding-left:8px;">Excluir</th>
											</tr>
										</thead>

										<tbody>
											<?php
												$administradores = $DAOAdministrador->select_all();
												foreach ($administradores as $administrador){
													echo "<tr>
														<td>".(is_null($administrador->get_nome()) ? "" : $administrador->get_nome())."</td>
														<td>".(is_null($administrador->get_email()) ? "" : $administrador->get_email())."</td>
														<td>".(is_null($administrador->get_login()) ? "" : $administrador->get_login())."</td>
														<td align=\"center\" style=\"width:10%;\"><button class=\"btn btn-sm btn-info\" onclick=\"openEditarAdministrador('".$administrador->get_id()."', '".$administrador->get_nome()."', '".$administrador->get_email()."', '".$administrador->get_login()."', '".$administrador->get_senha()."')\"> Editar </button></td>
														<td align=\"center\" style=\"width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirAdministrador('".$administrador->get_id()."')\"> Excluir </button></td>
													</tr>";
												}
											?>
										</tbody>
									</table>
								</div>
								<div class="panel-footer">
									<div class="row">
										<div class="col-md-12" align="center">
											<button onclick="openAddAdministrador();" class="btn btnlarge btn-success"> Cadastrar Administrador </button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">Template made by <i class="fa fa-love"></i><a href="https://www.themeineed.com">themeineed</a></p>
			</div>
			<div class="container-fluid">
				<p class="copyright">Menu Icons by <i class="fa fa-love"></i><a href="https://linearicons.com">Perxis</a></p>
			</div>
		</footer>
	</div>

	<div id="modalAdicionarAdministrador" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Cadastrar Administrador</h4>
					</div>

					<form enctype="multipart/form-data" method="POST" action="administradores.php">
						<div class="modal-body" style="padding-top:0px;padding-bottom:0px;">
							<div class="row">
								<input id="permitexec" type="hidden" name="permitexec" required/>
								<input id="typeoperation" type="hidden" name="typeoperation" required/>

								<div class="panel" style="margin-bottom:0px;">
									<div class="panel-heading" style="padding-bottom:0px;padding-top:10px;">
										<h3 class="panel-title">Dados da Operadora</h3>
									</div>
									<div class="panel-body">
										<div class="col-md-12">
											<div style="margin-bottom: 10px;">
												<span> Nome</span> </br>
												<input type="text" name="vnome" required/>
											</div>
										</div>
										<div class="col-md-12">
											<div style="margin-bottom: 10px;">
												<span> E-mail</span> </br>
												<input type="email" name="vemail"/>
											</div>
										</div>
									</div>
								</div>

								<div class="panel" style="margin-bottom:0px;">
									<div class="panel-heading" style="padding-bottom:0px;padding-top:10px;">
										<h3 class="panel-title">Dados de Entrada</h3>
									</div>
									<div class="panel-body">
										<div class="col-md-12">
											<div style="margin-bottom: 10px;">
												<span> Login</span> </br>
												<input type="text" name="vlogin" required/>
											</div>
										</div>
										<div class="col-md-12">
											<div style="margin-bottom: 10px;">
												<span> Senha</span> </br>
												<input id="addsenha" type="password" name="vsenha" required/>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
							<button type="button" onclick="addAdministrador()" class="btn btn-success">Adicionar</button>
							<button id="chkaddadministrador" type="submit" class="btn btn-success collapse">Submeter</button>
						</div>
					</form>
				</div>
		</div>
	</div>

	<div id="modalEditarAdministrador" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Editar Administrador</h4>
					</div>

					<form enctype="multipart/form-data" method="POST" action="administradores.php">
						<div class="modal-body" style="padding-top:0px;padding-bottom:0px;">
							<div class="row">
								<input id="permitexecedt" type="hidden" name="permitexec" required/>
								<input id="typeoperationedt" type="hidden" name="typeoperation" required/>
								<input id="edit_id" type="hidden" name="id" required/>
								<input id="sub_edit_senha" type="hidden" name="sub_senha" required/>

								<div class="panel" style="margin-bottom:0px;">
									<div class="panel-heading" style="padding-bottom:0px;padding-top:10px;">
										<h3 class="panel-title">Dados do Administrador</h3>
									</div>
									<div class="panel-body">
										<div class="col-md-12">
											<div style="margin-bottom: 10px;">
												<span> Nome</span> </br>
												<input id="edit_nome" type="text" name="vnome" required/>
											</div>

										</div>
										<div class="col-md-12">
											<div style="margin-bottom: 10px;">
												<span> E-mail</span> </br>
												<input id="edit_email" type="email" name="vemail" required/>
											</div>
										</div>
									</div>
								</div>

								<div class="panel" style="margin-bottom:0px;">
									<div class="panel-heading" style="padding-bottom:0px;padding-top:10px;">
										<h3 class="panel-title">Dados de Entrada</h3>
									</div>
									<div class="panel-body">
										<div class="col-md-12">
											<div style="margin-bottom: 10px;">
												<span> Login</span> </br>
												<input id="edit_login" type="text" name="vlogin" required/>
											</div>
										</div>
										<div id="div-edt-senha" class="col-md-12 collapse">
											<div style="margin-bottom: 10px;">
												<span> Senha</span> </br>
												<input id="edit_senha" type="password" name="vsenha" required/>
											</div>
										</div>
										<div class="col-md-12">
											<div style="margin-top: 10px; text-align: right;">
												<button id="btn-senha" type="button" onclick="edtSenha()" class="btn btn-info">Alterar Senha</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
							<button type="button" onclick="editAdministrador()" class="btn btn-success">Salvar</button>
							<button id="chkedtadministrador" type="submit" class="btn btn-success collapse">Submeter</button>
						</div>
					</form>
				</div>
		</div>
	</div>

	<div id="modalExcluir" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Excluir Administrador?</h4>
				</div>

				<form enctype="multipart/form-data" method="POST" action="administradores.php">
					<div class="modal-body">
						<input id="permitexecexcl" type="hidden" name="permitexec" required/>
						<input id="typeoperationexcl" type="hidden" name="typeoperation" required/>
						<input id="excludeid" type="hidden" name="excludeid" required/>
						<p> Tem certeza que deseja deletar o administrador? </p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
						<button type="submit" class="btn btn-success">Sim</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="modalContatoLemon" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Contato</h4>
				</div>

				<div class="modal-body">
					<h3> Lemon Inteligência </h3>
					<p> E-mail: atendimento@lemon360.com.br </p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>

	<script src="../assets/vendor/jquery/jquery.min.js"></script>
	<script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="../assets/vendor/chartist/js/chartist.min.js"></script>
	<script src="../assets/scripts/klorofil-common.js"></script>
	<script src="../assets/scripts/main.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

	<script type="text/javascript">
		<?php if ($hasMessage){ echo "alert (\"".$message."\");"; } ?>
		function excluirAdministrador(id){
			document.getElementById("permitexecexcl").value = true;
			document.getElementById("typeoperationexcl").value = 2;
			document.getElementById("excludeid").value = id;
			$("#modalExcluir").modal("show");
		}

		function openEditarAdministrador(id, nome, email, login, senha){
			document.getElementById("permitexecedt").value = true;
			document.getElementById("typeoperationedt").value = 1;
			document.getElementById("edit_id").value = id;
			document.getElementById("sub_edit_senha").value = senha;
			document.getElementById("edit_nome").value = nome;
			document.getElementById("edit_email").value = email;
			document.getElementById("edit_login").value = login;
			document.getElementById("edit_senha").value = senha;

			$('#btn-senha').removeClass ("btn-warning");
			$('#btn-senha').addClass ("btn-info");
			$('#btn-senha').text ("Alterar Senha");
			$('#div-edt-senha').addClass ("collapse");
			$("#modalEditarAdministrador").modal("show");
		}

		function edtSenha (){
			if ($('#btn-senha').hasClass ("btn-info")){
				document.getElementById("edit_senha").value = "";
				$('#btn-senha').removeClass ("btn-info");
				$('#btn-senha').addClass ("btn-warning");
				$('#btn-senha').text ("Manter Senha");
				$('#div-edt-senha').removeClass ("collapse");
			} else {
				if ($('#btn-senha').hasClass ("btn-warning")){
					document.getElementById("edit_senha").value = document.getElementById("sub_edit_senha").value;
					$('#btn-senha').removeClass ("btn-warning");
					$('#btn-senha').addClass ("btn-info");
					$('#btn-senha').text ("Alterar Senha");
					$('#div-edt-senha').addClass ("collapse");
				}
			}
		}

		function addAdministrador (){
			value = document.getElementById("addsenha").value;
			if ((value.length >= 6)&&(value.length <= 20)){
				if ((value.indexOf("'") > -1)||(value.indexOf("\"") > -1)){ alert ("Os caracteres ' e \" são inválidos!"); }
				else { document.getElementById("chkaddadministrador").click(); }
			} else { alert ("Senha inválida!\nA senha precisa ter pelo menos seis (6) caracteres\ne no máximo vinte (20) caracteres."); }
		}

		function editAdministrador (){
			value = document.getElementById("edit_senha").value;
			if ($('#btn-senha').hasClass ("btn-warning")){
				if ((value.length >= 6)&&(value.length <= 20)){
					if ((value.indexOf("'") > -1)||(value.indexOf("\"") > -1)){ alert ("Os caracteres ' e \" são inválidos!"); }
					else { document.getElementById("chkedtadministrador").click(); }
				} else { alert ("Senha inválida!\nA senha precisa ter pelo menos seis (6) caracteres\ne no máximo vinte (20) caracteres."); }
			} else {
				document.getElementById("edit_senha").value = document.getElementById("sub_edit_senha").value;
				document.getElementById("chkedtadministrador").click();
			}
		}

		function openAddAdministrador(){
			document.getElementById("permitexec").value = true;
			document.getElementById("typeoperation").value = 0;
			$("#modalAdicionarAdministrador").modal("show");
		}

		$(document).ready(function() {
			var table = $('#table-materiais').DataTable({
				"language": {
					"lengthMenu": "Mostrar &nbsp _MENU_ &nbsp administradores por página",
					"zeroRecords": "Nada encontrado, desculpe",
					"info": "Página _PAGE_ de _PAGES_",
					"infoEmpty": "Nenhum administrador encontrado",
					"infoFiltered": "(de um total de _MAX_ registros)",
					"search": "Pesquisar &nbsp",
					"oPaginate": {
						"sFirst":	"Primeiro",
						"sPrevious": "Anterior",
						"sNext":	"Seguinte",
						"sLast":	"Último"
					}
				},
				"columnDefs": [
					{ "searchable": true, "targets": 0 },
					{ "searchable": true, "targets": 1 },
					{ "searchable": true, "targets": 2 },
					{ "searchable": false, "orderable": false, "targets": 3 },
					{ "searchable": false, "orderable": false, "targets": 4 }
				]
			});

			document.getElementsByName("table-materiais_length")[0].style.height = "25px";
			document.getElementsByName("table-materiais_length")[0].style.padding = "0px";
			document.getElementsByName("table-materiais_length")[0].style.textAlign = "center";
			document.getElementsByClassName("form-control form-control-sm")[1].style.height = "25px";
		});
	</script>
</body>
