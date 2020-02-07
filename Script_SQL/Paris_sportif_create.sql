-- Drop table

--DROP TABLE public.team;

CREATE TABLE public.team (
	idteam serial NOT NULL,
	"name" varchar NOT NULL,
	points int4 NULL DEFAULT 0,
	CONSTRAINT team_pk PRIMARY KEY (idteam)
);

-- Drop table

--DROP TABLE public."match";

CREATE TABLE public."match" (
	idmatch serial NOT NULL,
	score_dom int4 NULL,
	score_ext int4 NULL,
	"location" varchar NULL,
	id_dom int4 NOT NULL,
	id_ext int4 NOT NULL,
	datetime timestamptz NULL,
	result int4 NULL,
	CONSTRAINT match_pk PRIMARY KEY (idmatch),
	CONSTRAINT match_fk FOREIGN KEY (id_dom) REFERENCES team(idteam),
	CONSTRAINT match_fk_1 FOREIGN KEY (id_ext) REFERENCES team(idteam)
);
-- Drop table

--DROP TABLE public.utilisateur;

CREATE TABLE public.utilisateur (
	iduser serial NOT NULL,
	username varchar NOT NULL,
	"password" varchar NOT NULL,
	email varchar NULL,
	first_name varchar NOT NULL,
	"name" varchar NOT NULL,
	score int4 NULL DEFAULT 25,
	"role" json NULL,
	CONSTRAINT utilisateur_pk PRIMARY KEY (iduser)
);

-- Drop table

--DROP TABLE public.bet;

CREATE TABLE public.bet (
	iduser int4 NOT NULL,
	idmatch int4 NOT NULL,
	"result" int NOT NULL,
	bet_datetime timestamptz NOT NULL,
	CONSTRAINT bet_pk PRIMARY KEY (iduser, idmatch),
	CONSTRAINT bet_fk FOREIGN KEY (iduser) REFERENCES utilisateur(iduser),
	CONSTRAINT bet_fk_1 FOREIGN KEY (idmatch) REFERENCES match(idmatch)
);