create table Users (id int auto_increment primary key ,
                    first_name varchar(255),
                    last_name varchar(255),
                    email varchar(255) unique not null,
                    password char(255) not null,
                    role int not null,
                    date_of_birth date,
                    cookie_id char(255) unique,
                    img_url varchar(255),
                    newsletter int,
                    constraint fk_cookie_id
                        foreign key(cookie_id) references Cookies(id)
                            on delete cascade
                            on update cascade
);