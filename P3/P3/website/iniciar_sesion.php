<!DOCTYPE html>

<html>

<head>

    <meta charset = "utf-8" />
    <title>Iniciar sesión - Bluediv</title>
    <link rel='stylesheet' href="style.css" type="text/css" media="screen" />
	
</head>

<body>

    <header>
        <nav id="menu-superior">
		
            <ul>
		        <li>
					<div id = "div-mediana">
						<img src="images/Black_mediana.png" alt="foto_mediana"/>
					</div>
					
					<div id = "div-entrar">
						<a href="iniciar_sesion.html" class = "ele-menu">Entrar</a> <br/><br/>
						<a href="registrarse.html" class = "ele-menu">Registrarse</a>
					</div>
                </li>
				
                <li id = "logo">
                    <a href="/">
			            <img src="images/LOGO.png" id = "imgLogo" alt="foto_logo"/>
		            </a>
                </li>
				
		        <li>
                    <div id = "div-user-carro">
                        <div class = "user-carro">
                            <div>
				                <img src="images/carro.png" alt="foto_carro"/>
			                </div>

                            <div>
                                <a href="" class = "ele-menu">Tu compra</a></div>
                            </div>
                            
                        </div>
                         
                        <div class = "user-carro2">
			                <div>
				                <img src="images/user.png" alt="foto_usuario"/>
			                </div>

                            <div>
                                <a href="" class = "ele-menu">Tu cuenta</a></div>
                            </div>
                            
                    	</div>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <?php

	try {
        $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $consulta = 'SELECT username, password FROM customers WHERE username = \'' . $_POST['usuario'] . '\'';
    $gsent = $db->prepare($consulta);
    $gsent->execute();

    $resultado = $gsent->fetchAll();

    if(empty($resultado)) 
        echo '<h3>Usuario y/o contraseña incorrecto</h3>';
    
    else {
        $username_db = $resultado[0]["username"];
        $password_db = $resultado[0]["password"];

        if(strcmp($_POST['usuario'], $username_db) == 0 && strcmp($_POST['password'], $password_db) == 0){
            print("<script> window.location.href='index.php'</script>");
            session_start();
            $consulta = 'SELECT firstname  FROM customers WHERE username = \'' . $_POST['usuario'] . '\'';
            $gsent = $db->prepare($consulta);
            $gsent->execute();
            $resultado = $gsent->fetchAll();

            $nombre = $resultado[0]["firstname"];
            $_SESSION['usuarioRegistrado'] = $nombre;
            $_SESSION['nickUsuario'] = $username_db;
            $_SESSION['sesionIniciada'] = true;
            

        } else 
            echo '<h3>Usuario y/o contraseña incorrecto</h3>';
    }

    $db = null; 

		
	?>
	
</body>
</html>