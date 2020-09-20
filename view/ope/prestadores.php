<?php
session_start();
if ((isset($_SESSION["healthcare-type-user"]))&&(isset($_SESSION["healthcare-login"]))&&(isset($_SESSION["healthcare-password"]))){
	if (intval($_SESSION["healthcare-type-user"]) != 1){ header("Location: ../../util/logout.php"); }
} else { header("Location: ../../util/logout.php"); }
session_commit();

require_once('../../dao/cnes_DAO.php');
require_once('../../dao/prestadora_DAO.php');
require_once('../../dao/operadora_DAO.php');
require_once('../../dao/login_DAO.php');
$DAOCNES = new CNES_DAO();
$DAOPrestadora = new Prestadora_DAO();
$DAOOperadora = new Operadora_DAO();
$DAOLogin = new Login_DAO();

$hasMessage = false;
$message = "";

$ufs_array = array ("AC", "AL", "AM", "AP", "BA", "CE", "DF", "ES", 
	"GO", "MA", "MG", "MS", "MT", "PA", "PB", "PE", "PI", "PR", "RJ", 
	"RN", "RO", "RR", "RS", "SC", "SE", "SP", "TO");

if (isset($_POST["permitexec"])){
	if (strcasecmp ("".$_POST["permitexec"], "true") == 0){
		if (intval($_POST["typeoperation"]) == 0){
			if ((isset($_POST["codprest"]))&&(isset($_SESSION["healthcare-user"]["id"]))){
				$newprestadora = new Prestadora();
				$newprestadora->set_CNES (new CNES());
				$newprestadora->set_OPERADORA (new Operadora());
				$newprestadora->get_CNES()->set_id ($_POST["codprest"]);
				$newprestadora->get_OPERADORA()->set_id ($_SESSION["healthcare-user"]["id"]);
				$DAOPrestadora->insert ($newprestadora);

				$prest_login = $DAOLogin->select_by_CNES ($_POST["codprest"]);
				if (count($prest_login) == 0){
					$login_prestadora = new Login();
					$login_prestadora->set_first_login(true);
					$login_prestadora->geraSenha();
					$login_prestadora->set_CNES (new CNES());
					$login_prestadora->get_CNES()->set_id ($_POST["codprest"]);
					$DAOLogin->insert ($login_prestadora);

					$hasMessage = true;
					$message = "Login gerado para o prestador!\\n";
					$message .= "A senha provisória é: ".$login_prestadora->get_senha()."\\n";
					$message .= "Por favor, informe esta senha ao prestador.\\n";
					$message .= "O login será realizado por meio do CNPJ/CPF e desta senha, \\n";
					$message .= "e a senha deverá ser alterada imediatamente no primeiro acesso!";
				}
			}
		}
		if (intval($_POST["typeoperation"]) == 1){
			if ((isset($_POST["idcnes"]))&&(isset($_SESSION["healthcare-user"]["id"]))){
				$array_prest = $DAOPrestadora->where_order_clause(2, "id_cnes = '".$_POST["idcnes"]."' AND id_operadora = ".$_SESSION["healthcare-user"]["id"]);
				$id = $array_prest[0]->get_id();
				$DAOPrestadora->delete($id);
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
						<li><a href="prestadores.php" class="active"><i class="lnr lnr-users"></i> <span>Meus Prestadores</span></a></li>
						<li><a href="tabelas.php" class=""><i class="lnr lnr-list"></i> <span>Montagem de Tabelas</span></a></li>
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
									<h3 class="panel-title">Prestadores de Serviços da Operadora</h3>
								</div>
								<div id="search-panel">
									<input id="nomeoperadora" type="hidden" required/>
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
													<th style="width:39%;font-size:14px;">Prestador</th>
													<th style="width:16%;font-size:14px;">CNPJ ou CPF</th>
													<th style="width:23%;font-size:14px;">Município</th>
													<th style="width:12%;font-size:14px;">Visualizar</th>
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
												<button data-toggle="modal" data-target="#modalAdicionarPrestadora" class="btn btnlarge btn-success"> Cadastrar Prestador na Operadora </button>
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

	<div id="modalAdicionarPrestadora" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Cadastrar Prestador de Serviços na Operadora </h4>
					</div>

					<form enctype="multipart/form-data" autocomplete="off" method="POST" action="prestadores.php">
						<div class="modal-body">
							<div class="row">
								<div>
									<input id="permitexec" type="hidden" name="permitexec" required/>
									<input id="typeoperation" type="hidden" name="typeoperation" required/>
									<div id="div-uf" class="col-md-12">
										<div style="margin-bottom: 10px;">
											<div class="autocomplete" style="width:100%">
												<span> UF do Prestador &nbsp&nbsp</span>
												<input id="auto-uf" autocomplete="none" type="text" name="uf" placeholder="" style="height:25px;width:40%"/>
												<button type="button" class="btn btn-sm btn-warning" onclick="desbloqCadast()" style="margin-top:-3px;height:25px;font-size:14px;padding-top:2px;">Buscar</button>
												<span id="textaguarde" class="collapse"> &nbsp&nbsp Aguarde... </span>
											</div>
										</div>
									</div>
								</div>

								<div id="cadastro_prest" class="collapse">
									<div id="div-nomeprest" class="col-md-12">
										<div style="margin-bottom: 10px;">
											<br><span> Nome Fantasia do Prestador</span> </br>
											<div class="autocomplete_double" style="width:100%">
												<input id="auto-nomeprest" autocomplete="none" type="text" name="nomeprest" onchange="changeNomePrest()" placeholder="">
											</div>
										</div>
									</div>
									<div id="div-codprest" class="col-md-12">
										<div style="margin-bottom: 10px;">
											<span> Código CNES do Prestador</span> </br>
											<div class="autocomplete_double" style="width:100%">
												<input id="auto-codprest" autocomplete="none" type="text" name="codprest" onchange="changeCodPrest()" placeholder="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
							<button type="button" onclick="addPrestadora()" class="btn btn-success">Adicionar</button>
							<button id="chkaddprestadora" type="submit" class="btn btn-success collapse">Submeter</button>
						</div>
					</form>
				</div>
		</div>
	</div>

	<div id="modalVisualizar" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content" style="width:100%;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Informações do Prestador de Serviços</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div id="textinfo"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>

	<div id="modalExcluir" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<form enctype="multipart/form-data" autocomplete="off" method="POST" action="prestadores.php">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Excluir Prestador de Serviços?</h4>
					</div>

					<div class="modal-body">
						<input id="idcnesexcl" type="hidden" name="idcnes" required/>
						<input id="permitexecexcl" type="hidden" name="permitexec" required/>
						<input id="typeoperationexcl" type="hidden" name="typeoperation" required/>
						<p> Tem certeza que deseja deletar o prestador de serviços? </p>
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
		var request = null;

		function autocomplete_double (inp1, arr1, inp2, arr2) {
			var currentFocus;
			inp1.addEventListener("input", function(e) {
				var a, b, i, val = this.value;
				closeAllListsDouble();
				if (!val) { return false;}
				currentFocus = -1;
				a = document.createElement("DIV");
				a.setAttribute("id", this.id + "autocomplete_double-list");
				a.setAttribute("class", "autocomplete_double-items");
				this.parentNode.appendChild(a);
				for (i = 0; i < arr1.length; i++) {
					if (arr1[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
						b = document.createElement("DIV");
						b.innerHTML = "<strong>" + arr1[i].substr(0, val.length) + "</strong>";
						b.innerHTML += arr1[i].substr(val.length);
						b.innerHTML += "<input type='hidden' value='" + arr1[i] + "'/>";
						b.innerHTML += "<input type='hidden' value='" + arr2[i] + "'/>";
						b.addEventListener("click", function(e) {
							inp1.value = this.getElementsByTagName("input")[0].value;
							inp2.value = this.getElementsByTagName("input")[1].value;
							closeAllListsDouble();
						});
						a.appendChild(b);
					}
				}
			});

			inp2.addEventListener("input", function(e) {
				var a, b, i, val = this.value;
				closeAllListsDouble();
				if (!val) { return false;}
				currentFocus = -1;
				a = document.createElement("DIV");
				a.setAttribute("id", this.id + "autocomplete_double-list");
				a.setAttribute("class", "autocomplete_double-items");
				this.parentNode.appendChild(a);
				for (i = 0; i < arr2.length; i++) {
					if (arr2[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
						b = document.createElement("DIV");
						b.innerHTML = "<strong>" + arr2[i].substr(0, val.length) + "</strong>";
						b.innerHTML += arr2[i].substr(val.length);
						b.innerHTML += "<input type='hidden' value='" + arr2[i] + "'/>";
						b.innerHTML += "<input type='hidden' value='" + arr1[i] + "'/>";
						b.addEventListener("click", function(e) {
							inp2.value = this.getElementsByTagName("input")[0].value;
							inp1.value = this.getElementsByTagName("input")[1].value;
							closeAllListsDouble();
						});
						a.appendChild(b);
					}
				}
			});

			inp1.addEventListener("keydown", function(e) {
				var x = document.getElementById(this.id + "autocomplete_double-list");
				if (x) x = x.getElementsByTagName("div");
				if (e.keyCode == 40) {
					currentFocus++;
					addActiveDouble(x);
				} else if (e.keyCode == 38) {
					currentFocus--;
					addActiveDouble(x);
				} else if (e.keyCode == 13) {
					e.preventDefault();
					if (currentFocus > -1) {
						if (x) x[currentFocus].click();
					}
				}
			});

			inp2.addEventListener("keydown", function(e) {
				var x = document.getElementById(this.id + "autocomplete_double-list");
				if (x) x = x.getElementsByTagName("div");
				if (e.keyCode == 40) {
					currentFocus++;
					addActiveDouble(x);
				} else if (e.keyCode == 38) {
					currentFocus--;
					addActiveDouble(x);
				} else if (e.keyCode == 13) {
					e.preventDefault();
					if (currentFocus > -1) {
						if (x) x[currentFocus].click();
					}
				}
			});

			function addActiveDouble(x) {
				if (!x) return false;
				removeActiveDouble(x);
				if (currentFocus >= x.length) currentFocus = 0;
				if (currentFocus < 0) currentFocus = (x.length - 1);
				x[currentFocus].classList.add("autocomplete_double-active");
			}

			function removeActiveDouble(x) {
				for (var i = 0; i < x.length; i++) {
					x[i].classList.remove("autocomplete_double-active");
				}
			}

			function closeAllListsDouble(elmnt) {
				var x = document.getElementsByClassName("autocomplete_double-items");
				for (var i = 0; i < x.length; i++) {
					if (elmnt != x[i] && elmnt != inp1) {
						x[i].parentNode.removeChild(x[i]);
					}
					if (elmnt != x[i] && elmnt != inp2) {
						x[i].parentNode.removeChild(x[i]);
					}
				}
			}

			document.addEventListener("click", function (e) { closeAllListsDouble(e.target); });
		}

		function autocomplete(inp, arr) {
			var currentFocus;
			inp.addEventListener("input", function(e) {
				var a, b, i, val = this.value;
				closeAllLists();
				if (!val) { return false;}
				currentFocus = -1;
				a = document.createElement("DIV");
				a.setAttribute("id", this.id + "autocomplete-list");
				a.setAttribute("class", "autocomplete-items");
				this.parentNode.appendChild(a);
				for (i = 0; i < arr.length; i++) {
					if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
						b = document.createElement("DIV");
						b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
						b.innerHTML += arr[i].substr(val.length);
						b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
						b.addEventListener("click", function(e) {
							inp.value = this.getElementsByTagName("input")[0].value;
							closeAllLists();
						});
						a.appendChild(b);
					}
				}
			});

			inp.addEventListener("keydown", function(e) {
				var x = document.getElementById(this.id + "autocomplete-list");
				if (x) x = x.getElementsByTagName("div");
				if (e.keyCode == 40) {
					currentFocus++;
					addActive(x);
				} else if (e.keyCode == 38) {
					currentFocus--;
					addActive(x);
				} else if (e.keyCode == 13) {
					e.preventDefault();
					if (currentFocus > -1) {
						if (x) x[currentFocus].click();
					}
				}
			});

			function addActive(x) {
				if (!x) return false;
				removeActive(x);
				if (currentFocus >= x.length) currentFocus = 0;
				if (currentFocus < 0) currentFocus = (x.length - 1);
				x[currentFocus].classList.add("autocomplete-active");
			}

			function removeActive(x) {
				for (var i = 0; i < x.length; i++) {
					x[i].classList.remove("autocomplete-active");
				}
			}

			function closeAllLists(elmnt) {
				var x = document.getElementsByClassName("autocomplete-items");
				for (var i = 0; i < x.length; i++) {
					if (elmnt != x[i] && elmnt != inp) {
						x[i].parentNode.removeChild(x[i]);
					}
				}
			}

			document.addEventListener("click", function (e) { closeAllLists(e.target); });
		}

		var ufs = [<?php
			$pass = false;
			foreach ($ufs_array as $uf){
				if ($pass == false){
					echo '"'.$uf.'"';
					$pass = true;
				} else { echo ', "'.$uf.'"'; }
			}
		?>];

		autocomplete (document.getElementById("auto-uf"), ufs);

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
			document.getElementById("nomeoperadora").value = <?php echo '"'.$_SESSION["healthcare-user"]["nome"].'"'; ?>;
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

			txtwhereclauseope = "UPPER(id) LIKE '%"+<?php echo '"'.$_SESSION["healthcare-user"]["id"].'"'; ?>+"%'";
			txtwhereclause = text;

			request = $.post('../../util/requests.php', { 
				request: 6,
				whereclause: txtwhereclause,
				whereclauseope: txtwhereclauseope
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
						{ "searchable": false, "orderable": false, "targets": 3 },
						{ "searchable": false, "orderable": false, "targets": 4 }
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

		function excluirOperadora(id_cnes, id_operadora){
			document.getElementById("idcnesexcl").value = id_cnes;
			document.getElementById("permitexecexcl").value = true;
			document.getElementById("typeoperationexcl").value = 1;
			$("#modalExcluir").modal("show");
		}

		function desbloqCadast(){
			$('#textaguarde').text (" \xA0\xA0 Aguarde... ");
			$('#textaguarde').removeClass ("collapse");
			var value = ""+document.getElementById("auto-uf").value;
			$.post('../../util/requests.php', { 
				request: 0,
				UF: value.toUpperCase()
			}, function (response){
				nomes = [];
				ids = [];

				if (!(response == "")){
					array_lines = response.split("; ");
					for (i=0; i < array_lines.length; i++){
						array_lines[i] = array_lines[i].split(", ");
						ids.push (""+array_lines[i][0]);
						nomes.push (""+array_lines[i][1]);
					}

					document.getElementById ("auto-codprest").value = "";
					document.getElementById ("auto-nomeprest").value = "";
					autocomplete_double (document.getElementById("auto-codprest"), ids,
						document.getElementById("auto-nomeprest"), nomes);
					$('#cadastro_prest').removeClass ("collapse");
					$('#textaguarde').addClass ("collapse");
				} else {
					$('#textaguarde').text (" \xA0\xA0 UF Inválido! ");
					autocomplete_double (document.getElementById("auto-codprest"), ids,
						document.getElementById("auto-nomeprest"), nomes);
				}
			});
		}

		function openVisualizarPrestadora (id_cnes, id_operadora){
			$.post('../../util/requests.php', { 
				request: 1,
				id_cnes: id_cnes,
				id_operadora: id_operadora
			}, function (response){
				$('#textinfo').html (""+response);
				$("#modalVisualizar").modal("show");
			});
		}

		function addPrestadora (){
			document.getElementById("permitexec").value = true;
			document.getElementById("typeoperation").value = 0;
			nomeprest = document.getElementById("auto-nomeprest").value;
			codprest = document.getElementById("auto-codprest").value;
			document.getElementById("auto-nomeprest").value = nomeprest.toUpperCase();
			document.getElementById("auto-codprest").value = codprest.toUpperCase();
			document.getElementById("chkaddprestadora").click();
		}

		$(document).ready(function() {
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