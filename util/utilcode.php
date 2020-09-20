<?php
class Util_Code {
	public function code ($original){
		$finalcode = unpack ('c*', $original);
		$strcode = "";
		foreach ($finalcode as $item){
			$choice = intval(rand(0, 1));
			if ($choice == 0){ $strcode .= $item.chr(rand(65, 90)); }
			else{ $strcode .= $item.chr(rand(97, 122)); }
		}

		$result = base64_encode ($strcode);
		return $result;
	}

	public function decode ($code){
		$initialcode = base64_decode ($code);
		$arrcode = str_split($initialcode);
		$newcode = "";
		for ($i = 0; $i < count($arrcode); $i++){
			$value = ord($arrcode[$i]);
			if ((($value >= 65)&&($value <= 90))||(($value >= 97)&&($value <= 122))){
				$newcode .= "-";
			} else { $newcode .= $arrcode[$i]; }
		}

		$firstdecode = explode("-", $newcode);
		$strfirstdecode = "";
		foreach ($firstdecode as $item){ $strfirstdecode .= pack ('c*', $item); }
		return $strfirstdecode;
	}
}
?>