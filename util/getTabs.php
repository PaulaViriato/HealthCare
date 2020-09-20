<?php
require_once('../dao/cmed_DAO.php');
require_once('../dao/medtuss_DAO.php');
require_once('../dao/medtnum_DAO.php');
require_once('../dao/mattuss_DAO.php');
require_once('../dao/mattnum_DAO.php');
require_once('../dao/medicamento_DAO.php');
require_once('../dao/material_DAO.php');

ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
set_time_limit(0);

$DAOCMED = new CMED_DAO();
$DAOMedTuss = new MedTuss_DAO();
$DAOMedTnum = new MedTnum_DAO();
$DAOMatTuss = new MatTuss_DAO();
$DAOMatTnum = new MatTnum_DAO();
$DAOMedicamento = new Medicamento_DAO();
$DAOMaterial = new Material_DAO();

$cmeds = $DAOCMED->select_by_MedTab ("1");
$medtuss = $DAOMedTuss->select_by_MedTab ("1");
$medtnum = $DAOMedTnum->select_by_MedTab ("1");
$mattuss = $DAOMatTuss->select_by_MatTab ("1");
$mattnum = $DAOMatTnum->select_by_MatTab ("1");
$medicamentos = $DAOMedicamento->extract_meds ($cmeds, $medtuss, $medtnum);
$materiais = $DAOMaterial->extract_mats ($mattuss, $mattnum);

echo "CMEDS: ".count($cmeds)."<br>";
echo "MedTuss: ".count($medtuss)."<br>";
echo "MedTnum: ".count($medtnum)."<br>";
echo "MatTuss: ".count($mattuss)."<br>";
echo "MatTnum: ".count($mattnum)."<br>";
echo "Medicamentos: ".count($medicamentos)."<br>";
echo "Materiais: ".count($materiais)."<br>";
?>