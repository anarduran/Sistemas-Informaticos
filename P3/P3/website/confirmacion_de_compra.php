<?php
    session_set_cookie_params(0,"/"); 
    session_start();

    if(!isset($_SESSION['sesionIniciada']))
        $_SESSION['sesionIniciada'] = false;
?>

<!DOCTYPE html>

<html>

<head>

    <meta charset = "utf-8" />
    <title>Bluediv</title>
    <link rel='stylesheet' href="style.css" type="text/css" media="screen" />
    
</head>

<body>

    <header>
        <nav id="menu-superior">
            
            <?php
            
            if ($_SESSION['sesionIniciada']==true){
            $u=$_SESSION['usuarioRegistrado'];
            
            print("
		
            <ul>
		        <li>
					<div id=div-mediana>
						<img src='images/Black_mediana.png' alt='foto_mediana'/>
					</div>
					
					<div id=div-entrar>
						<a href='cerrar_sesion.php' class='ele-menu'>Cerrar Sesión</a> <br/><br/>
					</div>
                </li>
				
                <li id=logo>
                    <a href=index.php>
			            <img src='images/LOGO.png' id=imgLogo alt='foto_logo'/>
		            </a>
                </li>
				
		        <li>
                    <div id=div-user-carro>
                    
                        <div class='user-carro'>
                            <div>
                                <a href='carrito.php'><img src='images/carro.png' alt='foto_carro'/></a>
                            </div>

                            <div>
                                <a href='carrito.php' class='ele-menu'>Tu compra</a></div>
                            </div>
                        </div>
                        
                        <div class='user-carro2'>
			                <div>
				                <a href='tu_cuenta.php'><img src='images/user.png' alt='foto_usuario'/></a>
			                </div>

                            <div>
                                <a href='tu_cuenta.php' class='ele-menu'>Usuario: $u</a></div>
                            </div>
                    	</div>
					</div>
                </li>
            </ul>
            ");
            }
            else{
                
            print("
		
            <ul>
		        <li>
					<div id=div-mediana>
						<img src='images/Black_mediana.png' alt='foto_mediana'/>
					</div>
					
					<div id=div-entrar>
						<a href='iniciar_sesion.html' class='ele-menu'>Entrar</a> <br/><br/>
						<a href='registrarse.html' class='ele-menu'>Registrarse</a>
					</div>
                </li>
				
                <li id=logo>
                    <a href=index.php>
			            <img src='images/LOGO.png' id=imgLogo alt='foto_logo'/>
		            </a>
                </li>
				
		        <li>
                    <div id=div-user-carro>
                    
                        <div class='user-carro'>
                            <div>
                                <a href='carrito.php'><img src='images/carro.png' alt='foto_carro'/></a>
                            </div>

                            <div>
                                <a href='carrito.php' class='ele-menu'>Tu compra</a></div>
                            </div>
                        </div>
                        
                        <div class='user-carro2'>
			                <div>
				                <a href='iniciar_sesion.html'><img src='images/user.png' alt='foto_usuario'/></a>
			                </div>

                            <div>
                                <a href='iniciar_sesion.html' class='ele-menu'>Tu cuenta</a></div>
                            </div>
                    	</div>
					</div>
                </li>
            </ul>
            ");
            }
            
            ?>
            
		</nav>
		
   </header>
   <div>
        <?php
            $contenido = file("usuarios/" . $_SESSION['nick_usuario'] . "/datos.dat");
            $saldototal = $contenido[12] - $_SESSION['total_compra'];
       
            $apellidos=$_SESSION['apellidos'];
            $sexo=$_SESSION['sexo'];
            $email=$_SESSION['email'];
            $usuario=$_SESSION['nick_usuario'];
            $contrasena=$_SESSION['contrasena'];
            $tarjeta=$_SESSION['tarjeta'];
            $direccion=$_SESSION['direccion'];
            $fijo=$_SESSION['fijo'];
            $movil=$_SESSION['movil'];
            $poblacion=$_SESSION['poblacion'];
            $provincia=$_SESSION['provincia'];
           
            /*Retiramos los saltos de linea*/
            $u = trim($u);
            $apellidos = trim($apellidos);
            $sexo = trim($sexo);
            $email = trim($email);
            $usuario = trim($usuario); 
            $contrasena = trim($contrasena);
            $tarjeta = trim($tarjeta);
            $direccion = trim($direccion);
            $fijo = trim($fijo);
            $movil = trim($movil);
            $poblacion = trim($poblacion);
            $provincia = trim($provincia);

            $file = fopen("usuarios/" . $usuario . "/datos.dat", "w");
           
            /*Sobreescribimos el fichero*/
            fwrite($file, $u . "\n" . $apellidos . "\n" . $sexo . "\n" . $email . "\n" . $usuario . "\n" . $contrasena . "\n" . $tarjeta . "\n" . $direccion . "\n" . $fijo . "\n" . $movil . "\n" . $poblacion . "\n" . $provincia. "\n" . $saldototal);
            
            $numpedido=rand(0,5000);
            $xml = simplexml_load_file("catalogo.xml") or die("Error: Cannot create object"); 
            $historial = simplexml_load_file("usuarios/$usuario/historial.xml");
            $pedido = $historial->addChild('pedido');
            $pedido->addChild('num_pedido', $numpedido);
            $fecha = date('d/m/y');
            $pedido->addChild('fecha', $fecha);
            $hora = date('G:i');
            $pedido->addChild('hora', $hora);
            
            foreach ($_SESSION['productos'] as $producto) {
                foreach ($xml->pelicula as $pelicula) {
                    if($producto[0] == $pelicula->id){
                        if($producto[1] == "dvd"){
                            $xml_producto = $pedido->addChild('producto');
                            $xml_producto->addChild('titulo',''. $pelicula->titulo .'');
                            $xml_producto->addChild('formato','dvd');
                            $xml_producto->addChild('precio',''. $pelicula->precio_dvd .'');
                            $xml_producto->addChild('cantidad',''.$producto[2].'');
                        }

                        else {
                            $xml_producto = $pedido->addChild('producto');
                            $xml_producto->addChild('titulo',''. $pelicula->titulo .'');
                            $xml_producto->addChild('formato','blueray');
                            $xml_producto->addChild('precio',''. $pelicula->precio_blueray .'');
                            $xml_producto->addChild('cantidad',''.$producto[2].'');
                        }
                    }
                }
            }

            $pedido->addChild('total_compra', $_SESSION['total_compra']);

            $historial->asXML("usuarios/$usuario/historial.xml");
            
            $simplexml = simplexml_load_file("usuarios/$usuario/historial.xml");
            $dom = new DOMDocument('1.0');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            
            $dom->load("usuarios/$usuario/historial.xml");
            $dom->save("usuarios/$usuario/historial.xml");

            $_SESSION['productos'] = NULL;
            $_SESSION['total_compra'] = NULL;
        ?>
        <div id="div-compra-realizada">
            <h3>Su compra se ha realizado con éxito</h3>
            <h4>En breve recibirá un email con los datos del pedido</h4>
        </div>
       
   </div>
   <footer>
    
        <ul>
            <li>Envío seguro 3-5 días</li>
            <li>|</li>
            <li>Bluediv 2017</li>
            <li>|</li>
            <li><img src="images/pago_seguro.png" alt="foto_pago"/></li>
        </ul>
        
    </footer>

</body>

</html>