create or replace function updateOrders() 
    returns trigger 
    language 'plpgsql'
    as $$
        declare
        begin 

        update orders set totalamount = a.suma
        from (select orderid, sum(price*quantity) as suma 
        from orderdetail 
        join orders using (orderid) 
        group by orderid) as a
        where a.orderid = orders.orderid;
    return new;
    
    end $$;

create trigger updOrders after update or insert on orderdetail for each row execute procedure updateOrders();