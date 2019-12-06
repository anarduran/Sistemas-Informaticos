create or replace function setOrderAmount() returns void as $$

    begin
    update orders set netamount = tot.orderTotal
        from (select orderid, sum(price*quantity) as orderTotal from orderdetail group by orderid) as tot where tot.orderid=orders.orderid;
        update orders set totalamount=netamount+(netamount*tax/100);
        
    end; $$

language 'plpgsql';

select * from setOrderAmount();