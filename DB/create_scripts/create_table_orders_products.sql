-- auto-generated definition
create table orders_products
(
    order_id   char(5)    not null,
    product_id int        not null,
    size       varchar(5) not null,
    quantity   int        not null,
    unit_price int        not null,
    primary key (order_id, product_id, size),
    constraint orders_products_orders_id_fk
        foreign key (order_id) references orders (id)
            on update cascade on delete cascade,
    constraint orders_products_products_id_fk
        foreign key (product_id) references products (id)
            on update cascade
);

