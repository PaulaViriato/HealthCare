<?php
session_start();
if (isset($_SESSION["healthcare-type-user"])){
	$type_user = intval($_SESSION["healthcare-type-user"]);
	if ($type_user < 2){
		if ((isset($_SESSION["healthcare-login"]))&&(isset($_SESSION["healthcare-password"]))){
			if ($type_user == 0){ header("Location: adm/administradores.php"); }
			if ($type_user == 1){ header("Location: ope/simple_prestadores.php"); }
		}
	} else {
		if ($type_user == 2){ header("Location: pre/medicamentos.php"); }
	}
}
session_commit();
?>

<head>
	<title>Login - HealthCare</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="assets/vendor/toastr/toastr.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/logo.png">
</head>

<body>
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/toastr/toastr.js"></script>

	<?php
		session_start();
		if(isset($_SESSION["healthcare-invalido"])){
			unset($_SESSION["healthcare-invalido"]);
	 		echo "<script> toastr.error('Credenciais inválidas', 'Erro!'); </script>";
 		}
 		session_commit();
	?>

	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<h3> HealthCare </h3>
								<p class="lead">Entre na sua conta</p>
							</div>
							<form class="form-auth-small" action="../util/authenticate.php" method="POST">
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Login *</label>
									<input type="text" name="login" class="form-control" id="signin-email" value="" placeholder="Login *">
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Senha</label>
									<input type="password" name="senha" class="form-control" id="signin-password" value="" placeholder="Senha">
								</div>
								<button type="submit" style="background-color: #009688; border-color: #009688" class="btn btn-success btn-lg btn-block">Entrar</button>
								<div class="bottom">
									<span class=""> <a href="cadastrese/" href="#">Abrir uma conta HealthCare </br></a></span>
									<span class=""><i class="fa fa-lock"></i> <a data-toggle="modal" data-target="#modalContatoLemon" href="#">Esqueceu sua senha?</br></a></span>
									<span style="font-size:12px;color:#dc4a46;width:100%;"><br><br>* Prestadores: inserir CNPJ ou CPF cadastrado no CNES (Cadastro Nacional de Estabelecimentos de Saúde), sem caracteres não numéricos.</span>
								</div>
							</form>
						</div>
					</div>
					<div class="right" style="background-image: url('assets/img/login-health.jpg');">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading">Painel de Administração HealthCare</h1>
							<p>Lemon Inteligência</p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
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
</body>