<?php
// Desenvolvedora: Paula Jeniffer dos Santos Viriato
// E-mail: paulajeniffer1@gmail.com
// Data: 03/09/2020

if (isset($_POST["request"])){
	session_start();
	if ((isset($_SESSION["healthcare-type-user"]))&&(isset($_SESSION["healthcare-login"]))&&(isset($_SESSION["healthcare-password"]))){
		if (intval($_SESSION["healthcare-type-user"]) == 0){
			if ((intval($_POST["request"]) == 5)||(intval($_POST["request"]) == 18)||(intval($_POST["request"]) > 24)){
				session_commit();
				exit();
			}
		} else {
			if (intval($_SESSION["healthcare-type-user"]) == 1){
				if ((intval($_POST["request"]) == 4)||(intval($_POST["request"]) == 7)||((intval($_POST["request"]) > 12)&&
					(intval($_POST["request"]) < 17))||(intval($_POST["request"]) > 22)){
					session_commit();
					exit();
				}
			} else {
				if (intval($_SESSION["healthcare-type-user"]) == 2){
					if (((intval($_POST["request"]) < 8)||(intval($_POST["request"]) > 12))&&(intval($_POST["request"]) != 17)&&
						(intval($_POST["request"]) != 19)&&(intval($_POST["request"]) != 20)){
						session_commit();
						exit();
					}
				} else {
					session_commit();
					exit();
				}
			}
		}
	}
} else { exit(); }

$dirarchives = str_replace("util", "archives", dirname (__FILE__));
$pathdir = dir($dirarchives);
while ($arq = $pathdir->read()){
	if (is_file($dirarchives."\\".$arq)){
		if (($arq[0] == '[')&&($arq[20] == ']')){
			try{
				$last_acess = new DateTime("".str_replace("_", ":", substr($arq, 1, 19)));
				$now = new DateTime("".date("Y-m-d H:i:s"));
				$interval = $now->diff($last_acess);
				if (intval($interval->h) >= 3){ unlink($dirarchives."\\".$arq); }
			} catch (Exception $e) { $now = new DateTime("".date("Y-m-d H:i:s")); }
		}
	}
}
$pathdir->close();

require_once(str_replace("util", "dao", dirname (__FILE__)).'/cnes_DAO.php');
require_once(str_replace("util", "dao", dirname (__FILE__)).'/prestadora_DAO.php');
require_once(str_replace("util", "dao", dirname (__FILE__)).'/medicamento_DAO.php');
require_once(str_replace("util", "dao", dirname (__FILE__)).'/material_DAO.php');
require_once(str_replace("util", "dao", dirname (__FILE__)).'/login_DAO.php');
require_once(str_replace("util", "dao", dirname (__FILE__)).'/tabela_DAO.php');

$path_upload = "C:/Users/Paula Viriato/Documents/LeMed_Upload/files/";
//$path_upload = "C:/Users/janser/Documents/LeMed_Upload/files/";

ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
set_time_limit(0);

