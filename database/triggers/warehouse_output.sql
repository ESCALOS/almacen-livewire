CREATE TRIGGER `descontar_productos_al_almacen` AFTER INSERT ON `warehouse_outputs`
 FOR EACH ROW UPDATE warehouse_details SET quantity = quantity - new.quantity, price = price - new.price WHERE id = new.warehouse_detail_id
