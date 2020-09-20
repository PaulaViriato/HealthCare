<?php
session_start();
if ((isset($_SESSION["healthcare-type-user"]))&&(isset($_SESSION["healthcare-login"]))&&(isset($_SESSION["healthcare-password"]))){
	if (intval($_SESSION["healthcare-type-user"]) != 1){ header("Location: ../../util/logout.php"); }
} else { header("Location: ../../util/logout.php"); }
session_commit();

require_once('../../dao/tabela_DAO.php');
require_once('../../dao/prestadora_DAO.php');
require_once('../../dao/medtab_DAO.php');
require_once('../../dao/mattab_DAO.php');

$DAOMedTab = new MedTab_DAO();
$DAOMatTab = new MatTab_DAO();
$DAOTabela = new Tabela_DAO();
$DAOPrestadora = new Prestadora_DAO();

$hasMessage = false;
$message = "";
if (isset($_POST["permitexec"])){
	if (strcasecmp ("".$_POST["permitexec"], "true") == 0){
		if (intval($_POST["typeoperation"]) == 1){
			if ((isset($_POST["idpres"]))&&(isset($_POST["typetabela"]))&&(isset($_POST["idref"]))){
				$prestador = new Operadora();
				$prestador->set_id($_POST["idpres"]);

				if (intval($_POST["typetabela"]) == 0){
					$medtab = new MedTab();
					$medtab->set_id ($_POST["idref"]);

					$objtabela = new Tabela();
					$objtabela->set_PRESTADORA($prestador);
					$objtabela->set_MEDTAB($medtab);
					$objtabela->set_MATTAB(new MatTab());
					$objtabela->set_type($_POST["typetabela"]);

					$id = $DAOTabela->insert ($objtabela);
					if (intval($id) == -1){
						$hasMessage = true;
						$message = "Não foi possível cadastrar a disponibilizacao!";
					}
				} else {
					$mattab = new MatTab();
					$mattab->set_id ($_POST["idref"]);

					$objtabela = new Tabela();
					$objtabela->set_PRESTADORA($prestador);
					$objtabela->set_MEDTAB(new MedTab());
					$objtabela->set_MATTAB($mattab);
					$objtabela->set_type($_POST["typetabela"]);

					$id = $DAOTabela->insert ($objtabela);
					if (intval($id) == -1){
						$hasMessage = true;
						$message = "Não foi possível cadastrar a disponibilizacao!";
					}
				}
			}
		}
		if (intval($_POST["typeoperation"]) == 2){
			if (isset($_POST["id"])){ $DAOTabela->delete($_POST["id"]); }
		}
	}
}

$tabelas = $DAOTabela->select_all();
$prestadores = $DAOPrestadora->select_by_Operadora ($_SESSION["healthcare-user"]["id"]);

$opemed = new Operadora();
$opemed->set_id("0");

$tabelastab = $DAOMedTab->select_by_Operadora (null);
foreach ($tabelastab as $t){ $t->set_OPERADORA($opemed); }

$aux = $DAOMedTab->select_by_Operadora ($_SESSION["healthcare-user"]["id"]);
foreach ($aux as $a){
	$a->set_OPERADORA($opemed);
	array_push ($tabelastab, $a);
}

$opemat = new Operadora();
$opemat->set_id("1");
$aux = $DAOMatTab->select_by_Operadora (null);
foreach ($aux as $a){
	$a->set_OPERADORA($opemat);
	array_push ($tabelastab, $a);
}

$aux = $DAOMatTab->select_by_Operadora ($_SESSION["healthcare-user"]["id"]);
foreach ($aux as $a){
	$a->set_OPERADORA($opemat);
	array_push ($tabelastab, $a);
}

