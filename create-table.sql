-- Active: 1667853929586@@127.0.0.1@3306@phalcon_app
create table cart(  
    id int(10) auto_increment  primary key,
    id_account int(10),
    created_at datetime default CURRENT_TIMESTAMP,
    updated_at datetime default CURRENT_TIMESTAMP
);

create table product(  
    id int(10) auto_increment  primary key,
    id_owner int(10),
    id_sub_category int(10),
    name varchar(255),
    description varchar(255) null,
    stock int(10),
    picture_url varchar(255) null,
    created_at datetime default CURRENT_TIMESTAMP,
    updated_at datetime default CURRENT_TIMESTAMP
);

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
    created_at datetime default CURRENT_TIMESTAMP,
    updated_at datetime default CURRENT_TIMESTAMP
);

create table review(  
    id int(10) auto_increment  primary key,
    id_product int(10),
    id_account int(10),
    comment varchar(255) null,
    nb_star int(10),
    created_at datetime default CURRENT_TIMESTAMP,
    updated_at datetime default CURRENT_TIMESTAMP
);

create table purchase(  
    id int(10) auto_increment  primary key,
    id_account int(10),
    total_price int(10),
    purchase_at datetime,
    created_at datetime default CURRENT_TIMESTAMP,
    updated_at datetime default CURRENT_TIMESTAMP
);

create table returned(  
    id int(10) auto_increment  primary key,
    id_account int(10),
    created_at datetime default CURRENT_TIMESTAMP,
    updated_at datetime default CURRENT_TIMESTAMP
);

create table category(  
    id int(10) auto_increment  primary key,
    child_category int(10),
    parent_category int(10),
    name varchar(255),
    created_at datetime default CURRENT_TIMESTAMP,
    updated_at datetime default CURRENT_TIMESTAMP
);

create table delivery(  
    id int(10) auto_increment  primary key,
    id_account int(10),
    status varchar(255) null,
    estimated_date datetime,
    delivery_at datetime null,
    created_at datetime default CURRENT_TIMESTAMP,
    updated_at datetime default CURRENT_TIMESTAMP
);

