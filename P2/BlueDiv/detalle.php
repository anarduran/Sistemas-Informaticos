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
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="JavaScript/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="JavaScript/aleatorio.js"></script>
	
	<div id="buscador">
    
        <form id="barra-busqueda" method="post" Action="buscador.php" name=busqueda>
            <div>
                <b>Usuarios conectados: <span id="online"></span></b></br></br></br>
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

        <div id="div-detalle">
        	<?php
	        	if(isset($_GET['compra'])){

	        		if(!isset($_POST['seleccion'])){
				        print(
				            "<script type=\"text/javascript\">
				                alert(\"Selecciona un producto para añadirlo a la cesta\");
				            </script>"
				        );

				    } else {
                        in_array('dvd', $_POST['seleccion']) ? $dvd = true : $dvd = false;

                        in_array('blueray', $_POST['seleccion']) ? $blueray = true : $blueray = false;

                        if(!isset($_SESSION['productos'])){
                            if($dvd == true && $blueray == false)
                                $_SESSION['productos'] = array(array($_GET['id'], "dvd", 1));

                            if($blueray == true && $dvd == false)
                                $_SESSION['productos'] = array(array($_GET['id'], "blueray", 1));

                            if($dvd == true && $blueray == true)
                                $_SESSION['productos'] = array(array($_GET['id'], "dvd", 1), array($_GET['id'], "blueray", 1));

                        } else {
                            if($dvd == true){
                                $cantidad = 0;
                                foreach($_SESSION['productos'] as $key => $producto){
                                    if($producto[0] == $_GET['id'] && $producto[1] == 'dvd'){
                                        $cantidad = $producto[2];
                                        $clave = $key;
                                        break;
                                    }
                                } 

                                if($cantidad == 0)
                                    array_push($_SESSION['productos'], array($_GET['id'], 'dvd', 1));
                                else
                                    $_SESSION['productos'][$clave][2] = $cantidad + 1;
                            }
                            
                            if($blueray == true){
                                $cantidad = 0;
                                foreach($_SESSION['productos'] as $key => $producto){
                                    if($producto[0] == $_GET['id'] && $producto[1] == 'blueray'){
                                        $cantidad = $producto[2];
                                        $clave = $key;
                                        break;
                                    }
                                } 

                                if($cantidad == 0)
                                    array_push($_SESSION['productos'], array($_GET['id'], 'blueray', 1));
                                else
                                    $_SESSION['productos'][$clave][2] = $cantidad + 1;
                            }
                        }

					    /*print_r ($_SESSION['productos']);*/

					    print(
					            "<script type=\"text/javascript\">
					                alert(\"Se han añadido los productos a la compra\");
					            </script>"
					    );

				    } 
			    }
		    ?>

            <?php 
            	$xml = simplexml_load_file("catalogo.xml") or die("Error: Cannot create object"); 

            	foreach ($xml->pelicula as $peliculas) {
            		if($_GET['id'] == $peliculas->id){
                        echo '<div style="text-indent: 0.5cm;">';
                            echo '<h1>'. $peliculas->titulo .'</h1>';
                            echo '<div class="estrellas2">';
                                    echo '<img src="images/' . $peliculas->valoracion .'_estrellas.png" alt="foto_estrellas"/>';
                            echo '</div>';
                        echo '</div>';

            			echo '<div class="caratula2">';
                            echo '<img src="' . $peliculas->caratula . '" alt="' . $peliculas->titulo . '"/>';
                        echo '</div>';

                        echo '<div class="sinopsis">';
                            echo '<p><b>Director:</b> ' . $peliculas->director . '<br/>';
                            echo '<b>Año:</b> ' . $peliculas->anio . '<br/>';
                            echo '<b>Duración: </b>' . $peliculas->duracion . '<br/><br/>';
                            echo $peliculas->descripcion . '</p>';
                        echo '</div>';

                        echo '<div class="tipo2">';
                            echo '<span style="float: left">';
                                echo '<form id="form_anadir" method="post" action="detalle.php?id='. $peliculas->id .'&compra=1">';
                                    echo ' <img src="images/dvd.png" alt="foto"/>';
                                    echo ' <input type="checkbox" name="seleccion[]" value="dvd"/>'. $peliculas->precio_dvd;
                                    echo ' <br/><br/>';
                                    echo ' <img src="images/ray.png" alt="foto"/>';
                                    echo ' <input type="checkbox" name="seleccion[]" value="blueray"/>'. $peliculas->precio_blueray;
                                    echo ' <br/><br/>';
                                    echo ' <input type="submit" name="submit" value="Añadir a la Cesta"/>';
                                echo '</from>';
                             echo '</span>';
                        echo '</div>';
                    
            		}

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