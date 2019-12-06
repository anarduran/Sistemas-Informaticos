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

    <?php 
    	if(isset($_GET['compra'])){
            
            if(!isset($_SESSION['id_carrito'])){
                
               	try {
	                $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
	            } catch (PDOException $e) {
	                echo $e->getMessage();
	            }

                if(!isset($_SESSION['id_usuario'])) {
                    /* Obtenemos el id del cliente que ha iniciado sesión */
                    $consulta = 'SELECT customerid FROM customers WHERE username = \'' . $_SESSION['nickUsuario'] .'\'';
                    $gsent = $db->prepare($consulta);
                    $gsent->execute();
                    $resultado = $gsent->fetchAll();
                    $id_usuario = $resultado[0]['customerid']; 


                    $_SESSION['id_usuario'] = $id_usuario;
                }

                $id_usuario = $_SESSION['id_usuario'];
                

	            /* Comprobamos si el cliente loggeado tiene algún carrito pendiente */
	            $consulta = 'SELECT max(orderid) as id from orders where customerid = '. $id_usuario .' and status is null';
	            $gsent = $db->prepare($consulta);
	            $gsent->execute();
	            $resultado = $gsent->fetchAll();

	            /* Si la variable resultado está vacía, significa que no hay ningún carrito pendiente */
	            if($resultado[0]['id'] != null)
	                $id_carrito = $resultado[0]['id'];

	            else {
                    
	                /* Obtenemos el máximo id de order */
	                $consulta = 'SELECT max(orderid) from orders';
	                $gsent = $db->prepare($consulta);
	                $gsent->execute();
	                $resultado = $gsent->fetchAll();
	                $id_max_order = $resultado[0][0]; 
	                $id_max_order++;

	                /* Creamos el carrito para el usuario loggeado */
	                $consulta = 'INSERT into orders (orderid, orderdate, customerid, status) values ('. $id_max_order .', current_date, '. $id_usuario .', null)';
	                $db->exec($consulta);

	                $id_carrito = $id_max_order;
	            }

	            $db = null;

                $_SESSION['id_carrito'] = $id_carrito;

        	} else 
        		$id_carrito = $_SESSION['id_carrito'];
        	
            $prod_id = $_GET['id'];

            try {
            	$db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            $consulta = 'SELECT quantity from orderdetail where orderid = ' . $id_carrito .' and prod_id = ' . $prod_id . '';

            $gsent = $db->prepare($consulta);
            $gsent->execute();
            $resultado = $gsent->fetchAll();
            $cantidad = $resultado[0][0];

            if($cantidad >= 1){
                $consulta = 'UPDATE orderdetail set quantity = ' . ++$cantidad . ' where orderid = ' . $id_carrito .' and prod_id = ' . $prod_id . '';
                $db->exec($consulta);
            } else {
            	$consulta = "SELECT price from products where prod_id = " . $prod_id;
            	$gsent = $db->prepare($consulta);
            	$gsent->execute();
	            $resultado = $gsent->fetchAll();
	            $price = $resultado[0][0];

            	$consulta = "INSERT into orderdetail values (". $id_carrito .", ". $prod_id .", ". $price .", '1')";
                $db->exec($consulta);
            }

            print(
	            "<script type=\"text/javascript\">
	                alert(\"Se han añadido los productos a la compra\");
	            </script>"
			);

            $db = null;
        }
    ?>

        <div id="div-detalle">
        	<?php
        
            $id_articulo = $_GET['id'];
        
            try {
                $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb" );
                    
            } catch(PDOException $e){
                echo $e->getMessage();
            }
            
            $sql = "SELECT im.movietitle, p.prod_id, p.price, p.description, im.image, im.year, d.directorname
					from imdb_movies im, products p, imdb_directormovies dm, imdb_directors d
					where im.movieid = dm.movieid and dm.directorid = d.directorid and im.movieid = p.movieid and p.prod_id = $id_articulo";
        
        	$gsent = $db->prepare($sql);
            $gsent->execute();
            $resultado = $gsent->fetchAll();
            
            echo '<div style="text-indent: 0.5cm;">';
                echo '<h1>'. $resultado[0]['movietitle'] .'</h1>';
            echo '</div>';

			echo '<div class="caratula2">';
                echo '<img src="' . $resultado[0]['image'] . '" alt="' . $peliculas->titulo . '"/>';
            echo '</div>';

            echo '<div class="sinopsis">';
                echo '<p><b>Director:</b> ' . $resultado[0]['directorname'] . '<br/>';
                echo '<b>Año:</b> ' . $resultado[0]['year'] . '<br/>';
                echo '<b>Descripción:</b> ' . $resultado[0]['description'] . '</p>';
            echo '</div>';

            echo '<div class="tipo2">';
                echo '<span style="float: left">';
                    echo '<form id="form_anadir" method="post" action="detalle.php?id='. $resultado[0]['prod_id'] .'&compra=1">';
                        echo ' <img src="images/dvd.png" alt="foto"/><br/><br/><br/>';
                        echo ' <input type="submit" name="submit" value="Añadir a la Cesta"/>';
                    echo '</from>';
                 echo '</span>';
            echo '</div>';
                    
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