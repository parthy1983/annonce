-- liste des emprunts non rendus
-- IS null pour tester un valeur nulle
select *
from emprunt
where date_rendu is null;

-- titres des livres non rendus
select titre
from livre
where id_livre in (
	select id_livre
	from emprunt
	where date_rendu is null
);

-- afficher les id des livres
-- empruntés par Chloe
select id_livre
from emprunt
where id_abonne = (
	select id_abonne
    from abonne where prenom = 'Chloe'
);

-- combien de livres a emprunté Guillaume
select count(*)
from emprunt
where id_abonne = (
	select id_abonne from abonne
    where prenom = 'Guillaume'
);

-- quels sont les titres de ces livres ?
select titre
from livre
where id_livre in (
	select id_livre
    from emprunt
    where id_abonne = (
		select id_abonne
        from abonne
        where prenom = 'Guillaume'
    )
);

-- le titre du/des livre(s) non encore
-- rendu(s) par Chloe
select titre
from livre
where id_livre in (
	select id_livre
    from emprunt
    where date_rendu is null
    and id_abonne = (
		select id_abonne
        from abonne
        where prenom = 'Chloe'
    )
);

-- qui a emprunté le plus de livres ?
select prenom
from abonne where id_abonne = (
	select id_abonne
	from emprunt
	group by id_abonne
	order by count(*) desc
	limit 1
);

-- jointure
select a.prenom, e.date_sortie
from abonne a, emprunt e
where a.id_abonne = e.id_abonne
and a.prenom = 'Guillaume';

-- le prénom de Guillaume
-- et les titres des livres empruntés
-- par Guillaume
select a.prenom, l.titre
from abonne a, emprunt e, livre l
where a.id_abonne = e.id_abonne
and e.id_livre = l.id_livre
and a.prenom = 'Guillaume';

-- avec join
select a.prenom, e.date_sortie
from abonne a
join emprunt e on a.id_abonne = e.id_abonne
where a.prenom = 'Guillaume';

select a.prenom, l.titre
from abonne a
join emprunt e on a.id_abonne = e.id_abonne
join livre l on e.id_livre = l.id_livre
where a.prenom = 'Guillaume';

-- les prénoms des abonnés qui ont emprunté
-- "une vie" en 2014
select a.prenom
from abonne a
join emprunt e on a.id_abonne = e.id_abonne
join livre l on e.id_livre = l.id_livre
where l.titre = 'Une vie'
and e.date_sortie like '2014%';

-- quels ont été les dates d'emprunt
-- (sortie et rendu) pour les livres
-- de maupassant ?
select e.date_sortie, e.date_rendu
from emprunt e
join livre l on e.id_livre = l.id_livre
where l.auteur = 'GUY DE MAUPASSANT';

-- pour chaque emprunt rendu
-- afficher le prénom de l'abonné
-- le titre du livre et les dates de sortie
-- et de rendu
select 
	a.prenom,
    l.titre, 
    e.date_sortie, 
    e.date_rendu
from abonne a
join emprunt e on a.id_abonne = e.id_abonne
join livre l on e.id_livre = l.id_livre
where e.date_rendu is not null;

-- compter le nombre de livres empruntés
-- par abonne (afficher le prénom de l'abonné
-- et le nombre de livres)
select a.prenom, count(e.id_livre) as nb_livres
from abonne a
join emprunt e on a.id_abonne = e.id_abonne
group by a.prenom;