for ($i = 0; $i < (count($tabelastab)-1); $i ++){
	for ($j = $i + 1; $j < count($tabelastab); $j ++){
		if(strtotime($tabelastab[$j]->get_data()) > strtotime($tabelastab[$i]->get_data())){
			$aux = $tabelastab[$i];
			$tabelastab[$i] = $tabelastab[$j];
			$tabelastab[$j] = $aux;
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
						<li><a href="disponibilizacao.php" class="active"><i class="lnr lnr-earth"></i> <span>Disponibilização</span></a></li>
						<li><a href="medicamentos.php" class=""><i class="lnr lnr-drop"></i> <span>Medicamentos</span></a></li>
						<li><a href="materiais.php" class=""><i class="lnr lnr-cart"></i> <span>Materiais</span></a></li>
						<li><a href="configuracoes.php" class=""><i class="lnr lnr-cog"></i> <span>Configurações</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="main">
			<div id="img-aguarde" class="collapse">
				<H1 style="text-align:center;margin-top:7%;">Em desenvolvimento...</H1><br>
				<img style="margin-top:10px;width:30%;margin-left:36%;" src="../assets/img/load.gif" class="img-responsive logo">
			</div>

			<div id="painel_tabela" class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Disponibilização</h3>
								</div>
								<div class="panel-body">
									<table id="table-materiais" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>Tipo</th>
												<th>Nome Tabela</th>
												<th>Prestador</th>
												<th style="width:12%;">Visualizar</th>
												<th style="width:10%;padding-left:8px;">Excluir</th>
											</tr>
										</thead>

										<tbody>
											<?php
												foreach ($tabelas as $tabela){
													if (intval($tabela->get_PRESTADORA()->get_OPERADORA()->get_id()) == intval($_SESSION["healthcare-user"]["id"])){
														echo "<tr>";
														if (!is_null($tabela->get_MEDTAB())){
															echo "<td>Medicamentos</td>
															<td>".$tabela->get_MEDTAB()->get_nome()."</td>";
														} else {
															echo "<td>Materiais</td>
															<td>".$tabela->get_MATTAB()->get_nome()."</td>";
														}

														$cnes = $tabela->get_PRESTADORA()->get_CNES();
														echo "<td>".(is_null($cnes->get_no_fantasia()) ? "" : $cnes->get_no_fantasia())."</td>
														<td align=\"center\" style=\"width:12%;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarTabela('".$tabela->get_id()."')\"> Visualizar </button></td>
														<td align=\"center\" style=\"width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirTabela('".$tabela->get_id()."')\"> Excluir </button></td>
														</tr>";
													}
												}
											?>
										</tbody>
									</table>
								</div>
								<div class="panel-footer">
									<div class="row">
										<div class="col-md-12" align="center">
											<button data-toggle="modal" data-target="#modalAdicionarDisponibilizacao" class="btn btnlarge btn-success"> Disponibilizar Tabela </button>
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

	<div id="modalAdicionarDisponibilizacao" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Disponibilização de Tabela</h4>
					</div>

					<form enctype="multipart/form-data" method="POST" action="disponibilizacao.php">
						<div class="modal-body">
							<div class="row">
								<input id="permitexecadd" type="hidden" name="permitexec" required/>
								<input id="typeoperationadd" type="hidden" name="typeoperation" required/>
								<input id="typetabelaadd" type="hidden" name="typetabela" required/>
								<input id="idrefadd" type="hidden" name="idref" required/>
								<input id="idpresadd" type="hidden" name="idpres" required/>
								<div class="btn-group" style="margin-left:5%;width:90%;">
									<button class="btn dropdown-toggle" id="strcampoprest" data-toggle="dropdown" style="width:100%;margin-right:10px;margin-bottom:10px;padding:0px;height:25px;margin-top:6px;text-align:center;">Selecione um Prestador &nbsp<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
									<?php
										$count = 0;
										foreach ($prestadores as $prestador){
											echo "<li><a tabindex=\"".$count."\" onclick=\"modifyDropdownPres('".$prestador->get_id()."', '[".$prestador->get_id()."] ".$prestador->get_CNES()->get_no_fantasia()."')\">[".$prestador->get_id()."] ".$prestador->get_CNES()->get_no_fantasia()."</a></li>";
												$count = $count + 1;
										}
									?>
									</ul>
								</div>
								<div class="btn-group" style="margin-left:5%;width:90%;">
									<button class="btn dropdown-toggle" id="strcampotipo" data-toggle="dropdown" style="width:100%;margin-right:10px;margin-bottom:10px;padding:0px;height:25px;margin-top:6px;text-align:center;">Selecione uma Categoria &nbsp<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
										<li><a tabindex="0" onclick="modifyDropdownCat('0')">Medicamento</a></li>
										<li><a tabindex="1" onclick="modifyDropdownCat('1')">Material</a></li>
									</ul>
								</div>
								<div id="tbref-medicamento" class="collapse">
									<div class="btn-group" style="margin-left:5%;width:90%;">
										<button class="btn dropdown-toggle" id="strcamporefmed" data-toggle="dropdown" style="width:100%;margin-right:10px;margin-bottom:10px;padding:0px;height:25px;margin-top:6px;text-align:center;">Selecione uma Tabela de Referência &nbsp<span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
										<?php
											$count = 0;
											foreach ($tabelastab as $tabela){
												if (intval($tabela->get_OPERADORA()->get_id()) == 0){
													echo "<li><a tabindex=\"".$count."\" onclick=\"modifyDropdownRefMed('".$tabela->get_id()."', '[".$tabela->get_id()."] ".$tabela->get_nome()."')\">[".$tabela->get_id()."] ".$tabela->get_nome()."</a></li>";
													$count = $count + 1;
												}
											}
										?>
										</ul>
									</div>
								</div>
								<div id="tbref-material" class="collapse">
									<div id="tbref-material" class="btn-group collapse" style="margin-left:5%;width:90%;">
										<button class="btn dropdown-toggle" id="strcamporefmat" data-toggle="dropdown" style="width:100%;margin-right:10px;margin-bottom:10px;padding:0px;height:25px;margin-top:6px;text-align:center;">Selecione uma Tabela de Referência &nbsp<span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
										<?php
											$count = 0;
											foreach ($tabelastab as $tabela){
												if (intval($tabela->get_OPERADORA()->get_id()) == 1){
													echo "<li><a tabindex=\"".$count."\" onclick=\"modifyDropdownRefMat('".$tabela->get_id()."', '[".$tabela->get_id()."] ".$tabela->get_nome()."')\">[".$tabela->get_id()."] ".$tabela->get_nome()."</a></li>";
													$count = $count + 1;
												}
											}
										?>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
							<button type="button" onclick="addTabela()" class="btn btn-success">Adicionar</button>
							<button id="chkaddtabela" type="submit" class="btn btn-success collapse">Submeter</button>
						</div>
					</form>
				</div>
		</div>
	</div>

	<div id="modalExcluir" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<form enctype="multipart/form-data" autocomplete="off" method="POST" action="disponibilizacao.php">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Excluir Disponibilização?</h4>
					</div>

					<div class="modal-body">
						<input id="idexcl" type="hidden" name="id" required/>
						<input id="permitexecexcl" type="hidden" name="permitexec" required/>
						<input id="typeoperationexcl" type="hidden" name="typeoperation" required/>
						<p> Tem certeza que deseja deletar a disponibilização? </p>
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
		document.getElementById("idrefadd").value = "-1";
		document.getElementById("idpresadd").value = "-1";
		document.getElementById("typetabelaadd").value = "-1";

		function modifyDropdownCat (index){
			document.getElementById("typetabelaadd").value = index;
			if (parseInt(index) == 0){
				$('#strcampotipo').html ("Medicamento &nbsp<span class=\"caret\"></span>");
				$('#tbref-material').addClass ("collapse");
				$('#tbref-medicamento').removeClass ("collapse");
			}
			if (parseInt(index) == 1){
				$('#strcampotipo').html ("Material &nbsp<span class=\"caret\"></span>");
				$('#tbref-medicamento').addClass ("collapse");
				$('#tbref-material').removeClass ("collapse");
			}
		}

		function modifyDropdownPres (id, text){
			document.getElementById("idpresadd").value = id;
			$('#strcampoprest').html (text+" &nbsp<span class=\"caret\"></span>");
		}

		function modifyDropdownRefMed (id, text){
			document.getElementById("idrefadd").value = id;
			$('#strcamporefmed').html (text+" &nbsp<span class=\"caret\"></span>");
		}

		function modifyDropdownRefMat (id, text){
			document.getElementById("idrefadd").value = id;
			$('#strcamporefmat').html (text+" &nbsp<span class=\"caret\"></span>");
		}

		function addTabela (){
			idref = document.getElementById("idrefadd").value;
			idpres = document.getElementById("idpresadd").value;
			typetabela = document.getElementById("typetabelaadd").value;

			if (parseInt(idpres) == -1){ alert("Selecione um prestador!"); }
			else{
				if (parseInt(typetabela) == -1){ alert("Selecione um tipo de tabela!"); }
				else {
					if (parseInt(idref) == -1){ alert("Selecione uma tabela de referência!"); }
					else{
						document.getElementById("permitexecadd").value = true;
						document.getElementById("typeoperationadd").value = "1";
						document.getElementById("chkaddtabela").click();
					}
				}
			}
		}

		function excluirTabela (id, typetabela){
			document.getElementById("idexcl").value = id;
			document.getElementById("permitexecexcl").value = true;
			document.getElementById("typeoperationexcl").value = 2;
			$("#modalExcluir").modal("show");
		}

		$(document).ready(function() {
			var table = $('#table-materiais').DataTable({
				"language": {
					"lengthMenu": "Mostrar &nbsp _MENU_ &nbsp disponibilizações por página",
					"zeroRecords": "Nada encontrado, desculpe",
					"info": "Página _PAGE_ de _PAGES_",
					"infoEmpty": "Nenhuma disponibilização encontrada",
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
					{ "searchable": false, "targets": 0 },
					{ "searchable": false, "targets": 1 },
					{ "searchable": false, "targets": 2 },
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