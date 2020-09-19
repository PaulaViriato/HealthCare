<?php
session_start();
if ((isset($_SESSION["healthcare-type-user"]))&&(isset($_SESSION["healthcare-login"]))&&(isset($_SESSION["healthcare-password"]))){
	if (intval($_SESSION["healthcare-type-user"]) != 0){ header("Location: ../../util/logout.php"); }
} else { header("Location: ../../util/logout.php"); }
session_commit();
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
						<li><a href="simple_prestadores.php" class=""><i class="lnr lnr-license"></i> <span>Prestadores</span></a></li>
						<li><a href="prestadores.php" class=""><i class="lnr lnr-users"></i> <span>Prestadores Operando</span></a></li>
						<li><a href="upload.php" class="active"><i class="lnr lnr-upload"></i> <span>Upload de Tabelas</span></a></li>
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
									<h3 class="panel-title">Upload de Tabelas</h3>
								</div>
								<div id="search-panel">
									<input id="searchindex" type="hidden" required/>
									<div class="panel-body" style="width:100%;padding-top:0px;padding-bottom:10px;">
										<div class="btn-group" style="margin-right:1%;width:20%;">
											<button class="btn dropdown-toggle" id="strcampo" data-toggle="dropdown" style="width:100%;margin-right:10px;margin-bottom:10px;padding:0px;height:25px;margin-top:6px;text-align:center;">Selecione um Campo &nbsp<span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
												<li><a tabindex="0" onclick="modifyDropdown('0')">Tipo</a></li>
												<li><a tabindex="1" onclick="modifyDropdown('1')">Nome</a></li>
												<li><a tabindex="2" onclick="modifyDropdown('2')">Data</a></li>
												<li><a tabindex="3" onclick="modifyDropdown('3')">Status</a></li>
												<li><a tabindex="4" onclick="modifyDropdown('4')">Todos</a></li>
											</ul>
										</div>
										<input id="searchtxt" type="text" style="height:25px;padding-left:5px;width:65%;font-size:14px;" placeholder="Buscar..." />
										<button class="btn" onclick="search()" style="width:12%;margin-left:1%;margin-bottom:10px;padding:0px;height:25px;margin-top:6px;text-align:center;">Buscar</span></button>
									</div>
								</div>
								<div id="table-panel">
									<div class="panel-body">
										<a type="hidden" id="aux_download"></a>
										<table id="table-materiais" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th style="width:17%;font-size:14px;padding-left:8px;">Tipo</th>
													<th style="width:44%;font-size:14px;">Nome</th>
													<th style="width:15%;font-size:14px;">Data</th>
													<th style="width:12%;font-size:14px;">Status</th>
													<th style="width:12%;font-size:14px;padding-left:8px;">Download</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
									<div class="panel-footer">
										<div class="row">
											<div class="col-md-12" align="center">
												<button data-toggle="modal" data-target="#modalAdicionarArquivo" class="btn btnlarge btn-success"> Novo Upload </button>
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

	<div id="modalAdicionarArquivo" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Novo Upload</h4>
					</div>

					<form>
						<div class="modal-body" style="padding-top:0px;padding-bottom:0px;">
							<div class="row" style="margin-bottom:20px;">
								<input id="typearquivoadd" type="hidden" name="typearquivo" required/>
								<div class="btn-group" style="margin-left:5%;width:90%;">
									<button class="btn dropdown-toggle" id="strcampotipo" data-toggle="dropdown" style="width:100%;margin-right:10px;margin-bottom:5px;padding:0px;height:25px;margin-top:20px;text-align:center;">Selecione um Tipo de Arquivo &nbsp<span class="caret"></span></button>
									<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
										<li><a tabindex="0" onclick="modifyDropdownType('0', 'CNES')">CNES</a></li>
										<li><a tabindex="1" onclick="modifyDropdownType('1', 'CMED (PMC)')">CMED (PMC)</a></li>
										<li><a tabindex="2" onclick="modifyDropdownType('2', 'CMED (PMVG)')">CMED (PMVG)</a></li>
										<li><a tabindex="3" onclick="modifyDropdownType('3', 'TUSS (Medicamentos)')">TUSS (Medicamentos)</a></li>
										<li><a tabindex="4" onclick="modifyDropdownType('4', 'TNUM (Medicamentos)')">TNUM (Medicamentos)</a></li>
										<li><a tabindex="5" onclick="modifyDropdownType('5', 'TUSS (Materiais)')">TUSS (Materiais)</a></li>
										<li><a tabindex="6" onclick="modifyDropdownType('6', 'TNUM (Materiais)')">TNUM (Materiais)</a></li>
									</ul>
								</div>
								<div style="margin-left:5%;width:90%;">
									<input style="width:100%;margin-right:10px;margin-bottom:5px;padding:0px;height:25px;margin-top:5px;text-align:center;" type="file" name="fileUpload" id="fileUpload" accept=".xls,.xlsx,.csv">
								</div>
								<div style="margin-left:5%;width:90%;">
									<progress style="width:100%;margin-right:10px;margin-bottom:0px;padding:0px;height:25px;margin-top:0px;text-align:center;" id="progressbar" value="0" max="100"></progress>
								</div>
								<div id="text_test"></div>
							</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
							<button type="button" onclick="addArquivo()" class="btn btn-success">Adicionar</button>
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

		function searchType (text){
			typee = removerAcentos (text.toUpperCase());
			typee = typee.replace(" ", "");
			typee = typee.replace("(", "").replace(")", "");
			typee = typee.replace("[", "").replace("]", "");
			typee = typee.replace("{", "").replace("}", "");
			value = -1;

			if (Number.isInteger(parseInt(typee))){ value = parseInt(typee); }
			else {
				if (typee == "CNES"){ value = 0; }
				if (typee == "CMEDPMC"){ value = 1; }
				if (typee == "CMEDPMVG"){ value = 2; }
				if (typee == "TUSSMEDICAMENTOS"){ value = 3; }
				if (typee == "TNUMMEDICAMENTOS"){ value = 4; }
				if (typee == "TUSSMATERIAIS"){ value = 5; }
				if (typee == "TNUMMATERIAIS"){ value = 6; }
			}
			return value;
		}

		function searchStatus (text){
			typee = removerAcentos (text.toUpperCase());
			typee = typee.replace(" ", "");
			typee = typee.replace("(", "").replace(")", "");
			typee = typee.replace("[", "").replace("]", "");
			typee = typee.replace("{", "").replace("}", "");
			value = -1;

			if (Number.isInteger(parseInt(typee))){ value = parseInt(typee); }
			else {
				if (typee == "PENDENTE"){ value = 0; }
				if (typee == "PROCESSANDO"){ value = 1; }
				if (typee == "CONCLUIDO"){ value = 2; }
				if (typee == "ERRO"){ value = 3; }
			}
			return typee;
		}

		function modifyDropdown (index){
			document.getElementById("searchindex").value = index;
			document.getElementById ("searchtxt").disabled = false;
			document.getElementById ("searchtxt").value = "";
			if (parseInt(index) == 0){ $('#strcampo').html ("Tipo &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 1){ $('#strcampo').html ("Nome &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 2){ $('#strcampo').html ("Data &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 3){ $('#strcampo').html ("Status &nbsp<span class=\"caret\"></span>"); }
			if (parseInt(index) == 4){
				$('#strcampo').html ("Todos &nbsp<span class=\"caret\"></span>");
				document.getElementById ("searchtxt").disabled = true;
			}
		}

		function modifyDropdownType (id, text){
			document.getElementById("typearquivoadd").value = id;
			$('#strcampotipo').html (text+" &nbsp<span class=\"caret\"></span>");
		}

		function addArquivo(){
			typee = document.getElementById("typearquivoadd").value;
			filee = document.getElementById("fileUpload").files[0];
			if (typee == ""){ alert ("Escolha um tipo de arquivo!"); }
			else {
				if ((""+filee) == "undefined"){ alert ("Selecione um arquivo!"); }
				else {
					var request = new XMLHttpRequest();
					request.upload.addEventListener("progress", uploadProgress, false)

					request.onreadystatechange = function() {
						if (request.readyState === 4) {
							if (request.response == "Sucess"){
								alert("Upload Realizado com Sucesso!");
								window.location = "upload.php";
							} else { alert("Erro ao Realizar Upload!"); }
						}
						document.getElementById ("progressbar").value = 0;
					}

					var formData = new FormData();
					formData.append ("request", 14);
					formData.append ("type", typee);
					formData.append ("file", filee);
					request.open('POST', '../../util/requests.php');
					request.send(formData);
				}
			}
		}

		function uploadProgress(event) {
			if (event.lengthComputable) {
				var percent = Math.round (event.loaded * 100 / event.total);
				document.getElementById ("progressbar").value = percent;
			} else { return; }
		}

		function search (){
			if (((parseInt(document.getElementById("searchindex").value) == -1)||
				(document.getElementById("searchtxt").value == ""))&&(parseInt(document.getElementById("searchindex").value) != 4)){
				if (parseInt(document.getElementById("searchindex").value) == -1){ alert ("Selecione um campo!"); }
				if (document.getElementById("searchtxt").value == ""){ alert ("Preencha o campo de busca!"); }
				return;
			}

			$('#img-aguarde').removeClass ("collapse");
			$('#main-panel').addClass ("collapse");

			text = "";
			index = parseInt(document.getElementById("searchindex").value);
			txtsc = document.getElementById("searchtxt").value;
			if (index == 0){ text = "file_type = "+searchType(txtsc); }
			if (index == 1){ text = "UPPER(caminho) LIKE '%"+txtsc.toUpperCase()+"%'"; }
			if (index == 2){ text = "UPPER(data) LIKE '%"+txtsc.toUpperCase()+"%'"; }
			if (index == 3){ text = "status = "+searchStatus(txtsc); }
			if (index == 4){ text = "id IS NOT NULL"; }

			request = $.post('../../util/requests.php', { 
				request: 15,
				whereclause: text
			}, function (response){
				$('#table-panel').html (""+response);
				var table = $('#table-materiais').DataTable({
					"language": {
						"lengthMenu": "Mostrar &nbsp _MENU_ &nbsp arquivos por página",
						"zeroRecords": "Nada encontrado, desculpe",
						"info": "Página _PAGE_ de _PAGES_",
						"infoEmpty": "Nenhum arquivo encontrado",
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

				document.getElementsByName("table-materiais_length")[0].style.height = "25px";
				document.getElementsByName("table-materiais_length")[0].style.padding = "0px";
				document.getElementsByName("table-materiais_length")[0].style.textAlign = "center";
				document.getElementsByClassName("form-control form-control-sm")[1].style.height = "25px";

				$('#img-aguarde').addClass ("collapse");
				$('#main-panel').removeClass ("collapse");
			});
		}

		function downloadArquivo (original, name){
			var request = new XMLHttpRequest();
			request.onreadystatechange = function() {
				if (request.readyState === 4) {
					a = document.getElementById ("aux_download");
					a.setAttribute("href", "../../archives/"+request.response);
					a.setAttribute("download", ""+name);
					a.click();
				}
			}

			var formData = new FormData();
			formData.append ("request", 16);
			formData.append ("original", original);
			formData.append ("name", name);
			request.open('POST', '../../util/requests.php');
			request.send(formData);
		}

		$(document).ready(function() {
			var table = $('#table-materiais').DataTable({
				"language": {
					"lengthMenu": "Mostrar &nbsp _MENU_ &nbsp arquivos por página",
					"zeroRecords": "Utilize os filtros para realizar buscas!",
					"info": "Página _PAGE_ de _PAGES_",
					"infoEmpty": "Nenhum arquivo encontrado",
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

			document.getElementsByName("table-materiais_length")[0].style.height = "25px";
			document.getElementsByName("table-materiais_length")[0].style.padding = "0px";
			document.getElementsByName("table-materiais_length")[0].style.textAlign = "center";
			document.getElementsByClassName("form-control form-control-sm")[1].style.height = "25px";
		});
	</script>
</body>