create table Orders_Products (order_id int,
                              product_id int,
                              primary key (order_id, product_id),
                              constraint `fk_order_id`
                                  foreign key(order_id) references Orders(id)
                                      on delete cascade
                                      on update cascade,
                              constraint `fk_product_id`
                                  foreign key(product_id) references Products(id)
                                      on delete cascade
                                      on update cascade
);