create table Orders (id int primary key auto_increment,
                     user_id int not null,
                     date date not null,
                     shipping_address varchar(255) not null,
                     amount numeric not null,
                     constraint `fk_user_id`
                         foreign key(user_id) references Users(id)
                             on delete cascade
                             on update cascade
);