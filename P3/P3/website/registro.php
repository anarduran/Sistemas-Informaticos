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

		try {
	        $db = new PDO("pgsql:dbname=si1; host=localhost", "alumnodb", "alumnodb");
	    } catch (PDOException $e) {
	        echo $e->getMessage();
	    }

	    $res = $db->query("SELECT max(customerid) as idmax FROM customers");
	    $resultado = $res->fetchAll();
	    $id_max = $resultado[0][0];

	    $id_max++;

	    $db->exec("INSERT INTO customers (customerid, firstname, lastname, address1, address2, city, state, zip, country, region, email, phone, creditcardtype, creditcard, creditcardexpiration, username, password, income, gender) values ('" . $id_max . "' , '" . $_POST['nombre'] . "', '" . $_POST['apellidos'] . "', '". $_POST['direccion1'] . "', '" . $_POST['direccion2'] . "' , '" .$_POST['poblacion'] . "', '" .$_POST['provincia'] . "', '" . $_POST['cp'] . "', '" . $_POST['pais'] . "', '" . $_POST['ccaa'] . "', '" . $_POST['email'] . "', '" . $_POST['telefono'] . "', '" . $_POST['tipo_tarjeta'] . "', '" . $_POST['tarjeta'] . "', '" . $_POST['exp_tarjeta'] . "', '" . $_POST['usuario'] . "', '" . $_POST['password'] . "', '0', '". $_POST['sexo'] . "')") or die(print_r($db->errorInfo(), true));
	
		echo '<h3>El usuario se ha creado correctamente.</h3>';

		$db = null;
	?>
	
</body>
</html>