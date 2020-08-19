SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema healthcare_db
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `healthcare_db` ;

-- -----------------------------------------------------
-- Schema healthcare_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `healthcare_db` DEFAULT CHARACTER SET utf8 ;
USE `healthcare_db` ;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_administrador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_administrador` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_administrador` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(256) NOT NULL,
  `email` VARCHAR(256) NULL,
  `login` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_cnes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_cnes` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_cnes` (
  `id` VARCHAR(20) NOT NULL,
  `ativo` BOOLEAN NOT NULL,
  `razao_social` VARCHAR(256) NOT NULL,
  `no_fantasia` VARCHAR(256) NOT NULL,
  `tipo_estabelecimento` VARCHAR(80) NOT NULL,
  `convenio` VARCHAR(40) NOT NULL,
  `natureza_juridica` VARCHAR(256) NOT NULL,
  `atendimento_prestado` VARCHAR(256) NOT NULL,
  `cnpj` VARCHAR(25) NOT NULL,
  `cpf` VARCHAR(25) NOT NULL,
  `cd_municipio` INT NOT NULL,
  `nm_municipio` VARCHAR(60) NOT NULL,
  `uf` VARCHAR(5) NOT NULL,
  `cep` VARCHAR(15) NOT NULL,
  `inclusao` DATE NOT NULL,
  `equipo_odontologico` BOOLEAN NOT NULL,
  `cirurgiao_dentista` BOOLEAN NOT NULL,
  `urgencia_emergencia` BOOLEAN NOT NULL,
  `leitos_clinica` INT NOT NULL,
  `leitos_cirurgia` INT NOT NULL,
  `leitos_obstetricia` INT NOT NULL,
  `leitos_pediatria` INT NOT NULL,
  `leitos_psiquiatria` INT NOT NULL,
  `leitos_uti_adulto` INT NOT NULL,
  `leitos_uti_pediatrica` INT NOT NULL,
  `leitos_uti_neonatal` INT NOT NULL,
  `leitos_unidade_interm_neo` INT NOT NULL,
  `anatomopatologia` BOOLEAN NOT NULL,
  `colposcopia` BOOLEAN NOT NULL,
  `eletrocardiograma` BOOLEAN NOT NULL,
  `fisioterapia` BOOLEAN NOT NULL,
  `patologia_clinica` BOOLEAN NOT NULL,
  `radiodiagnostico` BOOLEAN NOT NULL,
  `ultra_sonografia` BOOLEAN NOT NULL,
  `ecocardiografia` BOOLEAN NOT NULL,
  `endoscopia_vdigestivas` BOOLEAN NOT NULL,
  `hemoterapia_ambulatorial` BOOLEAN NOT NULL,
  `holter` BOOLEAN NOT NULL,
  `litotripsia_extracorporea` BOOLEAN NOT NULL,
  `mamografia` BOOLEAN NOT NULL,
  `psicoterapia` BOOLEAN NOT NULL,
  `terapia_renalsubst` BOOLEAN NOT NULL,
  `teste_ergometrico` BOOLEAN NOT NULL,
  `tomografia_computadorizada` BOOLEAN NOT NULL,
  `atendimento_hospitaldia` BOOLEAN NOT NULL,
  `endoscopia_vaereas` BOOLEAN NOT NULL,
  `hemodinamica` BOOLEAN NOT NULL,
  `medicina_nuclear` BOOLEAN NOT NULL,
  `quimioterapia` BOOLEAN NOT NULL,
  `radiologia_intervencionista` BOOLEAN NOT NULL,
  `radioterapia` BOOLEAN NOT NULL,
  `ressonancia_nmagnetica` BOOLEAN NOT NULL,
  `ultrassonografia_doppler` BOOLEAN NOT NULL,
  `videocirurgia` BOOLEAN NOT NULL,
  `odontologia_basica` BOOLEAN NOT NULL,
  `raiox_dentario` BOOLEAN NOT NULL,
  `endodontia` BOOLEAN NOT NULL,
  `periodontia` BOOLEAN NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_operadora`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_operadora` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_operadora` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(256) NOT NULL,
  `codans` VARCHAR(15) NULL,
  `cnpj` VARCHAR(25) NOT NULL,
  `email` VARCHAR(256) NULL,
  `contato` VARCHAR(100) NULL,
  `login` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(100) NOT NULL COMMENT 'Mais algum campo que deve ser acrescentado',
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_prestadora`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_prestadora` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_prestadora` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `id_cnes` VARCHAR(20) NOT NULL,
  `id_operadora` BIGINT NOT NULL COMMENT 'Mais algum campo que deve ser acrescentado',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_cnes`) REFERENCES `tb_cnes`(`id`),
  FOREIGN KEY (`id_operadora`) REFERENCES `tb_operadora`(`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_login`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_login` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_login` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `first_login` BOOLEAN NOT NULL,
  `senha` VARCHAR(100) NOT NULL,
  `id_cnes` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_cnes`) REFERENCES `tb_cnes`(`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_medicamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_medicamento` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_medicamento` (
  `id` VARCHAR(20) NOT NULL,
  `substancia` VARCHAR(500) NULL,
  `cnpj` VARCHAR(25) NULL,
  `laboratorio` VARCHAR(200) NULL,
  `codggrem` VARCHAR(20) NULL,
  `produto` VARCHAR(175) NULL,
  `apresentacao` VARCHAR(700) NULL,
  `classe_terapeutica` VARCHAR(175) NULL,
  `tipo_produto` VARCHAR(30) NULL,
  `tarja` VARCHAR(100) NULL,
  `cod_termo` BIGINT NULL,
  `generico` BOOLEAN NULL,
  `grupo_farmacologico` VARCHAR(175) NULL,
  `classe_farmacologica` VARCHAR(150) NULL,
  `forma_farmaceutica` VARCHAR(150) NULL,
  `unidmin_fracao` VARCHAR(15) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_medtab`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_medtab` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_medtab` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(256) NOT NULL,
  `deflator` DOUBLE NOT NULL DEFAULT 1,
  `pf_alicota` INT NULL,
  `pmc_alicota` INT NULL,
  `pmvg_alicota` INT NULL,
  `id_operadora` BIGINT NULL,
  `id_medtab` BIGINT NULL,
  `data` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_operadora`) REFERENCES `tb_operadora`(`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_cmed`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_cmed` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_cmed` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `id_medicamento` VARCHAR(20) NOT NULL,
  `id_medtab` BIGINT NOT NULL,
  `ean_um` VARCHAR(20) NULL,
  `ean_dois` VARCHAR(20) NULL,
  `ean_tres` VARCHAR(20) NULL,
  `regime_preco` VARCHAR(15) NOT NULL,
  `pf_semimpostos` DOUBLE NOT NULL,
  `pf_zero` DOUBLE NOT NULL,
  `pf_doze` DOUBLE NULL,
  `pf_dezessete` DOUBLE NULL,
  `pf_dezessete_alc` DOUBLE NULL,
  `pf_dezessetemeio` DOUBLE NULL,
  `pf_dezessetemeio_alc` DOUBLE NULL,
  `pf_dezoito` DOUBLE NULL,
  `pf_dezoito_alc` DOUBLE NULL,
  `pf_vinte` DOUBLE NULL,
  `pmc_zero` DOUBLE NULL,
  `pmc_doze` DOUBLE NULL,
  `pmc_dezessete` DOUBLE NULL,
  `pmc_dezessete_alc` DOUBLE NULL,
  `pmc_dezessetemeio` DOUBLE NULL,
  `pmc_dezessetemeio_alc` DOUBLE NULL,
  `pmc_dezoito` DOUBLE NULL,
  `pmc_dezoito_alc` DOUBLE NULL,
  `pmc_vinte` DOUBLE NULL,
  `pmvg_semimpostos` DOUBLE NULL,
  `pmvg_zero` DOUBLE NULL,
  `pmvg_doze` DOUBLE NULL,
  `pmvg_dezessete` DOUBLE NULL,
  `pmvg_dezessete_alc` DOUBLE NULL,
  `pmvg_dezessetemeio` DOUBLE NULL,
  `pmvg_dezessetemeio_alc` DOUBLE NULL,
  `pmvg_dezoito` DOUBLE NULL,
  `pmvg_dezoito_alc` DOUBLE NULL,
  `pmvg_vinte` DOUBLE NULL,
  `restricao_hospitalar` BOOLEAN NOT NULL,
  `cap` BOOLEAN NOT NULL,
  `confaz_oitosete` BOOLEAN NOT NULL,
  `icms_zero` BOOLEAN NOT NULL,
  `analise_recursal` BOOLEAN NULL,
  `lista_ctributario` VARCHAR(15) NOT NULL,
  `comercializacao` BOOLEAN NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_medicamento`) REFERENCES `tb_medicamento`(`id`),
  FOREIGN KEY (`id_medtab`) REFERENCES `tb_medtab`(`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_medtuss`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_medtuss` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_medtuss` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `id_medicamento` VARCHAR(20) NOT NULL,
  `id_medtab` BIGINT NOT NULL,
  `inicio_vigencia` DATE NOT NULL,
  `fim_vigencia` DATE NULL,
  `fim_implantacao` DATE NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_medicamento`) REFERENCES `tb_medicamento`(`id`),
  FOREIGN KEY (`id_medtab`) REFERENCES `tb_medtab`(`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_medtnum`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_medtnum` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_medtnum` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `id_medicamento` VARCHAR(20) NOT NULL,
  `id_medtab` BIGINT NOT NULL,
  `cod_tiss` BIGINT NOT NULL,
  `observacoes` VARCHAR(500) NULL,
  `cod_anterior` BIGINT NULL,
  `tipo_produto` VARCHAR(20) NOT NULL,
  `tipo_codificacao` VARCHAR(10) NOT NULL,
  `inicio_vigencia` DATE NOT NULL,
  `fim_vigencia` DATE NULL,
  `motivo_insercao` VARCHAR(150) NULL,
  `fim_implantacao` DATE NOT NULL,
  `cod_tissbrasindice` BIGINT NULL,
  `descricao_brasindice` VARCHAR(175) NULL,
  `apresentacao_brasindice` VARCHAR(500) NULL,
  `pertence_confaz` BOOLEAN NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_medicamento`) REFERENCES `tb_medicamento`(`id`),
  FOREIGN KEY (`id_medtab`) REFERENCES `tb_medtab`(`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_material`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_material` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_material` (
  `id` VARCHAR(20) NOT NULL,
  `cnpj` VARCHAR(25) NULL,
  `fabricante` VARCHAR(200) NULL,
  `classe_risco` VARCHAR(20) NULL,
  `descricao_produto` VARCHAR(800) NULL,
  `especialidade_produto` VARCHAR(500) NULL,
  `classificacao_produto` VARCHAR(50) NULL,
  `nome_tecnico` VARCHAR(200) NOT NULL,
  `unidmin_fracao` VARCHAR(10) NULL,
  `tipo_produto` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_mattab`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_mattab` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_mattab` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(256) NOT NULL,
  `deflator` DOUBLE NOT NULL DEFAULT 1,
  `id_operadora` BIGINT NULL,
  `id_mattab` BIGINT NULL,
  `data` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_operadora`) REFERENCES `tb_operadora`(`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_mattuss`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_mattuss` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_mattuss` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `id_material` VARCHAR(20) NOT NULL,
  `id_mattab` BIGINT NOT NULL,
  `termo` VARCHAR(400) NULL,
  `modelo` VARCHAR(300) NULL,
  `inicio_vigencia` DATE NOT NULL,
  `fim_vigencia` DATE NULL,
  `fim_implantacao` DATE NOT NULL,
  `codigo_termo` BIGINT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_material`) REFERENCES `tb_material`(`id`),
  FOREIGN KEY (`id_mattab`) REFERENCES `tb_mattab`(`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_mattnum`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_mattnum` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_mattnum` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `id_material` VARCHAR(20) NOT NULL,
  `id_mattab` BIGINT NOT NULL,
  `nome` VARCHAR(400) NULL,
  `cod_tiss` BIGINT NOT NULL,
  `nome_comercial` VARCHAR(300) NOT NULL,
  `observaces` VARCHAR(200) NULL,
  `cod_anterior` BIGINT NULL,
  `ref_tamanhomodelo` VARCHAR(120) NULL,
  `tipo_codificacao` VARCHAR(10) NOT NULL,
  `inicio_vigencia` DATE NOT NULL,
  `fim_vigencia` DATE NULL,
  `motivo_insercao` VARCHAR(100) NULL,
  `fim_implantacao` DATE NOT NULL,
  `cod_simpro` BIGINT NULL,
  `descricaoproduto_simpro` VARCHAR(150) NULL,
  `equivalencia_tecnica` VARCHAR(200) NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_material`) REFERENCES `tb_material`(`id`),
  FOREIGN KEY (`id_mattab`) REFERENCES `tb_mattab`(`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_tabela`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_tabela` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_tabela` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `type` TINYINT(1) NOT NULL,
  `id_prestadora` BIGINT NOT NULL,
  `id_medtab` BIGINT NULL,
  `id_mattab` BIGINT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_prestadora`) REFERENCES `tb_prestadora`(`id`),
  FOREIGN KEY (`id_medtab`) REFERENCES `tb_medtab`(`id`),
  FOREIGN KEY (`id_mattab`) REFERENCES `tb_mattab`(`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_arquivo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_arquivo` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_arquivo` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `file_type` TINYINT(1) NOT NULL,
  `caminho` VARCHAR(400) NOT NULL,
  `tab_type` TINYINT(1) NOT NULL,
  `id_medtab` BIGINT NULL,
  `id_mattab` BIGINT NULL,
  `status` TINYINT(1) NOT NULL,
  `data` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_medtab`) REFERENCES `tb_medtab`(`id`),
  FOREIGN KEY (`id_mattab`) REFERENCES `tb_mattab`(`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `healthcare_db`.`tb_rotina`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `healthcare_db`.`tb_rotina` ;

CREATE TABLE IF NOT EXISTS `healthcare_db`.`tb_rotina` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `type` TINYINT(1) NOT NULL,
  `url` VARCHAR(400) NOT NULL,
  `periodo` TINYINT(1) NOT NULL,
  `id_operadora` BIGINT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_operadora`) REFERENCES `tb_operadora`(`id`))
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;