-- auto-generated definition
create table cookies
(
    id              char(255) not null
        primary key,
    value           char(255) not null,
    expiration_date int       not null
);