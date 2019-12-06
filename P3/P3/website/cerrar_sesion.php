<!DOCTYPE html>

<html>

<head>

    <meta charset = "utf-8" />
    <title>Bluediv</title>
    <link rel='stylesheet' href="style.css" type="text/css" media="screen" />
	
</head>

<body>
            
         <?php
                session_start();
                $_SESSION['usuarioRegistrado']='';
                $_SESSION['sesionIniciada']=false;
                $_SESSION['id_carrito'] = null;
                $_SESSION['id_usuario'] = null;
                print("<script> window.location.href='index.php'</script>");
         ?>

</body>

</html>