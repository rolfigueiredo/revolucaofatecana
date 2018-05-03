<?php
Class Paginacao{
    private $total;
    private $itens;
    private $ini;

    function __construct($total){
        $this->ini      = 0;
        $this->itens    = 10;
        $this->total    = $total;
    }

    function GetIni(){
        return $this->ini;
    }
    function SetIni($v){
        $this->ini = $v;
    }

    function GetItens(){
        return $this->itens;
    }
    function SetItens($v){
        $this->itens = $v;
    }

    function GetTotalItens(){
        return $this->total;
    }

    function ValidarPaginacao(){
        if (($this->ini % $this->itens)){
            return false;
        }
        return true;

    }

    function ItensPaginar(){
        $txt="Exibindo de ";
        $txt.=$this->ini+1;
        $txt.=" a ";
        if (($this->ini+$this->itens)>$this->total)
            $txt.=$this->total;
        else
            $txt.=$this->ini+$this->itens;

        return $txt;
    }

    function Paginar(){
        $pags=intval($this->total/$this->itens)+1;

        // Evita que uma página que não exista seja acessada
        if($this->ini > ($pags+1)) {
            die('404');
        }

        $pag=0;

        echo "<nav aria-label=\"Page navigation\">";
        echo "<ul class=\"pagination\">";
        echo "<li class=\"page-item";
        if ($this->ini==0){ echo " disabled";};
        echo "\">";
        echo "<a class=\"page-link\" href=\"?ini=$pag\" aria-label=\"Anterior\">";
        echo "<span aria-hidden=\"true\">&laquo;</span>";
        echo "<span class=\"sr-only\">Anterior</span>";
        echo "</a>";
        echo "</li>";
        for ($i=1;$i<=$pags;$i++){
            echo "<br>";
            echo "<li class=\"page-item";
            if ($pag==$this->ini){ echo " active";};
            echo "\">";
            echo "<a class=\"page-link\" href=\"?ini=$pag\">$i</a>";
            echo "</li>";
            $pag+=$this->itens;
        }
        $pag-=$this->itens;
        echo "<li class=\"page-item";
        if ($this->ini==$pags){ echo " disabled";};
        echo "\">";
        echo "<a class=\"page-link\" href=\"?ini=$pag\" aria-label=\"Próximo\">";
        echo "<span aria-hidden=\"true\">&raquo;</span>";
        echo "<span class=\"sr-only\">Próximo</span>";
        echo "</a>";
        echo "</li>";
        echo "</ul>";
        echo "</nav>";
    }
}
?>