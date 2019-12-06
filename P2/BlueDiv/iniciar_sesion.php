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

	if(file_exists("usuarios/" . $_POST['usuario']) == FALSE){
		echo '<h3>No existe ningun usuario con ese nombre.</h3>';
		die();
	}

	$contenido = file("usuarios/" . $_POST['usuario'] . "/datos.dat");
	
	/*Obtenemos los contenidos del fichero*/
	$nombre = $contenido[0];
	$apellidos = $contenido[1];
	$sexo = $contenido[2];
	$email = $contenido[3];
	$usuario = $contenido[4]; 
	$contrasena = $contenido[5];
	$tarjeta = $contenido[6];
	$direccion = $contenido[7];
	$fijo = $contenido[8];
	$movil = $contenido[9];
	$poblacion = $contenido[10];
	$provincia = $contenido[11];
	$saldo = $contenido[12];

	/* Retiramos los saltos de linea */
	$usuario = trim($usuario); 
	$contrasena = trim($contrasena);

	if(strcmp($_POST['usuario'], $usuario) == 0 && strcmp(md5($_POST['password']), $contrasena) == 0){
		
        print("<script> window.location.href='index.php'</script>");
		session_start();
        $_SESSION['usuarioRegistrado'] = $nombre;
        $_SESSION['apellidos'] = $apellidos;
        $_SESSION['sexo'] = $sexo;
        $_SESSION['email'] = $email;
        $_SESSION['nick_usuario'] = $usuario;
        $_SESSION['contrasena'] = $contrasena;
        $_SESSION['tarjeta'] = $tarjeta;
        $_SESSION['direccion'] = $direccion;
        $_SESSION['fijo'] = $fijo;
        $_SESSION['movil'] = $movil;
        $_SESSION['poblacion'] = $poblacion;
        $_SESSION['provincia'] = $provincia;
        $_SESSION['sesionIniciada'] = true;
        $_SESSION['saldo'] = $saldo;
	}
	
	else 
		echo '<h3>Contraseña incorrecta.</h3>';
		
	?>
	
</body>
</html>