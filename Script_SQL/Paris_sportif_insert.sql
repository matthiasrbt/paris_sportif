INSERT INTO public."match"
(idmatch, score_dom, score_ext, "location", id_dom, id_ext, datetime, "result")
VALUES(2, NULL, NULL, NULL, 3, 4, '2020-02-06 20:58:09.000', NULL);
INSERT INTO public."match"
(idmatch, score_dom, score_ext, "location", id_dom, id_ext, datetime, "result")
VALUES(3, NULL, NULL, NULL, 1, 4, '2020-02-07 18:58:09.000', NULL);
INSERT INTO public."match"
(idmatch, score_dom, score_ext, "location", id_dom, id_ext, datetime, "result")
VALUES(1, 1, 2, '', 1, 2, '2020-02-04 21:05:00.000', NULL);
INSERT INTO public."match"
(idmatch, score_dom, score_ext, "location", id_dom, id_ext, datetime, "result")
VALUES(4, NULL, NULL, NULL, 2, 3, '2020-02-25 18:58:09.000', NULL);


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
VALUES(7, 'matthias', '$argon2id$v=19$m=65536,t=4,p=1$WjPY/J+RAVADtAYwOUwf6A$SItPSsRraXO092N+xLL1x0l3Cba+pr7z7jZcZjkvjcw', 'matthias.robert@protonmail.com', 'Matthias', 'ROBERT', 25, '{"1":"ROLE_ADMIN"}');
