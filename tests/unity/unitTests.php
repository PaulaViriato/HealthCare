<?php
require_once('administradorTest.php');
require_once('arquivoTest.php');
require_once('materialTest.php');
require_once('mattabTest.php');
require_once('medicamentoTest.php');
require_once('medtabTest.php');
require_once('medtussTest.php');
require_once('operadoraTest.php');
require_once('tabelaTest.php');

$administrador = new AdministradorTest;
$operadora = new OperadoraTest;
$medicamento = new MedicamentoTest;
$material = new MaterialTest;
$medtab = new MedTabTest;
$mattab = new MatTabTest;
$medtuss = new MedTussTest;
$tabela = new TabelaTest;
$arquivo = new ArquivoTest;
$passed = "<span style='color:green'>Passed On</span>";
$nopassed = "<span style='color:red'>Did Not Pass</span>";

echo "<H3><b>HealthCare Unit Tests:</b></H3>";

echo "Administrador: ".($administrador->test_all() ? $passed : $nopassed)."<br>";
echo "---> ID: ".($administrador->test_id() ? $passed : $nopassed)."<br>";
echo "---> Nome: ".($administrador->test_nome() ? $passed : $nopassed)."<br>";
echo "---> Email: ".($administrador->test_email() ? $passed : $nopassed)."<br>";
echo "---> Login: ".($administrador->test_login() ? $passed : $nopassed)."<br>";
echo "---> Senha: ".($administrador->test_senha() ? $passed : $nopassed)."<br>";

echo "<br>Operadora: ".($operadora->test_all() ? $passed : $nopassed)."<br>";
echo "---> ID: ".($operadora->test_id() ? $passed : $nopassed)."<br>";
echo "---> Nome: ".($operadora->test_nome() ? $passed : $nopassed)."<br>";
echo "---> Código ANS: ".($operadora->test_codans() ? $passed : $nopassed)."<br>";
echo "---> CNPJ: ".($operadora->test_cnpj() ? $passed : $nopassed)."<br>";
echo "---> Email: ".($operadora->test_email() ? $passed : $nopassed)."<br>";
echo "---> Contato: ".($operadora->test_contato() ? $passed : $nopassed)."<br>";
echo "---> Login: ".($operadora->test_login() ? $passed : $nopassed)."<br>";
echo "---> Senha: ".($operadora->test_senha() ? $passed : $nopassed)."<br>";

echo "<br>Medicamento: ".($medicamento->test_all() ? $passed : $nopassed)."<br>";
echo "---> ID: ".($medicamento->test_id() ? $passed : $nopassed)."<br>";
echo "---> Substância: ".($medicamento->test_substancia() ? $passed : $nopassed)."<br>";
echo "---> CNPJ: ".($medicamento->test_cnpj() ? $passed : $nopassed)."<br>";
echo "---> Laboratório: ".($medicamento->test_laboratorio() ? $passed : $nopassed)."<br>";
echo "---> Código GGREM: ".($medicamento->test_codggrem() ? $passed : $nopassed)."<br>";
echo "---> Produto: ".($medicamento->test_produto() ? $passed : $nopassed)."<br>";
echo "---> Apresentação: ".($medicamento->test_apresentacao() ? $passed : $nopassed)."<br>";
echo "---> Classe Terapêutica: ".($medicamento->test_classe_terapeutica() ? $passed : $nopassed)."<br>";
echo "---> Tipo de Produto: ".($medicamento->test_tipo_produto() ? $passed : $nopassed)."<br>";
echo "---> Tarja: ".($medicamento->test_tarja() ? $passed : $nopassed)."<br>";
echo "---> Código Termo: ".($medicamento->test_cod_termo() ? $passed : $nopassed)."<br>";
echo "---> Genérico: ".($medicamento->test_generico() ? $passed : $nopassed)."<br>";
echo "---> Grupo Farmacológico: ".($medicamento->test_grupo_farmacologico() ? $passed : $nopassed)."<br>";
echo "---> Classe Farmacológica: ".($medicamento->test_classe_farmacologica() ? $passed : $nopassed)."<br>";
echo "---> Forma Farmacêutica: ".($medicamento->test_forma_farmaceutica() ? $passed : $nopassed)."<br>";
echo "---> Unidade Mínima: ".($medicamento->test_unidmin_fracao() ? $passed : $nopassed)."<br>";

echo "<br>Material: ".($material->test_all() ? $passed : $nopassed)."<br>";
echo "---> ID: ".($material->test_id() ? $passed : $nopassed)."<br>";
echo "---> CNPJ: ".($material->test_cnpj() ? $passed : $nopassed)."<br>";
echo "---> Fabricante: ".($material->test_fabricante() ? $passed : $nopassed)."<br>";
echo "---> Classe de Risco: ".($material->test_classe_risco() ? $passed : $nopassed)."<br>";
echo "---> Descrição do Produto: ".($material->test_descricao_produto() ? $passed : $nopassed)."<br>";
echo "---> Especialidade do Produto: ".($material->test_especialidade_produto() ? $passed : $nopassed)."<br>";
echo "---> Classificação do Produto: ".($material->test_classificacao_produto() ? $passed : $nopassed)."<br>";
echo "---> Nome Técnico: ".($material->test_nome_tecnico() ? $passed : $nopassed)."<br>";
echo "---> Unidade Mínima: ".($material->test_unidmin_fracao() ? $passed : $nopassed)."<br>";
echo "---> Tipo de Produto: ".($material->test_tipo_produto() ? $passed : $nopassed)."<br>";

