drop view if exists asterisk_sip;
drop table if exists asterisk_sip;
CREATE VIEW asterisk_sip AS 
    SELECT
        p.id, 
        p.name,
        p.type,
        p.callerid,   
        p.defaultuser,
        p.secret,
        p.host,
        p.defaultip,
        p.mac,
        p.language,
        p.mailbox,
        p.regserver,
        p.regseconds,
        p.ipaddr,
        p.port,
        p.fullcontact,
        p.useragent,
        p.lastms,
        (SELECT 
                (case
                        when (Select a.unlocked from residents a, rooms b where a.room = b.id and b.phone = p.id) is not NULL
                        then (Select a.unlocked from residents a, rooms b where a.room = b.id and b.phone = p.id )::context
                        else 'locked'::context
                end)
        ) AS context
        from phones p ;

CREATE RULE asterisk_cdr_update AS
    ON UPDATE TO asterisk_sip
    DO INSTEAD 
        UPDATE phones SET
            regserver = NEW.regserver,
            regseconds = NEW.regseconds,
            ipaddr = NEW.ipaddr,
            port = NEW.port,
            fullcontact = NEW.fullcontact,
            useragent = NEW.useragent,
            lastms = NEW.lastms
        WHERE id = NEW.id;
