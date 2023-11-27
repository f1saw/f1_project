-- auto-generated definition
create table orders_products
(
    order_id   int not null,
    product_id int not null,
    primary key (order_id, product_id),
    constraint fk_order_id
        foreign key (order_id) references orders (id)
            on update cascade on delete cascade,
    constraint fk_product_id
        foreign key (product_id) references products (id)
            on update cascade on delete cascade
);

