<?php
session_start();
if ((isset($_SESSION["healthcare-type-user"]))&&(isset($_SESSION["healthcare-login"]))&&(isset($_SESSION["healthcare-password"]))){
	if (intval($_SESSION["healthcare-type-user"]) != 1){ header("Location: ../../util/logout.php"); }
} else { header("Location: ../../util/logout.php"); }
session_commit();

require_once('../../dao/medtab_DAO.php');
require_once('../../dao/mattab_DAO.php');

require_once('../../dao/cmed_DAO.php');
require_once('../../dao/medtuss_DAO.php');
require_once('../../dao/medtnum_DAO.php');
require_once('../../dao/mattuss_DAO.php');
require_once('../../dao/mattnum_DAO.php');

$DAOMedTab = new MedTab_DAO();
$DAOMatTab = new MatTab_DAO();

$DAOCMED = new CMED_DAO();
$DAOMedTuss = new MedTuss_DAO();
$DAOMedTnum = new MedTnum_DAO();
$DAOMatTuss = new MatTuss_DAO();
$DAOMatTnum = new MatTnum_DAO();

$hasMessage = false;
$message = "";
$hasExec = false;
$exec = "";
if (isset($_POST["permitexec"])){
	if (strcasecmp ("".$_POST["permitexec"], "true") == 0){
		if (intval($_POST["typeoperation"]) == 1){
			if ((isset($_POST["nome"]))&&(isset($_POST["typetabela"]))&&(isset($_POST["idref"]))){
				$operadora = new Operadora();
				$operadora->set_id($_SESSION["healthcare-user"]["id"]);

				if (intval($_POST["typetabela"]) == 0){
					$medtab = new MedTab();
					$medtab->set_nome ($_POST["nome"]);
					$medtab->set_OPERADORA ($operadora);
					$medtab->set_MEDTAB (new MedTab());
					$medtab->get_MEDTAB ()->set_id ($_POST["idref"]);
					$medtab->set_data (date("Y-m-d H:i:s"));

					if (isset($_POST["deflator"])){
						$value = floatval(1)+floatval(floatval(intval($_POST["deflator"]))/floatval(100));
						$medtab->set_deflator("".$value);
					} else { $medtab->set_deflator("1.0"); }

					if (intval($_POST["alicota_pf"]) != 0){ $medtab->set_pf_alicota(intval($_POST["alicota_pf"])-1); }
					if (intval($_POST["alicota_pmc"]) != 0){ $medtab->set_pmc_alicota(intval($_POST["alicota_pmc"])-1); }
					if (intval($_POST["alicota_pmvg"]) != 0){ $medtab->set_pmvg_alicota(intval($_POST["alicota_pmvg"])-1); }

					$id = $DAOMedTab->insert ($medtab);
					if (intval($id) == -1){
						$hasMessage = true;
						$message = "Não foi possível cadastrar a nova tabela!";
					}
				} else {
					$mattab = new MatTab();
					$mattab->set_nome ($_POST["nome"]);
					$mattab->set_OPERADORA ($operadora);
					$mattab->set_MATTAB (new MatTab());
					$mattab->get_MATTAB ()->set_id ($_POST["idref"]);
					$mattab->set_data (date("Y-m-d H:i:s"));

					$id = $DAOMatTab->insert ($mattab);
					if (intval($id) == -1){
						$hasMessage = true;
						$message = "Não foi possível cadastrar a nova tabela!";
					}
				}
			}
		}
		if (intval($_POST["typeoperation"]) == 2){
			if ((isset($_POST["typetabela"]))&&(isset($_POST["id"]))){
				if (intval($_POST["typetabela"]) == 0){ $DAOMedTab->delete($_POST["id"]); }
				else { $DAOMatTab->delete($_POST["id"]); }
			}
		}
		if (intval($_POST["typeoperation"]) == 3){
			if ((isset($_POST["typetabela"]))&&(isset($_POST["id"]))&&(isset($_POST["idant"]))&&(isset($_POST["idtab"]))){
				if (intval($_POST["typetabela"]) == 0){
					$whereclause = "id_medicamento = '".$_POST["id"]."' AND id_medtab = ".$_POST["idant"];
					$cmeds = $DAOCMED->select_all (null, null, $whereclause);
					$medtusss = $DAOMedTuss->select_all (null, null, $whereclause);
					$medtnums = $DAOMedTnum->select_all (null, null, $whereclause);

					foreach ($cmeds as $cmed){
						$cmed->set_ean_um("!!!DELETEDITEM!!!");
						$cmed->set_MEDTAB(new MedTab());
						$cmed->get_MEDTAB()->set_id($_POST["idtab"]);

						if (intval($_POST["idant"]) == intval($_POST["idtab"])){ $DAOCMED->update($cmed); }
						else { $DAOCMED->insert($cmed); }
					}

					foreach ($medtusss as $medtuss){
						$medtuss->set_fim_implantacao("1970-01-01 00:00:01");
						$medtuss->set_MEDTAB(new MedTab());
						$medtuss->get_MEDTAB()->set_id($_POST["idtab"]);

						if (intval($_POST["idant"]) == intval($_POST["idtab"])){ $DAOMedTuss->update($medtuss); }
						else { $DAOMedTuss->insert($medtuss); }
					}

					foreach ($medtnums as $medtnum){
						$medtnum->set_observacoes("!!!DELETEDITEM!!!");
						$medtnum->set_MEDTAB(new MedTab());
						$medtnum->get_MEDTAB()->set_id($_POST["idtab"]);

						if (intval($_POST["idant"]) == intval($_POST["idtab"])){ $DAOMedTnum->update($medtnum); }
						else { $DAOMedTnum->insert($medtnum); }
					}

					$currmedtab = $DAOMedTab->select_id($_POST["idtab"]);
					$hasExec = true;
					$exec = "openVisualizarTabela('".$currmedtab->get_id()."', '".$currmedtab->get_nome()."', '".$currmedtab->get_data()."', '0');";
				} else {
					$whereclause = "id_material = '".$_POST["id"]."' AND id_mattab = ".$_POST["idant"];
					$mattusss = $DAOMatTuss->select_all (null, null, $whereclause);
					$mattnums = $DAOMatTnum->select_all (null, null, $whereclause);

					foreach ($mattusss as $mattuss){
						$mattuss->set_termo("!!!DELETEDITEM!!!");
						$mattuss->set_MATTAB(new MatTab());
						$mattuss->get_MATTAB()->set_id($_POST["idtab"]);

						if (intval($_POST["idant"]) == intval($_POST["idtab"])){ $DAOMatTuss->update($mattuss); }
						else { $DAOMatTuss->insert($mattuss); }
					}

					foreach ($mattnums as $mattnum){
						$mattnum->set_nome("!!!DELETEDITEM!!!");
						$mattnum->set_MATTAB(new MatTab());
						$mattnum->get_MATTAB()->set_id($_POST["idtab"]);

						if (intval($_POST["idant"]) == intval($_POST["idtab"])){ $DAOMatTnum->update($mattnum); }
						else { $DAOMatTnum->insert($mattnum); }
					}

					$currmattab = $DAOMatTab->select_id($_POST["idtab"]);
					$hasExec = true;
					$exec = "openVisualizarTabela('".$currmattab->get_id()."', '".$currmattab->get_nome()."', '".$currmattab->get_data()."', '1');";
				}
			}
		}
	}
}

