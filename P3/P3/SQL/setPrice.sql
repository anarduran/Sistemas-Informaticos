update orderdetail

set price = precios.precio_orderdetail

from
(select orderdetail.orderid, orderdetail.prod_id, cast((products.price / 102^diferencia * 100^diferencia ) as decimal(34,2)) as precio_orderdetail
from products, (select orderid, cast(date_part('year', current_date) - date_part('year', orderdate) as integer) as diferencia
from orders) as diferencia_anios, orderdetail

where diferencia_anios.orderid = orderdetail.orderid and orderdetail.prod_id = products.prod_id) as precios, products
where orderdetail.orderid = precios.orderid and products.prod_id = precios.prod_id;