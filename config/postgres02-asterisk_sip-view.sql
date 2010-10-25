drop view if exists asterisk_sip;
drop table if exists asterisk_sip;
create view asterisk_sip as Select
        c.id, 
        c.name,
        c.accountcode,
        c.callerid,   
        c.canreinvite,
        (SELECT 
                (case
                        when (Select a.unlocked from residents a, rooms b where a.room = b.id and b.phone = c.id) is not NULL
                        then (Select a.unlocked from residents a, rooms b where a.room = b.id and b.phone = c.id )::context
                        else 'locked'::context
                end)
        ) AS context,

        c.host,
        c.port,
        c.mailbox,
        c.md5secret,
        c.nat, 
        c.permit,
        c.deny,  
        c.mask,  
        c.qualify,
        c.secret, 
        c.type,   
        c.username,
        c.defaultuser,
        c.useragent,  
        c.fromuser,   
        c.fromdomain, 
        c.disallow,   
        c.allow,      
        c.ipaddr,     
        c.mac,        
        c.fullcontact,
        c.regexten,   
        c.regserver,  
        c.regseconds, 
        c.lastms from phones c ;
