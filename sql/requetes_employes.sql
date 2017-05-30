-- tous les champs
-- pour les employés
select * from employes;

-- seulement les champs nom et prenom
select nom, prenom
from employes;

-- les services des employes
select service
from employes;

-- les différents service
-- suppression des doublons
select distinct service
from employes;

-- dédoublonnage sur plusieurs champs
select distinct service, sexe
from employes;

-- filtre sur le service comercial
select *
from employes
where service = 'commercial';

-- != ou <> : différent de
select *
from employes
where service != 'commercial';

select *
from employes
where service <> 'commercial';

-- opérateurs de comparaison
select * from employes
where salaire > 2000;

select * from employes
where salaire < 2000;

select * from employes
where salaire >= 2000;

select * from employes
where salaire <= 2000;

-- entre 2 valeurs incluses
select * from employes
where salaire between 1500 and 2000;

-- commence par un s
select * from employes
where prenom like 's%';

-- se termine par un e
select * from employes
where prenom like '%e';

-- contient un tiret
select * from employes
where prenom like '%-%';

-- tri des résultats
select *
from employes
order by nom;

select *
from employes
order by nom asc;

-- tri décroissant
select *
from employes
order by nom desc;

-- tri sur plusieurs champs
select *
from employes
order by prenom, nom;

-- limiter aux 5 1ers résultats
select *
from employes
order by prenom, nom
limit 5;

select *
from employes
order by prenom, nom
limit 5 offset 0;

-- 5 résultat à partir du 6e
select *
from employes
order by prenom, nom
limit 5 offset 5;

-- = limit 5 offset 10
select *
from employes
order by prenom, nom
limit 10, 5;

-- order des éléments d'une requête
select *
from employes
where service = 'commercial'
order by prenom, nom
limit 10, 5;

-- les 3 employés les mieux payés
select *
from employes
order by salaire desc
limit 3;

-- les 3 femmes les mieux payés
select *
from employes
where sexe = 'f'
order by salaire desc
limit 3;

-- fonctions d'aggrégat

-- compte le nb d'employes
select count(*)
from employes;

select count(*)
from employes
where sexe = 'f';

-- fait la somme des salaires de tous les employes
select sum(salaire)
from employes;

-- fait la moyenne (average) des salaires de tous les employes
select avg(salaire)
from employes;

-- maximum et minimum
select max(salaire)
from employes;

select min(salaire)
from employes;

-- sous-requête
-- on utilise le résultat
-- de la requête entre parenthèses
-- dans la requête principale
select salaire, prenom 
from employes
where salaire = (
	select min(salaire)
	from employes
);

-- in (str1, str2) : égal str1 ou égal str2
select *
from employes
where service in ('commercial', 'informatique');

select *
from employes
where service not in ('commercial', 'informatique');

select *
from employes
where service = 'commercial'
and salaire >= 2000
and sexe = 'f';

select *
from employes
where service = 'commercial'
or salaire >= 2000;

-- priorité du AND sur le OR
select * from employes
where service = 'commercial'
and (salaire = 2300
or salaire = 1900)
order by salaire;

-- on peut utiliser les opérateurs
-- mathematiques +, -, *, /
select salaire, salaire + 100
from employes;

-- group by
-- le nombre d'employes pour
-- chaque service
select service, count(*)
from employes
group by service;

-- le nombre d'employes pour
-- chaque service dont le service
-- contient plus de 2 employes
select 
	service, 
    count(*) as nb_employes
from employes
group by service
having nb_employes > 2;

-- INSERT
insert into employes(
	id_employes,
    prenom,
    nom,
    sexe,
    service,
    date_embauche,
    salaire
) values (
	1000,
    'Julien',
    'Anest',
    'm',
    'informatique',
    '2017-01-01',
    3000
);

select * from employes;

-- la clé primaire auto-increment sera automatiquement
-- générée si elle n'est pas dans la liste
insert into employes(
    prenom,
    nom,
    sexe,
    service,
    date_embauche,
    salaire
) values (
    'Julien2',
    'Anest',
    'm',
    'informatique',
    '2017-01-01',
    3000
);

-- UPDATE
update employes
set salaire = 3200,
	service = 'direction'
where id_employes = 1000;

-- DELETE
delete from employes
where id_employes = 1002;

-- REPLACE (mysql)
-- si la clé primaire passée
-- vaut NULL ou existe déjà dans
-- la table => UPDATE
-- sinon => INSERT
replace into employes(
	id_employes,
    prenom,
    nom,
    sexe,
    service,
    date_embauche,
    salaire
) values (
	NULL,
    'Julien',
    'Anest',
    'm',
    'informatique',
    '2017-01-01',
    3000
);