echo "<br>MedTab: ".($medtab->test_all() ? $passed : $nopassed)."<br>";
echo "---> ID: ".($medtab->test_id() ? $passed : $nopassed)."<br>";
echo "---> Nome: ".($medtab->test_nome() ? $passed : $nopassed)."<br>";
echo "---> Deflator: ".($medtab->test_deflator() ? $passed : $nopassed)."<br>";
echo "---> PF Alicota: ".($medtab->test_pf_alicota() ? $passed : $nopassed)."<br>";
echo "---> PMC Alicota: ".($medtab->test_pmc_alicota() ? $passed : $nopassed)."<br>";
echo "---> PMVG Alicota: ".($medtab->test_pmvg_alicota() ? $passed : $nopassed)."<br>";
echo "---> Operadora: ".($medtab->test_OPERADORA() ? $passed : $nopassed)."<br>";
echo "---> MedTab: ".($medtab->test_MEDTAB() ? $passed : $nopassed)."<br>";
echo "---> Data: ".($medtab->test_data() ? $passed : $nopassed)."<br>";
echo "---> Fields: ".($medtab->test_fields() ? $passed : $nopassed)."<br>";
echo "---> Format Type: ".($medtab->test_format_type() ? $passed : $nopassed)."<br>";
echo "---> Active: ".($medtab->test_active() ? $passed : $nopassed)."<br>";

echo "<br>MatTab: ".($mattab->test_all() ? $passed : $nopassed)."<br>";
echo "---> ID: ".($mattab->test_id() ? $passed : $nopassed)."<br>";
echo "---> Nome: ".($mattab->test_nome() ? $passed : $nopassed)."<br>";
echo "---> Deflator: ".($mattab->test_deflator() ? $passed : $nopassed)."<br>";
echo "---> Operadora: ".($mattab->test_OPERADORA() ? $passed : $nopassed)."<br>";
echo "---> MatTab: ".($mattab->test_MATTAB() ? $passed : $nopassed)."<br>";
echo "---> Data: ".($mattab->test_data() ? $passed : $nopassed)."<br>";
echo "---> Fields: ".($mattab->test_fields() ? $passed : $nopassed)."<br>";
echo "---> Format Type: ".($mattab->test_format_type() ? $passed : $nopassed)."<br>";
echo "---> Active: ".($mattab->test_active() ? $passed : $nopassed)."<br>";

echo "<br>MedTuss: ".($medtuss->test_all() ? $passed : $nopassed)."<br>";
echo "---> ID: ".($medtuss->test_id() ? $passed : $nopassed)."<br>";
echo "---> Medicamento: ".($medtuss->test_MEDICAMENTO() ? $passed : $nopassed)."<br>";
echo "---> MedTab: ".($medtuss->test_MEDTAB() ? $passed : $nopassed)."<br>";
echo "---> Inicio da Vigência: ".($medtuss->test_inicio_vigencia() ? $passed : $nopassed)."<br>";
echo "---> Fim da Vigência: ".($medtuss->test_fim_vigencia() ? $passed : $nopassed)."<br>";
echo "---> Fim da Implantação: ".($medtuss->test_fim_implantacao() ? $passed : $nopassed)."<br>";

echo "<br>Tabela: ".($tabela->test_all() ? $passed : $nopassed)."<br>";
echo "---> ID: ".($tabela->test_id() ? $passed : $nopassed)."<br>";
echo "---> Type: ".($tabela->test_type() ? $passed : $nopassed)."<br>";
echo "---> Prestadora: ".($tabela->test_PRESTADORA() ? $passed : $nopassed)."<br>";
echo "---> MedTab: ".($tabela->test_MEDTAB() ? $passed : $nopassed)."<br>";
echo "---> MatTab: ".($tabela->test_MATTAB() ? $passed : $nopassed)."<br>";

echo "<br>Arquivo: ".($arquivo->test_all() ? $passed : $nopassed)."<br>";
echo "---> ID: ".($arquivo->test_id() ? $passed : $nopassed)."<br>";
echo "---> File Type: ".($arquivo->test_file_type() ? $passed : $nopassed)."<br>";
echo "---> Caminho: ".($arquivo->test_caminho() ? $passed : $nopassed)."<br>";
echo "---> Table Type: ".($arquivo->test_tab_type() ? $passed : $nopassed)."<br>";
echo "---> MedTab: ".($arquivo->test_MEDTAB() ? $passed : $nopassed)."<br>";
echo "---> MatTab: ".($arquivo->test_MATTAB() ? $passed : $nopassed)."<br>";
echo "---> Status: ".($arquivo->test_status() ? $passed : $nopassed)."<br>";
echo "---> Data: ".($arquivo->test_data() ? $passed : $nopassed)."<br>";
echo "---> Linha: ".($arquivo->test_linha() ? $passed : $nopassed)."<br>";
echo "---> Coluna: ".($arquivo->test_coluna() ? $passed : $nopassed)."<br>";
?>