$opemed = new Operadora();
$opemed->set_id("0");
$opemed->set_nome("null");

$tabelas = $DAOMedTab->select_by_Operadora (null);
foreach ($tabelas as $t){
	$t->set_OPERADORA($opemed);
}

$opemed = new Operadora();
$opemed->set_id("0");
$opemed->set_nome("notnull");

$aux = $DAOMedTab->select_by_Operadora ($_SESSION["healthcare-user"]["id"]);
foreach ($aux as $a){
	$a->set_OPERADORA($opemed);
	$a->get_OPERADORA()->set_nome("notnull");
	array_push ($tabelas, $a);
}

$opemat = new Operadora();
$opemat->set_id("1");
$opemat->set_nome("null");

$aux = $DAOMatTab->select_by_Operadora (null);
foreach ($aux as $a){
	$a->set_OPERADORA($opemat);
	array_push ($tabelas, $a);
}

$opemat = new Operadora();
$opemat->set_id("1");
$opemat->set_nome("notnull");

$aux = $DAOMatTab->select_by_Operadora ($_SESSION["healthcare-user"]["id"]);
foreach ($aux as $a){
	$a->set_OPERADORA($opemat);
	$a->get_OPERADORA()->set_nome("notnull");
	array_push ($tabelas, $a);
}

