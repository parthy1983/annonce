-- 1 -- Afficher la profession de l'employé 547.
select profession from employes id=547;		
-- 2 -- Afficher la date d'embauche d'Amandine.
select date from employes where prenom 'Amandine';		
-- 3 -- Afficher le nom de famille de Guillaume
select nom from employes where prenom 'Guillaume';		
-- 4 -- Afficher le nombre de personne ayant un n° id_employes commençant par le chiffre 5.
select nom from employes where id_employes like '5%';		
-- 5 -- Afficher le nombre de commerciaux.
select count(*) from employes where service = 'commercial';	
-- 6 -- Afficher le salaire moyen des informaticiens.
select avg(salaire) from employes where service = 'informatique';	
-- 7 -- Afficher les 5 premiers employés après avoir classer leur nom de famille par ordre alphabétique.
select * from employes order by nom asc limit 5;			
-- 8 -- Afficher le coût des commerciaux sur 1 année.
select sum(salaire * 12) from employes where service = 'commercial';		
-- 9 -- Afficher le salaire moyen par service. (service + salaire moyen)
select service, avg(salaire) from employes group by service;		
-- 10 -- Afficher le nombre de recrutement sur l'année 2010.
		
-- 11 -- Afficher le salaire moyen appliqué lors des recrutements sur la période allant de 2005 a 2007

-- 12 -- Afficher le nombre de service différent

-- 13 -- Afficher tous les employés (sauf ceux du service production et secrétariat)

-- 14 -- Afficher conjoitement le nombre d'homme et de femme dans l'entreprise

-- 15 -- Afficher les commerciaux ayant été recrutés avant 2005 de sexe masculin et gagnant un salaire supérieur a 2500E

-- 16 -- Qui a été embauché en dernier

-- 17 -- Afficher les informations sur l'employé du service commercial gagnant le salaire le plus élevé

-- 18 -- Afficher le prénom du comptable gagnant le meilleur salaire

-- 19 -- Afficher le prénom de l'informaticien ayant été recruté en premier

-- 20 -- Augmenter chaque employé de 100E

-- 21 -- Supprimer les employés du service secrétariat

