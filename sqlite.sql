--root=********
--pass=********

select * from users_pass;
select * from users_rank;
delete from users_pass where salt = '<secret>';
delete from users_pass where usr_name = '<secret>';
delete from users_rank where usr_name = '<secret>';

.tables
.schema

CREATE TABLE users_pass
(
usr_name varchar(100) PRIMARY KEY,
salt varchar(100),
stretch varchar(100),
hash varchar(100)
);

CREATE TABLE users_rank
(
usr_name varchar(100),
usr_rank INTEGER
);

INSERT INTO users_rank (usr_name, usr_rank) VALUES ("asari",0);

CREATE TABLE topic_tbl
(
tp_id INTEGER PRIMARY KEY AUTOINCREMENT,
tp_owner varchar(100),
usr_rank INTEGER,
tp_lock INTEGER,
tp_title varchar(200),
tp_version INTEGER,
tp_delete INTEGER 
);

INSERT INTO topic_tbl (tp_owner, usr_rank, tp_lock, tp_title, tp_version) VALUES ("asari",0,0,"Welcome to UgLy Forum!",0);
INSERT INTO topic_tbl (tp_owner, usr_rank, tp_lock, tp_title, tp_version) VALUES ("asari",0,0,"Introduce new members",0);
select * from topic_tbl;

drop table message_tbl;
CREATE TABLE message_tbl
(
msg_id INTEGER PRIMARY KEY AUTOINCREMENT,
tp_id INTEGER,
msg_owner varchar(100),
usr_rank INTEGER,
msg_title varchar(100),
msg_content varchar(4000),
msg_version INTEGER,
msg_delete INTEGER,
msg_date varchar(100),
msg_edit_user varchar(100),
msg_edit_date varchar(100)
);

INSERT INTO message_tbl (tp_id, msg_owner, usr_rank, msg_title, msg_content, msg_version, msg_date) VALUES (1,"asari",0,"Welcome message","This forum has been created so that you can exchange ideas, converse and meet with others who share a common interest in a safe environment. <br> Every community has its own culture and boundaries. To share how you feel about content, we encourage you to use the Reactions (the little icons under every comment) to share your positive feedback with users. This will help reinforce the proper behavior which we expect by all community members. <br><br>Here are some rules that we ask you to follow:<ul><li>Keep your posts relevant to the forum category.</li><li>Please be respectful of others and don’t sweat the small stuff. We’re not all English majors.</li><li>Please do not post any personal information (or photos) of yourself that you wouldn’t want to disclose to the public at large.</li><li>Do not post hateful racist, or illegal content. Do not post copyrighted material without proper attribution.</li><li>Please do not use the forum for self-promotion, solicitation, or advertising. SPAM will not be tolerated.</li><li>Please refrain from discussing illegal activities, sharing lewd photos or using curse words.</li><li>Rudeness, personal attacks, bullying, threats or inflammatory posts will not be tolerated.</li><li>Do not question moderators in the open forum. Moderation can be stressful, use private messages to chat with moderators.</li></ul>In summary, use your common sense, treat others are you expect to be treated and help us build a great community experience for everyone.",0,datetime('now'));
INSERT INTO message_tbl (tp_id, msg_owner, usr_rank, msg_title, msg_content, msg_version, msg_date) VALUES (1,"asari",0,"Announcement","Topic will be locked",0,datetime('now'));
select * from message_tbl;
select datetime('now');
UPDATE message_tbl SET msg_content='Topic will be locked' where msg_id = 2;

--**Delete User**
DELETE FROM users_pass WHERE usr_name = "";
DELETE FROM users_rank WHERE usr_name = "";
DELETE FROM topic_tbl WHERE tp_owner = "";
DELETE FROM message_tbl WHERE tp_id = "";
DELETE FROM message_tbl WHERE msg_owner = "";


--**Delete User**
DELETE FROM topic_tbl WHERE tp_id = "";
DELETE FROM message_tbl WHERE tp_id = "";



-- to update user rank
update users_rank set usr_rank = 0 where usr_name = 'teddy';