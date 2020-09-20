<?php
session_start();
if ((isset($_SESSION["healthcare-type-user"]))&&(isset($_SESSION["healthcare-login"]))&&(isset($_SESSION["healthcare-password"]))){
	if (intval($_SESSION["healthcare-type-user"]) != 0){ header("Location: ../../util/logout.php"); }
} else { header("Location: ../../util/logout.php"); }
session_commit();

require_once('../../dao/cnes_DAO.php');
$DAOCNES = new CNES_DAO();

$hasMessage = false;
$message = "";
if (isset($_POST["permitexec"])){
	if (strcasecmp ("".$_POST["permitexec"], "true") == 0){
		if (intval($_POST["typeoperation"]) == 0){
			$newobject = new CNES();
			$newobject->set_id ($DAOCNES->next_id());
			$newobject->set_ativo (1);
			$newobject->set_razao_social ((isset($_POST["razao_social"]) ? strtoupper($_POST["razao_social"]) : ""));
			$newobject->set_no_fantasia ((isset($_POST["no_fantasia"]) ? strtoupper($_POST["no_fantasia"]) : ""));
			$newobject->set_tipo_estabelecimento ((isset($_POST["tipo_estabelecimento"]) ? strtoupper($_POST["tipo_estabelecimento"]) : ""));
			$newobject->set_convenio ((isset($_POST["convenio"]) ? strtoupper($_POST["convenio"]) : ""));
			$newobject->set_natureza_juridica ((isset($_POST["natureza_juridica"]) ? strtoupper($_POST["natureza_juridica"]) : ""));
			$newobject->set_atendimento_prestado ((isset($_POST["atendimento_prestado"]) ? strtoupper($_POST["atendimento_prestado"]) : ""));

			if (isset($_POST["cpf_cnpj"])){
				if (strlen("".$_POST["cpf_cnpj"]) > 11){
					$newobject->set_cnpj ($_POST["cpf_cnpj"]);
					$newobject->set_cpf ("");
				} else {
					$newobject->set_cnpj ("");
					$newobject->set_cpf ($_POST["cpf_cnpj"]);
				}
			} else {
				$newobject->set_cnpj ("");
				$newobject->set_cpf ("");
			}

			if ((isset($_POST["estado"]))&&(isset($_POST["municipio"]))){
				$newobject->set_cd_municipio ($DAOCNES->get_cd_municipio($_POST["municipio"], $_POST["estado"]));
			} else { $newobject->set_cd_municipio (""); }

			$newobject->set_nm_municipio ((isset($_POST["municipio"]) ? strtoupper($_POST["municipio"]) : ""));
			$newobject->set_uf ((isset($_POST["estado"]) ? strtoupper($_POST["estado"]) : ""));
			$newobject->set_cep ((isset($_POST["cep"]) ? strtoupper($_POST["cep"]) : ""));
			$newobject->set_inclusao (date("Y-m-d"));

			$newobject->set_leitos_clinica ((isset($_POST["l_clinica"]) ? ((intval($_POST["l_clinica"]) >= 0) ? $_POST["l_clinica"] : "0") : "0"));
			$newobject->set_leitos_cirurgia ((isset($_POST["l_cirurgia"]) ? ((intval($_POST["l_cirurgia"]) >= 0) ? $_POST["l_cirurgia"] : "0") : "0"));
			$newobject->set_leitos_obstetricia ((isset($_POST["l_obstetricia"]) ? ((intval($_POST["l_obstetricia"]) >= 0) ? $_POST["l_obstetricia"] : "0") : "0"));
			$newobject->set_leitos_pediatria ((isset($_POST["l_pediatria"]) ? ((intval($_POST["l_pediatria"]) >= 0) ? $_POST["l_pediatria"] : "0") : "0"));
			$newobject->set_leitos_psiquiatria ((isset($_POST["l_psiquiatria"]) ? ((intval($_POST["l_psiquiatria"]) >= 0) ? $_POST["l_psiquiatria"] : "0") : "0"));
			$newobject->set_leitos_uti_adulto ((isset($_POST["l_uti_adulto"]) ? ((intval($_POST["l_uti_adulto"]) >= 0) ? $_POST["l_uti_adulto"] : "0") : "0"));
			$newobject->set_leitos_uti_pediatrica ((isset($_POST["l_uti_pediatrica"]) ? ((intval($_POST["l_uti_pediatrica"]) >= 0) ? $_POST["l_uti_pediatrica"] : "0") : "0"));
			$newobject->set_leitos_uti_neonatal ((isset($_POST["l_uti_neonatal"]) ? ((intval($_POST["l_uti_neonatal"]) >= 0) ? $_POST["l_uti_neonatal"] : "0") : "0"));
			$newobject->set_leitos_unidade_interm_neo ((isset($_POST["l_unidade_interm_neo"]) ? ((intval($_POST["l_unidade_interm_neo"]) >= 0) ? $_POST["l_unidade_interm_neo"] : "0") : "0"));

			$newobject->set_equipo_odontologico ((isset($_POST["equipo_odontologico"]) ? 1 : 0));
			$newobject->set_cirurgiao_dentista ((isset($_POST["cirurgiao_dentista"]) ? 1 : 0));
			$newobject->set_urgencia_emergencia ((isset($_POST["urgencia_emergencia"]) ? 1 : 0));
			$newobject->set_anatomopatologia ((isset($_POST["anatomopatologia"]) ? 1 : 0));
			$newobject->set_colposcopia ((isset($_POST["colposcopia"]) ? 1 : 0));
			$newobject->set_eletrocardiograma ((isset($_POST["eletrocardiograma"]) ? 1 : 0));
			$newobject->set_fisioterapia ((isset($_POST["fisioterapia"]) ? 1 : 0));
			$newobject->set_patologia_clinica ((isset($_POST["patologia_clinica"]) ? 1 : 0));
			$newobject->set_radiodiagnostico ((isset($_POST["radiodiagnostico"]) ? 1 : 0));
			$newobject->set_ultra_sonografia ((isset($_POST["ultra_sonografia"]) ? 1 : 0));
			$newobject->set_ecocardiografia ((isset($_POST["ecocardiografia"]) ? 1 : 0));
			$newobject->set_endoscopia_vdigestivas ((isset($_POST["endoscopia_vdigestivas"]) ? 1 : 0));
			$newobject->set_hemoterapia_ambulatorial ((isset($_POST["hemoterapia_ambulatorial"]) ? 1 : 0));
			$newobject->set_holter ((isset($_POST["holter"]) ? 1 : 0));
			$newobject->set_litotripsia_extracorporea ((isset($_POST["litotripsia_extracorporea"]) ? 1 : 0));
			$newobject->set_mamografia ((isset($_POST["mamografia"]) ? 1 : 0));
			$newobject->set_psicoterapia ((isset($_POST["psicoterapia"]) ? 1 : 0));
			$newobject->set_terapia_renalsubst ((isset($_POST["terapia_renalsubst"]) ? 1 : 0));
			$newobject->set_teste_ergometrico ((isset($_POST["teste_ergometrico"]) ? 1 : 0));
			$newobject->set_tomografia_computadorizada ((isset($_POST["tomografia_computadorizada"]) ? 1 : 0));
			$newobject->set_atendimento_hospitaldia ((isset($_POST["atendimento_hospitaldia"]) ? 1 : 0));
			$newobject->set_endoscopia_vaereas ((isset($_POST["endoscopia_vaereas"]) ? 1 : 0));
			$newobject->set_hemodinamica ((isset($_POST["hemodinamica"]) ? 1 : 0));
			$newobject->set_medicina_nuclear ((isset($_POST["medicina_nuclear"]) ? 1 : 0));
			$newobject->set_quimioterapia ((isset($_POST["quimioterapia"]) ? 1 : 0));
			$newobject->set_radiologia_intervencionista ((isset($_POST["radiologia_intervencionista"]) ? 1 : 0));
			$newobject->set_radioterapia ((isset($_POST["radioterapia"]) ? 1 : 0));
			$newobject->set_ressonancia_nmagnetica ((isset($_POST["ressonancia_nmagnetica"]) ? 1 : 0));
			$newobject->set_ultrassonografia_doppler ((isset($_POST["ultrassonografia_doppler"]) ? 1 : 0));
			$newobject->set_videocirurgia ((isset($_POST["videocirurgia"]) ? 1 : 0));
			$newobject->set_odontologia_basica ((isset($_POST["odontologia_basica"]) ? 1 : 0));
			$newobject->set_raiox_dentario ((isset($_POST["raiox_dentario"]) ? 1 : 0));
			$newobject->set_endodontia ((isset($_POST["endodontia"]) ? 1 : 0));
			$newobject->set_periodontia ((isset($_POST["periodontia"]) ? 1 : 0));

			$DAOCNES->insert ($newobject);
		}
		if (intval($_POST["typeoperation"]) == 1){
			if (isset($_POST["id"])){ $DAOCNES->delete($_POST["id"]); }
		}
		if (intval($_POST["typeoperation"]) == 2){
			$newobject = new CNES();
			$newobject->set_id ((isset($_POST["id"]) ? strtoupper($_POST["id"]) : $DAOCNES->next_id()));
			$newobject->set_ativo (1);
			$newobject->set_razao_social ((isset($_POST["razao_social"]) ? strtoupper($_POST["razao_social"]) : ""));
			$newobject->set_no_fantasia ((isset($_POST["no_fantasia"]) ? strtoupper($_POST["no_fantasia"]) : ""));
			$newobject->set_tipo_estabelecimento ((isset($_POST["tipo_estabelecimento"]) ? strtoupper($_POST["tipo_estabelecimento"]) : ""));
			$newobject->set_convenio ((isset($_POST["convenio"]) ? strtoupper($_POST["convenio"]) : ""));
			$newobject->set_natureza_juridica ((isset($_POST["natureza_juridica"]) ? strtoupper($_POST["natureza_juridica"]) : ""));
			$newobject->set_atendimento_prestado ((isset($_POST["atendimento_prestado"]) ? strtoupper($_POST["atendimento_prestado"]) : ""));

			if (isset($_POST["cpf_cnpj"])){
				if (strlen("".$_POST["cpf_cnpj"]) > 11){
					$newobject->set_cnpj ($_POST["cpf_cnpj"]);
					$newobject->set_cpf ("");
				} else {
					$newobject->set_cnpj ("");
					$newobject->set_cpf ($_POST["cpf_cnpj"]);
				}
			} else {
				$newobject->set_cnpj ("");
				$newobject->set_cpf ("");
			}

			if ((isset($_POST["estado"]))&&(isset($_POST["municipio"]))){
				$newobject->set_cd_municipio ($DAOCNES->get_cd_municipio($_POST["municipio"], $_POST["estado"]));
			} else { $newobject->set_cd_municipio (""); }

			$newobject->set_nm_municipio ((isset($_POST["municipio"]) ? strtoupper($_POST["municipio"]) : ""));
			$newobject->set_uf ((isset($_POST["estado"]) ? strtoupper($_POST["estado"]) : ""));
			$newobject->set_cep ((isset($_POST["cep"]) ? strtoupper($_POST["cep"]) : ""));
			$newobject->set_inclusao (date("Y-m-d"));

			$newobject->set_leitos_clinica ((isset($_POST["l_clinica"]) ? ((intval($_POST["l_clinica"]) >= 0) ? $_POST["l_clinica"] : "0") : "0"));
			$newobject->set_leitos_cirurgia ((isset($_POST["l_cirurgia"]) ? ((intval($_POST["l_cirurgia"]) >= 0) ? $_POST["l_cirurgia"] : "0") : "0"));
			$newobject->set_leitos_obstetricia ((isset($_POST["l_obstetricia"]) ? ((intval($_POST["l_obstetricia"]) >= 0) ? $_POST["l_obstetricia"] : "0") : "0"));
			$newobject->set_leitos_pediatria ((isset($_POST["l_pediatria"]) ? ((intval($_POST["l_pediatria"]) >= 0) ? $_POST["l_pediatria"] : "0") : "0"));
			$newobject->set_leitos_psiquiatria ((isset($_POST["l_psiquiatria"]) ? ((intval($_POST["l_psiquiatria"]) >= 0) ? $_POST["l_psiquiatria"] : "0") : "0"));
			$newobject->set_leitos_uti_adulto ((isset($_POST["l_uti_adulto"]) ? ((intval($_POST["l_uti_adulto"]) >= 0) ? $_POST["l_uti_adulto"] : "0") : "0"));
			$newobject->set_leitos_uti_pediatrica ((isset($_POST["l_uti_pediatrica"]) ? ((intval($_POST["l_uti_pediatrica"]) >= 0) ? $_POST["l_uti_pediatrica"] : "0") : "0"));
			$newobject->set_leitos_uti_neonatal ((isset($_POST["l_uti_neonatal"]) ? ((intval($_POST["l_uti_neonatal"]) >= 0) ? $_POST["l_uti_neonatal"] : "0") : "0"));
			$newobject->set_leitos_unidade_interm_neo ((isset($_POST["l_unidade_interm_neo"]) ? ((intval($_POST["l_unidade_interm_neo"]) >= 0) ? $_POST["l_unidade_interm_neo"] : "0") : "0"));

			$newobject->set_equipo_odontologico ((isset($_POST["equipo_odontologico"]) ? 1 : 0));
			$newobject->set_cirurgiao_dentista ((isset($_POST["cirurgiao_dentista"]) ? 1 : 0));
			$newobject->set_urgencia_emergencia ((isset($_POST["urgencia_emergencia"]) ? 1 : 0));
			$newobject->set_anatomopatologia ((isset($_POST["anatomopatologia"]) ? 1 : 0));
			$newobject->set_colposcopia ((isset($_POST["colposcopia"]) ? 1 : 0));
			$newobject->set_eletrocardiograma ((isset($_POST["eletrocardiograma"]) ? 1 : 0));
			$newobject->set_fisioterapia ((isset($_POST["fisioterapia"]) ? 1 : 0));
			$newobject->set_patologia_clinica ((isset($_POST["patologia_clinica"]) ? 1 : 0));
			$newobject->set_radiodiagnostico ((isset($_POST["radiodiagnostico"]) ? 1 : 0));
			$newobject->set_ultra_sonografia ((isset($_POST["ultra_sonografia"]) ? 1 : 0));
			$newobject->set_ecocardiografia ((isset($_POST["ecocardiografia"]) ? 1 : 0));
			$newobject->set_endoscopia_vdigestivas ((isset($_POST["endoscopia_vdigestivas"]) ? 1 : 0));
			$newobject->set_hemoterapia_ambulatorial ((isset($_POST["hemoterapia_ambulatorial"]) ? 1 : 0));
			$newobject->set_holter ((isset($_POST["holter"]) ? 1 : 0));
			$newobject->set_litotripsia_extracorporea ((isset($_POST["litotripsia_extracorporea"]) ? 1 : 0));
			$newobject->set_mamografia ((isset($_POST["mamografia"]) ? 1 : 0));
			$newobject->set_psicoterapia ((isset($_POST["psicoterapia"]) ? 1 : 0));
			$newobject->set_terapia_renalsubst ((isset($_POST["terapia_renalsubst"]) ? 1 : 0));
			$newobject->set_teste_ergometrico ((isset($_POST["teste_ergometrico"]) ? 1 : 0));
			$newobject->set_tomografia_computadorizada ((isset($_POST["tomografia_computadorizada"]) ? 1 : 0));
			$newobject->set_atendimento_hospitaldia ((isset($_POST["atendimento_hospitaldia"]) ? 1 : 0));
			$newobject->set_endoscopia_vaereas ((isset($_POST["endoscopia_vaereas"]) ? 1 : 0));
			$newobject->set_hemodinamica ((isset($_POST["hemodinamica"]) ? 1 : 0));
			$newobject->set_medicina_nuclear ((isset($_POST["medicina_nuclear"]) ? 1 : 0));
			$newobject->set_quimioterapia ((isset($_POST["quimioterapia"]) ? 1 : 0));
			$newobject->set_radiologia_intervencionista ((isset($_POST["radiologia_intervencionista"]) ? 1 : 0));
			$newobject->set_radioterapia ((isset($_POST["radioterapia"]) ? 1 : 0));
			$newobject->set_ressonancia_nmagnetica ((isset($_POST["ressonancia_nmagnetica"]) ? 1 : 0));
			$newobject->set_ultrassonografia_doppler ((isset($_POST["ultrassonografia_doppler"]) ? 1 : 0));
			$newobject->set_videocirurgia ((isset($_POST["videocirurgia"]) ? 1 : 0));
			$newobject->set_odontologia_basica ((isset($_POST["odontologia_basica"]) ? 1 : 0));
			$newobject->set_raiox_dentario ((isset($_POST["raiox_dentario"]) ? 1 : 0));
			$newobject->set_endodontia ((isset($_POST["endodontia"]) ? 1 : 0));
			$newobject->set_periodontia ((isset($_POST["periodontia"]) ? 1 : 0));

			$DAOCNES->update ($newobject);
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
						<li><a href="administradores.php" class=""><i class="lnr lnr-star"></i> <span>Administradores</span></a></li>
						<li><a href="operadoras.php" class=""><i class="lnr lnr-heart-pulse"></i> <span>Operadoras</span></a></li>
						<li><a href="simple_prestadores.php" class="active"><i class="lnr lnr-license"></i> <span>Prestadores</span></a></li>
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
			<div id="img-aguarde" class="collapse">
				<button onclick="cancelOpe()" style="margin:20px;width:15%" class="btn btnlarge btn-info"> Cancelar Operação </button>
				<H1 style="text-align:center;margin-top:1%;">Aguarde...</H1><br>
				<img style="margin-top:20px;width:30%;margin-left:36%;" src="../assets/img/load.gif" class="img-responsive logo">
			</div>

			<div id="main-panel" class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Prestadores de Serviços</h3>
								</div>
								<div id="search-panel">
									<input id="searchindex" type="hidden" required/>
									<div class="panel-body" style="width:100%;padding-top:0px;padding-bottom:10px;">
										<div class="btn-group" style="margin-right:1%;width:20%;">
											<button class="btn dropdown-toggle" id="strcampo" data-toggle="dropdown" style="width:100%;margin-right:10px;margin-bottom:10px;padding:0px;height:25px;margin-top:6px;text-align:center;">Selecione um Campo &nbsp<span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
												<li><a tabindex="0" onclick="modifyDropdown('0')">Registro</a></li>
												<li><a tabindex="1" onclick="modifyDropdown('1')">Nome Fantasia</a></li>
												<li><a tabindex="2" onclick="modifyDropdown('2')">CNPJ ou CPF</a></li>
												<li><a tabindex="3" onclick="modifyDropdown('3')">Município</a></li>
												<li><a tabindex="4" onclick="modifyDropdown('4')">UF</a></li>
												<li><a tabindex="5" onclick="modifyDropdown('5')">Todos</a></li>
											</ul>
										</div>
										<input id="searchtxt" type="text" style="height:25px;padding-left:5px;width:65%;font-size:14px;" placeholder="Buscar..." />
										<button class="btn" onclick="search()" style="width:12%;margin-left:1%;margin-bottom:10px;padding:0px;height:25px;margin-top:6px;text-align:center;">Buscar</span></button>
									</div>
								</div>
								<div id="table-panel">
									<div class="panel-body">
										<table id="table-materiais" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th style="width:9%;font-size:14px;padding-left:8px;">Registro</th>
													<th style="width:22%;font-size:14px;">Nome Fantasia</th>
													<th style="width:22%;font-size:14px;">CNPJ ou CPF</th>
													<th style="width:22%;font-size:14px;">Município</th>
													<th style="width:5%;font-size:14px;">UF</th>
													<th style="width:10%;font-size:14px;">Editar</th>
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
												<button onclick="openAddPrestador()" class="btn btnlarge btn-success"> Cadastrar Prestador </button>
											</div>
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

	<div id="modalAdicionarPrestador" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cadastrar Prestador</h4>
				</div>

				<form enctype="multipart/form-data" method="POST" action="simple_prestadores.php">
					<div class="modal-body" style="padding:0px;">
						<input id="permitexecadd" type="hidden" name="permitexec" required/>
						<input id="typeoperationadd" type="hidden" name="typeoperation" required/>
						<input id="add_estado" type="hidden" name="estado" required/>
						<input id="add_municipio" type="hidden" name="municipio" required/>
						<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;padding-top:10px;margin-top:10px;">
							<h3 class="panel-title" style="font-size:17px;">Dados do Prestador</h3>
							<hr style="margin-top:10px;margin-bottom:15px;" />
						</div>
						<div class="row">
							<table style="margin-right:5%;margin-left:5%;margin-top:5px;margin-bottom:5px;width:90%;">
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:34%;">Razão Social: &nbsp</td>
									<td><input style="height:25px;" id="add_razao_social" type="text" name="razao_social"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:34%;">Nome Fantasia: &nbsp</td>
									<td><input style="height:25px;" id="add_no_fantasia" type="text" name="no_fantasia"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:34%;">Tipo de Estabelecimento: &nbsp</td>
									<td><input style="height:25px;" id="add_tipo_estabe" type="text" name="tipo_estabelecimento"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:34%;">Convênio: &nbsp</td>
									<td><input style="height:25px;" id="add_convenio" type="text" name="convenio"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:34%;">Natureza Jurídica: &nbsp</td>
									<td><input style="height:25px;" id="add_natureza_juridica" type="text" name="natureza_juridica"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:34%;">Atendimentos Prestados: &nbsp</td>
									<td><input style="height:25px;" id="add_atendimento_prest" type="text" name="atendimento_prestado"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:34%;">CPF ou CNPJ: &nbsp</td>
									<td><input style="height:25px;" id="add_cpf_cnpj" type="text" name="cpf_cnpj"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:34%;">Estado: &nbsp</td>
									<td><select style="height:25px;width:100%" id="add_estados" type="text" name="estados"></select></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:34%;">Municipio: &nbsp</td>
									<td><select style="height:25px;width:100%" id="add_cidades" type="text" name="cidades"></select></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:34%;">CEP: &nbsp</td>
									<td><input style="height:25px;" id="add_cep" type="text" name="cep"></td>
								</tr>
							</table>
						</div>
						<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;padding-top:10px;margin-top:10px;">
							<h3 class="panel-title" style="font-size:17px;">Número de Leitos</h3>
							<hr style="margin-top:10px;margin-bottom:15px;" />
						</div>
						<div class="row">
							<table style="margin-right:5%;margin-left:5%;margin-top:5px;margin-bottom:5px;width:90%;">
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:28%;">Clínica: &nbsp</td>
									<td><input style="height:25px;" id="add_l_clinica" type="number" name="l_clinica"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:28%;">Cirurgia: &nbsp</td>
									<td><input style="height:25px;" id="add_l_cirurgia" type="number" name="l_cirurgia"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:28%;">Obstetricia: &nbsp</td>
									<td><input style="height:25px;" id="add_l_obstetricia" type="number" name="l_obstetricia"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:28%;">Pediatria: &nbsp</td>
									<td><input style="height:25px;" id="add_l_pediatria" type="number" name="l_pediatria"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:28%;">Psiquiatria: &nbsp</td>
									<td><input style="height:25px;" id="add_l_psiquiatria" type="number" name="l_psiquiatria"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:28%;">UTI Adulto: &nbsp</td>
									<td><input style="height:25px;" id="add_l_uti_adulto" type="number" name="l_uti_adulto"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:28%;">UTI Pediatrica: &nbsp</td>
									<td><input style="height:25px;" id="add_l_uti_pediatrica" type="number" name="l_uti_pediatrica"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:28%;">UTI Neonatal: &nbsp</td>
									<td><input style="height:25px;" id="add_l_uti_neonatal" type="number" name="l_uti_neonatal"></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="text-align:right;width:28%;">Unidade Interm Neo: &nbsp</td>
									<td><input style="height:25px;" id="add_l_unidade_interm_neo" type="number" name="l_unidade_interm_neo"></td>
								</tr>
							</table>
						</div>
						<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;padding-top:10px;margin-top:10px;">
							<h3 class="panel-title" style="font-size:17px;">Itens Presentes</h3>
							<hr style="margin-top:10px;margin-bottom:15px;" />
						</div>
						<div class="row" style="margin-bottom:20px;">
							<table style="margin-right:5%;margin-left:5%;margin-top:5px;margin-bottom:5px;width:90%;">
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="width:33.33%"><input style="width:5%;" id="add_equipo_odontologico" name="equipo_odontologico" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Equipo Odontológico</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_cirurgiao_dentista" name="cirurgiao_dentista" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Cirurgião Dentista</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_urgencia_emergencia" name="urgencia_emergencia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Urgência e Emergência</span></div></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="width:33.33%"><input style="width:5%;" id="add_anatomopatologia" name="anatomopatologia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Anatomopatologia</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_colposcopia" name="colposcopia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Colposcopia</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_eletrocardiograma" name="eletrocardiograma" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Eletrocardiograma</span></div></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="width:33.33%"><input style="width:5%;" id="add_fisioterapia" name="fisioterapia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Fisioterapia</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_patologia_clinica" name="patologia_clinica" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Patologia Clínica</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_radiodiagnostico" name="radiodiagnostico" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Radiodiagnóstico</span></div></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="width:33.33%"><input style="width:5%;" id="add_ultra_sonografia" name="ultra_sonografia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Ultrassonografia</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_ecocardiografia" name="ecocardiografia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Ecocardiografia</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_endoscopia_vdigestivas" name="endoscopia_vdigestivas" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Endoscopia V Digestivas</span></div></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="width:33.33%"><input style="width:5%;" id="add_hemoterapia_ambulatorial" name="hemoterapia_ambulatorial" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Hemo. Ambulatorial</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_holter" name="holter" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Holter</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_litotripsia_extracorporea" name="litotripsia_extracorporea" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Litotripsia Extracorporea</span></div></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="width:33.33%"><input style="width:5%;" id="add_mamografia" name="mamografia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Mamografia</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_psicoterapia" name="psicoterapia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Psicoterapia</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_terapia_renalsubst" name="terapia_renalsubst" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Terapia Renal</span></div></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="width:33.33%"><input style="width:5%;" id="add_teste_ergometrico" name="teste_ergometrico" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Teste Ergométrico</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_tomografia_computadorizada" name="tomografia_computadorizada" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp T. Computadorizada</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_atendimento_hospitaldia" name="atendimento_hospitaldia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Atendimento Diurno</span></div></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="width:33.33%"><input style="width:5%;" id="add_endoscopia_vaereas" name="endoscopia_vaereas" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Endoscopia V Aereas</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_hemodinamica" name="hemodinamica" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Hemodinâmica</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_medicina_nuclear" name="medicina_nuclear" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Medicina Nuclear</span></div></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="width:33.33%"><input style="width:5%;" id="add_quimioterapia" name="quimioterapia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Quimioterapia</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_radiologia_intervencionista" name="radiologia_intervencionista" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Radiologia Inter.</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_radioterapia" name="radioterapia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Radioterapia</span></div></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="width:33.33%"><input style="width:5%;" id="add_ressonancia_nmagnetica" name="ressonancia_nmagnetica" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Resso. Magnética</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_ultrassonografia_doppler" name="ultrassonografia_doppler" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Ultrasso. Doppler</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_videocirurgia" name="videocirurgia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Videocirurgia</span></div></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="width:33.33%"><input style="width:5%;" id="add_odontologia_basica" name="odontologia_basica" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Odontologia Básica</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_raiox_dentario" name="raiox_dentario" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Raio X Dentário</span></div></td>
									<td style="width:33.33%"><input style="width:5%;" id="add_endodontia" name="endodontia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Endodontia</span></div></td>
								</tr>
								<tr style="border-width:5px;border-style:solid;border-color:white;">
									<td style="width:33.33%"><input style="width:5%;" id="add_periodontia" name="periodontia" type="checkbox" value=""><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Periodontia</span></div></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
						<button type="button" onclick="addPrestador()" class="btn btn-success">Adicionar</button>
						<button id="chkaddprestador" type="submit" class="btn btn-success collapse">Submeter</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="modalEditarPrestador" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" id="edt_panel">
			</div>
		</div>
	</div>

	<div id="modalExcluir" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<form enctype="multipart/form-data" method="POST" action="simple_prestadores.php">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Excluir Prestador?</h4>
					</div>

					<div class="modal-body">
						<input id="idprestadorexcl" type="hidden" name="id" required/>
						<input id="permitexecexcl" type="hidden" name="permitexec" required/>
						<input id="typeoperationexcl" type="hidden" name="typeoperation" required/>
						<p> Tem certeza que deseja deletar o prestador? </p>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
						<button type="submit" class="btn btn-success">Sim</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="modalAguarde" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Em desenvolvimento</h4>
				</div>

				<div class="modal-body">
					<input id="idmaterialexcl" type="hidden" name="id" required/>
					<input id="permitexecexcl" type="hidden" name="permitexec" required/>
					<input id="typeoperationexcl" type="hidden" name="typeoperation" required/>
					<p> Funcionalidade ainda em desenvolvimento! </p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
				</div>
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
		document.getElementById("searchindex").value = "-1";
		var request = null;

		function removerAcentos (newStringComAcento){
			var string = newStringComAcento;
			var mapaAcentosHex 	= {
				a : /[\xE0-\xE6]/g,
				e : /[\xE8-\xEB]/g,
				i : /[\xEC-\xEF]/g,
				o : /[\xF2-\xF6]/g,
				u : /[\xF9-\xFC]/g,
				c : /\xE7/g,
				n : /\xF1/g
			};

			for (var letra in mapaAcentosHex){
				var expressaoRegular = mapaAcentosHex[letra];
				string = string.replace( expressaoRegular, letra );
			}
			return string;
		}

		function searchUF (text){
			uf = removerAcentos (text.toUpperCase());
			if (uf == "ACRE"){ uf = "AC"; }
			if (uf == "ALAGOAS"){ uf = "AL"; }
			if (uf == "AMAPA"){ uf = "AP"; }
			if (uf == "AMAZONAS"){ uf = "AM"; }
			if (uf == "BAHIA"){ uf = "BA"; }
			if (uf == "CEARA"){ uf = "CE"; }
			if (uf == "DISTRITO FEDERAL"){ uf = "DF"; }
			if (uf == "ESPIRITO SANTO"){ uf = "ES"; }
			if (uf == "GOIAS"){ uf = "GO"; }
			if (uf == "MARANHAO"){ uf = "MA"; }
			if (uf == "MATO GROSSO"){ uf = "MT"; }
			if (uf == "MATO GROSSO DO SUL"){ uf = "MS"; }
			if (uf == "MINAS GERAIS"){ uf = "MG"; }
			if (uf == "PARA"){ uf = "PA"; }
			if (uf == "PARAIBA"){ uf = "PB"; }
			if (uf == "PARANA"){ uf = "PR"; }
			if (uf == "PERNAMBUCO"){ uf = "PE"; }
			if (uf == "PIAUI"){ uf = "PI"; }
			if (uf == "RIO DE JANEIRO"){ uf = "RJ"; }
			if (uf == "RIO GRANDE DO NORTE"){ uf = "RN"; }
			if (uf == "RIO GRANDE DO SUL"){ uf = "RS"; }
			if (uf == "RONDONIA"){ uf = "RO"; }
			if (uf == "RORAIMA"){ uf = "RR"; }
			if (uf == "SANTA CATARINA"){ uf = "SC"; }
			if (uf == "SAO PAULO"){ uf = "SP"; }
			if (uf == "SERGIPE"){ uf = "SE"; }
			if (uf == "TOCANTINS"){ uf = "TO"; }
			return uf;
		}

		function cancelOpe (){
			request.abort();
			request = null;
			$('#img-aguarde').addClass ("collapse");
			$('#main-panel').removeClass ("collapse");
		}

		function modifyDropdown (index){
			document.getElementById("searchindex").value = index;
			document.getElementById ("searchtxt").disabled = false;
			document.getElementById ("searchtxt").value = "";
			if (parseInt(index) == 0){ $('#strcampo').html ("Registro &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 1){ $('#strcampo').html ("Nome Fantasia &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 2){ $('#strcampo').html ("CNPJ ou CPF &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 3){ $('#strcampo').html ("Município &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 4){ $('#strcampo').html ("UF &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 5){
				$('#strcampo').html ("Todos &nbsp<span class=\"caret\"></span>");
				document.getElementById ("searchtxt").disabled = true;
			}
		}

		function search (){
			if (((parseInt(document.getElementById("searchindex").value) == -1)||
				(document.getElementById("searchtxt").value == ""))&&(parseInt(document.getElementById("searchindex").value) != 5)){
				if (parseInt(document.getElementById("searchindex").value) == -1){ alert ("Selecione um campo!"); }
				if (document.getElementById("searchtxt").value == ""){ alert ("Preencha o campo de busca!"); }
				return;
			}

			$('#img-aguarde').removeClass ("collapse");
			$('#main-panel').addClass ("collapse");

			text = "";
			index = parseInt(document.getElementById("searchindex").value);
			txtsc = document.getElementById("searchtxt").value;
			if (index == 0){ text = "UPPER(id) LIKE '%"+txtsc.toUpperCase()+"%'"; }
			if (index == 1){ text = "UPPER(no_fantasia) LIKE '%"+txtsc.toUpperCase()+"%'"; }
			if (index == 2){
				text = "UPPER(cnpj) LIKE '%"+txtsc.toUpperCase()+"%' OR ";
				text = text+"UPPER(cpf) LIKE '%"+txtsc.toUpperCase()+"%'";
			}
			if (index == 3){ text = "UPPER(nm_municipio) LIKE '%"+txtsc.toUpperCase()+"%'"; }
			if (index == 4){ text = "UPPER(uf) LIKE '%"+searchUF(txtsc)+"%'"; }
			if (index == 5){ text = "id IS NOT NULL"; }

			request = $.post('../../util/requests.php', { 
				request: 4,
				whereclause: text
			}, function (response){
				$('#table-panel').html (""+response);
				var table = $('#table-materiais').DataTable({
					"language": {
						"lengthMenu": "Mostrar &nbsp _MENU_ &nbsp prestadores por página",
						"zeroRecords": "Nada encontrado, desculpe",
						"info": "Página _PAGE_ de _PAGES_",
						"infoEmpty": "Nenhum prestador encontrado",
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
						{ "searchable": true, "targets": 4 },
						{ "searchable": false, "orderable": false, "targets": 5 },
						{ "searchable": false, "orderable": false, "targets": 6 }
					]
				});

				document.getElementsByName("table-materiais_length")[0].style.height = "25px";
				document.getElementsByName("table-materiais_length")[0].style.padding = "0px";
				document.getElementsByName("table-materiais_length")[0].style.textAlign = "center";
				document.getElementsByClassName("form-control form-control-sm")[1].style.height = "25px";

				$('#img-aguarde').addClass ("collapse");
				$('#main-panel').removeClass ("collapse");
			});
		}

		function excluirPrestador (id){
			document.getElementById("idprestadorexcl").value = id;
			document.getElementById("permitexecexcl").value = true;
			document.getElementById("typeoperationexcl").value = 1;
			$("#modalExcluir").modal("show");
		}

		function addPrestador (){
			var select_uf = document.getElementById ('add_estados');
			var select_cd = document.getElementById ('add_cidades');
			document.getElementById('add_estado').value = searchUF (select_uf.options[select_uf.selectedIndex].value);
			document.getElementById('add_municipio').value = select_cd.options[select_cd.selectedIndex].value.toUpperCase();
			document.getElementById("chkaddprestador").click();
		}

		function edtPrestador (){
			var select_uf = document.getElementById ('edt_estados');
			var select_cd = document.getElementById ('edt_cidades');
			document.getElementById('edt_estado').value = searchUF (select_uf.options[select_uf.selectedIndex].value);
			document.getElementById('edt_municipio').value = select_cd.options[select_cd.selectedIndex].value.toUpperCase();
			document.getElementById("chkedtprestador").click();
		}

		function openEditarPrestador(id, uf, cidade){
			$.post('../../util/requests.php', { 
				request: 7,
				id_cnes: id
			}, function (response){
				$('#edt_panel').html (""+response);
				document.getElementById("permitexecedt").value = true;
				document.getElementById("typeoperationedt").value = 2;
				document.getElementById("edt_estado").value = uf;
				document.getElementById("edt_municipio").value = cidade;

				$.getJSON ('../assets/scripts/estados_cidades.json', function (data) {
					var items = [];
					var options = '<option value=""></option>';

					$.each (data, function (key, val){
						curruf = searchUF($("#edt_estado").val());
						if (searchUF(val.nome) == curruf){
							options += '<option value="' + val.nome + '" selected>' + val.nome + '</option>';
						} else { options += '<option value="' + val.nome + '">' + val.nome + '</option>'; }
					});

					$("#edt_estados").html(options);
					$("#edt_estados").change(function () {
						var options_cidades = '';
						var str = "";
						$("#edt_estados option:selected").each (function () { str += $(this).text(); });

						$.each(data, function (key, val) {
							if (val.nome == str){
								$.each(val.cidades, function (key_city, val_city) {
									currcd = $("#edt_municipio").val();
									currcd = currcd.replace(/\t/g, '');
									if (val_city.toUpperCase() == currcd.toUpperCase()){
										options_cidades += '<option value="' + val_city + '" selected>' + val_city + '</option>';
									} else { options_cidades += '<option value="' + val_city + '">' + val_city + '</option>'; }
								});
							}
						});

						$("#edt_cidades").html(options_cidades);
					}).change();
				});

				$("#modalEditarPrestador").modal("show");
			});
		}

		function openAddPrestador(){
			document.getElementById("permitexecadd").value = true;
			document.getElementById("typeoperationadd").value = 0;
			$("#modalAdicionarPrestador").modal("show");
		}

		$(document).ready(function(){
			$.getJSON ('../assets/scripts/estados_cidades.json', function (data) {
				var items = [];
				var options = '<option value=""></option>';

				$.each (data, function (key, val) { options += '<option value="' + val.nome + '">' + val.nome + '</option>'; });
				$("#add_estados").html(options);
				$("#add_estados").change(function () {
					var options_cidades = '';
					var str = "";
					$("#add_estados option:selected").each (function () { str += $(this).text(); });

					$.each(data, function (key, val) {
						if (val.nome == str){
							$.each(val.cidades, function (key_city, val_city) {
								options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
							});
						}
					});

					$("#add_cidades").html(options_cidades);
				}).change();
			});

			var table = $('#table-materiais').DataTable({
				"language": {
					"lengthMenu": "Mostrar &nbsp _MENU_ &nbsp prestadores por página",
					"zeroRecords": "Utilize os filtros para realizar buscas!",
					"info": "Página _PAGE_ de _PAGES_",
					"infoEmpty": "Nenhum prestador encontrado",
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
					{ "searchable": true, "targets": 4 },
					{ "searchable": false, "orderable": false, "targets": 5 },
					{ "searchable": false, "orderable": false, "targets": 6 }
				]
			});

			document.getElementsByName("table-materiais_length")[0].style.height = "25px";
			document.getElementsByName("table-materiais_length")[0].style.padding = "0px";
			document.getElementsByName("table-materiais_length")[0].style.textAlign = "center";
			document.getElementsByClassName("form-control form-control-sm")[1].style.height = "25px";
		});
	</script>
</body>