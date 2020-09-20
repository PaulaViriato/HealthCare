<?php
require_once('../libs/SimpleXLS.php');
require_once('../libs/SimpleXLSX.php');
require_once('../libs/SpreadsheetReader/SpreadsheetReader.php');
require_once('../libs/SpreadsheetReader/php-excel-reader/excel_reader2.php');

class Content {
	// Propriedades
	private $last_time;
	private $last_memory;
	private $max_cols;

	// Construtor
	function __construct(){
		$this->last_time = null;
		$this->last_memory = null;
		$this->max_cols = 60;
		$this->max_batch = 1000;
	}

	// Métodos
	public function set_max_cols ($max_cols){ $this->max_cols = intval($max_cols); }
	public function get_max_cols (){ return $this->max_cols; }

	public function set_max_batch ($max_batch){ $this->max_batch = intval($max_batch); }
	public function get_max_batch (){ return $this->max_batch; }

	private function log_content ($message){
		$string = "";
		$date = date("Y-m-d H:i:s");
		$arquivo = fopen('log_content.log','r+');

		if ($arquivo){
			while ($linha = fgets($arquivo)){ $string .= $linha; }
			$string .= "[".$date."] ".$message."\n";
			rewind ($arquivo);
			ftruncate ($arquivo, 0);
			fwrite ($arquivo, $string);
			fclose($arquivo);
		}
	}

	private function get_csv ($fileName, $object){
		$file_handle = fopen($fileName, "r");
		while ($line = fgetcsv($file_handle, null, ";")){ $object->set_line($line); }
		fclose($file_handle);
	}

	private function get_excel ($fileName, $object, $sheet = 0){
		if (is_file ($fileName)){
			try {
				$spreadsheet = new SpreadsheetReader ($fileName);
				$spreadsheet->ChangeSheet ($sheet);
				foreach ($spreadsheet as $key => $row){ $object->set_line($row); }
			} catch (Exception $exception) { $this->log_content ($exception->getMessage()); }
		}
	}

	private function get_xlsx ($fileName, $object, $sheet = 0){
		if (is_file ($fileName)){
			try {
				$sizefile = intval (filesize ($fileName));
				$value = intval (15*1024*1024);
				if (($sizefile < $value)||($sizefile == $value)){
					if ($xlsx = SimpleXLSX::parse ($fileName)){
						$dim = $xlsx->dimension();
						$num_cols = $dim[0];
						$initCols = -1;

						if ($num_cols > $this->max_cols){ $initCols = $this->max_cols; }
						foreach ($xlsx->rows ($initCols, $sheet) as $row){ $object->set_line($row); }
					} else {
						$this->log_content (SimpleXLSX::parseError());
						$this->get_excel ($fileName, $object, $sheet);
					}
				} else {
					$this->log_content ("(".$fileName.") SimpleXLSX: The file size is larger than the maximum size.");
					$this->get_excel ($fileName, $object, $sheet);
				}
			} catch (Exception $exception) {
				$this->log_content ($exception->getMessage());
				$this->get_excel ($fileName, $object, $sheet);
			}
		}
	}

	private function get_xls ($fileName, $object, $sheet = 0){
		if (is_file ($fileName)){
			try {
				$sizefile = intval (filesize ($fileName));
				$value = intval (15*1024*1024);
				if (($sizefile < $value‬)||($sizefile == $value‬)){
					if ($xls = SimpleXLS::parse ($fileName)){
						foreach ($xls->rows ($this->max_cols, $sheet) as $row){
							$object->set_line($row);
						}
					} else {
						$this->log_content (SimpleXLS::parseError());
						$this->get_excel ($fileName, $object, $sheet);
					}
				} else {
					$this->log_content ("(".$fileName.") SimpleXLS: The file size is larger than the maximum size.");
					$this->get_excel ($fileName, $object, $sheet);
				}
			} catch (Exception $exception) {
				$this->log_content ($exception->getMessage());
				$this->get_excel ($fileName, $object, $sheet);
			}
		}
	}

	public function get_content ($fileName, $object, $sheet = 0){
		$time = microtime(1);
		$mem = memory_get_usage();

		if (strlen("".(strpos ($fileName, ".csv"))) > 0){
			if ($sheet == 0){ $this->get_csv($fileName, $object); }
		} else {
			if (strlen("".(strpos ($fileName, ".xlsx"))) > 0){ $this->get_xlsx ($fileName, $object, $sheet); }
			else {
				if (strlen("".(strpos ($fileName, ".xls"))) > 0){ $this->get_xls ($fileName, $object, $sheet); }
			}
		}

		$this->last_time = floatval((1000 * (microtime(1) - $time))/1000);
		$this->last_memory = ((memory_get_usage() - $mem) / (1024 * 1024));
	}

	public function explode_data ($data){
		$resreturn = array();
		foreach ($data as $line){ array_push ($resreturn, explode(";", $line)); }
		return $resreturn;
	}

	public function get_last_time (){ return $this->last_time; }
	public function get_last_memory (){ return $this->last_memory; }
}
?>
