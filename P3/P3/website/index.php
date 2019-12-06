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

    <div id="div-index">

        <div id="mas-vendidos">
			
            <?php
            
                print(
                    '<div style="text-indent: 0.5cm;">
                        <h1>TOP VENTAS</h1>
                    </div>'
                );

                try {
                    $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb" );
                } catch(PDOException $e){
                    echo $e->getMessage();
                }

                $sql = "select distinct on (pelicula) * from (select topVentas.pelicula, p.prod_id, p.price, p.description, im.image 
						from getTopVentas(2014) as topVentas, products p, imdb_movies im
						where im.movietitle = topVentas.pelicula and im.movieid = p.movieid
						group by pelicula, p.prod_id, topVentas.año, im.image 
						order by topVentas.año asc, prod_id asc) as q1;";

                foreach ($db->query($sql) as $fila) {
                    
                        echo '<div class="caratula">';
                                    echo '<a href="detalle.php?id=' . $fila['prod_id']. '"><img src="' . $fila['image'] . '" alt="' . $fila['movietitle'] . '"/></a>';
                                    echo '<p>' . $fila['pelicula'] . '</p>';
                                    echo '<p>' . number_format($fila['price'], 2) . ' €</p>';
                                    echo '<div class="tipo">';
                                    echo '<img src="images/dvd.png" alt="foto_dvd"/>';
                                    echo '</div>';
                        echo '</div>';
                }

                $db = null;

            ?>
			
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
