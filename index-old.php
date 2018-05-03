<?php
	require_once(dirname(__FILE__).'/class/Login.php');

	$objConnection = new Connection();
	$objLogin = new Login();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Revolução Fatecana</title>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
	<div class="container-geral">
		<div class="logo"><img src="images/logo1.jpg" alt="logo" /></div>
		<div class="container login">
			<h3>Formulário de Login</h3>
			<br />
			<form action="" method="POST">
				<label for="login">E-mail:</label>
				<br />
				<input type="text" name="email" id="email" placeholder="Coloque seu e-mail de cadastro" required />
				<br />
				<br />
				<label for="senha">Senha:</label>
				<br />
				<input type="password" name="senha" id="senha" required/>
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
			<div class="container-erro">
				<?php echo $logar ?>
			</div>
		<?php } ?>
	</div>
</body>
</html>