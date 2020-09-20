<?php
require_once('utilcode.php');
require_once('load_cmed.php');
require_once('load_medtuss.php');
require_once('load_medtnum.php');
require_once('load_cnes.php');
require_once('load_mattuss.php');
require_once('load_mattnum.php');

if (!isset($_POST["code"])){
	echo "Codigo de Acesso Invalido!";
	exit();
}

$code = $_POST["code"];
$utilcode = new Util_Code();
$decode = intval ($utilcode->decode ($code));

//Code = NTFWNTJjNTJmNTdyNTFRNDlMNTVTNTN0NDhPNDhr
if (($decode == intval("3449317500"))&&(isset($_POST["exec"]))){
	if ((intval($_POST["exec"]) == 1)&&(isset($_POST["operation"]))){
		if ((intval($_POST["operation"]) == 0)&&(isset($_POST["name"]))){
			$operadora = new Operadora();
			if (isset($_POST["id_operadora"])){ $operadora->get_id($_POST["id_operadora"]); }

			$medtab = new MedTab();
			$medtab->set_nome ($_POST["name"]);
			$medtab->set_OPERADORA ($operadora);
			$medtab->set_MEDTAB (new MedTab());
			$medtab->set_data (date("Y-m-d H:i:s"));

			$medtab_DAO = new MedTab_DAO();
			$id = $medtab_DAO->insert ($medtab);
			if (intval($id) == -1){ echo "0;-1;"; }
			else { echo "1;".$id.";"; }
		}

		if ((intval($_POST["operation"]) == 1)&&(isset($_POST["name"]))){
			$operadora = new Operadora();
			if (isset($_POST["id_operadora"])){ $operadora->get_id($_POST["id_operadora"]); }

			$mattab = new MatTab();
			$mattab->set_nome ($_POST["name"]);
			$mattab->set_OPERADORA ($operadora);
			$mattab->set_MATTAB (new MatTab());
			$mattab->set_data (date("Y-m-d H:i:s"));

			$mattab_DAO = new MatTab_DAO();
			$id = $mattab_DAO->insert ($mattab);
			if (intval($id) == -1){ echo "0;-1;"; }
			else { echo "1;".$id.";"; }
		}

		if ((intval($_POST["operation"]) == 2)&&(isset($_POST["fileName"]))&&(isset($_POST["id_medtab"]))){
			$fileName = "../archives/".$_POST["fileName"];
			$load = new Load_CMED();
			$load->set_authenticate (true);
			$resreturn = $load->load ($fileName, 0, $_POST["id_medtab"]);
			$resreturn = null;

			echo "--> [LOAD_CMED] File: ".$fileName." <--\n";
			echo "Time: ".$load->get_last_time()." seconds\n";
			echo "Memory: ".$load->get_last_memory()."\n";
		}

		if ((intval($_POST["operation"]) == 3)&&(isset($_POST["fileName"]))&&(isset($_POST["id_medtab"]))){
			$fileName = "../archives/".$_POST["fileName"];
			$load = new Load_CMED();
			$load->set_authenticate (true);
			$resreturn = $load->load ($fileName, 1, $_POST["id_medtab"]);
			$resreturn = null;

			echo "--> [LOAD_CMED] File: ".$fileName." <--\n";
			echo "Time: ".$load->get_last_time()." seconds\n";
			echo "Memory: ".$load->get_last_memory()."\n";
		}

		if ((intval($_POST["operation"]) == 4)&&(isset($_POST["fileName"]))&&(isset($_POST["id_medtab"]))){
			$fileName = "../archives/".$_POST["fileName"];
			$load = new Load_MedTuss();
			$load->set_authenticate (true);
			$resreturn = $load->load ($fileName, $_POST["id_medtab"]);
			$resreturn = null;

			echo "--> [LOAD_MEDTUSS] File: ".$fileName." <--\n";
			echo "Time: ".$load->get_last_time()." seconds\n";
			echo "Memory: ".$load->get_last_memory()."\n";
		}

		if ((intval($_POST["operation"]) == 5)&&(isset($_POST["fileName"]))&&(isset($_POST["id_medtab"]))){
			$fileName = "../archives/".$_POST["fileName"];
			$load = new Load_MedTnum();
			$load->set_authenticate (true);
			$resreturn = $load->load ($fileName, $_POST["id_medtab"]);
			$resreturn = null;

			echo "--> [LOAD_MEDTNUM] File: ".$fileName." <--\n";
			echo "Time: ".$load->get_last_time()." seconds\n";
			echo "Memory: ".$load->get_last_memory()."\n";
		}

		if ((intval($_POST["operation"]) == 6)&&(isset($_POST["fileName"]))&&(isset($_POST["id_mattab"]))){
			$fileName = "../archives/".$_POST["fileName"];
			$load = new Load_MatTuss();
			$load->set_authenticate (true);
			$resreturn = $load->load ($fileName, $_POST["id_mattab"]);
			$resreturn = null;

			echo "--> [LOAD_MATTUSS] File: ".$fileName." <--\n";
			echo "Time: ".$load->get_last_time()." seconds\n";
			echo "Memory: ".$load->get_last_memory()."\n";
		}

		if ((intval($_POST["operation"]) == 7)&&(isset($_POST["fileName"]))&&(isset($_POST["id_mattab"]))){
			$fileName = "../archives/".$_POST["fileName"];
			$load = new Load_MatTnum();
			$load->set_authenticate (true);
			$resreturn = $load->load ($fileName, $_POST["id_mattab"]);
			$resreturn = null;

			echo "--> [LOAD_MATTNUM] File: ".$fileName." <--\n";
			echo "Time: ".$load->get_last_time()." seconds\n";
			echo "Memory: ".$load->get_last_memory()."\n";
		}

		if ((intval($_POST["operation"]) == 8)&&(isset($_POST["fileName"]))){
			$fileName = "../archives/".$_POST["fileName"];
			$load = new Load_CNES();
			$resreturn = $load->load ($fileName);
			$resreturn = null;

			echo "--> [LOAD_CNES] File: ".$fileName." <--\n";
			echo "Time: ".$load->get_last_time()." seconds\n";
			echo "Memory: ".$load->get_last_memory()."\n";
		}
	}
} else { echo "Codigo de Acesso Invalido!"; }
?>
