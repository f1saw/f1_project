-- auto-generated definition
create table users
(
    id            int auto_increment
        primary key,
    first_name    varchar(255) null,
    last_name     varchar(255) null,
    email         varchar(255) not null,
    password      char(255)    not null,
    role          int          not null,
    date_of_birth char(10)     null,
    cookie_id     char(255)    null,
    img_url       varchar(255) null,
    newsletter    int          null,
    constraint cookie_id
        unique (cookie_id),
    constraint email
        unique (email),
    constraint users_ibfk_1
        foreign key (cookie_id) references cookies (id)
            on update cascade on delete set null
);