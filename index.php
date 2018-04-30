<?php
	require_once(dirname(__FILE__).'/class/Login.php');

	$objConnection = new Connection();
	$objLogin = new Login();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Revolução Fatecana</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/style.css?v=<?=date("d/m/Y H:i:s")?>" />
</head>
<body>
	<div id="login_quadro">
		<div class="logo1"><img src="images/logo1.jpg" alt="logo" /></div>
		<div class="container">
			<h3>Acesso ao Sistema SCAF</h3>
			<br />
			<form action="" method="POST">
				<label for="login">E-mail:</label>
				<br />
				<input type="text" name="email" id="email" placeholder="Coloque seu e-mail de cadastro" required />
				<br />
				<br />
				<label for="senha">Senha:</label>
				<br />
				<input type="password" name="senha" id="senha" required/ />
				<br />
				<br />
				<input type="submit" value="Efetuar login" name="Enviar" />
			</form>
		</div>
		<?php
		if(isset($_POST["Enviar"]) && $_POST["Enviar"] == "Efetuar login"){
			$logar = $objLogin->Logar($_POST["email"],$_POST['senha']);
		}
        ?>
		<br />
		<?php
		if (isset($logar)){
        ?>
		<div class="container-erro-tit">AVISO</div>
        <div class="container-erro"><?php echo $logar ?>
        </div>
		<?php } ?>
	</div>
	<div id="login_barra"></div>
</body>
</html>