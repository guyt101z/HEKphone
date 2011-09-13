
drop view if exists asterisk_sip;
CREATE VIEW asterisk_sip AS
    SELECT
        p.id,
        (SELECT '1' || lpad(b.room_no::varchar,3,'0') from rooms b
                where b.phone = p.id
        ) AS name,
        p.type,
        (SELECT
                (case
                        when (Select count(*) from residents a, rooms b
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL))) is not NULL
                        then (Select a.first_name || ' ' || a.last_name || ' ' || '(' || lpad(b.room_no::varchar,3,'0') || ')' from residents a, rooms b
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL)))
                        else (Select lpad(b.room_no::varchar,3,'0') from rooms b 
                                where b.phone=p.id)
                end)
        ) AS callerid,
        (SELECT '1' || lpad(b.room_no::varchar,3,'0') from rooms b
                where b.phone = p.id
        ) AS defaultuser,
        (SELECT
                (case
                        when (Select a.password from residents a, rooms b
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL))) is not NULL
                        then (Select SUBSTR(a.password,0,8) from residents a, rooms b
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL)))
                        else 'hekphone'
                end)
        ) AS secret,
        p.host,
        (SELECT '192.168.' || SUBSTR(lpad(b.room_no::varchar,3,'0'),0,2) || '.' || SUBSTR(lpad(b.room_no::varchar,3,'0'),2,4)::int from rooms b
                where b.phone = p.id
        ) AS defaultip,
        p.mac,
        (SELECT
                (case
                        when (Select a.culture from residents a, rooms b
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL))) != ''
                        then (Select SUBSTR(a.culture,0,3) from residents a, rooms b
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL)))
                        else 'de'
                end)
        ) AS language,
        (SELECT
                (case
                        when (Select count(*) from residents a, rooms b
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL))) is not NULL
                        then (Select a.id || '@default' from residents a, rooms b
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL)))
                        else null
                end)
        ) AS mailbox,
        p.regserver,
        p.regseconds,
        p.ipaddr,
        p.port,
        p.fullcontact,
        p.useragent,
        p.lastms,
        '00497218695' || p.name AS cid_number,
        (SELECT
                (case
                        when (Select a.unlocked from residents a, rooms b
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL))) is not NULL
                        then (Select a.unlocked from residents a, rooms b
                                where a.room = b.id and b.phone = p.id
                                and (a.move_in <= current_date and (a.move_out >= current_date or a.move_out is NULL)))::context
                        else 'locked'::context
                end)
        ) AS context
        from phones p
        where technology = 'SIP';

CREATE RULE asterisk_sip_update AS
    ON UPDATE TO asterisk_sip
    DO INSTEAD
        UPDATE phones SET
            id = NEW.id,
            name = NEW.name,
            type = NEW.type,
            callerid = NEW.callerid,
            defaultuser = OLD.defaultuser, -- prevent asterisk from overwriting the value, the phone would not be able to register otherwise
            host = NEW.host,
            defaultip = NEW.defaultip,
            mac = NEW.mac,
            language = NEW.language,
            mailbox = NEW.mailbox,
            regserver = NEW.regserver,
            regseconds = NEW.regseconds,
            ipaddr = NEW.ipaddr,
            port = NEW.port,
            fullcontact = NEW.fullcontact,
            useragent = NEW.useragent,
            lastms = NEW.lastms
        WHERE id = NEW.id;

GRANT ALL ON asterisk_sip to asterisk;
