create or replace function getTopMonths (integer, integer) returns int4 as'

	declare
	num1 alias for $1;
	num2 alias for $2;
	
	begin

		drop table if exists topMonths;
		create table topMonths(year integer, month integer);
		insert into topMonths select year, mes from
			(select extract (year from orderdate) as year, extract (month from orderdate) as mes, sum(t.cantidad) as cantidad,sum(totalamount) as suma from
			(select orderid, sum(quantity) as cantidad from orderdetail group by orderid) as t join orders using (orderid) group by mes, year) as topMonths

		where topMonths.cantidad >= num1 or suma >= num2
		order by year, mes;
		
	return 0;
end 'language 'plpgsql';

select * from getTopMonths(19000, 320000);