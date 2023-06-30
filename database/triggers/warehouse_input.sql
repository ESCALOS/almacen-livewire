CREATE TRIGGER `agregar_productos_al_almacen` AFTER INSERT ON `warehouse_inputs`
 FOR EACH ROW UPDATE warehouse_details SET quantity = quantity + new.quantity, price = price + new.price WHERE id = new.warehouse_detail_id
