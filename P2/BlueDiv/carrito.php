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

    <div id="buscador">
    
        <form id="barra-busqueda" method="post" Action="buscador.php" name=busqueda>
            <div>
                <b>Buscador de películas:</b>
                <input type="search" placeholder="Buscar..." name="elementos">
            </div>
            <div id="div-lista-busqueda">
                <select id="lista-genero" name="genero">
                  <option value="" selected="selected">- Género -</option>
                  <option value="Acción">Acción</option>
                  <option value="Comedia">Comedia</option>
                  <option value="Romance">Romance</option>
                  <option value="Infantiles">Infantiles</option>
                  <option value="Terror">Terror</option>
                </select>
                <input type="Submit" value="Buscar">
            </div>
        </form>
        
    </div>
    
    <br/>

    <div id = "menu-lateral">
    
        <div style="text-indent: 0.9cm;">
            <h1>CATEGORÍAS</h1>
        </div>
        
        <ul>
            <li><a href="categoria.php?genero=Acción">Acción</a></li>
            <li><a href="categoria.php?genero=Comedia">Comedia</a></li>
            <li><a href="categoria.php?genero=Romance">Romance</a></li>
            <li><a href="categoria.php?genero=Infantiles">Infantiles</a></li>
            <li><a href="categoria.php?genero=Terror">Terror</a></li>
        </ul>
        
    </div>

    <?php
    	if(isset($_GET['id']) && isset($_GET['formato'])){
    		foreach ($_SESSION['productos'] as $key => $producto){
    			if($producto[0] == $_GET['id'] && $producto[1] == $_GET['formato']){
    				if($producto[2] == 1){
    					unset($_SESSION['productos'][$key]);
                    	break;
    				}
    				else{
    					$_SESSION['productos'][$key][2] = $producto[2] - 1;
    					break;
    				}
                    
                }
    		}
    	}
    ?>

    
    <?php
        if(!isset($_SESSION['productos']) || count($_SESSION['productos']) == 0)
            print('<div id="div-sin-productos"><h3>No hay productos en el carrito</h3></div>');
        
        else {
        	echo '<div id="div-carrito">';
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
                                    echo '<td><a href="carrito.php?id=' . $peliculas->id .'&formato=dvd">Eliminar</a></td>';
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
                                    echo '<td><a href="carrito.php?id=' . $peliculas->id .'&formato=blueray">Eliminar</a></td>';
                                echo '</tr>';
                                $total_compra += $producto[2] * doubleval($peliculas->precio_blueray);
                            }
                            
                        }
                    }
                }
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
                    '<form id="form-compra" method="post" action="confirmar_compra.php">
                        <input type="Submit" value="Realizar Compra">
                    </form>
                    '
                );
            echo '</div>';
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