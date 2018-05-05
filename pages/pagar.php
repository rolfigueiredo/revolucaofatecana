<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include "inc/cabecalho.php"; ?>
    <title>Pagamento</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/content.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Formas de pagamento</h2>
    <form>
        <div class="radio">
            <label><input type="radio" name="optradio">Dinheiro</label>
        </div>
        <div class="radio">
            <label><input type="radio" name="optradio">PagSeguro</label>
        </div>
    </form>
    <button type="submit" class="btn btn-default">Continuar</button>

</div>
<?php include "inc/rodape.php"; ?>

</body>
</html>