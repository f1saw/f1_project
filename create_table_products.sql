create table Products (id int auto_increment primary key,
                       name varchar(50) not null,
                       description varchar(255),
                       price int not null,
                       img_url varchar(255)
);