<?php
session_start();
if ((isset($_SESSION["healthcare-type-user"]))&&(isset($_SESSION["healthcare-login"]))&&(isset($_SESSION["healthcare-password"]))){
	if (intval($_SESSION["healthcare-type-user"]) != 2){ header("Location: ../../util/logout.php"); }
} else { header("Location: ../../util/logout.php"); }
session_commit();

require_once('../../dao/login_DAO.php');
require_once('../../dao/prestadora_DAO.php');
require_once('../../dao/tabela_DAO.php');
$DAOLogin = new Login_DAO();
$DAOPrestadora = new Prestadora_DAO();
$DAOTabela = new Tabela_DAO();
$prest_operadoras = $DAOPrestadora->select_by_CNES($_SESSION["healthcare-user"]["id_cnes"]);

$hasMessage = false;
$message = "";

if (!isset($_SESSION["healthcare-user"]["currop"])){
	session_start();
	$_SESSION["healthcare-user"]["currop"]["nome"] = $prest_operadoras[0]->get_OPERADORA()->get_nome();
	$_SESSION["healthcare-user"]["currop"]["id"] = $prest_operadoras[0]->get_OPERADORA()->get_id();
	$_SESSION["healthcare-user"]["currop"]["idprest"] = $prest_operadoras[0]->get_id();
	session_commit();
}

if (isset($_POST["permitexec"])){
	if (strcasecmp ("".$_POST["permitexec"], "true") == 0){
		if (intval($_POST["typeoperation"]) == 0){
			if (isset($_POST["fl-novasenha"])){
				$login_prestadora = new Login();
				$login_prestadora->set_id($_SESSION["healthcare-user"]["id"]);
				$login_prestadora->set_first_login(false);
				$login_prestadora->set_senha ($_POST["fl-novasenha"]);
				$login_prestadora->set_CNES (new CNES());
				$login_prestadora->get_CNES()->set_id ($_SESSION["healthcare-user"]["id_cnes"]);
				$result = $DAOLogin->update ($login_prestadora);
				if (!$result){
					$hasMessage = true;
					$message = "Não foi possível cadastrar a nova senha!";
				}

				session_start();
				$_SESSION["healthcare-user"]["senha"] = $_POST["fl-novasenha"];
				$_SESSION["healthcare-user"]["first_login"] = $login_prestadora->get_first_login();
				session_commit();
			}
		}
		if (intval($_POST["typeoperation"]) == 1){
			if (isset($_POST["id-operadora"])){
				session_start();
				$_SESSION["healthcare-user"]["currop"]["id"] = $_POST["id-operadora"];
				foreach ($prest_operadoras as $ope){
					if (intval($ope->get_OPERADORA()->get_id()) == intval($_POST["id-operadora"])){
						$_SESSION["healthcare-user"]["currop"]["nome"] = $ope->get_OPERADORA()->get_nome();
						$_SESSION["healthcare-user"]["currop"]["idprest"] = $ope->get_id();
					}
				}
				session_commit();
			}
		}
	}
}

$tabelas = $DAOTabela->select_by_Prestadora ($_SESSION["healthcare-user"]["currop"]["idprest"]);
$mattab = null;
$curr_data = "1970-01-01 00:00:01";

