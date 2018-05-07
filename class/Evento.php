<?php
require_once('Connection.php');

Class Evento{


    private $cdEvento;
    private $nomeEvento;
    private $descEvento;
    private $localEvento;
    private $imgEvento;
    private $dtInicialEvento;
    private $dtFinalEvento;
    private $nomePalestrante;

	function __construct(){
		$objConnection = new Connection();
	}

	function getEventos(){
        $con = new Connection();
		$sql = "Select cd_evento, nm_evento, dt_inicial_evento from EVENTO order by dt_inicial_evento";
		if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->execute();
            $rstemp = $stmt->get_result();
            $rstemp = $rstemp->fetch_all();
            $stmt->close();
		};
		$con->Desconectar();

        return $rstemp;
	}

	function CadEvento($cod,$nome,$desc,$local,$dtInicio,$dtFim,$palestrante){
        $con = new Connection();
        $dtInicio= new DateTime($dtInicio);
        $dtFim = new DateTime($dtFim);
        //Verificar se o tratamento de datas está correto
		$sql = "Insert into EVENTO (cd_evento, nm_evento, ds_evento, ds_local_evento, dt_inicial_evento ,dt_final_evento, nm_palestrante) values (?,?,?,?,?,?,?)";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("issssss",$cod,$nome,$desc,$local,$dtInicio,$dtFim,$palestrante);
            $stmt->execute();
            echo $con->mysqli->error;
            $codigo_evento=$con->mysqli->insert_id;
		}
		$con->Desconectar();

        return $codigo_evento;
	}

	function AltEvento($cod,$nome,$desc,$local,$dtInicio,$dtFim,$palestrante){
        $con = new Connection();
        $dtInicio= new DateTime($dtInicio);
        $dtFim = new DateTime($dtFim);
        //Aqui também
		$sql = "Update EVENTO set cd_evento=?,nm_evento=?,ds_evento=?,dt_inicial_evento=?, dt_final_evento=?, nm_palestrante=? where cd_evento=?";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("issssssi",$cod,$nome,$desc,$local,$dtInicio,$dtFim,$palestrante,$cod);
            $stmt->execute();
            echo $con->mysqli->error;
		}
		$con->Desconectar();

        return $cod;
	}

	function ExcEvento($cod){
        $con = new Connection();
		$sql = "Delete * from EVENTO where cd_evento=?";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("i",$cod);
            $stmt->execute();
            echo $con->mysqli->error;
		}
		$con->Desconectar();

        return $cod;
	}

	function AtualizaImagem($cod,$img){
        $con = new Connection();
        $sql = "Update EVENTO set ds_local_imagem_evento=? where cd_evento=?";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("si",$img,$cod);
            $stmt->execute();
            echo $con->mysqli->error;
		}
		$con->Desconectar();

        return "ok";
	}


	function getDados($id){
        $con = new Connection();
		$sql = "Select e.nm_evento, e.ds_evento, e.ds_local_evento, e.ds_local_imagem_evento, e.dt_inicial_evento, e.dt_final_evento, e.nm_palestrante from EVENTO E where e.cd_evento=?";
		if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $stmt->bind_result($nome,$desc,$local,$img,$dtInicio,$dtFim,$palestrante);
            $stmt->store_result();
            if ($stmt->fetch()) {
                $this->cdEvento             = $id;
                $this->nomeEvento           = $nome;
                $this->descEvento           = $desc;
                $this->localEvento          = $local;
                $this->imgEvento            = $img;
                $this->dtInicialEvento      = $dtInicio;
                $this->dtFinalEvento        = $dtFim;
                $this->nomePalestrante      = $palestrante;
            }
            $stmt->close();
		};
		$con->Desconectar();
	}

	function getCodEvento(){
		return $this->cdEvento;
	}

	function getNomeEvento(){
		return $this->nomeEvento;
    }
    
    function getDescEvento(){
        return $this->descEvento;
    }

    function getLocalEvento(){
        return $this->localEvento;
    }

	function getDataInicialEvento(){
		return DateTime($this->dtInicialEvento);
    }
    
    function getDataFinalEvento(){
		return DateTime($this->dtFinalEvento);
	}

	function getDescEvento(){
		return $this->descEvento;
	}

	function getImgEvento(){
		return $this->imgEvento;
    }
    
    function getNomePalestrante(){
        return $this->nomePalestrante;
    }
}
?>