for ($i = 0; $i < (count($tabelas)-1); $i ++){
	for ($j = $i + 1; $j < count($tabelas); $j ++){
		if(strtotime($tabelas[$j]->get_data()) > strtotime($tabelas[$i]->get_data())){
			$aux = $tabelas[$i];
			$tabelas[$i] = $tabelas[$j];
			$tabelas[$j] = $aux;
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
		.thitens{ text-align:center; font-size:14px; }
		.tditens{ padding-top:0px; padding-bottom:0px; }
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
						<li><a href="tabelas.php" class="active"><i class="lnr lnr-list"></i> <span>Montagem de Tabelas</span></a></li>
						<li><a href="disponibilizacao.php" class=""><i class="lnr lnr-earth"></i> <span>Disponibilização</span></a></li>
						<li><a href="medicamentos.php" class=""><i class="lnr lnr-drop"></i> <span>Medicamentos</span></a></li>
						<li><a href="materiais.php" class=""><i class="lnr lnr-cart"></i> <span>Materiais</span></a></li>
						<li><a href="configuracoes.php" class=""><i class="lnr lnr-cog"></i> <span>Configurações</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="main">
			<div id="img-aguarde" class="collapse">
				<H1 style="text-align:center;margin-top:7%;">Aguarde...</H1><br>
				<img style="margin-top:10px;width:30%;margin-left:36%;" src="../assets/img/load.gif" class="img-responsive logo">
			</div>

			<div id="painel_medicamento" class="main-content collapse">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Tabelas Disponíveis - Exibição de Tabela</h3>
								</div>
								<div id="med_detalhes" style="padding-left:25px;padding-right:25px;margin-bottom:15px;">
									<b>Nome: </b><span id="medtab_nome"></span><br>
									<b>Data de Criação: </b><span id="medtab_criacao"></span><br>
									<b>Tipo: </b><span>Medicamentos</span><br>
									<input id="idmedtab" type="hidden" name="id" required/>
								</div>
								<div id="search-panel">
									<input id="searchindexmed" type="hidden" required/>
									<div class="panel-body" style="width:100%;padding-top:0px;padding-bottom:10px;">
										<div class="btn-group" style="margin-right:1%;width:20%;">
											<button class="btn dropdown-toggle" id="strcampomed" data-toggle="dropdown" style="width:100%;margin-right:10px;margin-bottom:10px;padding:0px;height:25px;margin-top:6px;text-align:center;">Selecione um Campo &nbsp<span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
												<li><a tabindex="0" onclick="modifyDropdownMed('0')">Registro</a></li>
												<li><a tabindex="1" onclick="modifyDropdownMed('1')">Substância</a></li>
												<li><a tabindex="2" onclick="modifyDropdownMed('2')">Produto</a></li>
												<li><a tabindex="3" onclick="modifyDropdownMed('3')">Laboratório</a></li>
											</ul>
										</div>
										<input id="searchtxtmed" type="text" style="height:25px;padding-left:5px;width:65%;font-size:14px;" placeholder="Buscar..." />
										<button class="btn" onclick="searchMed()" style="width:12%;margin-left:1%;margin-bottom:10px;padding:0px;height:25px;margin-top:6px;text-align:center;">Buscar</span></button>
									</div>
								</div>
								<div id="table-panel-medicamento">
									<div class="panel-body">
										<table id="table-medicamento" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th style="width:15%;font-size:14px;padding-left:8px;">Registro</th>
													<th style="width:19%;font-size:14px;">Substância</th>
													<th style="width:18%;font-size:14px;">Produto</th>
													<th style="width:18%;font-size:14px;">Laboratório</th>
													<th style="width:8%;font-size:14px;">Unidade</th>
													<th style="width:12%;font-size:14px;">Editar</th>
													<th style="width:10%;font-size:14px;padding-left:8px;">Excluir</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
									<div class="panel-footer">
										<div class="row">
											<div class="col-md-12" align="center">
												<button onclick="retornar(0)" class="btn btnlarge btn-default"> Retornar </button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="painel_material" class="main-content collapse">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Tabelas Disponíveis - Exibição de Tabela</h3>
								</div>
								<div id="med_detalhes" style="padding-left:25px;padding-right:25px;margin-bottom:15px;">
									<b>Nome: </b><span id="mattab_nome"></span><br>
									<b>Data de Criação: </b><span id="mattab_criacao"></span><br>
									<b>Tipo: </b><span>Materiais</span><br>
									<input id="idmattab" type="hidden" name="id" required/>
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
													<th style="width:27%;font-size:14px;">Nome Técnico</th>
													<th style="width:28%;font-size:14px;">Fabricante</th>
													<th style="width:10%;font-size:14px;">C. Risco</th>
													<th style="width:10%;font-size:14px;">Visualizar</th>
													<th style="width:10%;font-size:14px;padding-left:8px;">Excluir</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
									<div class="panel-footer">
										<div class="row">
											<div class="col-md-12" align="center">
												<button onclick="retornar(1)" class="btn btnlarge btn-default"> Retornar </button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="painel_tabela" class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Tabelas Disponíveis</h3>
								</div>
								<div class="panel-body">
									<table id="table_tabelas" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>Tipo</th>
												<th>ID</th>
												<th>Nome</th>
												<th>Data</th>
												<th style="width:12%;">Visualizar</th>
												<th style="width:10%;padding-left:8px;">Excluir</th>
											</tr>
										</thead>

										<tbody>
											<?php
												foreach ($tabelas as $tabela){
													echo "<tr>";
													if (intval($tabela->get_OPERADORA()->get_id()) == 0){
														echo "<td>Medicamentos</td>";
													} else { echo "<td>Materiais</td>"; }

													echo "<td>".(is_null($tabela->get_id()) ? "" : $tabela->get_id())."</td>
														<td>".(is_null($tabela->get_nome()) ? "" : $tabela->get_nome())."</td>
														<td>".(is_null($tabela->get_data()) ? "" : $tabela->get_data())."</td>
														<td align=\"center\" style=\"width:12%;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarTabela('".$tabela->get_id()."', '".$tabela->get_nome()."', '".$tabela->get_data()."', '".$tabela->get_OPERADORA()->get_id()."')\"> Visualizar </button></td>";

													if (strcasecmp($tabela->get_OPERADORA()->get_nome(), "null") == 0){
														echo "<td align=\"center\" style=\"width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirTabela('".$tabela->get_id()."', '".$tabela->get_OPERADORA()->get_id()."')\" disabled> Excluir </button></td>";
													} else {
														echo "<td align=\"center\" style=\"width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirTabela('".$tabela->get_id()."', '".$tabela->get_OPERADORA()->get_id()."')\"> Excluir </button></td>";
													}

													echo "</tr>";
												}
											?>
										</tbody>
									</table>
								</div>
								<div class="panel-footer">
									<div class="row">
										<div class="col-md-12" align="center">
											<button data-toggle="modal" data-target="#modalAdicionarTabela" class="btn btnlarge btn-success"> Cadastrar Nova Tabela </button>
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

	<div id="modalVisualizarMedicamento" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" style="width:100%;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Informações do Medicamento</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div id="textinfo-medicamento"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="edtmed" type="button" class="btn btn-success">Editar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>
				</div>
			</div>
		</div>
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
					<button id="edtmat" type="button" class="btn btn-success">Editar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Sair</button>
				</div>
			</div>
		</div>
	</div>

	<div id="modalAdicionarTabela" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Cadastrar Tabela</h4>
					</div>

					<form enctype="multipart/form-data" method="POST" action="tabelas.php">
						<div class="modal-body">
							<div class="row">
								<input id="permitexecadd" type="hidden" name="permitexec" required/>
								<input id="typeoperationadd" type="hidden" name="typeoperation" required/>
								<input id="typetabelaadd" type="hidden" name="typetabela" required/>
								<input id="idrefadd" type="hidden" name="idref" required/>
								<input id="hidalicota_pf" type="hidden" name="alicota_pf" required/>
								<input id="hidalicota_pmc" type="hidden" name="alicota_pmc" required/>
								<input id="hidalicota_pmvg" type="hidden" name="alicota_pmvg" required/>
								<div class="col-md-12" style="padding:0px;margin-left:0px;margin-right:0px;width:100%;">
									<div style="margin-bottom:10px;margin-left:5%;width:90%;">
										<span> Nome</span> </br>
										<input type="text" name="nome" required/>
									</div>
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
											foreach ($tabelas as $tabela){
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
											foreach ($tabelas as $tabela){
												if (intval($tabela->get_OPERADORA()->get_id()) == 1){
													echo "<li><a tabindex=\"".$count."\" onclick=\"modifyDropdownRefMat('".$tabela->get_id()."', '[".$tabela->get_id()."] ".$tabela->get_nome()."')\">[".$tabela->get_id()."] ".$tabela->get_nome()."</a></li>";
													$count = $count + 1;
												}
											}
										?>
										</ul>
									</div>
								</div>
								<div id="med_variables" class="col-md-12 collapse" style="margin-top:10px; padding:0px;margin-left:0px;margin-right:0px;width:100%;">
									<div style="margin-bottom:10px;margin-left:5%;width:90%;">
										<table style="width:100%;">
											<tr>
												<td style="width:20%;">Deflator (%)</td>
												<td style="width:80%;"><input style="width:100%;" value="" id="deflator_med" name="deflator" type="number" class="form-control"></td>
											</tr>
											<tr>
												<td style="width:20%;">Alícota PF</td>
												<td style="width:80%;">
													<div class="btn-group" style="width:100%;height:100%;">
														<button class="btn dropdown-toggle" id="stralicotapf" data-toggle="dropdown" style="width:100%;padding:0px;height:25px;margin-top:6px;text-align:center;">Selecione uma Alícota &nbsp<span class="caret"></span></button>
														<ul style="width:100%" class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
															<li><a tabindex="0" onclick="modifyDropdownPF(0, 'Sem Impostos')">Sem Impostos</a></li>
															<li><a tabindex="1" onclick="modifyDropdownPF(1, '0%')">0%</a></li>
															<li><a tabindex="2" onclick="modifyDropdownPF(2, '12%')">12%</a></li>
															<li><a tabindex="3" onclick="modifyDropdownPF(3, '17%')">17%</a></li>
															<li><a tabindex="4" onclick="modifyDropdownPF(4, '17% ALC')">17% ALC</a></li>
															<li><a tabindex="5" onclick="modifyDropdownPF(5, '17,5%')">17,5%</a></li>
															<li><a tabindex="6" onclick="modifyDropdownPF(6, '17,5% ALC')">17,5% ALC</a></li>
															<li><a tabindex="7" onclick="modifyDropdownPF(7, '18%')">18%</a></li>
															<li><a tabindex="8" onclick="modifyDropdownPF(8, '18% ALC')">18% ALC</a></li>
															<li><a tabindex="9" onclick="modifyDropdownPF(9, '20%')">20%</a></li>
														</ul>
													</div>
												</td>
											</tr>
											<tr>
												<td style="width:20%;">Alícota PMC</td>
												<td style="width:80%;">
													<div class="btn-group" style="width:100%;height:100%;">
														<button class="btn dropdown-toggle" id="stralicotapmc" data-toggle="dropdown" style="width:100%;padding:0px;height:25px;margin-top:6px;text-align:center;">Selecione uma Alícota &nbsp<span class="caret"></span></button>
														<ul style="width:100%" class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
															<li><a tabindex="0" onclick="modifyDropdownPMC(0, '0%')">0%</a></li>
															<li><a tabindex="1" onclick="modifyDropdownPMC(1, '12%')">12%</a></li>
															<li><a tabindex="2" onclick="modifyDropdownPMC(2, '17%')">17%</a></li>
															<li><a tabindex="3" onclick="modifyDropdownPMC(3, '17% ALC')">17% ALC</a></li>
															<li><a tabindex="4" onclick="modifyDropdownPMC(4, '17,5%')">17,5%</a></li>
															<li><a tabindex="5" onclick="modifyDropdownPMC(5, '17,5% ALC')">17,5% ALC</a></li>
															<li><a tabindex="6" onclick="modifyDropdownPMC(6, '18%')">18%</a></li>
															<li><a tabindex="7" onclick="modifyDropdownPMC(7, '18% ALC')">18% ALC</a></li>
															<li><a tabindex="8" onclick="modifyDropdownPMC(8, '20%')">20%</a></li>
														</ul>
													</div>
												</td>
											</tr>
											<tr>
												<td style="width:20%;">Alícota PMVG</td>
												<td style="width:80%;">
													<div class="btn-group" style="width:100%;height:100%;">
														<button class="btn dropdown-toggle" id="stralicotapmvg" data-toggle="dropdown" style="width:100%;padding:0px;height:25px;margin-top:6px;text-align:center;">Selecione uma Alícota &nbsp<span class="caret"></span></button>
														<ul style="width:100%" class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
															<li><a tabindex="0" onclick="modifyDropdownPMVG(0, 'Sem Impostos')">Sem Impostos</a></li>
															<li><a tabindex="1" onclick="modifyDropdownPMVG(1, '0%')">0%</a></li>
															<li><a tabindex="2" onclick="modifyDropdownPMVG(2, '12%')">12%</a></li>
															<li><a tabindex="3" onclick="modifyDropdownPMVG(3, '17%')">17%</a></li>
															<li><a tabindex="4" onclick="modifyDropdownPMVG(4, '17% ALC')">17% ALC</a></li>
															<li><a tabindex="5" onclick="modifyDropdownPMVG(5, '17,5%')">17,5%</a></li>
															<li><a tabindex="6" onclick="modifyDropdownPMVG(6, '17,5% ALC')">17,5% ALC</a></li>
															<li><a tabindex="7" onclick="modifyDropdownPMVG(7, '18%')">18%</a></li>
															<li><a tabindex="8" onclick="modifyDropdownPMVG(8, '18% ALC')">18% ALC</a></li>
															<li><a tabindex="9" onclick="modifyDropdownPMVG(9, '20%')">20%</a></li>
														</ul>
													</div>
												</td>
											</tr>
										</table>
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
				<form enctype="multipart/form-data" autocomplete="off" method="POST" action="tabelas.php">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Excluir Tabela?</h4>
					</div>

					<div class="modal-body">
						<input id="idexcl" type="hidden" name="id" required/>
						<input id="permitexecexcl" type="hidden" name="permitexec" required/>
						<input id="typeoperationexcl" type="hidden" name="typeoperation" required/>
						<input id="typetabelaexcl" type="hidden" name="typetabela" required/>
						<p> Tem certeza que deseja deletar a tabela? </p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
						<button type="submit" class="btn btn-success">Sim</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="modalExcluirMedicamento" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<form enctype="multipart/form-data" autocomplete="off" method="POST" action="tabelas.php">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Excluir Medicamento?</h4>
					</div>

					<div class="modal-body">
						<input id="idexclmed" type="hidden" name="id" required/>
						<input id="permitexecexclmed" type="hidden" name="permitexec" required/>
						<input id="typeoperationexclmed" type="hidden" name="typeoperation" required/>
						<input id="typetabelaexclmed" type="hidden" name="typetabela" required/>
						<input id="idantexclmed" type="hidden" name="idant" required/>
						<input id="idtabexclmed" type="hidden" name="idtab" required/>
						<p> Tem certeza que deseja deletar o medicamento? </p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
						<button type="submit" class="btn btn-success">Sim</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="modalExcluirMaterial" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<form enctype="multipart/form-data" autocomplete="off" method="POST" action="tabelas.php">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Excluir Material?</h4>
					</div>

					<div class="modal-body">
						<input id="idexclmat" type="hidden" name="id" required/>
						<input id="permitexecexclmat" type="hidden" name="permitexec" required/>
						<input id="typeoperationexclmat" type="hidden" name="typeoperation" required/>
						<input id="typetabelaexclmat" type="hidden" name="typetabela" required/>
						<input id="idantexclmat" type="hidden" name="idant" required/>
						<input id="idtabexclmat" type="hidden" name="idtab" required/>
						<p> Tem certeza que deseja deletar o material? </p>
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
		<?php if ($hasExec){ echo $exec; } ?>
		document.getElementById("searchindexmed").value = "-1";
		document.getElementById("searchindexmat").value = "-1";
		document.getElementById("idrefadd").value = "-1";
		document.getElementById("typetabelaadd").value = "-1";

		function modifyDropdownCat (index){
			document.getElementById("typetabelaadd").value = index;
			if (parseInt(index) == 0){
				$('#strcampotipo').html ("Medicamento &nbsp<span class=\"caret\"></span>");
				$('#tbref-material').addClass ("collapse");
				$('#tbref-medicamento').removeClass ("collapse");
				$('#med_variables').removeClass ("collapse");
			}
			if (parseInt(index) == 1){
				$('#strcampotipo').html ("Material &nbsp<span class=\"caret\"></span>");
				$('#tbref-medicamento').addClass ("collapse");
				$('#med_variables').addClass ("collapse");
				$('#tbref-material').removeClass ("collapse");
			}
		}

		function modifyDropdownRefMed (id, text){
			document.getElementById("idrefadd").value = id;
			$('#strcamporefmed').html (text+" &nbsp<span class=\"caret\"></span>");
		}

		function modifyDropdownRefMat (id, text){
			document.getElementById("idrefadd").value = id;
			$('#strcamporefmat').html (text+" &nbsp<span class=\"caret\"></span>");
		}

		function modifyDropdownPF (id, text){
			document.getElementById("hidalicota_pf").value = id;
			$('#stralicotapf').html (text+" &nbsp<span class=\"caret\"></span>");
		}

		function modifyDropdownPMC (id, text){
			document.getElementById("hidalicota_pmc").value = id;
			$('#stralicotapmc').html (text+" &nbsp<span class=\"caret\"></span>");
		}

		function modifyDropdownPMVG (id, text){
			document.getElementById("hidalicota_pmvg").value = id;
			$('#stralicotapmvg').html (text+" &nbsp<span class=\"caret\"></span>");
		}

		function excluirTabela (id, typetabela){
			document.getElementById("idexcl").value = id;
			document.getElementById("typetabelaexcl").value = typetabela;
			document.getElementById("permitexecexcl").value = true;
			document.getElementById("typeoperationexcl").value = 2;
			$("#modalExcluir").modal("show");
		}

		function modifyDropdownMed (index){
			document.getElementById("searchindexmed").value = index;
			if (parseInt(index) == 0){ $('#strcampomed').html ("Registro &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 1){ $('#strcampomed').html ("Substância &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 2){ $('#strcampomed').html ("Produto &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 3){ $('#strcampomed').html ("Laboratório &nbsp<span class=\"caret\"></span>"); }
		}

		function searchMed (){
			if ((parseInt(document.getElementById("searchindexmed").value) == -1)||
				(document.getElementById("searchtxtmed").value == "")){
				if (parseInt(document.getElementById("searchindexmed").value) == -1){ alert ("Selecione um campo!"); }
				if (document.getElementById("searchtxtmed").value == ""){ alert ("Preencha o campo de busca!"); }
				return;
			}

			text = "";
			index = parseInt(document.getElementById("searchindexmed").value);
			txtsc = document.getElementById("searchtxtmed").value;
			if (index == 0){ text = "UPPER(tb_medicamento.id) LIKE '%"+txtsc.toUpperCase()+"%'"; }
			if (index == 1){ text = "UPPER(tb_medicamento.substancia) LIKE '%"+txtsc.toUpperCase()+"%'"; }
			if (index == 2){ text = "UPPER(tb_medicamento.produto) LIKE '%"+txtsc.toUpperCase()+"%'"; }
			if (index == 3){ text = "UPPER(tb_medicamento.laboratorio) LIKE '%"+txtsc.toUpperCase()+"%'"; }

			$('#img-aguarde').removeClass ("collapse");
			$('#painel_medicamento').addClass ("collapse");
			$.post('../../util/requests.php', { 
				request: 8,
				id_medtab: document.getElementById("idmedtab").value,
				whereclause: text
			}, function (response){
				$('#table-panel-medicamento').html (""+response);
				var table = $('#table-medicamento').DataTable({
					"language": {
						"lengthMenu": "Mostrar &nbsp _MENU_ &nbsp medicamentos por página",
						"zeroRecords": "Nada encontrado, desculpe",
						"info": "Página _PAGE_ de _PAGES_",
						"infoEmpty": "Nenhum medicamento encontrado",
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
						{ "searchable": true, "targets": 3 },
						{ "searchable": false, "targets": 4 },
						{ "searchable": false, "orderable": false, "targets": 5 },
						{ "searchable": false, "orderable": false, "targets": 6 }
					]
				});
				document.getElementsByName("table-medicamento_length")[0].style.height = "25px";
				document.getElementsByName("table-medicamento_length")[0].style.padding = "0px";
				document.getElementsByName("table-medicamento_length")[0].style.textAlign = "center";
				var barform = document.getElementsByClassName("form-control form-control-sm");
				for (var i = 0; i < barform.length; i ++){ barform[i].style.height = "25px"; }

				$('#img-aguarde').addClass ("collapse");
				$('#painel_medicamento').removeClass ("collapse");
			});
		}

		function modifyDropdownMat (index){
			document.getElementById("searchindexmat").value = index;
			if (parseInt(index) == 0){ $('#strcampomat').html ("Registro &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 1){ $('#strcampomat').html ("Nome Técnico &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 2){ $('#strcampomat').html ("Classe de Risco &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 3){ $('#strcampomat').html ("Fabricante &nbsp<span class=\"caret\"></span>"); }
		}

		function searchMat (){
			if ((parseInt(document.getElementById("searchindexmat").value) == -1)||
				(document.getElementById("searchtxtmat").value == "")){
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

			$.post('../../util/requests.php', { 
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
						{ "searchable": false, "orderable": false, "targets": 4 },
						{ "searchable": false, "orderable": false, "targets": 5 }
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

		function addTabela (){
			idref = document.getElementById("idrefadd").value;
			typetabela = document.getElementById("typetabelaadd").value;
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

		function retornar(type){
			if (parseInt(type) == 0){
				$('#painel_medicamento').addClass ("collapse");
				$('#painel_tabela').removeClass ("collapse");
			} else {
				$('#painel_material').addClass ("collapse");
				$('#painel_tabela').removeClass ("collapse");
			}
		}

		function openVisualizarTabela(id, nome, data, type){
			if (parseInt(type) == 0){
				document.getElementById("idmedtab").value = id;
				$('#table-panel-medicamento').html ('<div class="panel-body"><table id="table-medicamento" class="table table-striped table-bordered"><thead><tr><th style="width:15%;font-size:14px;padding-left:8px;">Registro</th><th style="width:19%;font-size:14px;">Substância</th><th style="width:18%;font-size:14px;">Produto</th><th style="width:18%;font-size:14px;">Laboratório</th><th style="width:8%;font-size:14px;">Unidade</th><th style="width:12%;font-size:14px;">Visualizar</th><th style="width:10%;font-size:14px;padding-left:8px;">Excluir</th></tr></thead><tbody></tbody></table></div><div class="panel-footer"><div class="row"><div class="col-md-12" align="center"><button onclick="retornar(0)" class="btn btnlarge btn-default"> Retornar </button></div></div></div>');
				$('#medtab_nome').html (""+nome);
				$('#medtab_criacao').html (""+data);

				var table = $('#table-medicamento').DataTable({
					"language": {
						"lengthMenu": "Mostrar &nbsp _MENU_ &nbsp medicamentos por página",
						"zeroRecords": "Utilize os filtros para realizar buscas!",
						"info": "Página _PAGE_ de _PAGES_",
						"infoEmpty": "Nenhum medicamento encontrado",
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
						{ "searchable": true, "targets": 3 },
						{ "searchable": false, "targets": 4 },
						{ "searchable": false, "orderable": false, "targets": 5 },
						{ "searchable": false, "orderable": false, "targets": 6 }
					]
				});

				document.getElementsByName("table-medicamento_length")[0].style.height = "25px";
				document.getElementsByName("table-medicamento_length")[0].style.padding = "0px";
				document.getElementsByName("table-medicamento_length")[0].style.textAlign = "center";
				var barform = document.getElementsByClassName("form-control form-control-sm");
				for (var i = 0; i < barform.length; i ++){ barform[i].style.height = "25px"; }

				$('#painel_tabela').addClass ("collapse");
				$('#painel_medicamento').removeClass ("collapse");
			} else {
				document.getElementById("idmattab").value = id;
				$('#table-panel-material').html ('<div class="panel-body"><table id="table-material" class="table table-striped table-bordered"><thead><tr><th style="width:15%;font-size:14px;padding-left:8px;">Registro</th><th style="width:27%;font-size:14px;">Nome Técnico</th><th style="width:28%;font-size:14px;">Fabricante</th><th style="width:10%;font-size:14px;">C. Risco</th><th style="width:10%;font-size:14px;">Editar</th><th style="width:10%;font-size:14px;padding-left:8px;">Excluir</th></tr></thead><tbody></tbody></table></div><div class="panel-footer"><div class="row"><div class="col-md-12" align="center"><button onclick="retornar(1)" class="btn btnlarge btn-default"> Retornar </button></div></div></div>');
				$('#mattab_nome').html (""+nome);
				$('#mattab_criacao').html (""+data);

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
						{ "searchable": false, "orderable": false, "targets": 4 },
						{ "searchable": false, "orderable": false, "targets": 5 }
					]
				});

				document.getElementsByName("table-material_length")[0].style.height = "25px";
				document.getElementsByName("table-material_length")[0].style.padding = "0px";
				document.getElementsByName("table-material_length")[0].style.textAlign = "center";
				var barform = document.getElementsByClassName("form-control form-control-sm");
				for (var i = 0; i < barform.length; i ++){ barform[i].style.height = "25px"; }

				$('#painel_tabela').addClass ("collapse");
				$('#painel_material').removeClass ("collapse");
			}
		}

		function openVisualizarMedicamento(id, permitedt){
			if (permitedt == false){ document.getElementById("edtmed").disabled = true; }
			$.post('../../util/requests.php', { 
				request: 10,
				id_medtab: document.getElementById("idmedtab").value,
				id_medicamento: id
			}, function (response){
				$('#textinfo-medicamento').html (""+response);
				$("#modalVisualizarMedicamento").modal("show");
			});
		}

		function openVisualizarMaterial(id, permitedt){
			if (permitedt == false){ document.getElementById("edtmat").disabled = true; }
			$.post('../../util/requests.php', { 
				request: 11,
				id_mattab: document.getElementById("idmattab").value,
				id_material: id
			}, function (response){
				$('#textinfo-material').html (""+response);
				$("#modalVisualizarMaterial").modal("show");
			});
		}

		function excluirMedicamento(idmed, idtab){
			document.getElementById("idtabexclmed").value = document.getElementById("idmedtab").value;
			document.getElementById("idantexclmed").value = idtab;
			document.getElementById("idexclmed").value = idmed;
			document.getElementById("permitexecexclmed").value = true;
			document.getElementById("typeoperationexclmed").value = 3;
			document.getElementById("typetabelaexclmed").value = 0;
			$("#modalExcluirMedicamento").modal("show");
		}

		function excluirMaterial(idmat, idtab){
			document.getElementById("idtabexclmat").value = document.getElementById("idmattab").value;
			document.getElementById("idantexclmat").value = idtab;
			document.getElementById("idexclmat").value = idmat;
			document.getElementById("permitexecexclmat").value = true;
			document.getElementById("typeoperationexclmat").value = 3;
			document.getElementById("typetabelaexclmat").value = 1;
			$("#modalExcluirMaterial").modal("show");
		}

		$(document).ready(function() {
			var table = $('#table_tabelas').DataTable({
				"language": {
					"lengthMenu": "Mostrar &nbsp _MENU_ &nbsp tabelas por página",
					"zeroRecords": "Nada encontrado, desculpe",
					"info": "Página _PAGE_ de _PAGES_",
					"infoEmpty": "Nenhuma tabela encontrada",
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
					{ "searchable": true, "targets": 0 },
					{ "searchable": true, "targets": 1 },
					{ "searchable": true, "targets": 2 },
					{ "searchable": true, "targets": 3 },
					{ "searchable": false, "orderable": false, "targets": 4 },
					{ "searchable": false, "orderable": false, "targets": 5 }
				]
			});

			document.getElementsByName("table_tabelas_length")[0].style.height = "25px";
			document.getElementsByName("table_tabelas_length")[0].style.padding = "0px";
			document.getElementsByName("table_tabelas_length")[0].style.textAlign = "center";
			var barform = document.getElementsByClassName("form-control form-control-sm");
			for (var i = 0; i < barform.length; i ++){ barform[i].style.height = "25px"; }
		});
	</script>
</body>
