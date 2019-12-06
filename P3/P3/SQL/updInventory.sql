create or replace function updateinventory()

  returns trigger as $$
	declare 
	begin
	
	create table if not exists alert_inventory(
		alertid serial NOT NULL,
		prod_id integer NOT NULL,
		alertdate date,
		primary key (alertid),
		foreign key (prod_id) references products (prod_id) match simple
		on update no action on delete no action
	);

	update inventory set stock=stock-quantity, sales=sales+quantity
		from (select prod_id, quantity from orderdetail where orderid =NEW.orderid 
		and new.status ='Paid' and old.status = 'NoPaid') as a
		where inventory.prod_id=a.prod_id;

	insert into alert_inventory (prod_id, alertdate) select a.prod_id, current_date 
	from (select prod_id, quantity from orderdetail where orderid=new.orderid 
	and new.status ='Paid' and old.status = 'NoPaid') as a, inventory 
	where inventory.prod_id=a.prod_id and stock=0  ;
	return new;
	
	end $$
	language plpgsql;

create trigger updInventory after update on orders for each row execute procedure updateInventory();