-- Active: 1667853929586@@127.0.0.1@3306@phalcon_app
insert into cart(id_account) values
(1),
(2),
(3),
(4),
(5)
;

insert into account(id_cart, username, password, role) values
(1, 'userlocal', 'root', 1),
(2, 'adminlocal', 'root', 2),
(3, 'locali', 'root', 1),
(4, 'uslocal', 'root', 2),
(5, 'userlal', 'root', 1)
;

insert into product(id_owner, id_sub_category, name,stock) values
(1, 1, 'bac à sable',5),
(1, 2, 'sceau', 4),
(1, 3, 'bloc', 10),
(2, 4, 'test', 15),
(3, 5, 'root', 2),
(4, 6, 'toor', 6),
(4, 7, 'phalcon', 4);

create table cart_x_product(  
    id_cart int(10),
    id_product int(10)
);

create table product_x_purchase(  
    id_product int(10),
    id_purchase int(10)
);

create table product_x_return(  
    id_product int(10),
    id_return int(10)
);

create table account(  
    id int(10) auto_increment  primary key,
    id_cart int(10),
    username varchar(255),
    password varchar(255),
    email varchar(255) null,
    phone varchar(255) null,
    role int(10),
    address varchar(255) null,
    create_at datetime,
    update_at datetime
);

create table review(  
    id int(10) auto_increment  primary key,
    id_product int(10),
    id_account int(10),
    comment varchar(255) null,
    nb_star int(10),
    create_at datetime,
    update_at datetime
);

create table purchase(  
    id int(10) auto_increment  primary key,
    id_account int(10),
    total_price int(10),
    purchase_at datetime,
    create_at datetime,
    update_at datetime
);

create table returned(  
    id int(10) auto_increment  primary key,
    id_account int(10),
    create_at datetime,
    update_at datetime
);

create table category(  
    id int(10) auto_increment  primary key,
    child_category int(10),
    parent_category int(10),
    name varchar(255),
    create_at datetime,
    update_at datetime
);

create table delivery(  
    id int(10) auto_increment  primary key,
    id_account int(10),
    status varchar(255) null,
    estimated_date datetime,
    delivery_at datetime null,
    create_at datetime,
    update_at datetime
);

