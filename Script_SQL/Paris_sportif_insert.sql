INSERT INTO public."match"
(idmatch, "date", "time", score_dom, score_ext, "location", id_dom, id_ext)
VALUES(1, NULL, NULL, 0, 0, NULL, 1, 2);
INSERT INTO public."match"
(idmatch, "date", "time", score_dom, score_ext, "location", id_dom, id_ext)
VALUES(2, NULL, NULL, 0, 0, NULL, 3, 4);
INSERT INTO public."match"
(idmatch, "date", "time", score_dom, score_ext, "location", id_dom, id_ext)
VALUES(3, NULL, NULL, 0, 0, NULL, 1, 4);
INSERT INTO public."match"
(idmatch, "date", "time", score_dom, score_ext, "location", id_dom, id_ext)
VALUES(4, NULL, NULL, 0, 0, NULL, 2, 3);

************************************************************************************************************************
INSERT INTO public.team
(idteam, "name", points)
VALUES(1, 'Nantes', 0);
INSERT INTO public.team
(idteam, "name", points)
VALUES(2, 'Paris-SG', 0);
INSERT INTO public.team
(idteam, "name", points)
VALUES(3, 'Rennes', 0);
INSERT INTO public.team
(idteam, "name", points)
VALUES(4, 'Lille', 0);
************************************************************************************************************************
INSERT INTO public.utilisateur
(iduser, username, "password", email, first_name, "name", score, "role")
VALUES(3, 'matthias', '$argon2id$v=19$m=65536,t=4,p=1$WjPY/J+RAVADtAYwOUwf6A$SItPSsRraXO092N+xLL1x0l3Cba+pr7z7jZcZjkvjcw', 'matthias.robert@protonmail.com', 'Matthias', 'ROBERT', 25, '{"1":"ROLE_ADMIN"}');
