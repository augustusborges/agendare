/*use testes;

CREATE TABLE `testes`.`empresa` (
  `idempresa` INT NOT NULL AUTO_INCREMENT,
  `nomeempresa` VARCHAR(200) NULL,
  PRIMARY KEY (`idempresa`));

CREATE TABLE `testes`.`colaborador` (
  `idcolaborador` INT NOT NULL AUTO_INCREMENT,
  `nomecolaborador` VARCHAR(200) NULL,
  `idempresa` INT NULL,
  PRIMARY KEY (`idcolaborador`));

CREATE TABLE `testes`.`procedimento` (
  `idprocedimento` INT NOT NULL AUTO_INCREMENT,
  `nomeprocedimento` VARCHAR(200) NULL,
  `idempresa` INT NULL,
  PRIMARY KEY (`idprocedimento`));

CREATE TABLE `testes`.`servico` (
  `idservico` INT NOT NULL AUTO_INCREMENT,
  `idprocedimento` INT NULL,
  `idcolaborador` INT NULL,
  PRIMARY KEY (`idservico`));

CREATE TABLE `testes`.`agendamento` (
  `idagendamento` INT NOT NULL AUTO_INCREMENT,
  `idempresa` INT NULL,
  `idcolaborador` INT NULL,
  `dia` DATETIME NULL,
  `hora` VARCHAR(45) NULL,
  `livre` TINYINT(4) NULL,
  `idcliente` INT NULL,
  `idprocedimento` INT NULL,
   PRIMARY KEY (`idagendamento`));
   
   CREATE TABLE `testes`.`cliente` (
  `idcliente` INT NOT NULL AUTO_INCREMENT,
  `nomecliente` VARCHAR(200) NULL,
  `emailcliente` VARCHAR(200) NULL,
  `senhacliente` VARCHAR(255) NULL,
  PRIMARY KEY (`idcliente`));

insert into empresa (nomeempresa) values ("Cabelereiros Associados");
insert into empresa (nomeempresa) values ("Estética Reforma Geral");
insert into empresa (nomeempresa) values ("Clínica Médica");
select * from empresa;

insert into colaborador (nomecolaborador, idempresa) values ("Zeze Polessa", 1);
insert into colaborador (nomecolaborador, idempresa) values ("Francisco Cuoco", 1);
insert into colaborador (nomecolaborador, idempresa) values ("Brad Pitt",1);
insert into colaborador (nomecolaborador, idempresa) values ("Lucas Lucco", 2);
insert into colaborador (nomecolaborador, idempresa) values ("Zeze de Camargo", 2);
insert into colaborador (nomecolaborador, idempresa) values ("Leonardo",2);
insert into colaborador (nomecolaborador, idempresa) values ("Willian Bonner", 3);
insert into colaborador (nomecolaborador, idempresa) values ("Fatima Bernardes", 3);
insert into colaborador (nomecolaborador, idempresa) values ("Renata Vasconcelos",3);
select * from colaborador;

insert into procedimento (nomeprocedimento, idempresa) values ("Corte Masculino", 1);
insert into procedimento (nomeprocedimento, idempresa) values ("Unha Sllack", 1);
insert into procedimento (nomeprocedimento, idempresa) values ("Chapinha Progressiva", 1);
insert into procedimento (nomeprocedimento, idempresa) values ("Aplicação de Botox", 2);
insert into procedimento (nomeprocedimento, idempresa) values ("Drenagem Linfática", 2);
insert into procedimento (nomeprocedimento, idempresa) values ("Massagem", 2);
insert into procedimento (nomeprocedimento, idempresa) values ("Consulta Clínica Geral", 3);
insert into procedimento (nomeprocedimento, idempresa) values ("Apresentação de exames", 3);
insert into procedimento (nomeprocedimento, idempresa) values ("Exame de Esforço Físico", 3);
select * from procedimento;

insert into cliente (nomecliente, emailcliente, senha) values ("Alexandre Augustus Borges", "alexandre@alexandre.com", "123456");
insert into cliente (nomecliente, emailcliente, senha) values ("Paula Moreira Borges", "paula@paula.com", "123456");
insert into cliente (nomecliente, emailcliente, senha) values ("Severa Romana Maria", "severa@severa.com", "123456");
insert into cliente (nomecliente, emailcliente, senha) values ("Tânia Christina Aride", "tania@tania.com", "123456");
select * from procedimento;

insert into servico (idprocedimento, idcolaborador) values (1, 1);
insert into servico (idprocedimento, idcolaborador) values (2, 1);
insert into servico (idprocedimento, idcolaborador) values (3, 1);
insert into servico (idprocedimento, idcolaborador) values (2, 2);
insert into servico (idprocedimento, idcolaborador) values (3, 2);
insert into servico (idprocedimento, idcolaborador) values (3, 3);
insert into servico (idprocedimento, idcolaborador) values (4, 4);
insert into servico (idprocedimento, idcolaborador) values (5, 4);
insert into servico (idprocedimento, idcolaborador) values (6, 4);
insert into servico (idprocedimento, idcolaborador) values (5, 5);
insert into servico (idprocedimento, idcolaborador) values (6, 5);
insert into servico (idprocedimento, idcolaborador) values (6, 6);
insert into servico (idprocedimento, idcolaborador) values (7, 7);
insert into servico (idprocedimento, idcolaborador) values (8, 7);
insert into servico (idprocedimento, idcolaborador) values (9, 7);
insert into servico (idprocedimento, idcolaborador) values (8, 8);
insert into servico (idprocedimento, idcolaborador) values (9, 8);
insert into servico (idprocedimento, idcolaborador) values (9, 9);
select * from servico;

drop table empresa;
drop table colaborador;
drop table procedimento;
drop table servico;

ALTER TABLE empresa AUTO_INCREMENT = 1;
ALTER TABLE colaborador AUTO_INCREMENT = 1;
ALTER TABLE procedimento AUTO_INCREMENT = 1;
ALTER TABLE servico AUTO_INCREMENT = 1;


# Busca a lista de empresas cadastradas no sistema
select idempresa, nomeempresa from empresa;

# Busca os procedimentos de uma determinada empresa
select idprocedimento, nomeprocedimento from procedimento where idempresa = 1;

# Busca a lista de colaboradores de uma determinada empresa
select idcolaborador, nomecolaborador from colaborador where idempresa = 1;

# Busca os procedimentos executados por um determinado colaborador
select servico.idcolaborador, nomecolaborador, servico.idprocedimento, nomeprocedimento  from servico
inner join procedimento on procedimento.idprocedimento = servico.idprocedimento
inner join colaborador on colaborador.idcolaborador = servico.idcolaborador
where servico.idcolaborador = 1;

# Cria nova agenda para um determinado colaborador de uma determinada empresa
insert into agendamento (idempresa, idcolaborador, dia, hora, livre) values (1, 1, '2018-02-09', "0800", true); 
select * from agendamento;

#Limpa a tabela para novas inserções
delete from agendamento where idagendamento=1;
ALTER TABLE agendamento AUTO_INCREMENT = 1;

# Cria nova agenda para um determinado colaborador de uma determinada empresa
insert into agendamento (idempresa, idcolaborador, dia, hora, livre) values (1, 1, '2018-02-10', "1000", true); 

# Busca a agenda livre de um determinado colaborador para uma determinada data específica
select * from agendamento where dia='2018-02-10' and idcolaborador = 1 and livre=true;

# Busca a agenda livre de um determinado colaborador 
select * from agendamento where idcolaborador = 1 and livre=true;

#Busca os colaboradores que executam determinado procedimento em uma determinada empresa
select prc.idprocedimento, prc.nomeprocedimento, prc.idempresa, srv.idcolaborador, clb.nomecolaborador from procedimento prc 
inner join servico srv on srv.idprocedimento = prc.idprocedimento
inner join colaborador clb on clb.idcolaborador = srv.idcolaborador
where prc.idempresa = 1
and prc.idprocedimento = 3;

select prc.idprocedimento
    , prc.nomeprocedimento
        , prc.idempresa
        , srv.idcolaborador
        , clb.nomecolaborador
        , agn.hora
        from procedimento prc 
inner join servico srv on srv.idprocedimento = prc.idprocedimento
inner join colaborador clb on clb.idcolaborador = srv.idcolaborador
inner join agendamento agn on agn.idcolaborador = clb.idcolaborador
where prc.idempresa = 1
and prc.idprocedimento = 1
and agn.dia = '2018-02-09'
and agn.livre = true;

use testes;
select * from agendamento;
delete from agendamento;
 
select * from servico where idprocedimento = 3;

*/
# dado um procedimento
# e uma determinada data
# buscar todos os colaboradores que executam tal procedimento e que tenham horario livre na data informada








