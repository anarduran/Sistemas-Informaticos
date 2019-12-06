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
    <script type="text/javascript">
        function comprueba_saldo(saldo, total_compra){
            if(saldo - total_compra < 0){
                alert("No tienes saldo suficiente en tu monedero. Por favor, accede a tu cuenta para recargarlo.");
                return false;
            }

            return true;
        }
    </script>
    
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

		<?php
			if ($_SESSION['sesionIniciada'] == false){
				print(
					'<script type="text/javascript">
						window.location.href="iniciar_sesion.html";
					</script>'
				);
			} else {
				$contenido = file("usuarios/" . $_SESSION['nick_usuario'] . "/datos.dat");
				print(
					'<div id="div-confirmacion">
						<h2>CONFIRMACIÓN DE COMPRA</h2>
						<h3>Dirección de envío</h3>
						<p>
							'. $contenido[0] .' '. $contenido[1] .'<br/>
							'. $contenido[7] .'<br/>
							'. $contenido[10] .'('. $contenido[11] .')<br/>
						</p>
						<h3>Método de pago</h3>
						<p>Saldo del monedero: '. $contenido[12] .'€</p>
						<h3>Productos</h3>'
				);

				
				echo '<table id="tabla-carrito">';
                print(
                    "<tr>
                        <th>Carátula</th>
                        <th>Producto</th> 
                        <th>Formato</th>
                        <th>Cantidad</th>
                        <th>Precio</th> 
                    </tr>"
                );

				$xml = simplexml_load_file("catalogo.xml") or die("Error: Cannot create object");
                $total_compra = 0;
                foreach ($_SESSION['productos'] as $producto) {

                    foreach ($xml->pelicula as $peliculas) {

                        if($producto[0] == $peliculas->id){

                            if($producto[1] == "dvd"){
                                echo '<tr>';
                                    echo '<td><img class="caratula-carrito" src ="'. $peliculas->caratula .'" alt="'. $peliculas->titulo .'"></td>';
                                    echo '<td>'. $peliculas->titulo .'</td>';
                                    echo '<td><img src="images/dvd.png" alt="foto" class="img-formato"/></td>';
                                    echo '<td>'. $producto[2] .'</td>';
                                    echo '<td>'. $peliculas->precio_dvd .'</td>';
                                echo '</tr>';
                                $total_compra += $producto[2] * doubleval($peliculas->precio_dvd);
                            }

                            else {
                                echo '<tr>';
                                    echo '<td><img class="caratula-carrito" src ="'. $peliculas->caratula .'" alt="'. $peliculas->titulo .'"></td>';
                                    echo '<td>'. $peliculas->titulo .'</td>';
                                    echo '<td><img src="images/ray.png" alt="foto" class="img-formato"/></td>';
                                    echo '<td>'. $producto[2] .'</td>';
                                    echo '<td>'. $peliculas->precio_blueray .'</td>';
                                echo '</tr>';
                                $total_compra += $producto[2] * doubleval($peliculas->precio_blueray);
                            }
                            
                        }
                    }
                }
                $_SESSION['total_compra'] = $total_compra;
                    echo '<tr>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td>Total: </td>';
                        echo '<td>'.$total_compra.'€</td>';
                    echo '</tr>'; 
                echo '</table>';
                echo '<br/><br/>';
                print(
                    '<div id="div-from-confirmacion">
	                    <form id="form-confirmacion" method="post" action="confirmacion_de_compra.php" onSubmit = "return comprueba_saldo('. $contenido[12] .','.$total_compra.');">
                            <input type="button" value="Volver al carrito" onclick="window.location.href=\'carrito.php\'">
	                        <input type="Submit" value="Confirmar Compra">
	                    </form>
	                </div>'
                );
                echo '</div>';
                echo '<br/><br/>';
            }
		?>

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