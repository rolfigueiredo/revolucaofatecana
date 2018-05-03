<?php
require_once('Connection.php');
require_once('Paginacao.php');

Class Usuario{

    private $cdUsuario;
    private $cdTipo;
    private $RaAluno;
    private $cdCursoAluno;
    private $nomeUsuario;
    private $emailUsuario;
    private $imgUsuario;

	function __construct(){
		$objConnection = new Connection();
	}

	function getTipos(){
        $con = new Connection();
		$sql = "Select cd_tipo_usuario, nm_tipo_usuario from TIPO_USUARIO order by nm_tipo_usuario";
		if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->execute();
            $rstemp = $stmt->get_result();
            $rstemp = $rstemp->fetch_all();
            $stmt->close();
		};
		$con->Desconectar();

        return $rstemp;
	}

	function getCursos(){
        $con = new Connection();
		$sql = "Select cd_curso, sg_curso, nm_curso from USUARIO_ALUNO_CURSO order by nm_curso";
		if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->execute();
            $rstemp = $stmt->get_result();
            $rstemp = $rstemp->fetch_all();
            $stmt->close();
		};
		$con->Desconectar();

        return $rstemp;
	}

	function CadUsuario($tipo,$ra,$curso,$nome,$email,$senha){
        $con = new Connection();
		$sql = "Insert into USUARIO (TIPO_USUARIO_cd_tipo_usuario,nm_usuario,nm_email, nm_senha) values (?,?,?,?)";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("isss",$tipo,$nome,$email,md5($senha));
            $stmt->execute();
            echo $con->mysqli->error;
            $codigo_usuario=$con->mysqli->insert_id;

            if ($tipo==1){
                $sql1 = "Insert into USUARIO_ALUNO (ALUNO_cd_usuario, cd_ra_aluno,USUARIO_ALUNO_CURSO_cd_curso) values (?,?,?)";
                if ($stmt1 = $con->mysqli->prepare($sql1)) {
                    $stmt1->bind_param("isi",$codigo_usuario,$ra,$curso);
                    $stmt1->execute();
                    echo $con->mysqli->error;
                }
            }
		}
		$con->Desconectar();
        return $codigo_usuario;
	}

	function AltUsuario($id,$tipo,$ra,$curso,$nome,$email,$senha){
        $con = new Connection();
        $valor=str_replace(",",".",$valor);
		$sql = "Update USUARIO set TIPO_USUARIO_cd_tipo_usuario=?,nm_usuario=?,nm_email=? where cd_usuario=?";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("issi",$tipo,$nome,$email,$id);
            $stmt->execute();
            echo $con->mysqli->error;

            if ($senha){
                $sql1 = "Update USUARIO set nm_senha=? where ALUNO_cd_usuario=?";
                if ($stmt1 = $con->mysqli->prepare($sql1)) {
                    $stmt1->bind_param("si",md5($senha),$id);
                    $stmt1->execute();
                    echo $con->mysqli->error;
                }
            }

            if ($tipo==1){
                $sql1 = "Update USUARIO_ALUNO set cd_ra_aluno=?,USUARIO_ALUNO_CURSO_cd_curso=? where ALUNO_cd_usuario=?";
                if ($stmt1 = $con->mysqli->prepare($sql1)) {
                    $stmt1->bind_param("isi",$ra,$curso,$id);
                    $stmt1->execute();
                    echo $con->mysqli->error;
                }
            }
		}
		$con->Desconectar();

        return $id;
	}

	function ExcUsuario($id){
        $con = new Connection();
		$sql = "Delete from USUARIO_ALUNO where ALUNO_cd_usuario=?";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("i",$id);
            $stmt->execute();
            echo $con->mysqli->error;
		}
		$sql = "Delete from USUARIO where cd_usuario=?";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("i",$id);
            $stmt->execute();
            echo $con->mysqli->error;
		}
		$con->Desconectar();

        return $id;
	}

	function AtualizaImagem($codigo,$nome_img){
        $con = new Connection();
        $sql = "Update USUARIO set ds_local_foto=? where cd_usuario=?";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("si",$nome_img,$codigo);
            $stmt->execute();
            echo $con->mysqli->error;
		}
		$con->Desconectar();

        return "ok";
	}

    function QtdUsuarios($pesq){
        $con = new Connection();
		$sql = "Select u.cd_usuario from USUARIO u left outer join USUARIO_ALUNO ua on ua.ALUNO_cd_usuario=u.cd_usuario";
        if ($pesq){
            $pesq = "%{$pesq}%";
            $sql .= " where (u.nm_usuario like ? or u.nm_email like ? or ua.cd_ra_aluno like ?)";
        }
		if ($stmt = $con->mysqli->prepare($sql)) {
            if ($pesq)
                $stmt->bind_param("sss",$pesq,$pesq,$pesq);
            $stmt->execute();
            $stmt->store_result();
            $registros = $stmt->num_rows();
            $stmt->free_result();
            $stmt->close();
		};
		$con->Desconectar();

        return $registros;
    }

    function ListarUsuarios($pesq,$ini,$itens){
        $con = new Connection();
		$sql = "Select u.cd_usuario, u.nm_usuario, u.nm_email, u.ds_local_foto, ua.cd_ra_aluno, tu.nm_tipo_usuario, ac.sg_curso from USUARIO u join TIPO_USUARIO tu on tu.cd_tipo_usuario=u.TIPO_USUARIO_cd_tipo_usuario left outer join USUARIO_ALUNO ua on ua.ALUNO_cd_usuario=u.cd_usuario left outer join USUARIO_ALUNO_CURSO ac on ac.cd_curso=ua.USUARIO_ALUNO_CURSO_cd_curso";
        if ($pesq){
            $pesq = "%{$pesq}%";
            $sql .= " where (u.nm_usuario like ? or u.nm_email like ? or ua.cd_ra_aluno like ?)";
        }
        $sql .= " order by u.nm_usuario";
        $sql .= " LIMIT $ini,$itens";
		if ($stmt = $con->mysqli->prepare($sql)) {
            if ($pesq)
                $stmt->bind_param("sss",$pesq,$pesq,$pesq);
            $stmt->execute();
            $rstemp = $stmt->get_result();
            $rstemp = $rstemp->fetch_all();
            $stmt->close();
		};
		$con->Desconectar();

        return $rstemp;
    }

	function getDados($id){
        $con = new Connection();
		$sql = "Select u.TIPO_USUARIO_cd_tipo_usuario cd_tipo_usuario, u.nm_usuario, u.nm_email, u.ds_local_foto, ua.cd_ra_aluno, ua.USUARIO_ALUNO_CURSO_cd_curso cd_curso from USUARIO u left outer join USUARIO_ALUNO ua on ua.ALUNO_cd_usuario=u.cd_usuario where u.cd_usuario=?";
		if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $stmt->bind_result($cod_tipo, $nome, $email, $img, $ra, $cod_curso);
            $stmt->store_result();
            if ($stmt->fetch()) {
                $this->cdUsuario    = $id;
                $this->cdTipo       = $cod_tipo;
                $this->RaAluno      = $ra;
                $this->cdCursoAluno = $cod_curso;
                $this->nomeUsuario  = $nome;
                $this->emailUsuario = $email;
                $this->imgUsuario   = $img;
            }
            $stmt->close();
		};
		$con->Desconectar();
	}

	function getCodUsuario(){
		return $this->cdUsuario;
	}

	function getCodTipo(){
		return $this->cdTipo;
	}

	function getRaAluno(){
		return $this->RaAluno;
	}

	function getCodCursoAluno(){
		return $this->cdCursoAluno;
	}

	function getNomeUsuario(){
		return $this->nomeUsuario;
	}

	function getEmailUsuario(){
		return $this->emailUsuario;
	}

	function getImgUsuario(){
		return $this->imgUsuario;
	}

}
?>