<!DOCTYPE html>

<html>

<head>

    <meta charset = "utf-8" />
    <title>Registro - Bluediv</title>
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
                    <a href="index.php">
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

	    if(file_exists("usuarios/" . $_POST['usuario'])==TRUE){
            echo '<h3>Ya existe un usuario con ese nombre. Vuelva a registrarse.</h3>';
            die();
        }
    
        else if(file_exists("usuarios/" . $_POST['email'])==TRUE){
            echo '<h3>Ya existe un usuario con ese email. Vuelva a registrarse.</h3>';
            die();
        }
    
	    mkdir("usuarios/" . $_POST['usuario'], 0777);

	    $file = fopen("usuarios/" . $_POST['usuario'] . "/datos.dat", "w");
        
        $monedero = rand(10.0, 50.0);
	    fwrite($file, $_POST['nombre'] . "\n" . $_POST['apellidos'] . "\n" . $_POST['sexo'] . "\n" . $_POST['email'] . "\n" . $_POST['usuario'] . "\n" . md5($_POST['password']) . "\n" . $_POST['tarjeta'] . "\n" . $_POST['direccion'] . "\n" . $_POST['telefono-fijo'] . "\n" . $_POST['telefono-movil'] . "\n" . $_POST['poblacion'] . "\n" . $_POST['provincia'] . "\n" . $monedero);
	    fclose($file);
		
		$xml = new DomDocument('1.0', 'UTF-8');
		$root = $xml->createElement('historial');
		$root = $xml->appendChild($root);
		
		$xml->preserveWhiteSpace = false;
		$xml->formatOutput = true;
		$strings_xml = $xml->saveXML();
		$xml->save('usuarios/'. $_POST['usuario'] .'/historial.xml');
	
		echo '<h3>El usuario se ha creado correctamente.</h3>';
	?>
	
</body>
</html>