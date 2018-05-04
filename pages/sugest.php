<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include "inc/cabecalho.php"; ?>
    <title>Sugestões para o site</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/content.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Sugestões para o site</h2>
    <div class="form-group">
        <label for="comment"></label>
        <textarea class="form-control" rows="5" id="comment" placeholder="Deixe sua sugestão..."></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-default">Enviar</button>
    </div>
</div>
<?php include "inc/rodape.php"; ?>

</body>
</html>