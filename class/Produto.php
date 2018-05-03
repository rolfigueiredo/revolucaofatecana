<?php
require_once('Connection.php');

Class Produto{

    private $cdProduto;
    private $cdCategoria;
    private $nomeCategoria;
    private $nomeProduto;
    private $valorProduto;
    private $descProduto;
    private $imgProduto;

	function __construct(){
		$objConnection = new Connection();
	}

	function getCategorias(){
        $con = new Connection();
		$sql = "Select cd_categoria, nm_categoria from PRODUTO_CATEGORIA order by nm_categoria";
		if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->execute();
            $rstemp = $stmt->get_result();
            $rstemp = $rstemp->fetch_all();
            $stmt->close();
		};
		$con->Desconectar();

        return $rstemp;
	}

	function CadProduto($categ,$produto,$valor,$desc){
        $con = new Connection();
        $valor=str_replace(",",".",$valor);
		$sql = "Insert into PRODUTO (cd_categoria,nm_produto,vl_produto,ds_produto) values (?,?,?,?)";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("isss",$categ,$produto,$valor,$desc);
            $stmt->execute();
            echo $con->mysqli->error;
            $codigo_produto=$con->mysqli->insert_id;
		}
		$con->Desconectar();

        return $codigo_produto;
	}

	function AltProduto($id,$categ,$produto,$valor,$desc){
        $con = new Connection();
        $valor=str_replace(",",".",$valor);
		$sql = "Update PRODUTO set cd_categoria=?,nm_produto=?,vl_produto=?,ds_produto=? where cd_produto=?";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("isssi",$categ,$produto,$valor,$desc,$id);
            $stmt->execute();
            echo $con->mysqli->error;
		}
		$con->Desconectar();

        return $id;
	}

	function ExcProduto($id){
        $con = new Connection();
		$sql = "Delete from PRODUTO where cd_produto=?";
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
        $sql = "Update PRODUTO set ds_local_foto=? where cd_produto=?";
        if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("si",$nome_img,$codigo);
            $stmt->execute();
            echo $con->mysqli->error;
		}
		$con->Desconectar();

        return "ok";
	}

    function QtdProdutos($pesq){
        $con = new Connection();
		$sql = "Select p.cd_produto from PRODUTO p join PRODUTO_CATEGORIA pc on pc.cd_categoria=p.cd_categoria";
        if ($pesq){
            $pesq = "%{$pesq}%";
            $sql .= " where (p.nm_produto like ? or p.ds_produto like ? or pc.nm_categoria like ?)";
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

    function ListarProdutos($pesq,$ini,$itens){
        $con = new Connection();
		$sql = "Select p.cd_produto, p.nm_produto, p.vl_produto, p.ds_produto, p.ds_local_foto, pc.nm_categoria from PRODUTO p join PRODUTO_CATEGORIA pc on pc.cd_categoria=p.cd_categoria";
        if ($pesq){
            $pesq = "%{$pesq}%";
            $sql .= " where (p.nm_produto like ? or p.ds_produto like ? or pc.nm_categoria like ?)";
        }
        $sql .= " order by p.nm_produto";
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
		$sql = "Select p.nm_produto, p.cd_categoria, p.vl_produto, p.ds_produto, p.ds_local_foto, pc.nm_categoria from PRODUTO p join PRODUTO_CATEGORIA pc on pc.cd_categoria=p.cd_categoria where p.cd_produto=?";
		if ($stmt = $con->mysqli->prepare($sql)) {
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $stmt->bind_result($nome, $cod_categ, $valor, $descr, $img, $nome_categoria);
            $stmt->store_result();
            if ($stmt->fetch()) {
                $this->cdProduto     = $id;
                $this->nomeProduto   = $nome;
                $this->cdCategoria   = $cod_categ;
                $this->nomeCategoria = $nome_categoria;
                $this->valorProduto  = $valor;
                $this->descProduto   = $descr;
                $this->imgProduto    = $img;
            }
            $stmt->close();
		};
		$con->Desconectar();
	}

	function getCodProduto(){
		return $this->cdProduto;
	}

	function getCodCategoria(){
		return $this->cdCategoria;
	}

	function getNomeCategoria(){
		return $this->nomeCategoria;
	}

	function getNomeProduto(){
		return $this->nomeProduto;
	}

	function getValorProduto(){
		return str_replace(".",",",$this->valorProduto);
	}

	function getDescProduto(){
		return $this->descProduto;
	}

	function getImgProduto(){
		return $this->imgProduto;
	}
}
?>