if (isset($_POST["request"])){
	if (intval($_POST["request"]) == 0){
		if (isset($_POST["UF"])){
			$DAOCNES = new CNES_DAO();
			$load = $DAOCNES->select_features ($_POST["UF"]);
			$first = true;

			foreach ($load as $line){
				if ($first){
					echo $line[0].", ".str_replace("	", "", $line[1]);
					$first = false;
				} else { echo "; ".$line[0].", ".str_replace("	", "", $line[1]); }
			}
		}
	}
	if (intval($_POST["request"]) == 1){
		if ((isset($_POST["id_cnes"]))&&(isset($_POST["id_operadora"]))){
			$DAOCNES = new CNES_DAO();
			$DAOOperadora = new Operadora_DAO();
			$DAOLogin = new Login_DAO();

			$cnes = $DAOCNES->select_id ($_POST["id_cnes"]);
			$operadora = $DAOOperadora->select_id ($_POST["id_operadora"]);
			$login_prestadora = $DAOLogin->select_by_CNES ($_POST["id_cnes"]);
			?>
			<div class="container-fluid" style="padding-left:15px;padding-right:15px;">
				<div class="tabbable">
					<ul class="nav nav-tabs" style="border-style:none;">
						<li class="active"><a class="aba" href="#panel_info" data-toggle="tab"><h4 class="panel-title">Informações Gerais</h4></a></li>
						<li><a class="aba" href="#panel_leitos" data-toggle="tab"><h4 class="panel-title">Número de Leitos</h4></a></li>
						<li><a class="aba" href="#panel_itens" data-toggle="tab"><h4 class="panel-title">Itens Presentes</h4></a></li>
					</ul>
					<div class="tab-content">
						<div id="panel_info" class="tab-pane active" style="padding-bottom:0px; width:100%;" value="0">
							<?php
							if (count($login_prestadora) > 0){
								$first_login = $login_prestadora[0]->get_first_login();
								if (intval($first_login) == 1){
									$cnpj = $cnes->get_cnpj(); ?>
									<?php if (!is_null($cnpj)){ ?>
									<?php if (intval($cnpj) > 0){ ?>
									<span style="color:red;"><b>Login:</b> <?php echo $cnes->get_cnpj(); ?><br></span>
									<?php } else { ?>
									<span style="color:red;"><b>Login:</b> <?php echo $cnes->get_cpf(); ?><br></span>
									<?php } ?>
									<?php } else { ?>
									<span style="color:red;"><b>Login:</b> <?php echo $cnes->get_cpf(); ?><br></span>
									<?php } ?>
									<span style="color:red;"><b>Senha Temporária:</b> <?php echo $login_prestadora[0]->get_senha(); ?><br></span><br>
								<?php }
							}
							?>
							<b>Operadora:</b> <?php echo $operadora->get_nome(); ?><br>
							<b>Prestador:</b> <?php echo $cnes->get_no_fantasia(); ?><br>
							<b>Razão Social:</b> <?php echo $cnes->get_razao_social(); ?><br>
							<?php $cnpj = $cnes->get_cnpj(); ?>
							<?php if (!is_null($cnpj)){ ?>
							<?php if (intval($cnpj) > 0){ ?>
							<b>CNPJ:</b> <?php echo $cnes->get_cnpj(); ?><br>
							<?php } else { ?>
							<b>CPF:</b> <?php echo $cnes->get_cpf(); ?><br>
							<?php } ?>
							<?php } else { ?>
							<b>CPF:</b> <?php echo $cnes->get_cpf(); ?><br>
							<?php } ?>
							<b>Município:</b> <?php echo $cnes->get_nm_municipio()." - ".$cnes->get_uf(); ?><br>
							<b>Tipo de Estabelecimento:</b> <?php echo $cnes->get_tipo_estabelecimento(); ?><br>
							<b>Atendimentos Prestados:</b> <?php echo $cnes->get_atendimento_prestado(); ?>
						</div>
						<div id="panel_leitos" class="tab-pane" style="padding-bottom:0px; width:100%;" value="1">
							<H4 style="margin-top:15px;text-align:center;"><b>Número de Leitos:</b></H4>
							<div class="row" style="width:100%">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<table class="table table-striped table-bordered" style="align-items:center;">
										<tbody>
											<tr>
												<th style="text-align:center;">Clínica</th>
												<th style="text-align:center;">Cirurgia</th>
												<th style="text-align:center;">Obstetrícia</th>
											</tr>
											<tr style="text-align:center;">
												<td class="tditens"><?php echo $cnes->get_leitos_clinica(); ?></td>
												<td class="tditens"><?php echo $cnes->get_leitos_cirurgia(); ?></td>
												<td class="tditens"><?php echo $cnes->get_leitos_obstetricia(); ?></td>
											</tr>
											<tr>
												<th style="text-align:center;">Pediatria</th>
												<th style="text-align:center;">Psiquiatria</th>
												<th style="text-align:center;">UTI Adulto</th>
											</tr>
											<tr style="text-align:center;">
												<td class="tditens"><?php echo $cnes->get_leitos_pediatria(); ?></td>
												<td class="tditens"><?php echo $cnes->get_leitos_psiquiatria(); ?></td>
												<td class="tditens"><?php echo $cnes->get_leitos_uti_adulto(); ?></td>
											</tr>
											<tr>
												<th style="text-align:center;">UTI Pediátrica</th>
												<th style="text-align:center;">UTI Neonatal</th>
												<th style="text-align:center;">Interm Neo</th>
											</tr>
											<tr style="text-align:center;">
												<td class="tditens"><?php echo $cnes->get_leitos_uti_pediatrica(); ?></td>
												<td class="tditens"><?php echo $cnes->get_leitos_uti_neonatal(); ?></td>
												<td class="tditens"><?php echo $cnes->get_leitos_unidade_interm_neo(); ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div id="panel_itens" class="tab-pane" style="padding-bottom:0px; width:100%;" value="2">
							<H4 style="margin-top:0px;text-align:center;"><b>Itens Presentes:</b></H4>
							<table class="table table-striped table-bordered" style="align-items:center;">
							<tr>
								<th class="thitens">Equipo Odontologico</th>
								<th class="thitens">Cirurgiao Dentista</th>
								<th class="thitens">Urgência Emergencia</th>
								<th class="thitens">Anatomopatologia</th>
							</tr>
							<tr style="text-align:center;">
								<td class="tditens"><?php echo (($cnes->get_equipo_odontologico() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_cirurgiao_dentista() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_urgencia_emergencia() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_anatomopatologia() == 1) ? "Sim" : "Não"); ?></td>
							</tr>
							<tr>
								<th class="thitens">Colposcopia</th>
								<th class="thitens">Eletrocardiograma</th>
								<th class="thitens">Fisioterapia</th>
								<th class="thitens">Patologia Clínica</th>
							</tr>
							<tr style="text-align:center;">
								<td class="tditens"><?php echo (($cnes->get_colposcopia() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_eletrocardiograma() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_fisioterapia() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_patologia_clinica() == 1) ? "Sim" : "Não"); ?></td>
							</tr>
							<tr>
								<th class="thitens">Radiodiagnóstico</th>
								<th class="thitens">Ultrassonografia</th>
								<th class="thitens">Ecocardiografia</th>
								<th class="thitens">Endoscopia Digestiva</th>
							</tr>
							<tr style="text-align:center;">
								<td class="tditens"><?php echo (($cnes->get_radiodiagnostico() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_ultra_sonografia() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_ecocardiografia() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_endoscopia_vdigestivas() == 1) ? "Sim" : "Não"); ?></td>
							</tr>
							<tr>
								<th class="thitens">Hemoterapia Ambulatorial</th>
								<th class="thitens">Holter</th>
								<th class="thitens">Litotripsia Extracorporea</th>
								<th class="thitens">Mamografia</th>
							</tr>
							<tr style="text-align:center;">
								<td class="tditens"><?php echo (($cnes->get_hemoterapia_ambulatorial() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_holter() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_litotripsia_extracorporea() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_mamografia() == 1) ? "Sim" : "Não"); ?></td>
							</tr>
							<tr>
								<th class="thitens">Psicoterapia</th>
								<th class="thitens">Terapia Renal</th>
								<th class="thitens">Teste Ergométrico</th>
								<th class="thitens">Tomografia Computadorizada</th>
							</tr>
							<tr style="text-align:center;">
								<td class="tditens"><?php echo (($cnes->get_psicoterapia() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_terapia_renalsubst() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_teste_ergometrico() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_tomografia_computadorizada() == 1) ? "Sim" : "Não"); ?></td>
							</tr>
							<tr>
								<th class="thitens">Atendimento Hospital Dia</th>
								<th class="thitens">Endoscopia Vaereas</th>
								<th class="thitens">Hemodinâmica</th>
								<th class="thitens">Medicina Nuclear</th>
							</tr>
							<tr style="text-align:center;">
								<td class="tditens"><?php echo (($cnes->get_atendimento_hospitaldia() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_endoscopia_vaereas() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_hemodinamica() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_medicina_nuclear() == 1) ? "Sim" : "Não"); ?></td>
							</tr>
							<tr>
								<th class="thitens">Quimioterapia</th>
								<th class="thitens">Radiologia Intervencionista</th>
								<th class="thitens">Radioterapia</th>
								<th class="thitens">Ressonância Magnética</th>
							</tr>
							<tr style="text-align:center;">
								<td class="tditens"><?php echo (($cnes->get_quimioterapia() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_radiologia_intervencionista() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_radioterapia() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_ressonancia_nmagnetica() == 1) ? "Sim" : "Não"); ?></td>
							</tr>
							<tr>
								<th class="thitens">Ultrassonografia Doppler</th>
								<th class="thitens">Videocirurgia</th>
								<th class="thitens">Odontologia Básica</th>
								<th class="thitens">Raio-X Dentário</th>
							</tr>
							<tr style="text-align:center;">
								<td class="tditens"><?php echo (($cnes->get_ultrassonografia_doppler() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_videocirurgia() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_odontologia_basica() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_raiox_dentario() == 1) ? "Sim" : "Não"); ?></td>
							</tr>
							<tr>
								<th class="thitens">Endodontia</th>
								<th class="thitens">Periodontia</th>
							</tr>
							<tr style="text-align:center;">
								<td class="tditens"><?php echo (($cnes->get_endodontia() == 1) ? "Sim" : "Não"); ?></td>
								<td class="tditens"><?php echo (($cnes->get_periodontia() == 1) ? "Sim" : "Não"); ?></td>
							</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
	if (intval($_POST["request"]) == 2){
		if (isset($_POST["whereclause"])){
			$DAOMed = new Medicamento_DAO();
			$medicamentos = $DAOMed->select_all(null, "id, substancia, produto, laboratorio, unidmin_fracao", $_POST["whereclause"]);
			?>
			<div class="panel-body">
				<table id="table-materiais" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="width:15%;font-size:14px;padding-left:8px;">Registro</th>
							<?php if (intval($_SESSION["healthcare-type-user"]) != 1){ ?>
							<th style="width:19%;font-size:14px;">Substância</th>
							<th style="width:18%;font-size:14px;">Produto</th>
							<th style="width:18%;font-size:14px;">Laboratório</th>
							<?php } else { ?>
							<th style="width:23%;font-size:14px;">Substância</th>
							<th style="width:22%;font-size:14px;">Produto</th>
							<th style="width:22%;font-size:14px;">Laboratório</th>
							<?php } ?>
							<th style="width:8%;font-size:14px;">Unidade</th>
							<?php if (intval($_SESSION["healthcare-type-user"]) != 1){ ?>
							<th style="width:12%;font-size:14px;">Visualizar</th>
							<th style="width:10%;font-size:14px;padding-left:8px;">Excluir</th>
							<?php } else { ?>
							<th style="width:12%;font-size:14px;padding-left:8px;">Visualizar</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($medicamentos as $medicamento){
								echo "<tr>
									<td style=\"width:15%;font-size:14px;padding-left:8px;\">".(is_null($medicamento->get_id()) ? "" : strtoupper(substr($medicamento->get_id(), 0, 20)))."</td>";

								if (intval($_SESSION["healthcare-type-user"]) != 1){
									echo "<td style=\"width:19%;font-size:14px;\">".(is_null($medicamento->get_substancia()) ? strtoupper(substr($medicamento->get_substancia(), 0, 20)) : strtoupper(substr($medicamento->get_substancia(), 0, 20)))."</td>
										<td style=\"width:18%;font-size:14px;\">".(is_null($medicamento->get_produto()) ? strtoupper(substr($medicamento->get_substancia(), 0, 20)) : strtoupper(substr($medicamento->get_produto(), 0, 20)))."</td>
										<td style=\"width:18%;font-size:14px;\">".(is_null($medicamento->get_laboratorio()) ? "" : strtoupper(substr($medicamento->get_laboratorio(), 0, 20)))."</td>";
								} else {
									echo "<td style=\"width:23%;font-size:14px;\">".(is_null($medicamento->get_substancia()) ? strtoupper(substr($medicamento->get_substancia(), 0, 20)) : strtoupper(substr($medicamento->get_substancia(), 0, 20)))."</td>
										<td style=\"width:22%;font-size:14px;\">".(is_null($medicamento->get_produto()) ? strtoupper(substr($medicamento->get_substancia(), 0, 20)) : strtoupper(substr($medicamento->get_produto(), 0, 20)))."</td>
										<td style=\"width:22%;font-size:14px;\">".(is_null($medicamento->get_laboratorio()) ? "" : strtoupper(substr($medicamento->get_laboratorio(), 0, 20)))."</td>";
								}

								echo "<td style=\"width:8%;font-size:14px;\">".(is_null($medicamento->get_unidmin_fracao()) ? "" : strtoupper(substr($medicamento->get_unidmin_fracao(), 0, 7)))."</td>";

								if (intval($_SESSION["healthcare-type-user"]) != 1){
									echo "<td align=\"center\" style=\"width:12%;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarMedicamento('".$medicamento->get_id()."')\"> Visualizar </button></td>
										<td align=\"center\" style=\"width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirMedicamento('".$medicamento->get_id()."')\"> Excluir </button></td>
										</tr>";
								} else {
									echo "<td align=\"center\" style=\"width:12%;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarMedicamento('".$medicamento->get_id()."')\"> Visualizar </button></td>
										</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
			<?php
		}
	}
	if (intval($_POST["request"]) == 3){
		if (isset($_POST["whereclause"])){
			$DAOMaterial = new Material_DAO();
			$materiais = $DAOMaterial->select_all(null, "id, nome_tecnico, fabricante, classe_risco", $_POST["whereclause"]);
			?>
			<div class="panel-body">
				<table id="table-materiais" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="width:15%;font-size:14px;padding-left:8px;">Registro</th>
							<?php if (intval($_SESSION["healthcare-type-user"]) != 1){ ?>
							<th style="width:26%;font-size:14px;">Nome Técnico</th>
							<th style="width:27%;font-size:14px;">Fabricante</th>
							<?php } else { ?>
							<th style="width:31%;font-size:14px;">Nome Técnico</th>
							<th style="width:32%;font-size:14px;">Fabricante</th>
							<?php } ?>
							<th style="width:10%;font-size:14px;">C. Risco</th>
							<?php if (intval($_SESSION["healthcare-type-user"]) != 1){ ?>
							<th style="width:12%;font-size:14px;">Visualizar</th>
							<th style="width:10%;font-size:14px;padding-left:8px;">Excluir</th>
							<?php } else { ?>
							<th style="width:12%;font-size:14px;padding-left:8px;">Visualizar</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($materiais as $material){
								echo "<tr>
									<td style=\"width:15%;font-size:14px;padding-left:8px;\">".(is_null($material->get_id()) ? "" : strtoupper(substr($material->get_id(), 0, 20)))."</td>";

								if (intval($_SESSION["healthcare-type-user"]) != 1){
									echo "<td style=\"width:26%;font-size:14px;\">".(is_null($material->get_nome_tecnico()) ? "" : strtoupper(substr($material->get_nome_tecnico(), 0, 25)))."</td>
										<td style=\"width:27%;font-size:14px;\">".(is_null($material->get_fabricante()) ? "" : strtoupper(substr($material->get_fabricante(), 0, 25)))."</td>";
								} else {
									echo "<td style=\"width:31%;font-size:14px;\">".(is_null($material->get_nome_tecnico()) ? "" : strtoupper(substr($material->get_nome_tecnico(), 0, 25)))."</td>
										<td style=\"width:32%;font-size:14px;\">".(is_null($material->get_fabricante()) ? "" : strtoupper(substr($material->get_fabricante(), 0, 25)))."</td>";
								}

								echo "<td style=\"width:10%;font-size:14px;\">".(is_null($material->get_classe_risco()) ? "" : strtoupper(substr($material->get_classe_risco(), 0, 7)))."</td>";

								if (intval($_SESSION["healthcare-type-user"]) != 1){
									echo "<td align=\"center\" style=\"width:12%;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarMaterial('".$material->get_id()."')\"> Visualizar </button></td>
										<td align=\"center\" style=\"width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirMaterial('".$material->get_id()."')\"> Excluir </button></td>
										</tr>";
								} else {
									echo "<td align=\"center\" style=\"width:12%;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarMaterial('".$material->get_id()."')\"> Visualizar </button></td>
										</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
			<?php
		}
	}
	if (intval($_POST["request"]) == 4){
		if (isset($_POST["whereclause"])){
			$DAOCNES = new CNES_DAO();
			$cneses = $DAOCNES->select_all(null, "id, no_fantasia, cnpj, cpf, uf, nm_municipio", $_POST["whereclause"]);
			?>
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
						<?php
							foreach ($cneses as $cnes){
								echo "<tr>
									<td style=\"width:9%;font-size:14px;padding-left:8px;\">".(is_null($cnes->get_id()) ? "" : strtoupper(substr($cnes->get_id(), 0, 20)))."</td>
									<td style=\"width:22%;font-size:14px;\">".(is_null($cnes->get_no_fantasia()) ? "" : strtoupper(substr($cnes->get_no_fantasia(), 0, 20)))."</td>";

								$cnpj = $cnes->get_cnpj();
								if (intval($cnpj) > 0){
									echo "<td style=\"width:22%;font-size:14px;\">".(is_null($cnes->get_cnpj()) ? "" : strtoupper(substr($cnes->get_cnpj(), 0, 20)))."</td>";
								} else {
									echo "<td style=\"width:22%;font-size:14px;\">".(is_null($cnes->get_cpf()) ? "" : strtoupper(substr($cnes->get_cpf(), 0, 20)))."</td>";
								}

								echo "<td style=\"width:22%;font-size:14px;\">".(is_null($cnes->get_nm_municipio()) ? "" : strtoupper(substr($cnes->get_nm_municipio(), 0, 20)))."</td>
									<td style=\"width:5%;font-size:14px;\">".(is_null($cnes->get_uf()) ? "" : strtoupper(substr($cnes->get_uf(), 0, 7)))."</td>
									<td align=\"center\" style=\"width:10%;\"><button class=\"btn btn-sm btn-info\" onclick=\"openEditarPrestador('".$cnes->get_id()."', '".$cnes->get_uf()."', '".$cnes->get_nm_municipio()."')\"> Editar </button></td>
									<td align=\"center\" style=\"width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirPrestador('".$cnes->get_id()."')\"> Excluir </button></td>
									</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-12" align="center">
						<button data-toggle="modal" data-target="#modalAguarde" class="btn btnlarge btn-success"> Cadastrar Prestador </button>
					</div>
				</div>
			</div>
			<?php
		}
	}
	if (intval($_POST["request"]) == 5){
		if (isset($_POST["whereclause"])){
			$DAOCNES = new CNES_DAO();
			$cneses = $DAOCNES->select_all(null, "id, no_fantasia, cnpj, cpf, uf, nm_municipio", $_POST["whereclause"]);
			?>
			<div class="panel-body">
				<table id="table-materiais" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="width:9%;font-size:14px;padding-left:8px;">Registro</th>
							<th style="width:25%;font-size:14px;">Nome Fantasia</th>
							<th style="width:25%;font-size:14px;">CNPJ ou CPF</th>
							<th style="width:24%;font-size:14px;">Município</th>
							<th style="width:5%;font-size:14px;">UF</th>
							<th style="width:12%;font-size:14px;padding-left:8px;">Visualizar</th>
						</tr>
					</thead>
					<tbody>
						<?php

							foreach ($cneses as $cnes){
								echo "<tr>
									<td style=\"width:9%;font-size:14px;padding-left:8px;\">".(is_null($cnes->get_id()) ? "" : strtoupper(substr($cnes->get_id(), 0, 20)))."</td>
									<td style=\"width:25%;font-size:14px;\">".(is_null($cnes->get_no_fantasia()) ? "" : strtoupper(substr($cnes->get_no_fantasia(), 0, 20)))."</td>";

								$cnpj = $cnes->get_cnpj();
								if (intval($cnpj) > 0){
									echo "<td style=\"width:25%;font-size:14px;\">".(is_null($cnes->get_cnpj()) ? "" : strtoupper(substr($cnes->get_cnpj(), 0, 20)))."</td>";
								} else {
									echo "<td style=\"width:25%;font-size:14px;\">".(is_null($cnes->get_cpf()) ? "" : strtoupper(substr($cnes->get_cpf(), 0, 20)))."</td>";
								}

								echo "<td style=\"width:24%;font-size:14px;\">".(is_null($cnes->get_nm_municipio()) ? "" : strtoupper(substr($cnes->get_nm_municipio(), 0, 20)))."</td>
									<td style=\"width:5%;font-size:14px;\">".(is_null($cnes->get_uf()) ? "" : strtoupper(substr($cnes->get_uf(), 0, 7)))."</td>
									<td align=\"center\" style=\"width:12%;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarPrestadora('".$cnes->get_id()."', '".$_SESSION["healthcare-user"]["id"]."')\"> Visualizar </button></td>
									</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
			<?php
		}
	}
	if (intval($_POST["request"]) == 6){
		if ((isset($_POST["whereclause"]))&&(isset($_POST["whereclauseope"]))){
			$DAOCNES = new CNES_DAO();
			$DAOPrestadora = new Prestadora_DAO();
			$DAOOperadora = new Operadora_DAO();

			$whereclause = "".$_POST["whereclause"];
			$whereclauseope = "".$_POST["whereclauseope"];
			if ((strcasecmp($whereclause, "") == 0)||(strcasecmp($whereclause, " ") == 0)){ $whereclause = null; }
			if ((strcasecmp($whereclauseope, "") == 0)||(strcasecmp($whereclauseope, " ") == 0)){ $whereclauseope = null; }

			$operadoras = $DAOOperadora->select_all(null, null, $whereclauseope);
			$prestadoras = $DAOPrestadora->select_all();
			$cneses = $DAOCNES->select_prestadoras(null, "tb_cnes.id, tb_cnes.no_fantasia, tb_cnes.cnpj, tb_cnes.cpf, tb_cnes.uf, tb_cnes.nm_municipio", $whereclause);
			?>
			<div class="panel-body">
				<table id="table-materiais" class="table table-striped table-bordered">
					<thead>
						<tr>
						<?php if (intval($_SESSION["healthcare-type-user"]) == 0){ ?>
							<th style="width:9%;font-size:14px;padding-left:8px;">Operadora</th>
							<th style="width:36%;font-size:14px;">Nome Fantasia</th>
							<th style="width:13%;font-size:14px;">CNPJ ou CPF</th>
							<th style="width:20%;font-size:14px;">Município</th>
							<th style="width:12%;font-size:14px;">Visualizar</th>
							<th style="width:10%;font-size:14px;padding-left:8px;">Excluir</th>
						<?php } else { ?>
							<th style="width:39%;font-size:14px;">Prestador</th>
							<th style="width:16%;font-size:14px;">CNPJ ou CPF</th>
							<th style="width:23%;font-size:14px;">Município</th>
							<th style="width:12%;font-size:14px;">Visualizar</th>
							<th style="width:10%;font-size:14px;padding-left:8px;">Excluir</th>
						<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($cneses as $cnes){
								$prestadora = null;
								foreach ($prestadoras as $prest){
									if (strcasecmp($cnes->get_id(), $prest->get_CNES()->get_id()) == 0){
										foreach ($operadoras as $operadora){
											if (strcasecmp($operadora->get_id(), $prest->get_OPERADORA()->get_id()) == 0){
												$prestadora = $prest;
											}
										}
									}
								}

								if (!is_null($prestadora)){
									$objopera = $prestadora->get_OPERADORA();
									if ((!is_null($objopera))&&(!is_null($cnes))){
										if (intval($_SESSION["healthcare-type-user"]) == 0){
											echo "<tr>
												<td style=\"width:9%;font-size:14px;padding-left:8px;\">".(is_null($objopera->get_nome()) ? "" : strtoupper(substr($objopera->get_nome(), 0, 20)))."</td>
												<td style=\"width:36%;font-size:14px;\">".(is_null($cnes->get_no_fantasia()) ? "" : $cnes->get_no_fantasia())."</td>";

											$cnpj = $cnes->get_cnpj();
											if (intval($cnpj) > 0){
												echo "<td style=\"width:13%;font-size:14px;\">".(is_null($cnes->get_cnpj()) ? "" : strtoupper(substr($cnes->get_cnpj(), 0, 20)))."</td>";
											} else {
												echo "<td style=\"width:13%;font-size:14px;\">".(is_null($cnes->get_cpf()) ? "" : strtoupper(substr($cnes->get_cpf(), 0, 20)))."</td>";
											}

											echo "<td style=\"width:20%;font-size:14px;\">".(is_null($cnes->get_nm_municipio()) ? "" : $cnes->get_nm_municipio())."</td>
												<td align=\"center\" style=\"width:12%;font-size:14px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarPrestadora('".$cnes->get_id()."', '".$objopera->get_id()."')\"> Visualizar </button></td>
												<td align=\"center\" style=\"width:10%;font-size:14px;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirOperadora('".$cnes->get_id()."', '".$objopera->get_id()."')\"> Excluir </button></td>
												</tr>";
										} else {
											echo "<tr>
												<td style=\"width:39%;font-size:14px;\">".(is_null($cnes->get_no_fantasia()) ? "" : $cnes->get_no_fantasia())."</td>";

											$cnpj = $cnes->get_cnpj();
											if (intval($cnpj) > 0){
												echo "<td style=\"width:16%;font-size:14px;\">".(is_null($cnes->get_cnpj()) ? "" : strtoupper(substr($cnes->get_cnpj(), 0, 20)))."</td>";
											} else {
												echo "<td style=\"width:16%;font-size:14px;\">".(is_null($cnes->get_cpf()) ? "" : strtoupper(substr($cnes->get_cpf(), 0, 20)))."</td>";
											}

											echo "<td style=\"width:23%;font-size:14px;\">".(is_null($cnes->get_nm_municipio()) ? "" : $cnes->get_nm_municipio())."</td>
												<td align=\"center\" style=\"width:12%;font-size:14px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarPrestadora('".$cnes->get_id()."', '".$objopera->get_id()."')\"> Visualizar </button></td>
												<td align=\"center\" style=\"width:10%;font-size:14px;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirOperadora('".$cnes->get_id()."', '".$objopera->get_id()."')\"> Excluir </button></td>
												</tr>";
										}
									}
								}
							}
						?>
					</tbody>
				</table>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-12" align="center">
					<?php if (intval($_SESSION["healthcare-type-user"]) == 0){ ?>
						<button data-toggle="modal" data-target="#modalAdicionarPrestadora" class="btn btnlarge btn-success"> Associar Prestador com Operadora </button>
					<?php } else { ?>
						<button data-toggle="modal" data-target="#modalAdicionarPrestadora" class="btn btnlarge btn-success"> Cadastrar Prestador na Operadora </button>
					<?php } ?>
					</div>
				</div>
			</div>
			<?php
		}
	}
	if (intval($_POST["request"]) == 7){
		if (isset($_POST["id_cnes"])){
			$DAOCNES = new CNES_DAO();
			$cnes = $DAOCNES->select_id ($_POST["id_cnes"]); ?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Editar Prestador</h4>
			</div>
			<form enctype="multipart/form-data" method="POST" action="simple_prestadores.php">
				<div class="modal-body" style="padding:0px;">
					<input id="permitexecedt" type="hidden" name="permitexec" required/>
					<input id="typeoperationedt" type="hidden" name="typeoperation" required/>
					<input id="edt_id" type="hidden" name="id" value="<?php echo $cnes->get_id(); ?>" required/>
					<input id="edt_estado" type="hidden" name="estado" required/>
					<input id="edt_municipio" type="hidden" name="municipio" required/>
					<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;padding-top:10px;margin-top:10px;">
						<h3 class="panel-title" style="font-size:17px;">Dados do Prestador</h3>
						<hr style="margin-top:10px;margin-bottom:15px;" />
					</div>
					<div class="row">
						<table style="margin-right:5%;margin-left:5%;margin-top:5px;margin-bottom:5px;width:90%;">
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:34%;">Razão Social: &nbsp</td>
								<td><input style="height:25px;" id="edt_razao_social" type="text" name="razao_social" value="<?php echo $cnes->get_razao_social(); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:34%;">Nome Fantasia: &nbsp</td>
								<td><input style="height:25px;" id="edt_no_fantasia" type="text" name="no_fantasia" value="<?php echo $cnes->get_no_fantasia(); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:34%;">Tipo de Estabelecimento: &nbsp</td>
								<td><input style="height:25px;" id="edt_tipo_estabe" type="text" name="tipo_estabelecimento" value="<?php echo $cnes->get_tipo_estabelecimento(); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:34%;">Convênio: &nbsp</td>
								<td><input style="height:25px;" id="edt_convenio" type="text" name="convenio" value="<?php echo $cnes->get_convenio(); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:34%;">Natureza Jurídica: &nbsp</td>
								<td><input style="height:25px;" id="edt_natureza_juridica" type="text" name="natureza_juridica" value="<?php echo $cnes->get_natureza_juridica(); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:34%;">Atendimentos Prestados: &nbsp</td>
								<td><input style="height:25px;" id="edt_atendimento_prest" type="text" name="atendimento_prestado" value="<?php echo $cnes->get_atendimento_prestado(); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:34%;">CPF ou CNPJ: &nbsp</td>
								<td><input style="height:25px;" id="edt_cpf_cnpj" type="text" name="cpf_cnpj" value="<?php echo ((intval($cnes->get_cnpj()) > 0) ? $cnes->get_cnpj() : $cnes->get_cpf()); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:34%;">Estado: &nbsp</td>
								<td><select style="height:25px;width:100%" id="edt_estados" type="text" name="estados"></select></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:34%;">Municipio: &nbsp</td>
								<td><select style="height:25px;width:100%" id="edt_cidades" type="text" name="cidades"></select></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:34%;">CEP: &nbsp</td>
								<td><input style="height:25px;" id="edt_cep" type="text" name="cep" value="<?php echo $cnes->get_cep(); ?>"></td>
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
								<td><input style="height:25px;" id="edt_l_clinica" type="number" name="l_clinica" value = "<?php echo "".(intval($cnes->get_leitos_clinica())); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:28%;">Cirurgia: &nbsp</td>
								<td><input style="height:25px;" id="edt_l_cirurgia" type="number" name="l_cirurgia" value = "<?php echo "".(intval($cnes->get_leitos_cirurgia())); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:28%;">Obstetricia: &nbsp</td>
								<td><input style="height:25px;" id="edt_l_obstetricia" type="number" name="l_obstetricia" value = "<?php echo "".(intval($cnes->get_leitos_obstetricia())); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:28%;">Pediatria: &nbsp</td>
								<td><input style="height:25px;" id="edt_l_pediatria" type="number" name="l_pediatria" value = "<?php echo "".(intval($cnes->get_leitos_pediatria())); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:28%;">Psiquiatria: &nbsp</td>
								<td><input style="height:25px;" id="edt_l_psiquiatria" type="number" name="l_psiquiatria" value = "<?php echo "".(intval($cnes->get_leitos_psiquiatria())); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:28%;">UTI Adulto: &nbsp</td>
								<td><input style="height:25px;" id="edt_l_uti_adulto" type="number" name="l_uti_adulto" value = "<?php echo "".(intval($cnes->get_leitos_uti_adulto())); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:28%;">UTI Pediatrica: &nbsp</td>
								<td><input style="height:25px;" id="edt_l_uti_pediatrica" type="number" name="l_uti_pediatrica" value = "<?php echo "".(intval($cnes->get_leitos_uti_pediatrica())); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:28%;">UTI Neonatal: &nbsp</td>
								<td><input style="height:25px;" id="edt_l_uti_neonatal" type="number" name="l_uti_neonatal" value = "<?php echo "".(intval($cnes->get_leitos_uti_neonatal())); ?>"></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="text-align:right;width:28%;">Unidade Interm Neo: &nbsp</td>
								<td><input style="height:25px;" id="edt_l_unidade_interm_neo" type="number" name="l_unidade_interm_neo" value = "<?php echo "".(intval($cnes->get_leitos_unidade_interm_neo())); ?>"></td>
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
								<td style="width:33.33%"><input style="width:5%;" id="edt_equipo_odontologico" name="equipo_odontologico" type="checkbox" value="" <?php echo "".(($cnes->get_equipo_odontologico()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Equipo Odontológico</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_cirurgiao_dentista" name="cirurgiao_dentista" type="checkbox" value="" <?php echo "".(($cnes->get_cirurgiao_dentista()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Cirurgião Dentista</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_urgencia_emergencia" name="urgencia_emergencia" type="checkbox" value="" <?php echo "".(($cnes->get_urgencia_emergencia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Urgência e Emergência</span></div></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="width:33.33%"><input style="width:5%;" id="edt_anatomopatologia" name="anatomopatologia" type="checkbox" value="" <?php echo "".(($cnes->get_anatomopatologia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Anatomopatologia</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_colposcopia" name="colposcopia" type="checkbox" value="" <?php echo "".(($cnes->get_colposcopia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Colposcopia</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_eletrocardiograma" name="eletrocardiograma" type="checkbox" value="" <?php echo "".(($cnes->get_eletrocardiograma()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Eletrocardiograma</span></div></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="width:33.33%"><input style="width:5%;" id="edt_fisioterapia" name="fisioterapia" type="checkbox" value="" <?php echo "".(($cnes->get_fisioterapia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Fisioterapia</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_patologia_clinica" name="patologia_clinica" type="checkbox" value="" <?php echo "".(($cnes->get_patologia_clinica()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Patologia Clínica</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_radiodiagnostico" name="radiodiagnostico" type="checkbox" value="" <?php echo "".(($cnes->get_radiodiagnostico()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Radiodiagnóstico</span></div></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="width:33.33%"><input style="width:5%;" id="edt_ultra_sonografia" name="ultra_sonografia" type="checkbox" value="" <?php echo "".(($cnes->get_ultra_sonografia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Ultrassonografia</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_ecocardiografia" name="ecocardiografia" type="checkbox" value="" <?php echo "".(($cnes->get_ecocardiografia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Ecocardiografia</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_endoscopia_vdigestivas" name="endoscopia_vdigestivas" type="checkbox" value="" <?php echo "".(($cnes->get_endoscopia_vdigestivas()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Endoscopia V Digestivas</span></div></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="width:33.33%"><input style="width:5%;" id="edt_hemoterapia_ambulatorial" name="hemoterapia_ambulatorial" type="checkbox" value="" <?php echo "".(($cnes->get_hemoterapia_ambulatorial()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Hemo. Ambulatorial</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_holter" name="holter" type="checkbox" value="" <?php echo "".(($cnes->get_holter()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Holter</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_litotripsia_extracorporea" name="litotripsia_extracorporea" type="checkbox" value="" <?php echo "".(($cnes->get_litotripsia_extracorporea()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Litotripsia Extracorporea</span></div></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="width:33.33%"><input style="width:5%;" id="edt_mamografia" name="mamografia" type="checkbox" value="" <?php echo "".(($cnes->get_mamografia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Mamografia</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_psicoterapia" name="psicoterapia" type="checkbox" value="" <?php echo "".(($cnes->get_psicoterapia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Psicoterapia</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_terapia_renalsubst" name="terapia_renalsubst" type="checkbox" value="" <?php echo "".(($cnes->get_terapia_renalsubst()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Terapia Renal</span></div></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="width:33.33%"><input style="width:5%;" id="edt_teste_ergometrico" name="teste_ergometrico" type="checkbox" value="" <?php echo "".(($cnes->get_teste_ergometrico()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Teste Ergométrico</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_tomografia_computadorizada" name="tomografia_computadorizada" type="checkbox" value="" <?php echo "".(($cnes->get_tomografia_computadorizada()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp T. Computadorizada</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_atendimento_hospitaldia" name="atendimento_hospitaldia" type="checkbox" value="" <?php echo "".(($cnes->get_atendimento_hospitaldia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Atendimento Diurno</span></div></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="width:33.33%"><input style="width:5%;" id="edt_endoscopia_vaereas" name="endoscopia_vaereas" type="checkbox" value="" <?php echo "".(($cnes->get_endoscopia_vaereas()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Endoscopia V Aereas</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_hemodinamica" name="hemodinamica" type="checkbox" value="" <?php echo "".(($cnes->get_hemodinamica()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Hemodinâmica</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_medicina_nuclear" name="medicina_nuclear" type="checkbox" value="" <?php echo "".(($cnes->get_medicina_nuclear()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Medicina Nuclear</span></div></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="width:33.33%"><input style="width:5%;" id="edt_quimioterapia" name="quimioterapia" type="checkbox" value="" <?php echo "".(($cnes->get_quimioterapia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Quimioterapia</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_radiologia_intervencionista" name="radiologia_intervencionista" type="checkbox" value="" <?php echo "".(($cnes->get_radiologia_intervencionista()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Radiologia Inter.</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_radioterapia" name="radioterapia" type="checkbox" value="" <?php echo "".(($cnes->get_radioterapia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Radioterapia</span></div></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="width:33.33%"><input style="width:5%;" id="edt_ressonancia_nmagnetica" name="ressonancia_nmagnetica" type="checkbox" value="" <?php echo "".(($cnes->get_ressonancia_nmagnetica()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Resso. Magnética</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_ultrassonografia_doppler" name="ultrassonografia_doppler" type="checkbox" value="" <?php echo "".(($cnes->get_ultrassonografia_doppler()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Ultrasso. Doppler</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_videocirurgia" name="videocirurgia" type="checkbox" value="" <?php echo "".(($cnes->get_videocirurgia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Videocirurgia</span></div></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="width:33.33%"><input style="width:5%;" id="edt_odontologia_basica" name="odontologia_basica" type="checkbox" value="" <?php echo "".(($cnes->get_odontologia_basica()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Odontologia Básica</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_raiox_dentario" name="raiox_dentario" type="checkbox" value="" <?php echo "".(($cnes->get_raiox_dentario()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Raio X Dentário</span></div></td>
								<td style="width:33.33%"><input style="width:5%;" id="edt_endodontia" name="endodontia" type="checkbox" value="" <?php echo "".(($cnes->get_endodontia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Endodontia</span></div></td>
							</tr>
							<tr style="border-width:5px;border-style:solid;border-color:white;">
								<td style="width:33.33%"><input style="width:5%;" id="edt_periodontia" name="periodontia" type="checkbox" value="" <?php echo "".(($cnes->get_periodontia()) ? "checked" : ""); ?>><div style="margin-left:5%;margin-top:-17px;"><span>&nbsp Periodontia</span></div></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					<button type="button" onclick="edtPrestador()" class="btn btn-success">Editar</button>
					<button id="chkedtprestador" type="submit" class="btn btn-success collapse">Submeter</button>
				</div>
			</form>
		<?php }
	}
	if (intval($_POST["request"]) == 8){
		if ((isset($_POST["whereclause"]))&&(isset($_POST["id_medtab"]))){
			if (empty($_POST["whereclause"])){ $_POST["whereclause"] = null; }
			$DAOMedTab = new MedTab_DAO();

			$ids_medtab = array ();
			$medtab = $DAOMedTab->select_id ($_POST["id_medtab"]);

			$curr_medtab = $medtab;
			array_push ($ids_medtab, $curr_medtab->get_id());
			while (!is_null($curr_medtab->get_MEDTAB())){
				$curr_medtab = $DAOMedTab->select_id ($curr_medtab->get_MEDTAB()->get_id());
				array_push ($ids_medtab, $curr_medtab->get_id());
			}

			$alicota = "tb_cmed.pf_";
			if (is_null($medtab->get_pf_alicota())){ $alicota .= "semimpostos"; }
			else{
				switch ($medtab->get_pf_alicota()){
					case 0: $alicota .= "zero"; break;
					case 1: $alicota .= "doze"; break;
					case 2: $alicota .= "dezessete"; break;
					case 3: $alicota .= "dezessete_alc"; break;
					case 4: $alicota .= "dezessetemeio"; break;
					case 5: $alicota .= "dezessetemeio_alc"; break;
					case 6: $alicota .= "dezoito"; break;
					case 7: $alicota .= "dezoito_alc"; break;
					case 8: $alicota .= "vinte"; break;
					default: $alicota .= "semimpostos"; break;
				}
			}

			$alicota .= " AS pf_semimpostos";
			$variables = "tb_medicamento.*, ".$alicota;
			$results = $DAOMedTab->select_full_table ($ids_medtab, null, "DISTINCT ".$variables, $_POST["whereclause"]);
			?>
			<div class="panel-body">
				<table id="table-medicamento" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="width:15%;font-size:14px;padding-left:8px;">Registro</th>
							<?php if (intval($_SESSION["healthcare-type-user"]) == 2){ ?>
							<th style="width:22%;font-size:14px;">Substância</th>
							<th style="width:20%;font-size:14px;">Produto</th>
							<th style="width:20%;font-size:14px;">Laboratório</th>
							<?php } else { ?>
							<th style="width:18%;font-size:14px;">Substância</th>
							<th style="width:17%;font-size:14px;">Produto</th>
							<th style="width:17%;font-size:14px;">Laboratório</th>
							<?php } ?>
							<th style="width:11%;font-size:14px;">Preço F.</th>
							<th style="width:12%;font-size:14px;;padding-left:8px;">Visualizar</th>
							<?php if (intval($_SESSION["healthcare-type-user"]) != 2){ ?>
							<th style="width:10%;font-size:14px;padding-left:8px;">Excluir</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($results as $result){
								$medicamento = $result[0];
								$idant = $medicamento->get_codggrem();
								if (is_null($idant)){
									$idant = $medicamento->get_generico();
									if (is_null($idant)){ $idant = $medicamento->get_cod_termo(); }
								}

								echo "<tr>
									<td style=\"width:15%;font-size:14px;padding-left:8px;\">".(is_null($medicamento->get_id()) ? "" : strtoupper(substr($medicamento->get_id(), 0, 20)))."</td>";

								if (intval($_SESSION["healthcare-type-user"]) == 2){
									echo "<td style=\"width:22%;font-size:14px;\">".(is_null($medicamento->get_substancia()) ? strtoupper(substr($medicamento->get_substancia(), 0, 20)) : strtoupper(substr($medicamento->get_substancia(), 0, 20)))."</td>
										<td style=\"width:20%;font-size:14px;\">".(is_null($medicamento->get_produto()) ? strtoupper(substr($medicamento->get_substancia(), 0, 20)) : strtoupper(substr($medicamento->get_produto(), 0, 20)))."</td>
										<td style=\"width:20%;font-size:14px;\">".(is_null($medicamento->get_laboratorio()) ? "" : strtoupper(substr($medicamento->get_laboratorio(), 0, 20)))."</td>";
								} else {
									echo "<td style=\"width:18%;font-size:14px;\">".(is_null($medicamento->get_substancia()) ? strtoupper(substr($medicamento->get_substancia(), 0, 20)) : strtoupper(substr($medicamento->get_substancia(), 0, 20)))."</td>
										<td style=\"width:17%;font-size:14px;\">".(is_null($medicamento->get_produto()) ? strtoupper(substr($medicamento->get_substancia(), 0, 20)) : strtoupper(substr($medicamento->get_produto(), 0, 20)))."</td>
										<td style=\"width:17%;font-size:14px;\">".(is_null($medicamento->get_laboratorio()) ? "" : strtoupper(substr($medicamento->get_laboratorio(), 0, 20)))."</td>";
								}

								echo "<td style=\"width:11%;font-size:14px;\">".(is_null($result[1]->get_pf_semimpostos()) ? "-" : "R$ ".number_format(floatval($result[1]->get_pf_semimpostos())*floatval($medtab->get_deflator()), 2, ',', '.'))."</td>";

								if (intval($_SESSION["healthcare-type-user"]) != 2){
									if ((!is_null($medtab->get_OPERADORA()))||(intval($_SESSION["healthcare-type-user"]) == 0)){
										echo "<td align=\"center\" style=\"width:12%;;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarMedicamento('".$medicamento->get_id()."', true)\"> Visualizar </button></td>
											<td align=\"center\" style=\"width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirMedicamento('".$medicamento->get_id()."')\"> Excluir </button></td>";
									} else {
										echo "<td align=\"center\" style=\"width:12%;;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarMedicamento('".$medicamento->get_id()."', false)\"> Visualizar </button></td>
											<td align=\"center\" style=\"width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirMedicamento('".$medicamento->get_id()."')\" disabled> Excluir </button></td>";
									}
								} else {
									echo "<td align=\"center\" style=\"width:12%;;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarMedicamento('".$medicamento->get_id()."')\"> Visualizar </button></td>";
								}

								echo "</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
			<?php if ((intval($_SESSION["healthcare-type-user"]) != 2)||(isset($_POST["permitreturn"]))){ ?>
			<?php if (!is_null($medtab->get_format_type())){ ?>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-12" align="center">
						<button style="width:33%;margin-right:2%;" onclick="retornar(0)" class="btn btnlarge btn-default"> Retornar </button><button style="width:65%;" onclick="download('<?php echo $medtab->get_id(); ?>', '<?php echo $_SESSION["healthcare-user"]["id"]; ?>')" class="btn btnlarge btn-default"> Download da Tabela </button>
					</div>
				</div>
			</div>
			<?php } else { ?>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-12" align="center">
						<button onclick="retornar(0)" class="btn btnlarge btn-default"> Retornar </button>
					</div>
				</div>
			</div>
			<?php }
			}
		}
	}
	if (intval($_POST["request"]) == 9){
		if ((isset($_POST["whereclause"]))&&(isset($_POST["id_mattab"]))){
			if (empty($_POST["whereclause"])){ $_POST["whereclause"] = null; }
			$DAOMatTab = new MatTab_DAO();

			$ids_mattab = array ();
			$mattab = $DAOMatTab->select_id ($_POST["id_mattab"]);

			$curr_mattab = $mattab;
			array_push ($ids_mattab, $curr_mattab->get_id());
			while (!is_null($curr_mattab->get_MATTAB())){
				$curr_mattab = $DAOMatTab->select_id ($curr_mattab->get_MATTAB()->get_id());
				array_push ($ids_mattab, $curr_mattab->get_id());
			}

			$variables = "tb_material.*";
			$results = $DAOMatTab->select_full_table ($ids_mattab, null, "DISTINCT ".$variables, $_POST["whereclause"]);
			?>
			<div class="panel-body">
				<?php if (count($results) >= 75000){ ?>
				<div style="color:red;">Quantidade máxima de registros alcançada: 75.000 registros</div>
				<?php } ?>
				<table id="table-material" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="width:15%;font-size:14px;padding-left:8px;">Registro</th>
							<?php if (intval($_SESSION["healthcare-type-user"]) == 2){ ?>
							<th style="width:31%;font-size:14px;">Nome Técnico</th>
							<th style="width:32%;font-size:14px;">Fabricante</th>
							<?php } else { ?>
							<th style="width:26%;font-size:14px;">Nome Técnico</th>
							<th style="width:27%;font-size:14px;">Fabricante</th>
							<?php } ?>
							<th style="width:10%;font-size:14px;">C. Risco</th>
							<th style="width:12%;font-size:14px;padding-left:8px;">Visualizar</th>
							<?php if (intval($_SESSION["healthcare-type-user"]) != 2){ ?>
							<th style="width:10%;font-size:14px;padding-left:8px;">Excluir</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($results as $result){
								$material = $result[0];
								echo "<tr>
									<td style=\"width:15%;font-size:14px;padding-left:8px;\">".(is_null($material->get_id()) ? "" : strtoupper(substr($material->get_id(), 0, 20)))."</td>";

								if (intval($_SESSION["healthcare-type-user"]) == 2){
									echo "<td style=\"width:31%;font-size:14px;\">".(is_null($material->get_nome_tecnico()) ? "" : strtoupper(substr($material->get_nome_tecnico(), 0, 25)))."</td>
										<td style=\"width:32%;font-size:14px;\">".(is_null($material->get_fabricante()) ? "" : strtoupper(substr($material->get_fabricante(), 0, 25)))."</td>";
								} else {
									echo "<td style=\"width:26%;font-size:14px;\">".(is_null($material->get_nome_tecnico()) ? "" : strtoupper(substr($material->get_nome_tecnico(), 0, 25)))."</td>
										<td style=\"width:27%;font-size:14px;\">".(is_null($material->get_fabricante()) ? "" : strtoupper(substr($material->get_fabricante(), 0, 25)))."</td>";
								}

								echo "<td style=\"width:10%;font-size:14px;\">".(is_null($material->get_classe_risco()) ? "" : strtoupper(substr($material->get_classe_risco(), 0, 7)))."</td>";

								if (intval($_SESSION["healthcare-type-user"]) != 2){
									if ((!is_null($mattab->get_OPERADORA()))||(intval($_SESSION["healthcare-type-user"]) == 0)){
										echo "<td align=\"center\" style=\"width:12%;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarMaterial('".$material->get_id()."', true)\"> Visualizar </button></td>
											<td align=\"center\" style=\"width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirMaterial('".$material->get_id()."')\"> Excluir </button></td>";
									} else {
										echo "<td align=\"center\" style=\"width:12%;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarMaterial('".$material->get_id()."', false)\"> Visualizar </button></td>
											<td align=\"center\" style=\"width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirMaterial('".$material->get_id()."')\" disabled> Excluir </button></td>";
									}
								} else {
									echo "<td align=\"center\" style=\"width:12%;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarMaterial('".$material->get_id()."')\"> Visualizar </button></td>";
								}

								echo "</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
			<?php if ((intval($_SESSION["healthcare-type-user"]) != 2)||(isset($_POST["permitreturn"]))){ ?>
			<?php if (!is_null($mattab->get_format_type())){ ?>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-12" align="center">
						<button style="width:33%;margin-right:2%;" onclick="retornar(1)" class="btn btnlarge btn-default"> Retornar </button><button style="width:65%;" onclick="download('<?php echo $mattab->get_id(); ?>', '<?php echo $_SESSION["healthcare-user"]["id"]; ?>')" class="btn btnlarge btn-default"> Download da Tabela </button>
					</div>
				</div>
			</div>
			<?php } else { ?>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-12" align="center">
						<button onclick="retornar(1)" class="btn btnlarge btn-default"> Retornar </button>
					</div>
				</div>
			</div>
			<?php }
			}
		}
	}
	if (intval($_POST["request"]) == 10){
		if ((isset($_POST["id_medtab"]))&&(isset($_POST["id_medicamento"]))){
			$DAOMedTab = new MedTab_DAO;
			$DAOCMED = new CMED_DAO();
			$DAOMedTuss = new MedTuss_DAO();
			$DAOMedTnum = new MedTnum_DAO();

			$medtab = $DAOMedTab->select_id ($_POST["id_medtab"]);
			$cmeds = $DAOCMED->select_by_MedTab ($_POST["id_medtab"], null, "tb_cmed.id_medicamento = '".$_POST["id_medicamento"]."'");
			$medtuss = $DAOMedTuss->select_by_MedTab ($_POST["id_medtab"], null, "tb_medtuss.id_medicamento = '".$_POST["id_medicamento"]."'");
			$medtnum = $DAOMedTnum->select_by_MedTab ($_POST["id_medtab"], null, "tb_medtnum.id_medicamento = '".$_POST["id_medicamento"]."'");
			$medicamento = null;

			if (isset($cmeds[0])){ $medicamento = $cmeds[0]->get_MEDICAMENTO(); }
			else {
				if (isset($medtuss[0])){ $medicamento = $medtuss[0]->get_MEDICAMENTO(); }
				else {
					if (isset($medtnum[0])){ $medicamento = $medtnum[0]->get_MEDICAMENTO(); }
				}
			}
			?>
			<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;">
				<h3 class="panel-title" style="font-size:17px;">Informações Gerais</h3>
				<hr style="margin-top:10px;margin-bottom:15px;" />
			</div>
			<div style="margin-left:5%;margin-right:5%;width:90%;">
				<b>Substância:</b> <?php echo $medicamento->get_substancia(); ?><br>
				<b>CNPJ:</b> <?php echo $medicamento->get_cnpj(); ?><br>
				<b>Laboratório:</b> <?php echo $medicamento->get_laboratorio(); ?><br>
				<b>Codggrem:</b> <?php echo $medicamento->get_codggrem(); ?><br>
				<b>Produto:</b> <?php echo $medicamento->get_produto(); ?><br>
				<b>Apresentação:</b> <?php echo $medicamento->get_apresentacao(); ?><br>
				<b>Classe Terapêutica:</b> <?php echo $medicamento->get_classe_terapeutica(); ?><br>
				<b>Tipo de Produto:</b> <?php echo $medicamento->get_tipo_produto(); ?><br>
				<b>Tarja:</b> <?php echo $medicamento->get_tarja(); ?><br>
				<b>Código do Termo:</b> <?php echo $medicamento->get_cod_termo(); ?><br>
				<b>Grupo Farmacológico:</b> <?php echo $medicamento->get_grupo_farmacologico(); ?><br>
				<b>Classe Farmacológica:</b> <?php echo $medicamento->get_classe_farmacologica(); ?><br>
				<b>Forma Farmacêutica:</b> <?php echo $medicamento->get_forma_farmaceutica(); ?><br>
				<b>Unidade mínima:</b> <?php echo $medicamento->get_unidmin_fracao(); ?><br>
			</div>
			<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;padding-top:10px;margin-top:10px;">
				<h3 class="panel-title" style="font-size:17px;">CMED</h3>
				<hr style="margin-top:10px;margin-bottom:15px;" />
			</div>
			<?php if (isset($cmeds[0])){ ?>
				<div style="margin-left:5%;margin-right:5%;width:90%;">
					<b>Preço do Fabricante:</b> <?php
						$pf_value = null;
						if (is_null($medtab->get_pf_alicota())){ $pf_value = $cmeds[0]->get_pf_semimpostos(); }
						else{
							switch ($medtab->get_pf_alicota()){
								case 0: $pf_value = $cmeds[0]->get_pf_zero(); break;
								case 1: $pf_value = $cmeds[0]->get_pf_doze(); break;
								case 2: $pf_value = $cmeds[0]->get_pf_dezessete(); break;
								case 3: $pf_value = $cmeds[0]->get_pf_dezessete_alc(); break;
								case 4: $pf_value = $cmeds[0]->get_pf_dezessetemeio(); break;
								case 5: $pf_value = $cmeds[0]->get_pf_dezessetemeio_alc(); break;
								case 6: $pf_value = $cmeds[0]->get_pf_dezoito(); break;
								case 7: $pf_value = $cmeds[0]->get_pf_dezoito_alc(); break;
								case 8: $pf_value = $cmeds[0]->get_pf_vinte(); break;
								default: $pf_value = $cmeds[0]->get_pf_semimpostos(); break;
							}
						}
						echo "".(is_null($pf_value) ? "-" : "R$ ".number_format(floatval($pf_value)*floatval($medtab->get_deflator()), 2, ',', '.'));
					?><br>
					<b>Preço Máximo de Venda ao Consumidor:</b> <?php
						$pmc_value = null;
						if (is_null($medtab->get_pmc_alicota())){ $pmc_value = $cmeds[0]->get_pmc_zero(); }
						else{
							switch ($medtab->get_pmc_alicota()){
								case 0: $pmc_value = $cmeds[0]->get_pmc_doze(); break;
								case 1: $pmc_value = $cmeds[0]->get_pmc_dezessete(); break;
								case 2: $pmc_value = $cmeds[0]->get_pmc_dezessete_alc(); break;
								case 3: $pmc_value = $cmeds[0]->get_pmc_dezessetemeio(); break;
								case 4: $pmc_value = $cmeds[0]->get_pmc_dezessetemeio_alc(); break;
								case 5: $pmc_value = $cmeds[0]->get_pmc_dezoito(); break;
								case 6: $pmc_value = $cmeds[0]->get_pmc_dezoito_alc(); break;
								case 7: $pmc_value = $cmeds[0]->get_pmc_vinte(); break;
								default: $pmc_value = $cmeds[0]->get_pmc_zero(); break;
							}
						}
						echo "".(is_null($pmc_value) ? "-" : "R$ ".number_format(floatval($pmc_value)*floatval($medtab->get_deflator()), 2, ',', '.'));
					?><br>
					<b>Preço Máximo de Venda ao Governo:</b> <?php
						$pmvg_value = null;
						if (is_null($medtab->get_pmvg_alicota())){ $pmvg_value = $cmeds[0]->get_pmvg_semimpostos(); }
						else{
							switch ($medtab->get_pmvg_alicota()){
								case 0: $pmvg_value = $cmeds[0]->get_pmvg_zero(); break;
								case 1: $pmvg_value = $cmeds[0]->get_pmvg_doze(); break;
								case 2: $pmvg_value = $cmeds[0]->get_pmvg_dezessete(); break;
								case 3: $pmvg_value = $cmeds[0]->get_pmvg_dezessete_alc(); break;
								case 4: $pmvg_value = $cmeds[0]->get_pmvg_dezessetemeio(); break;
								case 5: $pmvg_value = $cmeds[0]->get_pmvg_dezessetemeio_alc(); break;
								case 6: $pmvg_value = $cmeds[0]->get_pmvg_dezoito(); break;
								case 7: $pmvg_value = $cmeds[0]->get_pmvg_dezoito_alc(); break;
								case 8: $pmvg_value = $cmeds[0]->get_pmvg_vinte(); break;
								default: $pmvg_value = $cmeds[0]->get_pmvg_semimpostos(); break;
							}
						}
						echo "".(is_null($pmvg_value) ? "-" : "R$ ".number_format(floatval($pmvg_value)*floatval($medtab->get_deflator()), 2, ',', '.'));
					?><br>
					<b>Regime de Preço:</b> <?php echo $cmeds[0]->get_regime_preco(); ?><br>
					<b>EAN 1:</b> <?php echo $cmeds[0]->get_ean_um(); ?><br>
					<b>EAN 2:</b> <?php echo $cmeds[0]->get_ean_dois(); ?><br>
					<b>EAN 3:</b> <?php echo $cmeds[0]->get_ean_tres(); ?><br>
				</div>
			<?php } ?>
			<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;padding-top:10px;margin-top:10px;">
				<h3 class="panel-title" style="font-size:17px;">TUSS</h3>
				<hr style="margin-top:10px;margin-bottom:15px;" />
			</div>
			<?php if (isset($medtuss[0])){ ?>
				<div style="margin-left:5%;margin-right:5%;width:90%;">
					<b>Inicio da Vigência:</b> <?php echo $medtuss[0]->get_inicio_vigencia(); ?><br>
					<b>Fim da Vigência:</b> <?php echo $medtuss[0]->get_fim_vigencia(); ?><br>
					<b>Fim da Implantação:</b> <?php echo $medtuss[0]->get_fim_implantacao(); ?><br>
				</div>
			<?php } ?>
			<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;padding-top:10px;margin-top:10px;">
				<h3 class="panel-title" style="font-size:17px;">TNUM</h3>
				<hr style="margin-top:10px;margin-bottom:15px;" />
			</div>
			<?php if (isset($medtnum[0])){ ?>
				<div style="margin-left:5%;margin-right:5%;width:90%;">
					<b>Tipo de Produto:</b> <?php echo $medtnum[0]->get_tipo_produto(); ?><br>
					<b>Inicio da Vigência:</b> <?php echo $medtnum[0]->get_inicio_vigencia(); ?><br>
					<b>Fim da Vigência:</b> <?php echo $medtnum[0]->get_fim_vigencia(); ?><br>
					<b>Motivo da Inserção:</b> <?php echo $medtnum[0]->get_motivo_insercao(); ?><br>
					<b>Fim da Implantação:</b> <?php echo $medtnum[0]->get_fim_implantacao(); ?><br>
					<b>Descrição Brasindice:</b> <?php echo $medtnum[0]->get_descricao_brasindice(); ?><br>
					<b>Apresentação Brasindice:</b> <?php echo $medtnum[0]->get_apresentacao_brasindice(); ?><br>
				</div>
			<?php }
		}
	}
	if (intval($_POST["request"]) == 11){
		if ((isset($_POST["id_mattab"]))&&(isset($_POST["id_material"]))){
			$DAOMatTuss = new MatTuss_DAO();
			$DAOMatTnum = new MatTnum_DAO();

			$mattuss = $DAOMatTuss->select_by_MatTab ($_POST["id_mattab"], null, "tb_mattuss.id_material = '".$_POST["id_material"]."'");
			$mattnum = $DAOMatTnum->select_by_MatTab ($_POST["id_mattab"], null, "tb_mattnum.id_material = '".$_POST["id_material"]."'");
			$material = null;

			if (isset($mattuss[0])){ $material = $mattuss[0]->get_MATERIAL(); }
			else {
				if (isset($mattnum[0])){ $material = $mattnum[0]->get_MATERIAL(); }
			}
			?>
			<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;">
				<h3 class="panel-title" style="font-size:17px;">Informações Gerais</h3>
				<hr style="margin-top:10px;margin-bottom:15px;" />
			</div>
			<div style="margin-left:5%;margin-right:5%;width:90%;">
				<b>CNPJ:</b> <?php echo $material->get_cnpj(); ?><br>
				<b>Fabricante:</b> <?php echo $material->get_fabricante(); ?><br>
				<b>Classe de Risco:</b> <?php echo $material->get_classe_risco(); ?><br>
				<b>Descrição do Produto:</b> <?php echo $material->get_descricao_produto(); ?><br>
				<b>Especialidade do Produto:</b> <?php echo $material->get_especialidade_produto(); ?><br>
				<b>Classificação do Produto:</b> <?php echo $material->get_classificacao_produto(); ?><br>
				<b>Nome Técnico:</b> <?php echo $material->get_nome_tecnico(); ?><br>
				<b>Unidade Mínima:</b> <?php echo $material->get_unidmin_fracao(); ?><br>
				<b>Tipo de Produto:</b> <?php echo $material->get_tipo_produto(); ?><br>
			</div>
			<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;padding-top:10px;margin-top:10px;">
				<h3 class="panel-title" style="font-size:17px;">TUSS</h3>
				<hr style="margin-top:10px;margin-bottom:15px;" />
			</div>
			<?php if (isset($mattuss[0])){ ?>
				<div style="margin-left:5%;margin-right:5%;width:90%;">
					<b>Termo:</b> <?php echo $mattuss[0]->get_termo(); ?><br>
					<b>Modelo:</b> <?php echo $mattuss[0]->get_modelo(); ?><br>
					<b>Início Vigência:</b> <?php echo $mattuss[0]->get_inicio_vigencia(); ?><br>
					<b>Fim Vigência:</b> <?php echo $mattuss[0]->get_fim_vigencia(); ?><br>
					<b>Fim Implantação:</b> <?php echo $mattuss[0]->get_fim_implantacao(); ?><br>
					<b>Código do Termo:</b> <?php echo $mattuss[0]->get_codigo_termo(); ?><br>
				</div>
			<?php } ?>
			<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;padding-top:10px;margin-top:10px;">
				<h3 class="panel-title" style="font-size:17px;">TNUM</h3>
				<hr style="margin-top:10px;margin-bottom:15px;" />
			</div>
			<?php if (isset($mattnum[0])){ ?>
				<div style="margin-left:5%;margin-right:5%;width:90%;">
					<b>Nome:</b> <?php echo $mattnum[0]->get_nome(); ?><br>
					<b>Código TISS:</b> <?php echo $mattnum[0]->get_cod_tiss(); ?><br>
					<b>Nome Comercial:</b> <?php echo $mattnum[0]->get_nome_comercial(); ?><br>
					<b>Tamanho / Modelo:</b> <?php echo $mattnum[0]->get_ref_tamanhomodelo(); ?><br>
					<b>Início da Vigência:</b> <?php echo $mattnum[0]->get_inicio_vigencia(); ?><br>
					<b>Fim da Vigência:</b> <?php echo $mattnum[0]->get_fim_vigencia(); ?><br>
					<b>Motivo da Inserção:</b> <?php echo $mattnum[0]->get_motivo_insercao(); ?><br>
					<b>Fim da Implantação:</b> <?php echo $mattnum[0]->get_fim_implantacao(); ?><br>
					<b>Descrição SIMPRO:</b> <?php echo $mattnum[0]->get_descricaoproduto_simpro(); ?><br>
					<b>Equivalência Técnica:</b> <?php echo $mattnum[0]->get_equivalencia_tecnica(); ?><br>
				</div>
			<?php }
		}
	}
	if (intval($_POST["request"]) == 12){
		if (isset($_POST["content"])){ echo md5($_POST["content"]); }
	}
	if (intval($_POST["request"]) == 13){
		if (isset($_POST["whereclause"])){
			$DAOOperadora = new Operadora_DAO();
			$operadoras = $DAOOperadora->select_all(null, "id, nome, codans, cnpj, email, contato, login, senha", $_POST["whereclause"]);
			?>
			<div class="panel-body">
				<table id="table-materiais" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="font-size:14px;">Nome</th>
							<th style="font-size:14px;">E-mail</th>
							<th style="font-size:14px;">Telefone</th>
							<th style="width:10%;font-size:14px;">Editar</th>
							<th style="width:10%;padding-left:8px;font-size:14px;">Excluir</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($operadoras as $operadora){
								echo "<tr>
									<td style=\"font-size:14px;\">".(is_null($operadora->get_nome()) ? "" : $operadora->get_nome())."</td>
									<td style=\"font-size:14px;\">".(is_null($operadora->get_email()) ? "" : $operadora->get_email())."</td>
									<td style=\"font-size:14px;\">".(is_null($operadora->get_contato()) ? "" : $operadora->get_contato())."</td>
									<td align=\"center\" style=\"width:10%;font-size:14px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openEditarOperadora('".$operadora->get_id()."', '".$operadora->get_nome()."', '".(is_null($operadora->get_codans()) ? "" : $operadora->get_codans())."', '".$operadora->get_cnpj()."', '".$operadora->get_email()."', '".$operadora->get_contato()."', '".$operadora->get_login()."', '".$operadora->get_senha()."')\"> Editar </button></td>
									<td align=\"center\" style=\"width:10%;padding-left:8px;font-size:14px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirOperadora('".$operadora->get_id()."')\"> Excluir </button></td>
								</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-12" align="center">
						<button onclick="openAddOperadora();" class="btn btnlarge btn-success"> Cadastrar Operadora </button>
					</div>
				</div>
			</div>
			<?php
		}
	}
	if (intval($_POST["request"]) == 14){
		if ((isset($_POST["type"]))and(isset($_FILES['file']['name']))){
			$data = "".date("Y-m-d H:i:s");
			$filepath = $path_upload.$_FILES['file']['name'];
			$cryptodata = "".md5($data);
			$filepath = str_replace (".xls", "_".$cryptodata.".xls", $filepath);
			$filepath = str_replace (".csv", "_".$cryptodata.".csv", $filepath);

			if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)){
				chmod ($filepath, 0777);
				$DAOArquivo = new Arquivo_DAO();
				$newarquivo = new Arquivo();
				$newarquivo->set_file_type (intval($_POST["type"]));
				$newarquivo->set_caminho ($filepath);
				$newarquivo->set_status (0);
				$newarquivo->set_data ($data);

				$medtab_DAO = new MedTab_DAO();
				$mattab_DAO = new MatTab_DAO();
				$medtab = new MedTab();
				$mattab = new MatTab();

				if (intval($_POST["type"]) == 0){ $newarquivo->set_tab_type (0); }
				else {
					if ((intval($_POST["type"]) >= 1)and(intval($_POST["type"]) <= 4)){
						$newarquivo->set_tab_type (1);
						if (isset($_POST["idtabela"])){ $medtab->set_id ($_POST["idtabela"]); }
						else {
							$medtab->set_nome ("Tabela Administrativa de Medicamentos - ".date("d/m/Y"));
							$medtab->set_OPERADORA (new Operadora());
							$medtab->set_MEDTAB (new MedTab());
							$medtab->set_data ($data);
							$medtab->set_id ($medtab_DAO->insert ($medtab));
						}
						$newarquivo->set_MEDTAB ($medtab);
					} else {
						$newarquivo->set_tab_type (2);
						if (isset($_POST["idtabela"])){ $mattab->set_id ($_POST["idtabela"]); }
						else {
							$mattab->set_nome ("Tabela Administrativa de Materiais - ".date("d/m/Y"));
							$mattab->set_OPERADORA (new Operadora());
							$mattab->set_MATTAB (new MatTab());
							$mattab->set_data ($data);
							$mattab->set_id ($mattab_DAO->insert ($mattab));
						}
						$newarquivo->set_MATTAB ($mattab);
					}
				}

				$DAOArquivo->insert ($newarquivo);
				echo "Sucess";
			} else { echo "Error"; }
		} else { echo "Error"; }
	}
	if (intval($_POST["request"]) == 15){
		if (isset($_POST["whereclause"])){
			$DAOArquivo = new Arquivo_DAO();
			$arquivos = $DAOArquivo->select_all(null, "id, file_type, caminho, data, status", $_POST["whereclause"]);
			?>
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
						<?php
							foreach ($arquivos as $arquivo){
								$typee = "";
								if ($arquivo->get_file_type() == 0){ $typee = "CNES"; }
								if ($arquivo->get_file_type() == 1){ $typee = "CMED (PMC)"; }
								if ($arquivo->get_file_type() == 2){ $typee = "CMED (PMVG)"; }
								if ($arquivo->get_file_type() == 3){ $typee = "TUSS (Medicamentos)"; }
								if ($arquivo->get_file_type() == 4){ $typee = "TNUM (Medicamentos)"; }
								if ($arquivo->get_file_type() == 5){ $typee = "TUSS (Materiais)"; }
								if ($arquivo->get_file_type() == 6){ $typee = "TNUM (Materiais)"; }

								$statuss = "";
								if ($arquivo->get_status() == 0){ $statuss = "Pendente"; }
								if ($arquivo->get_status() == 1){ $statuss = "Processando"; }
								if ($arquivo->get_status() == 2){ $statuss = "Concluído"; }
								if ($arquivo->get_status() == 3){ $statuss = "Erro"; }

								$original = $arquivo->get_caminho();
								$posunder = strripos ($original, "_");
								$pospoint = strripos ($original, ".");
								$suborigi = substr ($original, $posunder, $pospoint - $posunder);
								$namecami = str_replace ($suborigi, "", $original);
								$posbarr = strripos ($namecami, "/");
								$suborigi = substr ($namecami, 0, $posbarr+1);
								$namecami = str_replace ($suborigi, "", $namecami);

								echo "<tr>
									<td style=\"width:17%;font-size:14px;padding-left:8px;\">".(is_null($typee)?"":$typee)."</td>
									<td style=\"width:44%;font-size:14px;\">".(is_null($namecami) ? "" : $namecami)."</td>
									<td style=\"width:15%;font-size:14px;\">".(is_null($arquivo->get_data()) ? "" : $arquivo->get_data())."</td>
									<td style=\"width:12%;font-size:14px;\">".(is_null($statuss) ? "" : $statuss)."</td>
									<td align=\"center\" style=\"width:12%;font-size:14px;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"downloadArquivo('".$original."', '".$namecami."')\"> Download </button></td>
								</tr>";
							}
						?>
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
			<?php
		}
	}
	if (intval($_POST["request"]) == 16){
		if ((isset($_POST["original"]))&&(isset($_POST["name"]))){
			$name_curr = str_replace("util", "archives", dirname (__FILE__)).'\\['.date("Y-m-d H_i_s").'] '.$_POST["name"];
			copy($_POST["original"], $name_curr);
			echo '['.date("Y-m-d H_i_s").'] '.$_POST["name"];
		}
	}
	if (intval($_POST["request"]) == 17){
		if ((isset($_POST["id_medtab"]))&&(isset($_POST["id_prest"]))){
			$DAOMedTab = new MedTab_DAO();

			$ids_medtab = array ();
			$medtab = $DAOMedTab->select_id ($_POST["id_medtab"]);

			$curr_medtab = $medtab;
			array_push ($ids_medtab, $curr_medtab->get_id());
			while (!is_null($curr_medtab->get_MEDTAB())){
				$curr_medtab = $DAOMedTab->select_id ($curr_medtab->get_MEDTAB()->get_id());
				array_push ($ids_medtab, $curr_medtab->get_id());
			}

			$fields = $medtab->get_fields();
			if ((preg_match("/pf_preco/", $fields))||(preg_match("/pmc_preco/", $fields))||(preg_match("/pmvg_preco/", $fields))){
				if (preg_match("/pf_preco/", $fields)){
					$alicofloat = $medtab->get_pf_alicota();
					$alicota = "";
					if (is_null($alicofloat)){ $alicota .= "semimpostos"; }
					else {
						switch ($alicofloat){
							case 0: $alicota .= "zero"; break;
							case 1: $alicota .= "doze"; break;
							case 2: $alicota .= "dezessete"; break;
							case 3: $alicota .= "dezessete_alc"; break;
							case 4: $alicota .= "dezessetemeio"; break;
							case 5: $alicota .= "dezessetemeio_alc"; break;
							case 6: $alicota .= "dezoito"; break;
							case 7: $alicota .= "dezoito_alc"; break;
							case 8: $alicota .= "vinte"; break;
							default: $alicota .= "semimpostos"; break;
						}
					}

					$fields = str_replace("pf_preco", "pf_".$alicota." AS pf_semimpostos", $fields);
				}

				if (preg_match("/pmc_preco/", $fields)){
					$alicofloat = $medtab->get_pmc_alicota();
					$alicota = "";
					if (is_null($alicofloat)){ $alicota .= "zero"; }
					else {
						switch ($alicofloat){
							case 0: $alicota .= "doze"; break;
							case 1: $alicota .= "dezessete"; break;
							case 2: $alicota .= "dezessete_alc"; break;
							case 3: $alicota .= "dezessetemeio"; break;
							case 4: $alicota .= "dezessetemeio_alc"; break;
							case 5: $alicota .= "dezoito"; break;
							case 6: $alicota .= "dezoito_alc"; break;
							case 7: $alicota .= "vinte"; break;
							default: $alicota .= "zero"; break;
						}
					}

					$fields = str_replace("pmc_preco", "pmc_".$alicota." AS pmc_zero", $fields);
				}

				if (preg_match("/pmvg_preco/", $fields)){
					$alicofloat = $medtab->get_pmvg_alicota();
					$alicota = "";
					if (is_null($alicofloat)){ $alicota .= "semimpostos"; }
					else {
						switch ($alicofloat){
							case 0: $alicota .= "zero"; break;
							case 1: $alicota .= "doze"; break;
							case 2: $alicota .= "dezessete"; break;
							case 3: $alicota .= "dezessete_alc"; break;
							case 4: $alicota .= "dezessetemeio"; break;
							case 5: $alicota .= "dezessetemeio_alc"; break;
							case 6: $alicota .= "dezoito"; break;
							case 7: $alicota .= "dezoito_alc"; break;
							case 8: $alicota .= "vinte"; break;
							default: $alicota .= "semimpostos"; break;
						}
					}

					$fields = str_replace("pmvg_preco", "pmvg_".$alicota." AS pmvg_semimpostos", $fields);
				}
			}

			$results = $DAOMedTab->select_full_table ($ids_medtab, null, "DISTINCT ".$fields, null);
			$content = array();

			$fieldsjson = file_get_contents ('variables.json');
			$json = json_decode ($fieldsjson);
			$expfields = explode (", ", str_replace(".", "", $medtab->get_fields()));
			$first_line = array();
			foreach ($expfields as $expfield){
				foreach($json->medicamento as $item){
					if (preg_match("/".$expfield."/", $item)){
						$title = str_replace($expfield.";", "", $item);
						array_push ($first_line, $title);
					}
				}
			}

			array_push ($content, $first_line);
			foreach ($results as $result){
				$line = array();
				if (preg_match("/tb_medicamento.id/", $fields)){ array_push ($line, "".$result[0]->get_id()); }
				if (preg_match("/tb_medicamento.substancia/", $fields)){ array_push ($line, "".$result[0]->get_substancia()); }
				if (preg_match("/tb_medicamento.cnpj/", $fields)){ array_push ($line, "".$result[0]->get_cnpj()); }
				if (preg_match("/tb_medicamento.laboratorio/", $fields)){ array_push ($line, "".$result[0]->get_laboratorio()); }
				if (preg_match("/tb_medicamento.codggrem/", $fields)){ array_push ($line, "".$result[0]->get_codggrem()); }
				if (preg_match("/tb_medicamento.produto/", $fields)){ array_push ($line, "".$result[0]->get_produto()); }
				if (preg_match("/tb_medicamento.apresentacao/", $fields)){ array_push ($line, "".$result[0]->get_apresentacao()); }
				if (preg_match("/tb_medicamento.classe_terapeutica/", $fields)){ array_push ($line, "".$result[0]->get_classe_terapeutica()); }
				if (preg_match("/tb_medicamento.tipo_produto/", $fields)){ array_push ($line, "".$result[0]->get_tipo_produto()); }
				if (preg_match("/tb_medicamento.tarja/", $fields)){ array_push ($line, "".$result[0]->get_tarja()); }
				if (preg_match("/tb_medicamento.cod_termo/", $fields)){ array_push ($line, "".$result[0]->get_cod_termo()); }
				if (preg_match("/tb_medicamento.generico/", $fields)){ array_push ($line, "".$result[0]->get_generico()); }
				if (preg_match("/tb_medicamento.grupo_farmacologico/", $fields)){ array_push ($line, "".$result[0]->get_grupo_farmacologico()); }
				if (preg_match("/tb_medicamento.classe_farmacologica/", $fields)){ array_push ($line, "".$result[0]->get_classe_farmacologica()); }
				if (preg_match("/tb_medicamento.forma_farmaceutica/", $fields)){ array_push ($line, "".$result[0]->get_forma_farmaceutica()); }
				if (preg_match("/tb_medicamento.unidmin_fracao/", $fields)){ array_push ($line, "".$result[0]->get_unidmin_fracao()); }
				if (preg_match("/tb_cmed.ean_um/", $fields)){ array_push ($line, "".$result[1]->get_ean_um()); }
				if (preg_match("/tb_cmed.ean_dois/", $fields)){ array_push ($line, "".$result[1]->get_ean_dois()); }
				if (preg_match("/tb_cmed.ean_tres/", $fields)){ array_push ($line, "".$result[1]->get_ean_tres()); }
				if (preg_match("/tb_cmed.regime_preco/", $fields)){ array_push ($line, "".$result[1]->get_regime_preco()); }
				if (preg_match("/tb_cmed.pf_preco/", $fields)){ array_push ($line, "".$result[1]->get_pf_semimpostos()); }
				if (preg_match("/tb_cmed.pmc_preco/", $fields)){ array_push ($line, "".$result[1]->get_pmc_zero()); }
				if (preg_match("/tb_cmed.pmvg_preco/", $fields)){ array_push ($line, "".$result[1]->get_pmvg_semimpostos()); }
				if (preg_match("/tb_cmed.restricao_hospitalar/", $fields)){ array_push ($line, "".$result[1]->get_restricao_hospitalar()); }
				if (preg_match("/tb_cmed.cap/", $fields)){ array_push ($line, "".$result[1]->get_cap()); }
				if (preg_match("/tb_cmed.confaz_oitosete/", $fields)){ array_push ($line, "".$result[1]->get_confaz_oitosete()); }
				if (preg_match("/tb_cmed.icms_zero/", $fields)){ array_push ($line, "".$result[1]->get_icms_zero()); }
				if (preg_match("/tb_cmed.analise_recursal/", $fields)){ array_push ($line, "".$result[1]->get_analise_recursal()); }
				if (preg_match("/tb_cmed.lista_ctributario/", $fields)){ array_push ($line, "".$result[1]->get_lista_ctributario()); }
				if (preg_match("/tb_cmed.comercializacao/", $fields)){ array_push ($line, "".$result[1]->get_comercializacao()); }
				if (preg_match("/tb_medtuss.inicio_vigencia/", $fields)){ array_push ($line, "".$result[2]->get_inicio_vigencia()); }
				if (preg_match("/tb_medtuss.fim_vigencia/", $fields)){ array_push ($line, "".$result[2]->get_fim_vigencia()); }
				if (preg_match("/tb_medtuss.fim_implantacao/", $fields)){ array_push ($line, "".$result[2]->get_fim_implantacao()); }
				if (preg_match("/tb_medtnum.cod_tiss/", $fields)){ array_push ($line, "".$result[3]->get_cod_tiss()); }
				if (preg_match("/tb_medtnum.observacoes/", $fields)){ array_push ($line, "".$result[3]->get_observacoes()); }
				if (preg_match("/tb_medtnum.cod_anterior/", $fields)){ array_push ($line, "".$result[3]->get_cod_anterior()); }
				if (preg_match("/tb_medtnum.tipo_produto/", $fields)){ array_push ($line, "".$result[3]->get_tipo_produto()); }
				if (preg_match("/tb_medtnum.tipo_codificacao/", $fields)){ array_push ($line, "".$result[3]->get_tipo_codificacao()); }
				if (preg_match("/tb_medtnum.inicio_vigencia/", $fields)){ array_push ($line, "".$result[3]->get_inicio_vigencia()); }
				if (preg_match("/tb_medtnum.fim_vigencia/", $fields)){ array_push ($line, "".$result[3]->get_fim_vigencia()); }
				if (preg_match("/tb_medtnum.motivo_insercao/", $fields)){ array_push ($line, "".$result[3]->get_motivo_insercao()); }
				if (preg_match("/tb_medtnum.fim_implantacao/", $fields)){ array_push ($line, "".$result[3]->get_fim_implantacao()); }
				if (preg_match("/tb_medtnum.cod_tissbrasindice/", $fields)){ array_push ($line, "".$result[3]->get_cod_tissbrasindice()); }
				if (preg_match("/tb_medtnum.descricao_brasindice/", $fields)){ array_push ($line, "".$result[3]->get_descricao_brasindice()); }
				if (preg_match("/tb_medtnum.apresentacao_brasindice/", $fields)){ array_push ($line, "".$result[3]->get_apresentacao_brasindice()); }
				if (preg_match("/tb_medtnum.pertence_confaz/", $fields)){ array_push ($line, "".$result[3]->get_pertence_confaz()); }
				array_push ($content, $line);
			}

			if (intval($medtab->get_format_type()) < 10){
				$text = "";
				foreach ($content as $cont){
					foreach ($cont as $item){
						if (strcasecmp($item, "null") == 0){ $text .= ";"; }
						else{ $text .= str_replace(";", ",", $item).";"; }
					}
					$text .= "\n"; 
				}

				$namefile = str_replace("util", "archives", dirname (__FILE__))."\\";
				$posnamefile = "[".date("Y-m-d H_i_s")."][".$_POST["id_prest"]."][".$_POST["id_medtab"]."] ";
				$posnamefile .= str_replace("/", "", $medtab->get_nome()).".csv";
				$namefile .= $posnamefile;

				$arq = fopen ($namefile, 'w');
				if ($arq == false){ echo "Erro"; }
				else {
					fwrite ($arq, $text);
					fclose($arq);
					echo $posnamefile.";[Medicamentos] ".str_replace("/", "", $medtab->get_nome()).".csv";
				}
			}
		}
	}
	if (intval($_POST["request"]) == 18){
		if (isset($_POST["whereclause"])){
			$DAOTabela = new Tabela_DAO();
			$where = "tb_prestadora.id_operadora = ".$_SESSION["healthcare-user"]["id"]." AND ".$_POST["whereclause"];
			$tabelas = $DAOTabela->select_full (null, $where);
			?>
			<div class="panel-body">
				<table id="table-materiais" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="width:12%;font-size:14px;padding-left:8px;">Tipo</th>
							<th style="width:40%;font-size:14px;">Nome da Tabela</th>
							<th style="width:24%;font-size:14px;">Prestador</th>
							<th style="width:14%;font-size:14px;">CPF/CNPJ</th>
							<th style="width:10%;font-size:14px;padding-left:8px;">Excluir</th>
						</tr>
					</thead>
					<tbody>
					<?php
						foreach ($tabelas as $tabela){
							if (intval($tabela->get_PRESTADORA()->get_OPERADORA()->get_id()) == intval($_SESSION["healthcare-user"]["id"])){
								echo "<tr>";
								if (!is_null($tabela->get_MEDTAB())){
									echo "<td style=\"width:12%;font-size:14px;padding-left:8px;\">Medicamentos</td>
									<td style=\"width:40%;font-size:14px;\">".strtoupper(substr($tabela->get_MEDTAB()->get_nome(), 0, 50))."</td>";
								} else {
									echo "<td style=\"width:12%;font-size:14px;padding-left:8px;\">Materiais</td>
									<td style=\"width:40%;font-size:14px;\">".strtoupper(substr($tabela->get_MATTAB()->get_nome(), 0, 50))."</td>";
								}

								$cnes = $tabela->get_PRESTADORA()->get_CNES();
								echo "<td style=\"width:24%;font-size:14px;\">".(is_null($cnes->get_no_fantasia()) ? "" : strtoupper(substr($cnes->get_no_fantasia(), 0, 30)))."</td>";

								$cnpj = $cnes->get_cnpj();
								if (!is_null($cnpj)){
									if (intval($cnpj) > 0){ echo "<td style=\"width:14%;font-size:14px;\">".(is_null($cnes->get_cnpj()) ? "" : $cnes->get_cnpj())."</td>"; }
									else { echo "<td style=\"width:14%;font-size:14px;\">".(is_null($cnes->get_cpf()) ? "" : $cnes->get_cpf())."</td>"; }
								} else { echo "<td style=\"width:14%;font-size:14px;\">".(is_null($cnes->get_cpf()) ? "" : $cnes->get_cpf())."</td>"; }

								echo "<td align=\"center\" style=\"width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirTabela('".$tabela->get_id()."')\"> Excluir </button></td>
								</tr>";
							}
						}
					?>
					</tbody>
				</table>
			</div>
			<?php
		}
	}
	if (intval($_POST["request"]) == 19){
		if ((isset($_POST["whereclause"]))&&(isset($_POST["typetab"]))){
			$usert = $_SESSION["healthcare-type-user"];
			$DAOMedTab = new MedTab_DAO();
			$DAOMatTab = new MatTab_DAO();
			$tabelas = array();

			if (intval($usert) != 2){
				$whereclausenull = "ISNULL(id_operadora) AND ".$_POST["whereclause"];
				$whereclauseope = "(id_operadora = ".$_SESSION["healthcare-user"]["id"].") AND ".$_POST["whereclause"];

				if ((intval($_POST["typetab"]) == -1)||(intval($_POST["typetab"]) == 0)){
					$opemed = new Operadora();
					$opemed->set_id("0");
					$opemed->set_nome("null");

					$aux = $DAOMedTab->select_all(null, null, $whereclausenull);
					foreach ($aux as $a){
						$a->set_OPERADORA($opemed);
						array_push ($tabelas, $a);
					}

					if ($usert != 0){
						$opemed = new Operadora();
						$opemed->set_id("0");
						$opemed->set_nome("notnull");

						$aux = $DAOMedTab->select_all(null, null, $whereclauseope);
						foreach ($aux as $a){
							$a->set_OPERADORA($opemed);
							$a->get_OPERADORA()->set_nome("notnull");
							array_push ($tabelas, $a);
						}
					}
				}

				if ((intval($_POST["typetab"]) == -1)||(intval($_POST["typetab"]) == 1)){
					$opemat = new Operadora();
					$opemat->set_id("1");
					$opemat->set_nome("null");

					$aux = $DAOMatTab->select_all(null, null, $whereclausenull);
					foreach ($aux as $a){
						$a->set_OPERADORA($opemat);
						array_push ($tabelas, $a);
					}

					if ($usert != 0){
						$opemat = new Operadora();
						$opemat->set_id("1");
						$opemat->set_nome("notnull");

						$aux = $DAOMatTab->select_all(null, null, $whereclauseope);
						foreach ($aux as $a){
							$a->set_OPERADORA($opemat);
							$a->get_OPERADORA()->set_nome("notnull");
							array_push ($tabelas, $a);
						}
					}
				}
			} else {
				$DAOTabela = new Tabela_DAO();
				$presttabelas = $DAOTabela->select_by_Prestadora ($_SESSION["healthcare-user"]["currop"]["idprest"]);
				foreach ($presttabelas as $prestt) {
					if (intval($prestt->get_type()) == 0){
						$prestt->get_MEDTAB()->set_OPERADORA(new Operadora());
						$prestt->get_MEDTAB()->get_OPERADORA()->set_id(0);

						$exist = false;
						foreach ($tabelas as $tab){
							if ((intval($tab->get_id()) == intval($prestt->get_MEDTAB()->get_id()))&&
								(intval($tab->get_OPERADORA()->get_id())) == 0){
								$exist = true;
							}
						}
						if ($exist == false){ array_push ($tabelas, $prestt->get_MEDTAB()); }
					} else {
						$prestt->get_MATTAB()->set_OPERADORA(new Operadora());
						$prestt->get_MATTAB()->get_OPERADORA()->set_id(1);

						$exist = false;
						foreach ($tabelas as $tab){
							if ((intval($tab->get_id()) == intval($prestt->get_MATTAB()->get_id()))&&
								(intval($tab->get_OPERADORA()->get_id())) == 1){
								$exist = true;
							}
						}
						if ($exist == false){ array_push ($tabelas, $prestt->get_MATTAB()); }
					}
				}
			}
			?>
			<div class="panel-body">
				<table id="table_tabelas" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="font-size:14px;padding-left:8px;">Tipo</th>
							<th style="font-size:14px;">ID</th>
							<th style="font-size:14px;">Nome</th>
							<th style="font-size:14px;">Data</th>
							<?php if (intval($usert) != 2){ ?>
							<th style="font-size:14px;width:12%;">Visualizar</th>
							<th style="font-size:14px;width:10%;">Excluir</th>
							<th style="font-size:14px;width:10%;padding-left:8px;">Editar</th>
							<?php } else { ?>
							<th style="font-size:14px;width:12%;padding-left:8px;">Visualizar</th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($tabelas as $tabela){
								$edtv = "";
								echo "<tr>";
								if (intval($tabela->get_OPERADORA()->get_id()) == 0){
									echo "<td style=\"font-size:14px;padding-left:8px;\">Medicamentos</td>";
									if (intval($usert) != 2){
										$edtv .= "".(is_null($tabela->get_id()) ? "" : $tabela->get_id());
										$edtv .= ";".(is_null($tabela->get_nome()) ? "" : $tabela->get_nome());
										$edtv .= ";".(is_null($tabela->get_deflator()) ? "" : floatval(floatval($tabela->get_deflator()) - floatval(1))*floatval(100));
										$edtv .= ";".(is_null($tabela->get_pf_alicota()) ? "-1" : $tabela->get_pf_alicota());
										$edtv .= ";".(is_null($tabela->get_pmc_alicota()) ? "-1" : $tabela->get_pmc_alicota());
										$edtv .= ";".(is_null($tabela->get_pmvg_alicota()) ? "-1" : $tabela->get_pmvg_alicota());
										$edtv .= ";".(is_null($tabela->get_OPERADORA()) ? "" : $tabela->get_OPERADORA()->get_id());
										$edtv .= ";".(is_null($tabela->get_MEDTAB()) ? "-1" : $tabela->get_MEDTAB()->get_id());
										$edtv .= ";".(is_null($tabela->get_data()) ? "" : $tabela->get_data());
										$edtv .= ";".(is_null($tabela->get_fields()) ? "" : $tabela->get_fields());
										$edtv .= ";".(is_null($tabela->get_format_type()) ? "-1" : $tabela->get_format_type());
									}
								} else {
									echo "<td style=\"font-size:14px;padding-left:8px;\">Materiais</td>";
									if (intval($usert) != 2){
										$edtv .= "".(is_null($tabela->get_id()) ? "" : $tabela->get_id());
										$edtv .= ";".(is_null($tabela->get_nome()) ? "" : $tabela->get_nome());
										$edtv .= ";".(is_null($tabela->get_deflator()) ? "" : floatval(floatval($tabela->get_deflator()) - floatval(1))*floatval(100));
										$edtv .= ";".(is_null($tabela->get_OPERADORA()) ? "" : $tabela->get_OPERADORA()->get_id());
										$edtv .= ";".(is_null($tabela->get_MATTAB()) ? "-1" : $tabela->get_MATTAB()->get_id());
										$edtv .= ";".(is_null($tabela->get_data()) ? "" : $tabela->get_data());
										$edtv .= ";".(is_null($tabela->get_fields()) ? "" : $tabela->get_fields());
										$edtv .= ";".(is_null($tabela->get_format_type()) ? "-1" : $tabela->get_format_type());
									}
								}

								echo "<td style=\"font-size:14px;\">".(is_null($tabela->get_id()) ? "" : $tabela->get_id())."</td>
									<td style=\"font-size:14px;\">".(is_null($tabela->get_nome()) ? "" : $tabela->get_nome())."</td>
									<td style=\"font-size:14px;\">".(is_null($tabela->get_data()) ? "" : $tabela->get_data())."</td>
									<td align=\"center\" style=\"font-size:14px;width:12%;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openVisualizarTabela('".$tabela->get_id()."', '".$tabela->get_nome()."', '".$tabela->get_data()."', '".$tabela->get_OPERADORA()->get_id()."', '".(is_null($tabela->get_format_type()) ? "-1" : $tabela->get_format_type())."')\"> Visualizar </button></td>";

								if (intval($usert) != 2){
									if ((strcasecmp($tabela->get_OPERADORA()->get_nome(), "null") == 0)&&($usert != 0)){
										echo "<td align=\"center\" style=\"font-size:14px;width:10%;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirTabela('".$tabela->get_id()."', '".$tabela->get_OPERADORA()->get_id()."')\" disabled> Excluir </button></td><td align=\"center\" style=\"font-size:14px;width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openEditarTabela('".$tabela->get_OPERADORA()->get_id()."', '".$edtv."')\" disabled> Editar </button></td>";
									} else {
										echo "<td align=\"center\" style=\"font-size:14px;width:10%;\"><button class=\"btn btn-sm btn-danger\" onclick=\"excluirTabela('".$tabela->get_id()."', '".$tabela->get_OPERADORA()->get_id()."')\"> Excluir </button></td><td align=\"center\" style=\"font-size:14px;width:10%;padding-left:8px;\"><button class=\"btn btn-sm btn-info\" onclick=\"openEditarTabela('".$tabela->get_OPERADORA()->get_id()."', '".$edtv."')\"> Editar </button></td>";
									}
								}

								echo "</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
			<?php
		}
	}
	if (intval($_POST["request"]) == 20){
		if ((isset($_POST["id_mattab"]))&&(isset($_POST["id_prest"]))){
			$DAOMatTab = new MatTab_DAO();

			$ids_mattab = array ();
			$mattab = $DAOMatTab->select_id ($_POST["id_mattab"]);

			$curr_mattab = $mattab;
			array_push ($ids_mattab, $curr_mattab->get_id());
			while (!is_null($curr_mattab->get_MATTAB())){
				$curr_mattab = $DAOMatTab->select_id ($curr_mattab->get_MATTAB()->get_id());
				array_push ($ids_mattab, $curr_mattab->get_id());
			}

			$fields = $mattab->get_fields();
			$results = $DAOMatTab->select_full_table ($ids_mattab, null, "DISTINCT ".$fields, null);
			$content = array();

			$fieldsjson = file_get_contents ('variables.json');
			$json = json_decode ($fieldsjson);
			$expfields = explode (", ", str_replace(".", "", $mattab->get_fields()));
			$first_line = array();
			foreach ($expfields as $expfield){
				foreach($json->material as $item){
					if (preg_match("/".$expfield."/", $item)){
						$title = str_replace($expfield.";", "", $item);
						array_push ($first_line, $title);
					}
				}
			}

			array_push ($content, $first_line);
			foreach ($results as $result){
				$line = array();
				if (preg_match("/tb_material.id/", $fields)){ array_push ($line, "".$result[0]->get_id()); }
				if (preg_match("/tb_material.cnpj/", $fields)){ array_push ($line, "".$result[0]->get_cnpj()); }
				if (preg_match("/tb_material.fabricante/", $fields)){ array_push ($line, "".$result[0]->get_fabricante()); }
				if (preg_match("/tb_material.classe_risco/", $fields)){ array_push ($line, "".$result[0]->get_classe_risco()); }
				if (preg_match("/tb_material.descricao_produto/", $fields)){ array_push ($line, "".$result[0]->get_descricao_produto()); }
				if (preg_match("/tb_material.especialidade_produto/", $fields)){ array_push ($line, "".$result[0]->get_especialidade_produto()); }
				if (preg_match("/tb_material.classificacao_produto/", $fields)){ array_push ($line, "".$result[0]->get_classificacao_produto()); }
				if (preg_match("/tb_material.nome_tecnico/", $fields)){ array_push ($line, "".$result[0]->get_nome_tecnico()); }
				if (preg_match("/tb_material.unidmin_fracao/", $fields)){ array_push ($line, "".$result[0]->get_unidmin_fracao()); }
				if (preg_match("/tb_material.tipo_produto/", $fields)){ array_push ($line, "".$result[0]->get_tipo_produto()); }


				if (preg_match("/tb_mattnum.id/", $fields)){ array_push ($line, "".$result[1]->get_id()); }
				if (preg_match("/tb_mattnum.nome/", $fields)){ array_push ($line, "".$result[1]->get_nome()); }
				if (preg_match("/tb_mattnum.cod_tiss/", $fields)){ array_push ($line, "".$result[1]->get_cod_tiss()); }
				if (preg_match("/tb_mattnum.nome_comercial/", $fields)){ array_push ($line, "".$result[1]->get_nome_comercial()); }
				if (preg_match("/tb_mattnum.observaces/", $fields)){ array_push ($line, "".$result[1]->get_observaces()); }
				if (preg_match("/tb_mattnum.cod_anterior/", $fields)){ array_push ($line, "".$result[1]->get_cod_anterior()); }
				if (preg_match("/tb_mattnum.ref_tamanhomodelo/", $fields)){ array_push ($line, "".$result[1]->get_ref_tamanhomodelo()); }
				if (preg_match("/tb_mattnum.tipo_codificacao/", $fields)){ array_push ($line, "".$result[1]->get_tipo_codificacao()); }
				if (preg_match("/tb_mattnum.inicio_vigencia/", $fields)){ array_push ($line, "".$result[1]->get_inicio_vigencia()); }
				if (preg_match("/tb_mattnum.fim_vigencia/", $fields)){ array_push ($line, "".$result[1]->get_fim_vigencia()); }
				if (preg_match("/tb_mattnum.motivo_insercao/", $fields)){ array_push ($line, "".$result[1]->get_motivo_insercao()); }
				if (preg_match("/tb_mattnum.fim_implantacao/", $fields)){ array_push ($line, "".$result[1]->get_fim_implantacao()); }
				if (preg_match("/tb_mattnum.cod_simpro/", $fields)){ array_push ($line, "".$result[1]->get_cod_simpro()); }
				if (preg_match("/tb_mattnum.descricaoproduto_simpro/", $fields)){ array_push ($line, "".$result[1]->get_descricaoproduto_simpro()); }
				if (preg_match("/tb_mattnum.equivalencia_tecnica/", $fields)){ array_push ($line, "".$result[1]->get_equivalencia_tecnica()); }
				array_push ($content, $line);
			}

			if (intval($mattab->get_format_type()) < 10){
				$text = "";
				foreach ($content as $cont){
					foreach ($cont as $item){
						if (strcasecmp($item, "null") == 0){ $text .= ";"; }
						else{ $text .= str_replace(";", ",", $item).";"; }
					}
					$text .= "\n"; 
				}

				$namefile = str_replace("util", "archives", dirname (__FILE__))."\\";
				$posnamefile = "[".date("Y-m-d H_i_s")."][".$_POST["id_prest"]."][".$_POST["id_mattab"]."] ";
				$posnamefile .= str_replace("/", "", $mattab->get_nome()).".csv";
				$namefile .= $posnamefile;

				$arq = fopen ($namefile, 'w');
				if ($arq == false){ echo "Erro"; }
				else {
					fwrite ($arq, $text);
					fclose($arq);
					echo $posnamefile.";[Materiais] ".str_replace("/", "", $mattab->get_nome()).".csv";
				}
			}
		}
	}
	if (intval($_POST["request"]) == 21){
		if (isset($_POST["id_medicamento"])){
			$DAOMedicamento = new Medicamento_DAO;
			$medicamento = $DAOMedicamento->select_id ($_POST["id_medicamento"]);
			?>
			<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;padding-top:0px;">
				<b>Substância:</b> <?php echo $medicamento->get_substancia(); ?><br>
				<b>CNPJ:</b> <?php echo $medicamento->get_cnpj(); ?><br>
				<b>Laboratório:</b> <?php echo $medicamento->get_laboratorio(); ?><br>
				<b>Codggrem:</b> <?php echo $medicamento->get_codggrem(); ?><br>
				<b>Produto:</b> <?php echo $medicamento->get_produto(); ?><br>
				<b>Apresentação:</b> <?php echo $medicamento->get_apresentacao(); ?><br>
				<b>Classe Terapêutica:</b> <?php echo $medicamento->get_classe_terapeutica(); ?><br>
				<b>Tipo de Produto:</b> <?php echo $medicamento->get_tipo_produto(); ?><br>
				<b>Tarja:</b> <?php echo $medicamento->get_tarja(); ?><br>
				<b>Código do Termo:</b> <?php echo $medicamento->get_cod_termo(); ?><br>
				<b>Grupo Farmacológico:</b> <?php echo $medicamento->get_grupo_farmacologico(); ?><br>
				<b>Classe Farmacológica:</b> <?php echo $medicamento->get_classe_farmacologica(); ?><br>
				<b>Forma Farmacêutica:</b> <?php echo $medicamento->get_forma_farmaceutica(); ?><br>
				<b>Unidade mínima:</b> <?php echo $medicamento->get_unidmin_fracao(); ?><br>
			</div>
		<?php }
	}
	if (intval($_POST["request"]) == 22){
		if (isset($_POST["id_material"])){
			$DAOMaterial = new Material_DAO();
			$material = $DAOMaterial->select_id ($_POST["id_material"]);
			?>
			<div style="margin-left:20px;margin-right:20px;padding-bottom:0px;padding-top:0px;">
				<b>CNPJ:</b> <?php echo $material->get_cnpj(); ?><br>
				<b>Fabricante:</b> <?php echo $material->get_fabricante(); ?><br>
				<b>Classe de Risco:</b> <?php echo $material->get_classe_risco(); ?><br>
				<b>Descrição do Produto:</b> <?php echo $material->get_descricao_produto(); ?><br>
				<b>Especialidade do Produto:</b> <?php echo $material->get_especialidade_produto(); ?><br>
				<b>Classificação do Produto:</b> <?php echo $material->get_classificacao_produto(); ?><br>
				<b>Nome Técnico:</b> <?php echo $material->get_nome_tecnico(); ?><br>
				<b>Unidade Mínima:</b> <?php echo $material->get_unidmin_fracao(); ?><br>
				<b>Tipo de Produto:</b> <?php echo $material->get_tipo_produto(); ?><br>
			</div>
		<?php }
	}
	if (intval($_POST["request"]) == 23){
		if (isset($_POST["type"])){
			if (intval($_POST["type"]) == 0){ ?>
				<table id="table-medtab" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="width:5%;font-size:14px;padding-left:8px;">#</th>
							<th style="width:10%;font-size:14px;">ID</th>
							<th style="width:60%;font-size:14px;">Nome</th>
							<th style="width:25%;font-size:14px;">Data</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$DAOMedTab = new MedTab_DAO();
						$tabelasO = $DAOMedTab->select_by_Operadora (null);
						foreach ($tabelasO as $tabela){
							echo "<tr>
								<td style='width:5%;font-size:14px;padding-left:8px;'><input type='radio' name='rd_medtab' value='[".$tabela->get_id()."] ".(is_null($tabela->get_nome()) ? "" : $tabela->get_nome())."'></td>
								<td style='width:10%;font-size:14px;'>".(is_null($tabela->get_id()) ? "" : $tabela->get_id())."</td>
								<td style='width:60%;font-size:14px;'>".(is_null($tabela->get_nome()) ? "" : $tabela->get_nome())."</td>
								<td style='width:25%;font-size:14px;'>".(is_null($tabela->get_data()) ? "" : $tabela->get_data())."</td>
							</tr>";
						}
					?>
					</tbody>
				</table>
			<?php } else { ?>
				<table id="table-mattab" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th style="width:5%;font-size:14px;padding-left:8px;">#</th>
							<th style="width:10%;font-size:14px;">ID</th>
							<th style="width:60%;font-size:14px;">Nome</th>
							<th style="width:25%;font-size:14px;">Data</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$DAOMatTab = new MatTab_DAO();
						$tabelasO = $DAOMatTab->select_by_Operadora (null);
						foreach ($tabelasO as $tabela){
							echo "<tr>
								<td style='width:5%;font-size:14px;padding-left:8px;'><input type='radio' name='rd_mattab' value='[".$tabela->get_id()."] ".(is_null($tabela->get_nome()) ? "" : $tabela->get_nome())."'></td>
								<td style='width:10%;font-size:14px;'>".(is_null($tabela->get_id()) ? "" : $tabela->get_id())."</td>
								<td style='width:60%;font-size:14px;'>".(is_null($tabela->get_nome()) ? "" : $tabela->get_nome())."</td>
								<td style='width:25%;font-size:14px;'>".(is_null($tabela->get_data()) ? "" : $tabela->get_data())."</td>
							</tr>";
						}
					?>
					</tbody>
				</table>
			<?php }
		}
	}
	if (intval($_POST["request"]) == 24){
		if ((isset($_POST["nome"]))&&(isset($_POST["typetabela"]))&&(isset($_POST["idref"]))){
			$operadora = new Operadora();
			if (intval($_POST["typetabela"]) == 0){
				$DAOMedTab = new MedTab_DAO();

				$medtab = new MedTab();
				$medtab->set_nome ($_POST["nome"]);
				$medtab->set_OPERADORA ($operadora);
				$medtab->set_MEDTAB (new MedTab());

				if (isset($_POST["idref"])){
					if (intval($_POST["idref"]) != -1){ $medtab->get_MEDTAB ()->set_id ($_POST["idref"]); }
				}

				$medtab->set_data (date("Y-m-d H:i:s"));
				if (isset($_POST["deflator"])){
					$value = floatval(1)+floatval(floatval(intval($_POST["deflator"]))/floatval(100));
					$medtab->set_deflator("".$value);
				} else { $medtab->set_deflator("1.0"); }

				if ((isset($_POST["typedownload"]))&&(isset($_POST["setfields"]))){
					if (intval($_POST["typedownload"]) != -1){
						$medtab->set_format_type($_POST["typedownload"]);
						$medtab->set_fields($_POST["setfields"]);
					}
				}

				if (intval($_POST["alicota_pf"]) != 0){ $medtab->set_pf_alicota(intval($_POST["alicota_pf"])-1); }
				if (intval($_POST["alicota_pmc"]) != 0){ $medtab->set_pmc_alicota(intval($_POST["alicota_pmc"])-1); }
				if (intval($_POST["alicota_pmvg"]) != 0){ $medtab->set_pmvg_alicota(intval($_POST["alicota_pmvg"])-1); }

				$id = $DAOMedTab->insert ($medtab);
				if (intval($id) == -1){
					$hasMessage = true;
					$message = "Não foi possível cadastrar a nova tabela!";
				}
			} else {
				$DAOMatTab = new MatTab_DAO();

				$mattab = new MatTab();
				$mattab->set_nome ($_POST["nome"]);
				$mattab->set_OPERADORA ($operadora);
				$mattab->set_MATTAB (new MatTab());

				if (isset($_POST["idref"])){
					if (intval($_POST["idref"]) != -1){ $mattab->get_MATTAB ()->set_id ($_POST["idref"]); }
				}

				$mattab->set_data (date("Y-m-d H:i:s"));
				if ((isset($_POST["typedownload"]))&&(isset($_POST["setfields"]))){
					if (intval($_POST["typedownload"]) != -1){
						$mattab->set_format_type($_POST["typedownload"]);
						$mattab->set_fields($_POST["setfields"]);
					}
				}

				$id = $DAOMatTab->insert ($mattab);
				if (intval($id) == -1){
					$hasMessage = true;
					$message = "Não foi possível cadastrar a nova tabela!";
				}
			}
		}
	}
}
?>