drop type if exists context cascade; --this will at least delete the view asterisk_sip!

create type context as enum ('unlocked', 'locked');

create or replace function bool_to_context (boolean)
    returns context
    strict
    language sql as '
    select case
        when $1 then ''unlocked''::context
        else ''locked''::context
        end;
    ';

create cast (boolean as context)
    with function bool_to_context(boolean)
    as assignment;
