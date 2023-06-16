drop database if exists atigazolasok;

create database atigazolasok
DEFAULT CHARACTER SET utf8 
DEFAULT COLLATE utf8_general_ci;

use atigazolasok;

create table jatekos(
    id int primary key auto_increment not NULL,
    nev nvarchar(100),
    ertek float,
    nemzetiseg nvarchar(100)
);

INSERT INTO jatekos (nev, ertek, nemzetiseg) VALUES ('Erling Haaland','151.5','norvég');
INSERT INTO jatekos (nev, ertek, nemzetiseg) VALUES ('Lionel Messi', '80.1', 'argentin');
INSERT INTO jatekos (nev, ertek, nemzetiseg) VALUES ('Neymar', '72.9', 'brazil');
INSERT INTO jatekos (nev, ertek, nemzetiseg) VALUES ('Kylian Mbappé', '141.2', 'francia');
INSERT INTO jatekos (nev, ertek, nemzetiseg) VALUES ('Kevin De Bruyne', '149.7', 'belga');
INSERT INTO jatekos (nev, ertek, nemzetiseg) VALUES ('Cristiano Ronaldo', '20.5', 'portugál');
INSERT INTO jatekos (nev, ertek, nemzetiseg) VALUES ('Robert Lewandowski', '43.3', 'lengyel');
INSERT INTO jatekos (nev, ertek, nemzetiseg) VALUES ('Mohamed Salah', '94.8', 'egyiptomi');
INSERT INTO jatekos (nev, ertek, nemzetiseg) VALUES ('Sergio Ramos', '10.6', 'spanyol');
INSERT INTO jatekos (nev, ertek, nemzetiseg) VALUES ('Manuel Neuer', '67.9', 'német');


create table csapat(
    id int primary key auto_increment not NULL,
    nev nvarchar(100),
    nemzetiseg nvarchar(100)
);

INSERT INTO csapat (nev, nemzetiseg) VALUES ('Még nincs csapata', '');
INSERT INTO csapat (nev, nemzetiseg) VALUES ('Visszavonult', '');
INSERT INTO csapat (nev, nemzetiseg) VALUES ('Manchester City', 'angol');
INSERT INTO csapat (nev, nemzetiseg) VALUES ('Dortmund', 'német');
INSERT INTO csapat (nev, nemzetiseg) VALUES ('Real Madrid', 'spanyol');
INSERT INTO csapat (nev, nemzetiseg) VALUES ('Paris Saint-Germain', 'francia');
INSERT INTO csapat (nev, nemzetiseg) VALUES ('Juventus', 'olasz');
INSERT INTO csapat (nev, nemzetiseg) VALUES ('Bayern München', 'német');
INSERT INTO csapat (nev, nemzetiseg) VALUES ('Barcelona', 'spanyol');
INSERT INTO csapat (nev, nemzetiseg) VALUES ('Wolfsburg', 'német');

create table atigazolas(
    id int primary key auto_increment not NULL,
    jatekosid int not NULL,
    regi_csapatid int not NULL,
    uj_csapatid int not NULL,
    osszeg float,
    datum date not NULL,

    FOREIGN KEY (jatekosid) REFERENCES jatekos(id),
    FOREIGN KEY (regi_csapatid) REFERENCES csapat(id),
    FOREIGN KEY (uj_csapatid) REFERENCES csapat(id)
);
INSERT INTO atigazolas (jatekosid, regi_csapatid, uj_csapatid, osszeg, datum) VALUES ('1', '1','4','0','2020-01-15');
INSERT INTO atigazolas (jatekosid, regi_csapatid, uj_csapatid, osszeg, datum) VALUES ('1', '4','3','80.4','2022-01-15');
INSERT INTO atigazolas (jatekosid, regi_csapatid, uj_csapatid, osszeg, datum) VALUES ('5', '1','10','10.1','2010-07-12');
INSERT INTO atigazolas (jatekosid, regi_csapatid, uj_csapatid, osszeg, datum) VALUES ('5', '10','3','75.7','2020-08-01');

create table felhasznalo(
id int primary key auto_increment not NULL,
felhasznalonev nvarchar(100),
jelszo nvarchar(255),
skin nvarchar(50)
);
