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