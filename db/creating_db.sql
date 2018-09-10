use mul18;
select * from mul18.color;

-- INSERT INTO color (colorname, cssclass) VALUES ('Yellow', 'yellow');
-- INSERT INTO color (colorname, cssclass) VALUES ('Green', 'green');
-- INSERT INTO color (colorname, cssclass) VALUES ('Blue', 'blue');

INSERT INTO postit (author, headertext, bodytext, color_id) VALUES ('Torben', 'Husk!', 'at købe billet til Esbjerg', 3);

select * from color;
select * from postit;

select id,colorname from color;

INSERT INTO color (colorname, cssclass) VALUES ('grey', 'grey');

select id,colorname from color;


select postit.id, createdate, author, headertext, bodytext, cssclass FROM postit INNER JOIN color ON color_id=color.id;

select * from color;