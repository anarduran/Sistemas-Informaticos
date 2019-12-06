<?php
    session_set_cookie_params(0,"/"); 
    session_start();
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
                                <a href='' class='ele-menu'>Usuario: $u</a>
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
						<a href='iniciar_sesion.html' class='ele-menu'>Entrar</a><br/><br/>
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
	
        <div style="text-indent: 0.5cm;">
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

    <div id="div-busqueda">


        <?php

        	if(strcmp($_POST['elementos'],"")){
        		$xml = simplexml_load_file("catalogo.xml") or die("Error: Cannot create object");
        		$contador = 0;

	        	foreach ($xml->pelicula as $peliculas) {
	        		$flag = 0;

	        		if(stristr($peliculas->titulo, $_POST['elementos']) != false){
        			$contador++;
        			$flag = 1;
        		}

        		if(stristr($peliculas->director, $_POST['elementos']) != false){
        			$contador++;
        			$flag = 1;
        		}
        		
        		if(stristr($peliculas->anio, $_POST['elementos']) != false){
        			$contador++;
        			$flag = 1;
        		}
        		
        		if(stristr($peliculas->pais, $_POST['elementos']) != false){
        			$contador++;
        			$flag = 1;
        		}

	        		if(!strcmp($_POST['genero'], "")){
	        			if($flag == 1){
	        				$contador++;
		        			echo '<div class="caratula">';
		                                echo '<a href="detalle.php?id=' . $peliculas->id . '"><img src="' . $peliculas->caratula . '" alt="' . $peliculas->titulo . '"/></a>';
		                                echo '<p>' . $peliculas->titulo . '</p>';
		                                echo '<div class="estrellas">';
		                                echo '<img src="images/' . $peliculas->valoracion .'_estrellas.png" alt="foto_estrellas"/>';
		                                echo '</div>';
		                                echo '<p>' . $peliculas->precio_dvd . ' | ' . $peliculas->precio_blueray . '</p>';
		                                echo '<div class="tipo">';
		                                echo '<img src="images/dvd.png" alt="foto_dvd"/>';
		                                echo '<img src="images/ray.png" alt="foto_ray"/>';
		                                echo '</div>';
		                    echo '</div>';
	        			}
	        		} else {
	        			if(!strcmp($_POST['genero'], $peliculas->genero)){
	        				if($flag == 1){
	        					$contador++;
			        			echo '<div class="caratula">';
			                                echo '<a href="detalle.php?id=' . $peliculas->id . '"><img src="' . $peliculas->caratula . '" alt="' . $peliculas->titulo . '"/></a>';
			                                echo '<p>' . $peliculas->titulo . '</p>';
			                                echo '<div class="estrellas">';
			                                echo '<img src="images/' . $peliculas->valoracion .'_estrellas.png" alt="foto_estrellas"/>';
			                                echo '</div>';
			                                echo '<p>' . $peliculas->precio_dvd . ' | ' . $peliculas->precio_blueray . '</p>';
			                                echo '<div class="tipo">';
			                                echo '<img src="images/dvd.png" alt="foto_dvd"/>';
			                                echo '<img src="images/ray.png" alt="foto_ray"/>';
			                                echo '</div>';
			                    echo '</div>';
	        				}
	        			}
	        		}
	        	}

	        	if($contador == 0)
	        	   echo '<h2 id="titulo_no_result">Lo sentimos, no hemos encontrado ningún resultado para la búsqueda introducida</h2>';
        	} else
            	 echo '<h2 id="titulo_no_result">Lo sentimos, no hemos encontrado ningún resultado para la búsqueda introducida</h2>';
        	
        	
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