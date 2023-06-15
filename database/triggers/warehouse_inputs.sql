CREATE TRIGGER `IngresosDepartamentos` AFTER INSERT ON `warehouse_inputs`
 FOR EACH ROW UPDATE warehouse_departments SET quantity = quantity + new.quantity, price = price + new.price WHERE id = new.warehouse_department_id
