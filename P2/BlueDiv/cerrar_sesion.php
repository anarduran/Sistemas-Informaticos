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
                $_SESSION['productos']=NULL;
                print("<script> window.location.href='index.php'</script>");
         ?>

</body>

</html>