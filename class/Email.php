<?php
session_start();
require_once('Connection.php');

Class Login{

	function __construct(){

		$objConnection = new Connection();

	}

	function verificarLogado(){
		if(!isset($_SESSION["logado"])){
			header("Location: dirname(__FILE__)/../index.php");
			exit();
		}
	}

	function Logar($email,$senha){
		$sql = "select cd_ra_aluno id, nm_senha, nm_aluno from USUARIO where nm_email ='".$email."'";
		$q_usuario = mysql_query($sql);
		if(mysql_num_rows($q_usuario) == 1){
			$d_usuario = mysql_fetch_array($q_usuario);
			if($d_usuario["nm_senha"] == md5($senha)){
				$_SESSION["id_usuario"] = $d_usuario["id"];
				$_SESSION["nm_usuario"] = $d_usuario["nm_aluno"];
				$_SESSION["logado"] = "sim";
				header("Location: dirname(__FILE__)/../welcome.php");
			}else{
				$Erro = "Senha e/ou Email errado(s)!";
				return $Erro;
			}
		}else{
			$Erro = "Senha e/ou Email errado(s)!";
			return $Erro;
		};
	}

	function getIdUsuario(){
		return $_SESSION["nm_usuario"];
	}

	function deslogar(){
		session_destroy();
		header("Location: dirname(__FILE__)/../index.php");
	}
}
?>