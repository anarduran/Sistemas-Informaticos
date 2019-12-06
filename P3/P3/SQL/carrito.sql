-- Creamos una función para crear un carrito para un cliente determinado

create or replace function crear_carrito(nick_cliente text) returns integer as $$
	declare
		max_id integer;
		id_cliente integer;
	begin
		-- Obtenemos el id mas alto de la tabla orders
		select into max_id max(orderid) as maxid from orders;
		max_id = max_id + 1;
		-- Obtenemos el id del cliente con el nick pasado por argumento
		select into id_cliente customerid from customers where username = nick_cliente;
		-- Creamos un nuevo carrito para ese cliente con status null
		insert into orders (orderid, orderdate, customerid, status) values (max_id, current_date, id_cliente, null);
		return max_id;
	end;

$$LANGUAGE plpgsql;

-- Creamos una función para añadir un producto al carrito

create or replace function anadir_producto(id_producto integer, nick_cliente text) returns void as $$
	declare
		id_order integer;
		id_cliente integer;
		price_producto numeric;
		cantidad_actual integer;
	begin
		-- Obtenemos el id del cliente con el nick pasado por argumento
		select into id_cliente customerid from customers where username = nick_cliente;
		-- Obtenemos el id del último carrito del cliente
		select into id_order orderid from orders where customerid = id_cliente and status = null order by orderid desc limit 1;
		-- Obtenemos el precio actual del producto
		select into price_producto price from products where prod_id = id_producto;
		-- Comprobamos si tenemos añadido algua cantidad ya de ese producto
		select into cantidad_actual quantity from orderdetail where orderid = id_order and prod_id = id_producto;
		-- Si ya existe, aumentamos en 1 la cantidad
		if cantidad_actual >= 1 then
			update orderdetail 
			set quantity = cantidad_actual + 1
			where orderid = id_order and prod_id = id_producto;
		else
		-- Si no, lo creamos
		insert into orderdetail values (id_order, id_producto, price_producto, '1');
		end if;

	end;
	
$$ LANGUAGE plpgsql;

-- Creamos una función para eliminar un producto del carrito

create or replace function eliminar_producto(id_producto integer, nick_cliente text) returns void as $$
	declare
		id_order integer;
		id_cliente integer;
		cantidad_actual integer;
	begin
		-- Obtenemos el id del cliente con el nick pasado por argumento
		select into id_cliente customerid from customers where username = nick_cliente;
		-- Obtenemos el id del último carrito del cliente
		select into id_order orderid from orders where customerid = id_cliente and status = null order by orderid desc limit 1;
		-- Comprobamos si tenemos añadido algua cantidad ya de ese producto
		select into cantidad_actual quantity from orderdetail where orderid = id_order and prod_id = id_producto;
		-- Si la cantidad actual es mayor de 1 bajamos en una unidad la cantidad
		if cantidad_actual > 1 then
			update orderdetail 
			set quantity = cantidad_actual - 1
			where orderid = id_order and prod_id = id_producto;
		else
		-- Si no, lo eliminamos
		delete from orderdetail where orderid = id_order and prod_id = id_producto;
		end if;

	end;
	
$$ LANGUAGE plpgsql;

-- Creamos una función para crear un carrito para un cliente determinado

create or replace function getId_carrito(nick_cliente text) returns integer as $$
	declare
		max_id integer;
		id_cliente integer;
	begin
		-- Obtenemos el id del cliente con el nick pasado por argumento
		select into id_cliente customerid from customers where username = nick_cliente;
		-- Obtenemos el id del carrito
		select into id_carrito max(orderid) as id from orders where customerid = id_cliente and status = null;
		if id_carrito == null 
			return -1;
		else
			return id_carrito;
	end;

$$LANGUAGE plpgsql;