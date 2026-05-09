create table admin (
    id_admin int primary key auto_increment,
    nom varchar(255) not null,
    prenom varchar(255) not null,
    email varchar(255) not null unique,
    mot_de_passe varchar(255) not null
);