foreach ($tabelas as $tab){
	if (intval($tab->get_type()) == 1){
		$data = $tab->get_MATTAB()->get_data();
		if (strtotime($data) > strtotime($curr_data)){
			$mattab = $tab->get_MATTAB();
			$curr_data = $data;
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
					<div style="margin-left:40px;margin-top:-26px;"><span>&nbsp&nbsp Prestador: &nbsp<?php echo $_SESSION["healthcare-user"]["nome"]; ?>&nbsp&nbsp</span></div>
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
							<form style="height:0px;margin-bottom:0px;" enctype="multipart/form-data" method="POST" action="materiais.php">
								<input id="permitexectope" type="hidden" name="permitexec" required/>
								<input id="typeoperationtope" type="hidden" name="typeoperation" required/>
								<input id="idoperadoratope" type="hidden" name="id-operadora" required/>
								<button id="chktope" type="submit" class="btn btn-success collapse">Submeter</button>
							</form>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>Operadora: &nbsp<?php echo $_SESSION["healthcare-user"]["currop"]["nome"]; ?>&nbsp&nbsp</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<?php
									foreach ($prest_operadoras as $ope) {
										echo '<li><a href="#" onclick="changeOpe(\''.$ope->get_OPERADORA()->get_id().'\')"><i class="lnr lnr-heart-pulse"></i> <span>'.$ope->get_OPERADORA()->get_nome().'</span></a></li>';
									}
								?>
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
						<li><a href="medicamentos.php" class=""><i class="lnr lnr-drop"></i> <span>Medicamentos</span></a></li>
						<li><a href="materiais.php" class="active"><i class="lnr lnr-cart"></i> <span>Materiais</span></a></li>
						<li><a href="anteriores.php" class=""><i class="lnr lnr-list"></i> <span>Tabelas Anteriores</span></a></li>
						<li><a href="configuracoes.php" class=""><i class="lnr lnr-cog"></i> <span>Configurações</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="main">
			<?php if (is_null($mattab)){ ?>
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="panel">
							<div class="panel-heading" style="text-align:center;">
								<h3 class="panel-title">Nenhuma Tabela Vigente!</h3>
								Aguarde a disponibilização de uma tabela de materiais pela operadora!
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } else { ?>
			<div id="img-aguarde" class="collapse">
				<button onclick="cancelOpe()" style="margin:20px;width:15%" class="btn btnlarge btn-info"> Cancelar Operação </button>
				<H1 style="text-align:center;margin-top:1%;">Aguarde...</H1><br>
				<img style="margin-top:20px;width:30%;margin-left:36%;" src="../assets/img/load.gif" class="img-responsive logo">
			</div>

			<div id="painel_material" class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Materiais</h3>
								</div>
								<div id="med_detalhes" style="padding-left:25px;padding-right:25px;margin-bottom:15px;">
									<b>Nome: </b><span><?php echo $mattab->get_nome(); ?></span><br>
									<b>Data de Criação: </b><span><?php echo $mattab->get_data(); ?></span><br>
									<input id="idmattab" type="hidden" name="id" value="<?php echo $mattab->get_id(); ?>" required/>
								</div>
								<div id="search-panel">
									<input id="searchindexmat" type="hidden" required/>
									<div class="panel-body" style="width:100%;padding-top:0px;padding-bottom:10px;">
										<div class="btn-group" style="margin-right:1%;width:20%;">
											<button class="btn dropdown-toggle" id="strcampomat" data-toggle="dropdown" style="width:100%;margin-right:10px;margin-bottom:10px;padding:0px;height:25px;margin-top:6px;text-align:center;">Selecione um Campo &nbsp<span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
												<li><a tabindex="0" onclick="modifyDropdownMat('0')">Registro</a></li>
												<li><a tabindex="1" onclick="modifyDropdownMat('1')">Nome Técnico</a></li>
												<li><a tabindex="2" onclick="modifyDropdownMat('2')">Classe de Risco</a></li>
												<li><a tabindex="3" onclick="modifyDropdownMat('3')">Fabricante</a></li>
												<li><a tabindex="4" onclick="modifyDropdownMat('4')">Todos</a></li>
											</ul>
										</div>
										<input id="searchtxtmat" type="text" style="height:25px;padding-left:5px;width:65%;font-size:14px;" placeholder="Buscar..." />
										<button class="btn" onclick="searchMat()" style="width:12%;margin-left:1%;margin-bottom:10px;padding:0px;height:25px;margin-top:6px;text-align:center;">Buscar</span></button>
									</div>
								</div>
								<div id="table-panel-material">
									<div class="panel-body">
										<table id="table-material" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th style="width:15%;font-size:14px;padding-left:8px;">Registro</th>
													<th style="width:31%;font-size:14px;">Nome Técnico</th>
													<th style="width:32%;font-size:14px;">Fabricante</th>
													<th style="width:10%;font-size:14px;">C. Risco</th>
													<th style="width:12%;font-size:14px;padding-left:8px;">Visualizar</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
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

	<div id="modalVisualizarMaterial" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" style="width:100%;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Informações do Material</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div id="textinfo-material"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>

	<div id="modalFirstLogin" class="modal fade" data-backdrop="static" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Cadastrar Nova Senha</h4>
				</div>

				<form enctype="multipart/form-data" method="POST" action="materiais.php">
					<div class="modal-body">
						<input id="permitexecfl" type="hidden" name="permitexec" required/>
						<input id="typeoperationfl" type="hidden" name="typeoperation" required/>
						<div class="row">
							<div class="col-md-12">
								<table style="width:100%;">
									<tr style="border-width:7px;border-style:solid;border-color:white;">
										<td style="text-align:right;width:25%;"> Senha Atual: &nbsp&nbsp</td>
										<td style="text-align:left;"><input id="fl-senhaatual" type="password" name="fl-senhaatual" required/></td>
									</tr>
									<tr style="border-width:7px;border-style:solid;border-color:white;">
										<td style="text-align:right;width:25%;"> Nova Senha: &nbsp&nbsp</td>
										<td style="text-align:left;"><input id="fl-novasenha" type="password" name="fl-novasenha" required/></td>
									</tr>
									<tr style="border-width:7px;border-style:solid;border-color:white;">
										<td style="text-align:right;width:25%;"> Confirmar Senha: &nbsp&nbsp</td>
										<td style="text-align:left;"><input id="fl-confsenha" type="password" name="fl-confsenha" required/></td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" onclick="firstLoginLogout()" class="btn btn-default">Sair</button>
						<button type="button" onclick="firstLogin()" class="btn btn-success">Cadastrar</button>
						<button id="chkfirstlogin" type="submit" class="btn btn-success collapse">Submeter</button>
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
		var request = null;

		<?php
			if ((isset($_SESSION["healthcare-user"]["first_login"]))&&(isset($_SESSION["healthcare-user"]["senha"]))){
				if (intval($_SESSION["healthcare-user"]["first_login"]) == 1){
					echo 'currsenha = "'.$_SESSION["healthcare-user"]["senha"].'";';
					echo 'document.getElementById("permitexecfl").value = true;';
					echo 'document.getElementById("typeoperationfl").value = 0;';
					echo '$("#modalFirstLogin").modal("show");';
				}
			}
		?>

		function changeOpe (id){
			document.getElementById("permitexectope").value = true;
			document.getElementById("typeoperationtope").value = 1;
			document.getElementById("idoperadoratope").value = id;
			document.getElementById("chktope").click();
		}

		function firstLogin(){
			fl_senhaatual = document.getElementById("fl-senhaatual").value;
			fl_novasenha = document.getElementById("fl-novasenha").value;
			fl_confsenha = document.getElementById("fl-confsenha").value;

			if (fl_senhaatual != currsenha){ alert ("Senha atual incorreta!"); }
			else {
				if (fl_novasenha == currsenha){ alert ("A nova senha não pode ser igual a atual!"); }
				else {
					if (fl_novasenha != fl_confsenha){ alert ("A nova senha e a confirmação não são iguais!"); }
					else {
						if ((fl_novasenha.indexOf("'") > -1)||(fl_novasenha.indexOf("\"") > -1)){
							alert ("Os caracteres ' e \" são inválidos!");
						} else {
							if ((fl_novasenha.length >= 6)&&(fl_novasenha.length <= 20)){
								document.getElementById("chkfirstlogin").click();
							} else { alert ("Senha inválida!\nA senha precisa ter pelo menos seis (6) caracteres\ne no máximo vinte (20) caracteres."); }
						}
					}
				}
			}
		}

		function firstLoginLogout(){ window.location = "../../util/logout.php"; }

		function cancelOpe (){
			request.abort();
			request = null;
			$('#img-aguarde').addClass ("collapse");
			$('#painel_material').removeClass ("collapse");
		}

		function modifyDropdownMat (index){
			document.getElementById("searchindexmat").value = index;
			document.getElementById ("searchtxtmat").disabled = false;
			document.getElementById ("searchtxtmat").value = "";
			if (parseInt(index) == 0){ $('#strcampomat').html ("Registro &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 1){ $('#strcampomat').html ("Nome Técnico &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 2){ $('#strcampomat').html ("Classe de Risco &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 3){ $('#strcampomat').html ("Fabricante &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 4){
				$('#strcampomat').html ("Todos &nbsp<span class=\"caret\"></span>");
				document.getElementById ("searchtxtmat").disabled = true;
			}
		}

		function searchMat (){
			if (((parseInt(document.getElementById("searchindexmat").value) == -1)||
				(document.getElementById("searchtxtmat").value == ""))&&(parseInt(document.getElementById("searchindexmat").value) != 4)) {
				if (parseInt(document.getElementById("searchindexmat").value) == -1){ alert ("Selecione um campo!"); }
				if (document.getElementById("searchtxtmat").value == ""){ alert ("Preencha o campo de busca!"); }
				return;
			}

			$('#img-aguarde').removeClass ("collapse");
			$('#painel_material').addClass ("collapse");

			text = "";
			index = parseInt(document.getElementById("searchindexmat").value);
			txtsc = document.getElementById("searchtxtmat").value;
			if (index == 0){ text = "UPPER(tb_material.id) LIKE '%"+txtsc.toUpperCase()+"%'"; }
			if (index == 1){ text = "UPPER(tb_material.nome_tecnico) LIKE '%"+txtsc.toUpperCase()+"%'"; }
			if (index == 2){ text = "UPPER(tb_material.classe_risco) LIKE '%"+txtsc.toUpperCase()+"%'"; }
			if (index == 3){ text = "UPPER(tb_material.fabricante) LIKE '%"+txtsc.toUpperCase()+"%'"; }
			if (index == 4){ text = "tb_material.id IS NOT NULL"; }

			request = $.post('../../util/requests.php', { 
				request: 9,
				id_mattab: document.getElementById("idmattab").value,
				whereclause: text
			}, function (response){
				$('#table-panel-material').html (""+response);
				var table = $('#table-material').DataTable({
					"language": {
						"lengthMenu": "Mostrar &nbsp _MENU_ &nbsp materiais por página",
						"zeroRecords": "Nada encontrado, desculpe",
						"info": "Página _PAGE_ de _PAGES_",
						"infoEmpty": "Nenhum material encontrado",
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
						{ "searchable": false, "targets": 3 },
						{ "searchable": false, "orderable": false, "targets": 4 }
					]
				});

				document.getElementsByName("table-material_length")[0].style.height = "25px";
				document.getElementsByName("table-material_length")[0].style.padding = "0px";
				document.getElementsByName("table-material_length")[0].style.textAlign = "center";
				var barform = document.getElementsByClassName("form-control form-control-sm");
				for (var i = 0; i < barform.length; i ++){ barform[i].style.height = "25px"; }

				$('#img-aguarde').addClass ("collapse");
				$('#painel_material').removeClass ("collapse");
			});
		}

		function openVisualizarMaterial(id){
			$.post('../../util/requests.php', { 
				request: 11,
				id_mattab: document.getElementById("idmattab").value,
				id_material: id
			}, function (response){
				$('#textinfo-material').html (""+response);
				$("#modalVisualizarMaterial").modal("show");
			});
		}

		$(document).ready(function() {
			var table = $('#table-material').DataTable({
				"language": {
					"lengthMenu": "Mostrar &nbsp _MENU_ &nbsp materiais por página",
					"zeroRecords": "Utilize os filtros para realizar buscas!",
					"info": "Página _PAGE_ de _PAGES_",
					"infoEmpty": "Nenhum material encontrado",
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
					{ "searchable": false, "targets": 3 },
					{ "searchable": false, "orderable": false, "targets": 4 }
				]
			});

			document.getElementsByName("table-material_length")[0].style.height = "25px";
			document.getElementsByName("table-material_length")[0].style.padding = "0px";
			document.getElementsByName("table-material_length")[0].style.textAlign = "center";
			var barform = document.getElementsByClassName("form-control form-control-sm");
			for (var i = 0; i < barform.length; i ++){ barform[i].style.height = "25px"; }
		});
	</script>
</body>
