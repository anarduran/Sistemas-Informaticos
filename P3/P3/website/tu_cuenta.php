<?php
    session_set_cookie_params(0,"/"); 
    session_start();
?>

<!DOCTYPE html>

<html>

<head>

    <meta charset = "utf-8" />
    <title>Película - Bluediv</title>
    <link rel='stylesheet' href="style.css" type="text/css" media="screen" />
    <script type="text/javascript" src="JavaScript/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
	    	$('#tabla-historial').on('click', '.fila-pedido', function(){
	    		var id = $(this).attr('id');
	    		var res = id.split('-');
				$("#div-tabla-detalle-" + res[1]).toggle("slow");
			})
		});
    </script>
	
</head>

<body>

    <header>
        <nav id="menu-superior">
            
            <?php
            
            if ($_SESSION['sesionIniciada']==true){
            $u=$_SESSION['usuarioRegistrado'];
            $usuario=$_SESSION['nick_usuario'];
            
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
		if(isset($_GET['recarga']) && $_POST['recarga'] != ""){
			$contenido = file("usuarios/" . $usuario . "/datos.dat");
	    	$saldo = $contenido[12];
		    $saldototal = $saldo + $_POST['recarga'];
		   
		    $apellidos = $_SESSION['apellidos'];
		    $sexo = $_SESSION['sexo'];
		    $email = $_SESSION['email'];
		    $usuario = $_SESSION['nick_usuario'];
		    $contrasena = $_SESSION['contrasena'];
		    $tarjeta = $_SESSION['tarjeta'];
		    $direccion = $_SESSION['direccion'];
		    $fijo = $_SESSION['fijo'];
		    $movil = $_SESSION['movil'];
		    $poblacion = $_SESSION['poblacion'];
		    $provincia = $_SESSION['provincia'];
		   
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
		}
		
	?>
	<div id="div-recarga-saldo">
	
	<?php
	
	    $contenido = file("usuarios/" . $usuario . "/datos.dat");
	    $saldo = $contenido[12];
	    echo'<form id="form-recargar" method="post" Action="tu_cuenta.php?recarga=1" name=recargar>';
				echo'<b>Recargar saldo:</b>';
				echo'<div id="div-lista-recarga">';
				    echo'<select id="lista-recargas" name="recarga">';
				      echo'<option value="" selected="selected">- Cantidad -</option>';
				      echo'<option value="5">5€</option>';
				      echo'<option value="10">10€</option>';
				      echo'<option value="20">20€</option>';
				      echo'<option value="50">50€</option>';
				      echo'<option value="100">100€</option>';
				    echo'</select>';
				echo'<input type="Submit" value="Recargar">';
			    echo'</div><br/><br/><br/>';
			    print("<b>Saldo disponible: </b>" . $saldo . "€");
	    echo'</form>';
	    
	?>
	</div>
	<div id="div-tabla-historial">
	<?php
						
			$xml = simplexml_load_file("usuarios/$usuario/historial.xml");
			echo '<table id="tabla-historial">';
                print(
                    '<tr>
                        <th>Nº Pedido</th>
                        <th>Fecha</th> 
                        <th>Hora</th> 
                        <th>Total Compra</th> 
                    </tr>'
                );
				foreach($xml->pedido as $pedido){
					print(
						'<tr id="fila-'. $pedido->num_pedido .'" class="fila-pedido">
							<td>'. $pedido->num_pedido .'</td>
							<td>'. $pedido->fecha .'</td>
							<td>'. $pedido->hora .'</td>
							<td>'. $pedido->total_compra .' €</td>
						</tr>'
					);

					
				}
				echo '</table>';
				$contenido = file("usuarios/" . $_SESSION['nick_usuario'] . "/datos.dat");
				foreach($xml->pedido as $pedido){
					print(' 
						<div id="div-tabla-detalle-'. $pedido->num_pedido .'" class="div-tabla-detalle">
							<br><br><br>
								<h3>Pedido nº '. $pedido->num_pedido .'</h4>
								<h4>Dirección de envío</h3>
							<p>
							'. $contenido[0] .' '. $contenido[1] .'<br/>
							'. $contenido[7] .'<br/>
							'. $contenido[10] .'('. $contenido[11] .')<br/>
							</p>
								<table class="tabla-detalle">
									<tr>
				                        <th>Producto</th>
				                        <th>Formato</th> 
				                        <th>Cantidad</th> 
				                        <th>Precio</th> 
            						</tr>'
                    );

					foreach($pedido->producto as $producto){
						print('
											<tr>
												<td>'. $producto->titulo .'</td>
												');
						if($producto->formato == 'dvd')
							 echo '<td><img src="images/dvd.png" alt="foto" class="img-formato-detalle"/></td>';
						else
							 echo '<td><img src="images/ray.png" alt="foto" class="img-formato-detalle"/></td>';
						print('
												<td>'. $producto->cantidad .'</td>
												<td>'. $producto->precio .'</td>
											</tr>
						');
					}

					print('
											<tr>
												<td></td>
												<td></td>
												<td>Total compra: </td>
												<td>'. $pedido->total_compra .' €</td>
											</tr>
										</table>
									</div>'
					);
					
			}
	?>
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