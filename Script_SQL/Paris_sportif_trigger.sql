CREATE OR REPLACE FUNCTION public.formatting_user()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
	begin
		new.first_name = initcap(new.first_name);
		new.name = upper(new.name);
		return new;
	end
$function$
;
create trigger trig_bef_ins_utilisateur_formatting_user before
insert
    on
    public.utilisateur for each row execute procedure formatting_user();
------------------------------------------------------------------------------------------------------------------------
CREATE OR REPLACE FUNCTION public.gen_result_match()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
	DECLARE
		score_d integer;
		score_e integer;
	BEGIN
		select into score_d new.score_dom from match where idmatch = new.idmatch;
		select into score_e new.score_ext from match where idmatch = new.idmatch;
		IF score_d = score_e THEN
			update match set result = 0 where idmatch = new.idmatch;
		ELSEIF score_d > score_e THEN
			update match set result = 1 where idmatch = new.idmatch;
		ELSEIF score_d < score_e THEN
			update match set result = 2 where idmatch = new.idmatch;
		END IF;
			return new;
	END;
$function$
;

create trigger trig_aft_upd_match after
update
    of score_dom,
    score_ext on
    public.match for each row execute procedure gen_result_match();
------------------------------------------------------------------------------------------------------------------------
