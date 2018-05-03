<?php
class Upload{
    private $arquivo;
    private $altura;
    private $largura;
    private $novo_nome_arq;
    private $pasta;

    function __construct($arquivo, $altura, $largura, $novo_nome_arq, $pasta){
        $this->arquivo          = $arquivo;
        $this->altura           = $altura;
        $this->largura          = $largura;
        $this->novo_nome_arq    = $novo_nome_arq;
        $this->pasta            = $pasta;
    }

    public function getExtensao(){
        //retorna a extensao da imagem
        return $extensao = strtolower(end(explode('.', $this->arquivo['name'])));
    }

    private function ehImagem($extensao){
        $extensoes = array('gif', 'jpeg', 'jpg', 'png'); // extensoes permitidas
        if (in_array($extensao, $extensoes))
            return true;
    }

    private function redimensionar($imgLarg, $imgAlt, $tipo, $img_localizacao){
        if ( $imgLarg > $imgAlt ){
            $novaLarg = $this->largura;
            $novaAlt = round( ($novaLarg / $imgLarg) * $imgAlt );
        }
        elseif ( $imgAlt > $imgLarg ){
            $novaAlt = $this->altura;
            $novaLarg = round( ($novaAlt / $imgAlt) * $imgLarg );
        }
        else
            $novaAltura = $novaLargura = max($this->largura, $this->altura);

        //redimencionar a imagem
        $novaimagem = imagecreatetruecolor($novaLarg, $novaAlt);

        switch ($tipo){
            case 1:	// gif
                $origem = imagecreatefromgif($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
                $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagegif($novaimagem, $img_localizacao);
                break;
            case 2:	// jpg
                $origem = imagecreatefromjpeg($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
                $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagejpeg($novaimagem, $img_localizacao);
                break;
            case 3:	// png
                $origem = imagecreatefrompng($img_localizacao);
                imagecopyresampled($novaimagem, $origem, 0, 0, 0, 0,
                $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagepng($novaimagem, $img_localizacao);
                break;
        }
        imagedestroy($novaimagem);
        imagedestroy($origem);
    }

    public function salvar(){
        $destino = $this->pasta . $this->novo_nome_arq . "." . $this->getExtensao();

        //move o arquivo
        if (! move_uploaded_file($this->arquivo['tmp_name'], $destino)){
            if ($this->arquivo['error'] == 1)
                return "Tamanho excede o permitido";
            else
                return "Erro " . $this->arquivo['error'];
        }

        if ($this->ehImagem($extensao)){
            //pega a largura, altura, tipo e atributo da imagem
            list($largura, $altura, $tipo, $atributo) = getimagesize($destino);

            // testa se é preciso redimensionar a imagem
            if(($largura > $this->largura) || ($altura > $this->altura))
                $this->redimensionar($largura, $altura, $tipo, $destino);
        }
        return "Sucesso";
    }

    public function deletar(){
        $destino = $this->pasta . $this->novo_nome_arq;
        echo $destino;
        //exclui o arquivo
        unlink($destino);

        return "Sucesso";
    }
}
?>