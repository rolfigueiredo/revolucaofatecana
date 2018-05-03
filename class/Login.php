<?php
session_start();
require_once('Connection.php');

Class Login{

    public function __construct(){
		$con = new Connection();
	}

	public function verificarLogado(){
		if(!isset($_SESSION["logado"])){
			header("Location: dirname(__FILE__)/../index.php");
			exit();
		}
	}

	public function Logar($email,$senha){
		$con = new Connection();
		$sql = "select u.cd_usuario, u.nm_senha, u.nm_usuario, tu.nm_tipo_usuario from USUARIO u join TIPO_USUARIO tu on tu.cd_tipo_usuario=u.TIPO_USUARIO_cd_tipo_usuario where nm_email = ?";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("s",$email);
            $stmt->execute();
            $stmt->bind_result($id, $senhadb, $usuario, $tipo);
            $stmt->fetch();
			if($senhadb == md5($senha)){
				$_SESSION["id_usuario"] = $email;
				$_SESSION["nm_usuario"] = $usuario;
				$_SESSION["nm_tipo"] = $tipo;
				$_SESSION["logado"] = "sim";
				header("Location: dirname(__FILE__)/../admin.php");
			}else{
				$Erro = "Senha e/ou Email errado(s)!";
				return $Erro;
			}
		}else{
			$Erro = "Senha e/ou Email errado(s)!";
			return $Erro;
		};
        $stmt->close();
		$con->Desconectar();
	}

	public function getIdUsuario(){
		return $_SESSION["nm_usuario"];
	}

	public function getTipoUsuario(){
		return $_SESSION["nm_tipo"];
	}

	public function deslogar(){
		session_destroy();
		header("Location: dirname(__FILE__)/../index.php");
	}
}
?>