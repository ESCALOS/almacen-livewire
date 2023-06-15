CREATE TRIGGER `IngresoAlmacen` AFTER UPDATE ON `warehouse_departments`
 FOR EACH ROW UPDATE warehouse_details SET quantity = quantity + new.quantity, price = price + new.price WHERE id = new.warehouse_detail_id
