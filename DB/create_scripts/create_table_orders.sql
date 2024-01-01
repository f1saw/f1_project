-- auto-generated definition
create table orders
(
    id               char(5)      not null
        primary key,
    user_id          int          not null,
    date             char(19)     not null,
    shipping_address varchar(255) not null,
    amount           decimal      not null,
    constraint fk_user_id
        foreign key (user_id) references users (id)
            on update cascade on delete cascade
);

