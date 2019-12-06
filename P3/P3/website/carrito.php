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
        if (isset($_GET['id'])) {
            try {
                $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            $id_carrito = $_SESSION['id_carrito'];
            $prod_id = $_GET['id'];

            $consulta = 'SELECT quantity from orderdetail where orderid = ' . $id_carrito .' and prod_id = ' . $prod_id . '';
            $gsent = $db->prepare($consulta);
            $gsent->execute();
            $resultado = $gsent->fetchAll();
            $cantidad = $resultado[0][0];

            if($cantidad > 1){
                $consulta = 'UPDATE orderdetail set quantity = ' . --$cantidad . ' where orderid = ' . $id_carrito .' and prod_id = ' . $prod_id . '';
                $db->exec($consulta);
            } else {
                $consulta = 'DELETE from orderdetail where orderid = ' . $id_carrito .' and prod_id = ' . $prod_id . '';
                $db->exec($consulta);
            }

            $db = null;
        }
    ?>
    

    <?php
        try {
            $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        if($_SESSION['sesionIniciada'] == true){

            if(!isset($_SESSION['id_usuario']))
                $_SESSION['id_usuario'] = get_idUser();

            $id_usuario = $_SESSION['id_usuario'];   

            /* Comprobamos si el cliente loggeado tiene algún carrito pendiente */
            $consulta = 'SELECT max(orderid) as id from orders where customerid = '. $id_usuario .' and status is null';
            $gsent = $db->prepare($consulta);
            $gsent->execute();
            $resultado = $gsent->fetchAll();

            /* La variable resultado está vacía, significa que no hay ningún carrito pendiente */
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
            print_carrito($id_carrito);

        } else 
            print('<div id="div-sin-productos"><h3>Inicia sesión para ver y añadir productos</h3></div>');

    ?>

    <?php

        function get_idUser(){

            try {
                $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            /* Obtenemos el id del cliente que ha iniciado sesión */
            $consulta = 'SELECT customerid FROM customers WHERE username = \'' . $_SESSION['nickUsuario'] .'\'';
            $gsent = $db->prepare($consulta);
            $gsent->execute();
            $resultado = $gsent->fetchAll();
            $id_usuario = $resultado[0]['customerid']; 

            $db = null;

            return $id_usuario;
        }

        function get_idCarrito($id_user){

            try {
                $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            $consulta = 'SELECT max(orderid) as id from orders where customerid = '. $id_user .' and status is null';
            $gsent = $db->prepare($consulta);
            $gsent->execute();
            $resultado = $gsent->fetchAll();
            $id_carrito = $resultado[0]['id'];

            $db = null;

            return $id_carrito;
        }

        

        function print_carrito($id_carrito){
        	
            try {
                $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            /* Comprobamos si el carrito está vacío o no */
            $consulta = 'SELECT count(*) from orderdetail where orderid = '. $id_carrito;
            $gsent = $db->query($consulta);
            $resultado = $gsent->fetchAll();
            $n_productos = $resultado[0][0];


            /* Si el carrito está vacío, lo indicamos. Si no, imprimimos su contenido*/
            if($n_productos == 0)
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

                $consulta = 'SELECT prod_id, quantity from orderdetail where orderid = '. $id_carrito;
                $gsent = $db->query($consulta);

                while($fila = $gsent->fetch(PDO::FETCH_NUM)){
                    $prod_id = $fila[0];
                    $quantity = $fila[1];

                    $consulta = 'SELECT m.movietitle, m.image, p.price from products p, imdb_movies m where p.prod_id = '. $prod_id .' and p.movieid = m.movieid';
                    $gsent1 = $db->query($consulta);
                    $resultado = $gsent1->fetchAll();

                    $titulo = $resultado[0][0];
                    $ruta_imagen = $resultado[0][1];
                    $precio = $resultado[0][2];

                    echo '<tr>';
                        echo '<td><img class="caratula-carrito" src ="'. $ruta_imagen .'" alt="'. $titulo .'"></td>';
                        echo '<td>'. $titulo .'</td>';
                        echo '<td><img src="images/dvd.png" alt="foto" class="img-formato"/></td>';
                        echo '<td>'. $quantity .'</td>'; 
                        echo '<td>'. number_format($precio, 2) .' €</td>';
                        echo '<td><a href="carrito.php?id=' . $prod_id .'">Eliminar</a></td>';
                    echo '</tr>';

                }

                $consulta = 'SELECT totalamount from orders where orderid = '. $id_carrito;
                $gsent2 = $db->query($consulta);
                $resultado = $gsent2->fetchAll();

                $total_compra = $resultado[0][0];

                echo '<tr>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td>Total: </td>';
                        echo '<td>'.number_format($total_compra, 2).' €</td>';
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

            $db = null;

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