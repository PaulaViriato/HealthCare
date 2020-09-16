<?php
session_start();
if ((isset($_SESSION["healthcare-type-user"]))&&(isset($_SESSION["healthcare-login"]))&&(isset($_SESSION["healthcare-password"]))){
	if (intval($_SESSION["healthcare-type-user"]) != 1){ header("Location: ../../util/logout.php"); }
} else { header("Location: ../../util/logout.php"); }
session_commit();

require_once('../../dao/operadora_DAO.php');
$DAOOperadora = new Operadora_DAO();

$hasMessage = false;
$message = "";
if (isset($_POST["permitexec"])){
	if (strcasecmp ("".$_POST["permitexec"], "true") == 0){
		if (intval($_POST["typeoperation"]) == 0){
			if (isset($_POST["ap-novasenha"])){
				$operadora = $DAOOperadora->select_id($_SESSION["healthcare-user"]["id"]);
				$operadora->set_senha($_POST["ap-novasenha"]);
				$result = $DAOOperadora->update($operadora);
				if (!$result){
					$hasMessage = true;
					$message = "Não foi possível cadastrar a nova senha!";
				}

				session_start();
				$_SESSION["healthcare-user"]["senha"] = $_POST["ap-novasenha"];
				session_commit();
			}
		}
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
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>Operadora: <?php echo $_SESSION["healthcare-user"]["nome"]; ?>&nbsp&nbsp</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
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
						<li><a href="simple_prestadores.php" class=""><i class="lnr lnr-license"></i> <span>Prestadores</span></a></li>
						<li><a href="prestadores.php" class=""><i class="lnr lnr-users"></i> <span>Meus Prestadores</span></a></li>
						<li><a href="tabelas.php" class=""><i class="lnr lnr-list"></i> <span>Montagem de Tabelas</span></a></li>
						<li><a href="disponibilizacao.php" class=""><i class="lnr lnr-earth"></i> <span>Disponibilização</span></a></li>
						<li><a href="medicamentos.php" class=""><i class="lnr lnr-drop"></i> <span>Medicamentos</span></a></li>
						<li><a href="materiais.php" class=""><i class="lnr lnr-cart"></i> <span>Materiais</span></a></li>
						<li><a href="configuracoes.php" class="active"><i class="lnr lnr-cog"></i> <span>Configurações</span></a></li>
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
									<h3 class="panel-title">Configurações</h3>
								</div>
								<div class="panel-body">
									<button onclick="alterarSenha();" class="btn btnlarge btn-info"> Alterar Senha </button>
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

	<div id="modalAlterPassword" class="modal fade" data-backdrop="static" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Cadastrar Nova Senha</h4>
				</div>

				<form enctype="multipart/form-data" method="POST" action="configuracoes.php">
					<div class="modal-body">
						<input id="permitexecap" type="hidden" name="permitexec" required/>
						<input id="typeoperationap" type="hidden" name="typeoperation" required/>
						<div class="row">
							<div class="col-md-12">
								<table style="width:100%;">
									<tr style="border-width:7px;border-style:solid;border-color:white;">
										<td style="text-align:right;width:25%;"> Senha Atual: &nbsp&nbsp</td>
										<td style="text-align:left;"><input id="ap-senhaatual" type="password" name="ap-senhaatual" required/></td>
									</tr>
									<tr style="border-width:7px;border-style:solid;border-color:white;">
										<td style="text-align:right;width:25%;"> Nova Senha: &nbsp&nbsp</td>
										<td style="text-align:left;"><input id="ap-novasenha" type="password" name="ap-novasenha" required/></td>
									</tr>
									<tr style="border-width:7px;border-style:solid;border-color:white;">
										<td style="text-align:right;width:25%;"> Confirmar Senha: &nbsp&nbsp</td>
										<td style="text-align:left;"><input id="ap-confsenha" type="password" name="ap-confsenha" required/></td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
						<button type="button" onclick="alterPassword()" class="btn btn-success">Cadastrar</button>
						<button id="chkalterpss" type="submit" class="btn btn-success collapse">Submeter</button>
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
		var currsenha = "";

		function alterarSenha(){
			<?php echo 'currsenha = "'.$_SESSION["healthcare-user"]["senha"].'";'; ?>
			document.getElementById("permitexecap").value = true;
			document.getElementById("typeoperationap").value = 0;
			$("#modalAlterPassword").modal("show");
		}

		function alterPassword(){
			ap_senhaatual = document.getElementById("ap-senhaatual").value;
			$.post('../../util/requests.php', { 
				request: 12,
				content: ap_senhaatual
			}, function (response){
				ap_senhaatual = ""+response;
				ap_novasenha = document.getElementById("ap-novasenha").value;
				ap_confsenha = document.getElementById("ap-confsenha").value;

				if (ap_senhaatual != currsenha){ alert ("Senha atual incorreta!"); }
				else {
					if (ap_novasenha == currsenha){ alert ("A nova senha não pode ser igual a atual!"); }
					else {
						if (ap_novasenha != ap_confsenha){ alert ("A nova senha e a confirmação não são iguais!"); }
						else {
							if ((ap_novasenha.indexOf("'") > -1)||(ap_novasenha.indexOf("\"") > -1)){
								alert ("Os caracteres ' e \" são inválidos!");
							} else {
								if ((ap_novasenha.length >= 6)&&(ap_novasenha.length <= 20)){
									document.getElementById("chkalterpss").click();
								} else { alert ("Senha inválida!\nA senha precisa ter pelo menos seis (6) caracteres\ne no máximo vinte (20) caracteres."); }
							}
						}
					}
				}
			});
		}

		$(document).ready(function() {
			var table = $('#table-materiais').DataTable({
				"language": {
					"lengthMenu": "Mostrar _MENU_  funcionários por página",
					"zeroRecords": "Nada encontrado, desculpe",
					"info": "Página _PAGE_ de _PAGES_",
					"infoEmpty": "Nenhum funcionário encontrado",
					"infoFiltered": "(de um total de _MAX_ registros)",
					"search": "Pesquisar",
					"oPaginate": {
						"sFirst":	"Primeiro",
						"sPrevious": "Anterior",
						"sNext":	"Seguinte",
						"sLast":	"Último"
					}
				},
				"columnDefs": [
					{ "searchable": false, "targets": 1 },
					{ "searchable": false, "orderable": false, "targets": 2 },
					{ "searchable": false, "orderable": false, "targets": 3 },
					{ "searchable": false, "orderable": false, "targets": 4 }
				]
			});
		});
	</script>
</body>
