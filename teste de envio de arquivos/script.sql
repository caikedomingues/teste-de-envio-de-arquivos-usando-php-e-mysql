

create database testedeenviodearquivos;

use testedeenviodearquivos;

create table pessoas(

id int auto_increment,
email varchar(255),
senha varchar(255),
arquivo longblob, /*Tipo que suporta arquivos de tamanhos grandes.*/

primary key(id)


)default charset=utf8;

/*Modificando a coluna arquivo para transforma-la no tipo texto*/

alter table pessoas modify column arquivo text;

/*Exclusão do id 6 do banco de dados*/
delete from pessoas where id = 8;

/*Agora que conseguimos a maneira correta de armazenar fotos, vamos
apagar o banco de dados inteiro e adicionar novas fotos de usuário*/
/*Desabilita o modo segurança do mysql e possibilita apagar todos os
registros do banco de dados*/
SET SQL_SAFE_UPDATES = 0;
/*Ira excluir todo o banco de dados*/
delete from pessoas;

select*from pessoas;