<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include "../inc/cabecalho.php"; ?>
    <title>Cadastrar usuário</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/content.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Cadastrar nova chapa</h2>
    <form>
        <div class="form-group">
            <label for="sel1">Selecione o tipo de usuário:</label>
                <select class="form-control" id="sel1">
                    <option>Aluno</option>
                    <option>Professor</option>
                </select>
        </div>
        <div class="form-group">
            <label for="ra">Nome da chapa:</label>
            <input type="text" class="form-control" id="ra" placeholder="Ex: 1234567890123" name="ra" pattern="[0-9]{13}">
        </div>
        <label for="nome">Integrantes:</label>
        <div class="form-group">
            <label for="nome">Nome completo:</label>
            <input type="text" class="form-control" id="nome" placeholder="Ex: Rodrigo Salgado" name="ra" pattern="[a-zA-Z ]">
        </div>
         <div class="form-group">
            <label for="nome">Nome completo:</label>
            <input type="text" class="form-control" id="nome" placeholder="Ex: Rodrigo Salgado" name="ra" pattern="[a-zA-Z ]">
        </div>
         <div class="form-group">
            <label for="nome">Nome completo:</label>
            <input type="text" class="form-control" id="nome" placeholder="Ex: Rodrigo Salgado" name="ra" pattern="[a-zA-Z ]">
        </div>
        <button type="submit" class="btn btn-default">Cadastrar</button>
    </form>
</div>
<?php include "../inc/rodape.php"; ?>

</body>
</html>