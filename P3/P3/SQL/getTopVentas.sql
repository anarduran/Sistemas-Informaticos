create or replace function getTopventas(integer)
returns table (año integer, pelicula varchar, ventas bigint) as $$
    begin

    RETURN QUERY 
    
    select cast(f.año as integer),(array_agg(f.pelicula order by f.ventas desc))[1] as "pelicula", cast(max(f.ventas) as bigint) as "ventas" 
    from (select c.pelicula,sum(c.ventas) as ventas, c.año 
    from (select imdb.movietitle as "pelicula", t.suma as"ventas", date_part('year', orders.orderdate::date) as "año" 
    from orders
        join (select sum(quantity) as suma,orderdetail.prod_id as prod_id, orderdetail.orderid 
        from orderdetail where orderdetail.prod_id=orderdetail.prod_id group by orderdetail.prod_id,orderid order by suma desc) as t on t.orderid=orders.orderid
        join products prod on t.prod_id=prod.prod_id 
        join imdb_movies imdb on prod.movieid=imdb.movieid
    where  date_part('year', orders.orderdate::date)>=$1
    order by date_part('year', orders.orderdate::date)
    
    )as c where c.pelicula=c.pelicula and c.año=c.año group by  c.pelicula,c.año order by c.pelicula asc) as f group by f.año order by f.año;

end;  $$ 

language 'plpgsql';  

select * from getTopventas(2014);