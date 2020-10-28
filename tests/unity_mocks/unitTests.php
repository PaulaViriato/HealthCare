<?php
require_once('administrador_daoTest.php');
require_once('medicamento_daoTest.php');
require_once('material_daoTest.php');

$administrador = new Administrador_DAOTest;
$medicamento = new Medicamento_DAOTest;
$material = new Material_DAOTest;
$passed = "<span style='color:green'>Passed On</span>";
$nopassed = "<span style='color:red'>Did Not Pass</span>";

echo "<H3><b>HealthCare Unit Tests With Mocks:</b></H3>";

echo "Administrador DAO: ".($administrador->test_all() ? $passed : $nopassed)."<br>";
echo "---> Get Insert: ".($administrador->test_get_insert() ? $passed : $nopassed)."<br>";
echo "---> Get Update: ".($administrador->test_get_update() ? $passed : $nopassed)."<br>";
echo "---> Insert: ".($administrador->test_insert() ? $passed : $nopassed)."<br>";
echo "---> Unmodified: ".($administrador->test_unmodified() ? $passed : $nopassed)."<br>";
echo "---> Update: ".($administrador->test_update() ? $passed : $nopassed)."<br>";
echo "---> Delete: ".($administrador->test_delete() ? $passed : $nopassed)."<br>";
echo "---> Where / Order Clause: ".($administrador->test_where_order_clause() ? $passed : $nopassed)."<br>";
echo "---> Exist ID: ".($administrador->test_exist_id() ? $passed : $nopassed)."<br>";
echo "---> Exist Login: ".($administrador->test_exist_login() ? $passed : $nopassed)."<br>";
echo "---> Login: ".($administrador->test_login() ? $passed : $nopassed)."<br>";
echo "---> Select by ID: ".($administrador->test_select_id() ? $passed : $nopassed)."<br>";
echo "---> Select All: ".($administrador->test_select_all() ? $passed : $nopassed)."<br>";

echo "<br>Medicamento DAO: ".($medicamento->test_all() ? $passed : $nopassed)."<br>";
echo "---> Get Insert: ".($medicamento->test_get_insert() ? $passed : $nopassed)."<br>";
echo "---> Get Update: ".($medicamento->test_get_update() ? $passed : $nopassed)."<br>";
echo "---> Insert: ".($medicamento->test_insert() ? $passed : $nopassed)."<br>";
echo "---> Unmodified: ".($medicamento->test_unmodified() ? $passed : $nopassed)."<br>";
echo "---> Update: ".($medicamento->test_update() ? $passed : $nopassed)."<br>";
echo "---> Delete: ".($medicamento->test_delete() ? $passed : $nopassed)."<br>";
echo "---> Where / Order Clause: ".($medicamento->test_where_order_clause() ? $passed : $nopassed)."<br>";
echo "---> Exist ID: ".($medicamento->test_exist_id() ? $passed : $nopassed)."<br>";
echo "---> Select by ID: ".($medicamento->test_select_id() ? $passed : $nopassed)."<br>";
echo "---> Select All: ".($medicamento->test_select_all() ? $passed : $nopassed)."<br>";
echo "---> Extract Medicines: ".($medicamento->test_extract_meds() ? $passed : $nopassed)."<br>";

echo "<br>Material DAO: ".($material->test_all() ? $passed : $nopassed)."<br>";
echo "---> Get Insert: ".($material->test_get_insert() ? $passed : $nopassed)."<br>";
echo "---> Get Update: ".($material->test_get_update() ? $passed : $nopassed)."<br>";
echo "---> Insert: ".($material->test_insert() ? $passed : $nopassed)."<br>";
echo "---> Unmodified: ".($material->test_unmodified() ? $passed : $nopassed)."<br>";
echo "---> Update: ".($material->test_update() ? $passed : $nopassed)."<br>";
echo "---> Delete: ".($material->test_delete() ? $passed : $nopassed)."<br>";
echo "---> Where / Order Clause: ".($material->test_where_order_clause() ? $passed : $nopassed)."<br>";
echo "---> Exist ID: ".($material->test_exist_id() ? $passed : $nopassed)."<br>";
echo "---> Select by ID: ".($material->test_select_id() ? $passed : $nopassed)."<br>";
echo "---> Select All: ".($material->test_select_all() ? $passed : $nopassed)."<br>";
echo "---> Extract Materials: ".($material->test_extract_mats() ? $passed : $nopassed)."<br>";
?>