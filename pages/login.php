<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>REVOLUÇÃO FATECANA</title>
        <!--<link rel="stylesheet" type="text/css" 
          href="style/login.css" /> -->
        <style type="text/css"/> 
            /*IMG {box-shadow: 12px 9px 24px 3px #000000;}*/
            /*#div2 {margin-top: auto;
            margin-left:640px}*/
            div {background-color: #ccd1c2;
            border-radius: 20px;
            box-shadow: 4px 4px 15px 5px #000000;
            text-align: center;
            heigth: 100px;
            width: 320px;
            padding-top: 10px;
            padding-bottom: 10px
            }
    </style>
    </head>
    
    <body>
        
        <!--<img src="https://photos.app.goo.gl/Nn4qvqqESezTVYRn2" width="320" height="240" alt="Revolução Fatecana"/>-->
        <!--<div id="div2">-->
        <img src="../img/logo.jpg" width="320" height="320" alt="logo"/>
        <br/><br/><br/>
        <form action="action.php" method="post">
            <div id:="div1" > RA: <br><input type="number" max-length="13" name="txtRA" /></div><br/>
            <div id:="div1">Senha: <br><input type="password" name="txtSenha"></div><br/>
            <div><input type="submit" value="Login" name="btnLogin"/></div>
        </form>
        <!--</div>-->
        <?php
        // put your code here
        ?>
        
    </body>
</html>
