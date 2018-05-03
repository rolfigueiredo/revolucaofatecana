<?php
require_once('Connection.php');

Class Vendas{
    private $itens;

    function __construct(){
        $this->itens    = Array();
    }

    public function Carrinho($id,$nome,$valor){
        if (!empty($_SESSION['vendas'])){
            $this->itens=$_SESSION['vendas'];
        }
        $valor=str_replace(",",".",$valor);
        $novo_item = array (
            'cd_produto'    => $id,
            'nome_produto'    => $nome,
            'qtd_produto'   => 1,
            'vl_produto'    => $valor
        );
        array_push($this->itens,$novo_item);

        $_SESSION['vendas']=$this->itens;
    }

    public function AltQtd($id,$qtd){
        $_SESSION['vendas'][$id]['qtd_produto']=$qtd;
    }

    public function LimparCarrinho(){
        unset($_SESSION['vendas']);
    }

    function GravarCarrinho($id){
        $data_atual=(new \DateTime())->format('Y-m-d H:i:s');
        $con = new Connection();
		$sql = "Insert into COMPRA (dt_compra, USUARIO_cd_usuario) values (?,?)";
        echo "#0";
        if ($stmt = $con->mysqli->prepare($sql)) {
            echo "#1";
            $stmt->bind_param("si",$data_atual,$id);
            $stmt->execute();
            echo $con->mysqli->error;
            $codigo_compra=$con->mysqli->insert_id;

            if ($codigo_compra){
                $sql1 = "Insert into COMPRA_ITENS (COMPRA_cd_compra, PRODUTO_cd_produto, qtd_item, vl_unitario) values (?,?,?,?)";
                if ($stmt1 = $con->mysqli->prepare($sql1)) {

                    $carrinho_qtdItens=count($_SESSION['vendas']);
                    if ($carrinho_qtdItens>0){
                        for ($i=0;$i<$carrinho_qtdItens;$i++) {
                            $stmt1->bind_param("iiis",$codigo_compra,$_SESSION['vendas'][$i]['cd_produto'],$_SESSION['vendas'][$i]['qtd_produto'],$_SESSION['vendas'][$i]['vl_produto']);
                            $stmt1->execute();
                            echo $con->mysqli->error;
                        }
                    }
                }
            }
		}
		$con->Desconectar();
        return "ok";
	}
}
?>