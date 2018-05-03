<?php
class Connection extends mysqli{

	var $Server = "mysql07-farm56.kinghost.net";
	var $Username = "revolucaofatec";
	var $Password = "revfatec88";
	var $Database = "revolucaofatec";
    public $mysqli;

	function __construct(){
		$this->Conectar();
	}

	function Conectar(){
        $this->mysqli = new mysqli($this->Server,$this->Username,$this->Password,$this->Database);
		if(!mysqli)
			echo "Erro ao tentar abrir a conexão!";
	}

    function Desconectar(){
        $this->mysqli->close();
    }
}
?>