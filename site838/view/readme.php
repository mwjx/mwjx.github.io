<?php
//------------------------------
//create time:2006-6-5
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:˵��
//------------------------------
//Ҫʵ�ֵ�Ŀ��,2017-06-10 
//cacheĿ���ֹδ��¼


//exit(md5("aa"));
/*
838,����Դ,post,encode
838С˵��ҳ�²���Դ��վ����
mwjx,��̬����,����ͼƬ
*/
/*
����1.5ǧIP,2007-3-26
�����º�1.5��IP,��10��1��
ƽ��ÿ������2ǧ
4������շ�����ͻ��3ǧ//ʧ��
*/
/*
Ŀ¼˵��
/html/  //��̬����Ŀ¼
/data/  //����Ŀ¼
/data/update_track/ //��������Ŀ¼
/books/  //վ����Ʒ�⣬�б�ҳ����Ʒҳ
/store/  //��Ʒ�⣬�б�ҳ
/udata/	 //�û�����Ŀ¼
/author/ //�����б�����ҳ
/chars/a_author/ //��ĸ��������
/chars/a_books/  //��ĸ����վ����Ʒ
/chars/a_class/  //��ĸ����վ����Ʒ

*/
/*
--------��װ˵��-----------
config.inc.php
function.inc.php
*/
//$m_guest_id = 200200167;//200200167,�ο�ר��ID
/*
----------sql---------
*/
/*
-----------����(Ҳ��������)ͶƱ-----------
from_id:ͶƱ��ID,0Ϊ�ο�
to_id:������ID(һ������ID)
i_ip:ͶƱ��IP������ʽ
aday:ͶƱ����
classid:ͶƱ����1��������,2��������
CREATE TABLE tbl_voterc (
	id bigint(20) unsigned NOT NULL auto_increment,
	from_id int(10) unsigned NOT NULL default '0',
	to_id int(10) unsigned NOT NULL default '0',
	i_ip bigint(20) unsigned NOT NULL default '0',
	aday date NOT NULL default '0000-00-00',
	classid int(10) NOT NULL default '0',
	PRIMARY KEY (id),
	KEY from_id (from_id),
	KEY to_id (to_id),
	KEY i_ip (i_ip),
	KEY aday (aday),	
	KEY classid (classid)
	) TYPE=MyISAM;
*/



/*
---------����---------
ID(id):
����(name):
����ID(type):ÿ��type����һ�ֲ�ͬ������
����(host):������ID
ִ����(run_er):ִ����ID
ִ�м��(enum_interval):(M/W/D/H/E)��,��,��,Сʱ,ÿ��
��������(cday):
����ɹ�ִ��ʱ��(last):
�Ƿ���Ч(active):Y��Ч,N��Ч
CREATE TABLE tbl_task (
  id int(10) unsigned NOT NULL auto_increment,
  name varchar(50) NOT NULL default '',
  `type` TINYINT(3) NOT NULL default '0',
  host bigint(20) unsigned NOT NULL default '0',
  run_er bigint(20) unsigned NOT NULL default '0',
  `interval` enum('M','W','D',"H",'E') NOT NULL default 'D',
  cday date NOT NULL default '0000-00-00',
  last datetime NOT NULL default '0000-00-00 00:00:00',
  active enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (`id`,`type`,`interval`,`last`),
  KEY active (active)
) TYPE=MyISAM;

*/

/*
-------------��̳������ݱ�-----
��������������������ʷԭ��Ҳ�в����Ǹ�����¼
int_class_id:������Ŀ(���)ID
enum_good:Y/N(����/��ͨ)
str_poster:�������û���
str_author:ԭ����
int_click:�����
int_price:���¼۸񣬿���Ҫ������2007-3-27
int_money:�����õĽ�Ǯ������Ҫ������2007-3-27
enum_father:Y/N(����/����)
int_fatherid:������ID���Ǹ�����¼ʱ��Ч������Ҫ������2007-3-27
str_title:����
enum_active:Y/N(��Ч/��Ч)
enum_top:Y/N(�ö�/���ö�)
dte_post:��������
dtt_change:�������ʱ��
CREATE TABLE tbl_article (
  int_id int(10) unsigned NOT NULL auto_increment,
  int_class_id int(10) unsigned NOT NULL default '0',
  enum_good enum('Y','N') NOT NULL default 'N',
  str_poster varchar(20) NOT NULL default '0',
  str_author varchar(20) NOT NULL default '0',
  int_click int(10) unsigned NOT NULL default '0',
  int_price int(10) unsigned NOT NULL default '0',
  int_money int(10) unsigned NOT NULL default '0',
  enum_father enum('Y','N') NOT NULL default 'N',
  int_fatherid int(10) unsigned NOT NULL default '0',
  str_title varchar(100) NOT NULL default '0',
  enum_active enum('Y','N') NOT NULL default 'Y',
  enum_top enum('Y','N') NOT NULL default 'N',
  dte_post date NOT NULL default '0000-00-00',
  dtt_change datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (int_id),
  KEY str_title (str_title),
  KEY enum_good (enum_good),
  KEY enum_father (enum_father),
  KEY enum_active (enum_active),
  KEY enum_top (enum_top),
  KEY int_class_id (int_class_id),
  KEY int_id (int_id),
  KEY int_money (int_money),
  KEY int_fatherid (int_fatherid),
  KEY dtt_change (dtt_change)
) TYPE=MyISAM;
ALTER TABLE `db_mwjx`.`tbl_article` CHANGE `str_title` `str_title` VARCHAR(255) DEFAULT '0' NOT NULL
---------phpwind----------
CREATE TABLE pw_threads (
  tid mediumint(8) unsigned NOT NULL auto_increment,
  fid smallint(6) NOT NULL default '0',
  icon tinyint(2) NOT NULL default '0',
  titlefont char(15) NOT NULL default '',
  author char(15) NOT NULL default '',
  authorid mediumint(8) unsigned NOT NULL default '0',
  subject char(100) NOT NULL default '',
  toolinfo char(16) NOT NULL default '',
  toolfield int(10) unsigned NOT NULL default '0',
  ifcheck tinyint(1) NOT NULL default '0',
  type tinyint(2) NOT NULL default '0',
  postdate int(10) unsigned NOT NULL default '0',
  lastpost int(10) unsigned NOT NULL default '0',
  lastposter char(15) NOT NULL default '',
  hits int(10) unsigned NOT NULL default '0',
  replies int(10) unsigned NOT NULL default '0',
  topped smallint(6) NOT NULL default '0',
  locked tinyint(1) NOT NULL default '0',
  digest tinyint(1) NOT NULL default '0',
  ifupload tinyint(1) NOT NULL default '0',
  pollid int(10) NOT NULL default '0',
  ifmail tinyint(1) NOT NULL default '0',
  ifmark smallint(6) NOT NULL default '0',
  PRIMARY KEY  (tid),
  KEY authorid (authorid),
  KEY digest (digest),
  KEY topped (topped),
  KEY ifcheck (ifcheck),
  KEY lastpost (fid,topped,lastpost)
) TYPE=MyISAM;

CREATE TABLE pw_tmsgs (
  tid mediumint(8) unsigned NOT NULL default '0',
  aid text NOT NULL,
  userip varchar(15) NOT NULL default '',
  ifsign tinyint(1) NOT NULL default '0',
  buy text NOT NULL,
  ipfrom varchar(80) NOT NULL default '',
  alterinfo varchar(50) NOT NULL default '',
  ifconvert tinyint(1) NOT NULL default '1',
  content mediumtext NOT NULL,
  form varchar(30) NOT NULL default '',
  ifmark varchar(255) NOT NULL default '',
  c_from varchar(30) NOT NULL default '',
  PRIMARY KEY  (tid)
) TYPE=MyISAM;

        
*/
/*
//------------��Ŀ��Ϣ��-----------
id:��ID
name:����
fid:����ĿID
creator:������ID
enable:�Ƿ���Ч
last:�������ʱ��
memo:��ע�����ܣ�˵��,��Ϊ�����ֶ�
cover:����ͼƬ
CREATE TABLE class_info (
	id mediumint(8) unsigned NOT NULL default '0' auto_increment,
	name  varchar(50) NOT NULL default '',
	fid mediumint(8) unsigned NOT NULL default '0',
	creator int(10) unsigned NOT NULL default '0',
	enable enum('Y','N') NOT NULL default 'N',	
	last datetime NOT NULL default '0000-00-00 00:00:00',
	memo text NOT NULL  default '',
	PRIMARY KEY  (id),
	key fid(fid)
) TYPE=MyISAM;
ALTER TABLE `db_mwjx`.`class_info` ADD `cover` VARCHAR(255) NOT NULL; 
*/
/*
//------------��Ŀά���˱�,Ҫ����,2011-1-1-------------
id:��ĿID
manager:ά����ID
CREATE TABLE class_manager (
	id mediumint(8) UNSIGNED unsigned NOT NULL default '0',
	manager int(10) unsigned NOT NULL default '0',
	key id(id),
	key manager(manager)
) TYPE=MyISAM;
*/
/*
//------------�ҵ����-----------
id:���
uid:�û�ID
cid:��ĿID
title:����
aid:����Ķ��½�ID
ct:����ʱ��
memo:��ע
CREATE TABLE my_book (
	id mediumint(8) unsigned NOT NULL auto_increment,
	uid int(10) unsigned NOT NULL default '0',
	cid mediumint(8) unsigned NOT NULL default '0',
	title  varchar(255) NOT NULL default '',
	aid int(10) unsigned NOT NULL default '0',
	ct datetime NOT NULL default '0000-00-00 00:00:00',
	memo text NOT NULL  default '',
	PRIMARY KEY  (id),
	key cid(cid)
) TYPE=MyISAM;
*/

/*
//------------����������Ŀ��------------
cid:��ĿID
aid:����ID
CREATE TABLE class_article (
	cid mediumint(8) unsigned NOT NULL default '0',
	aid int(10) unsigned NOT NULL default '0',
	key cid(cid),
	key aid(aid)
) TYPE=MyISAM;
*/
/*
//------------������---------------------
r_type:��������,1/2/3(��Ŀ����/���¸���/������ҳ)
id:���,2007-7-3���
gid:��������ID,����һ����Ŀ������ID
poster:������ID
modify:����ʱ��
title:����
content:����
CREATE TABLE reply (
	id int(10) unsigned NOT NULL auto_increment,
	r_type TINYINT NOT NULL default '0',
	gid int(10) unsigned NOT NULL default '0',
	poster int(10) unsigned NOT NULL default '0',
	modify datetime NOT NULL default '0000-00-00 00:00:00',
	title varchar(100) NOT NULL default '',	
	content text NOT NULL  default '',	
	PRIMARY KEY (id),
	key gid(gid),
	key poster(poster),
	key modify(modify)
) TYPE=MyISAM;
*/
/*----------------��Ȩ��authorize--------------
src_php/my_power.php
class/mwjx/authorize.php
res_class:��Դ����:-1��,0����/1��վ/2��Ŀ/3����
res:��ԴID:-1��,0����
action:��Ȩ����:-1��,0����/3���/4ɾ��/23�Ƽ�����ҳ/24�����Ŀ��Դ��
26��Ŀ:��������
run_class:��Ȩ��������:1�û�/2�û���(��ʱ�ر�)
runer:��Ȩ����:-1�ޣ�0����,����ֵΪID
CREATE TABLE authorize (
	res_class int(10) NOT NULL default '-1',
	res int(10) NOT NULL default '-1',
	action int(10) NOT NULL default '-1',
	run_class int(10) NOT NULL default '1',
	runer int(10) NOT NULL default '-1',
	key run_class(run_class),
	key runer(runer)
) TYPE=MyISAM;
*/
/*
-----------�����Դ�ۻ���(���ʹ���)-----------
type:����1����,2��Ŀ
visit_id:���»���ĿID
i_ip:�û�IP������ʽ
amonth:�·�,2007-08-00,����λ�̶�Ϊ00
CREATE TABLE visit (
  id bigint(20) unsigned NOT NULL auto_increment,
  type tinyint(3) NOT NULL default '0',
  visit_id int(10) unsigned NOT NULL default '0',
  i_ip bigint(20) unsigned NOT NULL default '0',
  amonth date NOT NULL default '0000-00-00',
  PRIMARY KEY  (id),
  KEY visit_id (visit_id),
  KEY i_ip (i_ip),
  KEY type (type),
  KEY id (id),
  KEY amonth (amonth)
) TYPE=MyISAM;

//--------2007-8-1----------
ALTER TABLE `db_mwjx`.`visit` ADD `amonth` DATE DEFAULT '0000-00-00' NOT NULL;
ALTER TABLE `db_mwjx`.`visit` ADD INDEX (`amonth`); 
*/
/*
-----------���������Ŀ��--------------
//�������ӣ�������ӣ�
type:����1����,2��Ŀ
//�ƺ�����2��Ŀ���ӵĹ����ѱ�class_tree��ȡ��,2007-7-20
master_id:����¼,���»���ĿID
link_id:���»���ĿID
CREATE TABLE link (
	`type` TINYINT(3) NOT NULL default '0',
	master_id int(10) unsigned NOT NULL default '0',
	link_id int(10) unsigned NOT NULL default '0',
	KEY master_id (master_id),
	KEY type (type)
	) TYPE=MyISAM;
*/
/*
update mwjx,��Ŀ,2006-12-22
//������Ŀ��Ϣ��
//��Ŀά���˱�
//��������������������
//dataĿ¼

*/
/*
-----------�����ؼ��ʼ�¼��--------------
keyword:�ؼ���
num:����������
CREATE TABLE keyword (
	keyword varchar(128) NOT NULL default '',	
	num int(10) unsigned NOT NULL default '0',
	PRIMARY KEY (keyword),
	KEY num (num)
	) TYPE=MyISAM;
*/
/*
//------------��Ŀ������------------
fid:����ĿID
sid:����ĿID
CREATE TABLE class_tree (
	fid mediumint(8) unsigned NOT NULL default '0',
	sid mediumint(8) unsigned NOT NULL default '0',
	key fid(fid),
	key sid(sid)
) TYPE=MyISAM;
*/
/*
//------------���ӱ�------------
title:����
url:����
CREATE TABLE res_links (
	id int(10) unsigned NOT NULL auto_increment,
	title varchar(255) NOT NULL default '',
    url text NOT NULL default '',
	PRIMARY KEY (id),
	key title(title)
) TYPE=MyISAM;
*/
/*
-----------�Ǽ�������Ŀ��--------------
type:����1����,2��Ŀ
id:����¼,���»���ĿID
num:���»���Ŀ��������1-5
aday:��¼����
CREATE TABLE top_star (
	`type` TINYINT(3) NOT NULL default '0',
	id int(10) unsigned NOT NULL default '0',
	num tinyint(1) NOT NULL default '1',
	aday date NOT NULL default '0000-00-00',
	KEY id (id),
	KEY type (type),
	KEY num (num),
	KEY aday (aday)
	) TYPE=MyISAM;
//-------��Ȩ���û���������������Ա���ͨ��-------
//�����Ҫ����,2007-6-20
CREATE TABLE top_star_auditing (
	`type` TINYINT(3) NOT NULL default '0',
	id int(10) unsigned NOT NULL default '0',
	num tinyint(1) NOT NULL default '1',
	aday date NOT NULL default '0000-00-00',
	KEY id (id),
	KEY type (type),
	KEY num (num),
	KEY aday (aday)
	) TYPE=MyISAM;
*/
/*
//------------��Ŀ�����Ƽ�,2007-6-8------------
aid:�Ƽ�����ID
cid:��ĿID,���±��Ƽ��������Ŀ
CREATE TABLE article_recommend (
	id int(10) unsigned NOT NULL auto_increment,
	cid mediumint(8) unsigned NOT NULL default '0',
	aid int(10) unsigned NOT NULL default '0',
	PRIMARY KEY (id),
	key cid(cid),
	key aid(aid)
) TYPE=MyISAM;
*/
/*
//------------������˱�,2007-6-14------------
id:���
requester:�����ˣ��û�ID
action:�������ͣ�������include/power.xml�ļ���
modify:����ʱ��
effect:�Ƿ�ͨ�����Y/N/F(ͨ��/δͨ��/δ����)
verify:������,�û�ID
content:�������ݣ���������ִ�еĳ����Ϣ
CREATE TABLE action_queue (
	id int(10) unsigned NOT NULL auto_increment,
	requester int(10) unsigned NOT NULL default '0',
	action mediumint(8) unsigned NOT NULL default '0',
	modify datetime NOT NULL default '0000-00-00 00:00:00',
	effect enum('Y','N','F') NOT NULL default 'F',
	verify int(10) unsigned NOT NULL default '0',
	content text NOT NULL default '',
	PRIMARY KEY (id),
	key requester(requester),
	key modify(modify),
	key effect(effect)
) TYPE=MyISAM;
*/
/*-----------------վ����Ϣ-----------------
id:���
sender:������
receiver:�ռ���
modify:�������ʱ��
had_read:�Ƿ��Ѷ�,Y/N(��/��)
title:����
content:����
CREATE TABLE msg (
	id int(10) unsigned NOT NULL auto_increment,
	sender int(10) unsigned NOT NULL default '0',
	receiver int(10) unsigned NOT NULL default '0',
	modify datetime NOT NULL default '0000-00-00 00:00:00',
	had_read enum('Y','N') NOT NULL default 'N',
	title varchar(255) NOT NULL default '',
	content text NOT NULL default '',
	PRIMARY KEY (id),
	key sender(sender),
	key receiver(receiver),
	key modify(modify),
	key had_read(had_read)
) TYPE=MyISAM;
*/
/*
//------------�û�������,2007-8-1------------
id:���
userid:�û�ID,��tbl_user�û����int_id
settled:�ѽ�����
unsettled:δ����Ԥ����
amonth:�·�,2007-08-00,����λ�̶�Ϊ00
modify:����ʱ��
memo:��ע
CREATE TABLE user_cash (
	id int(10) unsigned NOT NULL auto_increment,
	userid int(10) unsigned NOT NULL default '0',
	settled mediumint(8) NOT NULL default '0',
	unsettled mediumint(8) NOT NULL default '0',
	amonth date NOT NULL default '0000-00-00',
	modify datetime NOT NULL default '0000-00-00 00:00:00',
	memo text NOT NULL default '',
	PRIMARY KEY (id),
	key userid(userid),
	key settled(settled),
	key unsettled(unsettled),
	key amonth(amonth)
) TYPE=MyISAM;
*/
/*
//------------���ľ�ѡ�ʽ��,2007-8-1------------
id:���
settled:�ѽ�����
unsettled:δ����Ԥ����
amonth:�·�,2007-08-00,����λ�̶�Ϊ00
modify:����ʱ��
memo:��ע
CREATE TABLE mwjx_cash (
	id int(10) unsigned NOT NULL auto_increment,
	settled mediumint(8) NOT NULL default '0',
	unsettled mediumint(8) NOT NULL default '0',
	amonth date NOT NULL default '0000-00-00',
	modify datetime NOT NULL default '0000-00-00 00:00:00',
	memo text NOT NULL default '',
	PRIMARY KEY (id),
	key settled(settled),
	key unsettled(unsettled),
	key amonth(amonth)
) TYPE=MyISAM;
*/
/*
//------------�ʼ����ͼ�¼,2007-8-7------------
id:���
tid:��������0(����)
oid:������ID,��������ID
tomail:����������
modify:����ʱ��
CREATE TABLE mail_rc (
	id int(10) unsigned NOT NULL auto_increment,
	tid tinyint(1) NOT NULL default '0',
	oid int(10) unsigned NOT NULL default '0',
	tomail text NOT NULL default '',
	modify datetime NOT NULL default '0000-00-00 00:00:00',
	PRIMARY KEY (id),
	key oid(oid),
	key modify(modify)
) TYPE=MyISAM;
*/
/*
//------------�����ʼ��б�,2007-8-8------------
id:���
tomail:����������
t_set:��������
last:���һ�η��ͳɹ�����
active:�Ƿ񼤻�
CREATE TABLE mail_list (
  id int(10) unsigned NOT NULL auto_increment,
  tomail varchar(255) NOT NULL default '',
  t_set set('daily_up') NOT NULL default 'daily_up',
  `last` date NOT NULL default '0000-00-00',
  active enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (id),
  UNIQUE KEY tomail_3 (tomail),
  KEY tomail (tomail),
  KEY `last` (`last`),
  KEY active (active),
  KEY tomail_2 (tomail)
) TYPE=MyISAM
*/
/*
//------------��Ŀ��Ŀ��------------
id:���
title:����
cid:������ĿID
orderid:˳���
last:�����������
content:���ݣ��ԡ�\n���ָ������±��⼰����ID��Ϣ
CREATE TABLE class_dir (
  id int(10) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  cid mediumint(8) unsigned NOT NULL default '0',
  orderid tinyint(3) NOT NULL default '0',
  `last` date NOT NULL default '0000-00-00',
  content text NOT NULL  default '',
  PRIMARY KEY  (id),
  KEY cid (cid),
  KEY orderid (orderid)
) TYPE=MyISAM
*/
/*
//------------����׷�ټ�¼------------
id:���
cid:�����ĿID
url:����Դ��ַ
md5:����Դ��ַ���ݵ�hash
modify:�������ʱ��
CREATE TABLE book_unover (
  id int(10) unsigned NOT NULL auto_increment,
  cid mediumint(8) unsigned NOT NULL default '0',
  url text NOT NULL,
  md5 varchar(32) NOT NULL default '',
  modify datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id),
  UNIQUE KEY id (id),
  KEY cid (cid)
) TYPE=MyISAM;

ALTER TABLE `db_mwjx`.`book_unover` ADD `id` INT(10) UNSIGNED DEFAULT '0' NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
ALTER TABLE `db_mwjx`.`book_unover` ADD UNIQUE (`id`); 
*/

/*----------�û��ղ�-----------
uid:�û�ID
ctype:�ղ�����,1/2(����/��Ŀ)
oid:�ղ���ID
aday:�ղ�����
CREATE TABLE collections (
	id int(10) unsigned NOT NULL auto_increment,
	uid int(10) unsigned NOT NULL default '0',
	ctype tinyint(3) NOT NULL default '0',
	oid int(10) unsigned NOT NULL default '0',
	aday date NOT NULL default '0000-00-00',
	PRIMARY KEY  (id),
	KEY uid (uid)
) TYPE=MyISAM;
*/
/*----------����������-----------
id:���
name:�����ߴ���
money:�������
modify:����ʱ��
comments:�ظ�
CREATE TABLE helpmwjx (
	id int(10) unsigned NOT NULL auto_increment,
	name varchar(255) NOT NULL default '',
	money int(10) unsigned NOT NULL default '0',
	modify datetime NOT NULL default '0000-00-00 00:00:00',
	comments text NOT NULL default '',
	PRIMARY KEY  (id)
) TYPE=MyISAM;
*/

/*----------�鼮����-----------
id:���
title:����
txt:����
fid:��ĿID
num:���ش���
aday:�������
poster:�����ID
filename:�ļ���
size:��С
hz:��ʽ����׺
CREATE TABLE book_down (
	id int(10) unsigned NOT NULL auto_increment,
	title varchar(255) NOT NULL default '',
	txt text NOT NULL default '',
	fid mediumint(8) unsigned NOT NULL default '0',
	num mediumint(8) unsigned NOT NULL default '0',
	aday date NOT NULL default '0000-00-00',
	poster int(10) unsigned NOT NULL default '0',
	filename varchar(255) NOT NULL default '',
	size mediumint(8) unsigned NOT NULL default '0',
	hz varchar(32) NOT NULL default '',
	PRIMARY KEY  (id),
	KEY fid (fid)
) TYPE=MyISAM;
*/

/*-----------С˵����׷��---------
cid:С˵����ĿID
title:��Դ��ַ����
url:��Դ������ַ
flag:��Դ��վ��־,0(ȱʡ),1(����С˵)
CREATE TABLE update_track (
	id mediumint(8) unsigned NOT NULL auto_increment,
	cid mediumint(8) unsigned NOT NULL default '0',
	title varchar(255) NOT NULL default '',
	url text NOT NULL default '',
	PRIMARY KEY  (id),
	KEY cid (cid)
) TYPE=MyISAM;
ALTER TABLE `db_mwjx`.`update_track` ADD `flag` TINYINT(2) DEFAULT '0' NOT NULL; 
ALTER TABLE `fish838`.`update_track` CHANGE `flag` `flag` SMALLINT(5) DEFAULT '0' NOT NULL
ALTER TABLE `fish838`.`update_track` CHANGE `flag` `flag` SMALLINT(5) UNSIGNED DEFAULT '0' NOT NULL
*/
/*-----------С˵����׷���½ڱ�---------
tid:��ԴID(��update_track���id)��Ϊnovels_links���ID
title:�½ڱ���
url:�½ڵ�ַ
hash:��ַ��md5ֵ,ֻ�����ķ�ҳ���ã����һҳ���ݵ�hashֵ
used:�Ƿ��ù�
CREATE TABLE track_section (
	id BIGINT(10) unsigned NOT NULL auto_increment,
	tid mediumint(8) unsigned NOT NULL default '0',
	title varchar(255) NOT NULL default '',
	url text NOT NULL default '',
	hash varchar(64) NOT NULL default '',
	used enum('Y','N') NOT NULL default 'N',
	PRIMARY KEY  (id),
	KEY tid (tid)
) TYPE=MyISAM;
*/
/*-----------С˵����׷��Ԥ�����---------
track_if.php���봦��
sid:��ԴID(��update_track���id)
title:�½ڱ���
url:�½ڵ�ַ
status:״̬:D/R(Ԥ����/��ȡ)
post:post��������
CREATE TABLE track_deal (
	id mediumint(8) unsigned NOT NULL auto_increment,
	sid mediumint(8) unsigned NOT NULL default '0',
	title varchar(255) NOT NULL default '',
	url text NOT NULL default '',
	status enum('D','R') NOT NULL default 'R',
	post text NOT NULL default '',
	PRIMARY KEY  (id),
	KEY sid (sid)
) TYPE=MyISAM;
*/
/*---------�û���Ϣ��----------
CREATE TABLE tbl_user (
  int_userid int(10) unsigned NOT NULL default '0',
  str_username varchar(20) NOT NULL default '����',
  str_userpwd varchar(20) NOT NULL default '0',
  str_icon varchar(150) NOT NULL default '0',
  str_email varchar(50) NOT NULL default '0',
  str_qq varchar(20) NOT NULL default '0',
  dte_reg date NOT NULL default '0000-00-00',
  str_sign varchar(50) NOT NULL default '0',
  str_page varchar(50) NOT NULL default 'http://www.mwjx.com',
  str_area varchar(50) NOT NULL default '0',
  str_comment varchar(50) NOT NULL default '0',
  str_honor varchar(50) NOT NULL default '0',
  dtt_lastpost datetime NOT NULL default '0000-00-00 00:00:00',
  int_postamount int(10) unsigned NOT NULL default '0',
  str_pe varchar(50) NOT NULL default '0',
  str_receive varchar(50) NOT NULL default '0',
  int_money bigint(20) NOT NULL default '0',
  int_life int(10) NOT NULL default '0',
  str_food varchar(50) NOT NULL default '0',
  int_entermuch int(10) unsigned NOT NULL default '0',
  dtt_lastenter datetime NOT NULL default '0000-00-00 00:00:00',
  str_power varchar(50) NOT NULL default '0',
  str_other varchar(200) NOT NULL default '0',
  enum_active enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (int_userid),
  KEY str_username (str_username),
  KEY dte_reg (dte_reg),
  KEY dtt_lastpost (dtt_lastpost),
  KEY int_money (int_money),
  KEY int_life (int_life),
  KEY str_food (str_food),
  KEY int_entermuch (int_entermuch),
  KEY dtt_lastenter (dtt_lastenter),
  KEY str_power (str_power),
  KEY enum_active (enum_active)
) TYPE=MyISAM;

*/


//���������ʾ�����ķ���
/*
//������̨��������
1.��д����������
2.��task.php�������м��������·��������(get_tbl_task)
3.������Զ���������,��task_list.php�н����������ͼ����Զ������б�(str_auto)
4.�����ݿ�tbl_task�������һ����¼
5.������������Ҫ��
6.д�ļ��Ŀ���Ҫ�������ļ����Ըĳ�777
*/

/*
update mwjx,���а�,2007-3-28
������:keyword

update mwjx,���������,2007-3-8
��������:visit,link

update mwjx,����,2007-1-24
�½�������

update,mwjx,�Զ����������������,2007-4-17
//visit�����id�ֶ�
//����һ�������¼
///mwjx/src_php/
//task_list.php
//task.php




update,mwjx,��ҳ����,2007-4-26
//�����Ŀ������class_tree

update,mwjx,��ҳ�İ�,�Ƽ�����,2007-4-27
//������,res_links

update mwjx,��Ŀ��ҳ��2007-6-8
//������,article_recommend

update,mwjx,�Ƽ����£�2007-6-14
//����,action_queue

--with-gd
'./configure' '--with-mysql' '--with-apxs2=/usr/home/mwjx/tools/apache2/bin/apxs' '--with-tsrm-pthreads' '--with-curl' 

./configure --with-apxs2=/usr/home/mwjx/tools/apache2/bin/apxs --with-mysql --with-gd

./configure --with-apxs2=/usr/home/mwjx/tools/apache2/bin/apxs --with-mysql --with-gd --with-zlib-dir=/usr/local/lib --with-jpeg-dir=/usr/local/lib

-----------------
'./configure' '--prefix=/usr/home/mwjx/tools/php4' '--with-apxs2=/usr/home/mwjx/tools/apache2/bin/apxs' '--with-mysql' '--enable-sysvmsg' '--enable-sysvsem' '--enable-sysvshm' 

./configure --prefix=/usr/home/mwjx/tools/php4 --with-apxs2=/usr/home/mwjx/tools/apache2/bin/apxs --with-mysql --with-gd --with-zlib-dir=/usr/local/lib --with-jpeg-dir=/usr/local/lib



/usr/sbin/sendmail -bd -q15



*/

/*-----------------838���-------------------
create database fish838;
cid:��ĿID
click:���
title:����
last:����ʱ��
sid:��ԴID,track_section��id
CREATE TABLE article (
  id int(10) unsigned NOT NULL auto_increment,
  cid int(10) unsigned NOT NULL default '0',
  click int(10) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  last datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY cid (cid)
) TYPE=MyISAM;
ALTER TABLE `fish838`.`article` ADD `sid` BIGINT(10) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE `fish838`.`article` ADD INDEX (`sid`); 

//10������¼һ��������һ����350M���ң�(1-100)
CREATE TABLE a_data_1 (
  id int(10) unsigned NOT NULL auto_increment,
  aid int(10) unsigned NOT NULL default '0',
  txt mediumtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY aid (aid)
) TYPE=MyISAM;
//���ɱ�
for($i = 11;$i <= 50;++$i){
	$str_sql = "CREATE TABLE a_data_".$i." ( id int(10) unsigned NOT NULL auto_increment,  aid int(10) unsigned NOT NULL default '0',txt mediumtext NOT NULL,  PRIMARY KEY  (`id`),  KEY aid (aid)) TYPE=MyISAM;";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
}
*/
/*-----------������Ϣ---------
title:��������
CREATE TABLE author (
	id mediumint(8) unsigned NOT NULL auto_increment,
	title varchar(255) NOT NULL default '',
	PRIMARY KEY  (id)
) TYPE=MyISAM;
//����ֶΣ�����ĸƴ��
ALTER TABLE `fish838`.`author` ADD `firstchars` VARCHAR(8) DEFAULT 'u' NOT NULL;
*/
/*-----------��Ʒ����---------
novels:��ƷID,novels���ID
sou:��Դվ���־
val:��Դ������һ������Դվ�����ƷID,���������������֯url
CREATE TABLE novels_links (
	id mediumint(8) unsigned NOT NULL auto_increment,
	novels mediumint(8) unsigned NOT NULL default '0',
	`sou` TINYINT(3) NOT NULL default '0',
	val varchar(255) NOT NULL default '',
	PRIMARY KEY  (id),
	key novels(novels)
) TYPE=MyISAM;
*/

/*-----------С˵��Ϣ---------
cid:��ĿID
title:����
author:����
status:С˵��վ״̬,Y/N(���/������)
included:�Ƿ���¼Y/N(��¼/δ��¼)
over:С˵״̬��'O','S','I'(���over/ֹͣ����stop/������ing)
CREATE TABLE novels (
  id mediumint(8) unsigned NOT NULL auto_increment,
  cid mediumint(8) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  author mediumint(8) unsigned NOT NULL default '0',
  status enum('Y','N') NOT NULL default 'N',
  included enum('Y','N') NOT NULL default 'N',
  over enum('O','S','I') NOT NULL default 'I',
  PRIMARY KEY  (id),
  KEY cid (cid)
) TYPE=MyISAM;

ALTER TABLE `db_mwjx`.`novels` ADD `over` ENUM('O','S','I') DEFAULT 'I' NOT NULL;
//����ֶΣ�����ĸƴ��
ALTER TABLE `fish838`.`novels` ADD `firstchars` VARCHAR(8) DEFAULT 'u' NOT NULL;
*/
/*-----------�½ڹ��˹���---------
site:��Դվ���־
t:����1.�½�URL�ҵ�����,2.�½�URL�Ҳ�������,
7.[�½�]�����д�������,8.[�½�]�����в���������
9.[�½�]���ⳤ��С������,10.[�½�]���ⳤ�ȴ�������
11.[�½�]�������,12.[�½�]���ݹ���,13.[�½�]���߹���
14.[�½�]����:utf8,gb2312
15.[�½�]������ַ����:ǰ��`|��

21.[����]�б���ʼҳ
22.[����]�б�򿪷�ʽget/post,Ĭ��get����д
23.[����]URL�ҵ�����
24.[����]URL�Ҳ�������
25.[����]�����ҵ�����
26.[����]�����Ҳ�������
27.[����]��ȡ����Դ�б�
28.[����]��ȡ����Դ��¼
29.[����]ȥ��URL�еĲ���(��ʽ:s,e)
41.[����]�б���ʼҳ
42.[����]�б�򿪷�ʽget/post,Ĭ��get����д
43.[����]URL�ҵ�����
44.[����]URL�Ҳ�������
45.[����]�����ҵ�����
46.[����]�����Ҳ�������
47.[����]��ȡ����Դ�б�
48.[����]��ȡ����Դ��¼
49.[����]ȥ��URL�еĲ���
val:����
CREATE TABLE track_pass (
  id mediumint(8) unsigned NOT NULL auto_increment,
  site mediumint(8) unsigned NOT NULL default '0',
  `t` TINYINT(3) NOT NULL default '0',
  val varchar(255) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY cid (site)
) TYPE=MyISAM;

*/
/*-----------��Դվ��---------
id:���
title:����
flag:ʶ���ʶ,�����ʶ��|�ŷָ�
CREATE TABLE track_sou (
  id mediumint(8) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  flag varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

*/
/*-----------������鼮---------
id:���
title:��Ʒ��
t:���
able:�ܷ����,Y/N(��/����)
author:����
flag:ʶ���ʶ,�����ʶ��|�ŷָ�
CREATE TABLE track_preparatory (
  id mediumint(8) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  t varchar(128) NOT NULL default '',
  `able` enum('Y','N') NOT NULL default 'Y',
  author varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

*/

/*-----------������Դ-----------
list.exe 32 http://vip.book.sina.com.cn/book_rank.php?dpc=1
*/

/*-----------������Դ�б�---------
search_source.php���봦��
id:���
site:��Դվ��(��track_sou���id)
url:��ַ
post:post��������
t:����1/2(�����/�������)
CREATE TABLE search_source (
	id mediumint(8) unsigned NOT NULL auto_increment,
	site mediumint(8) unsigned NOT NULL default '0',
	url text NOT NULL default '',
	post text NOT NULL default '',
	t TINYINT(3) unsigned NOT NULL default '0',
	PRIMARY KEY  (id)
) TYPE=MyISAM;
*/
/*
classid:����,3С˵ͶƱ
CREATE TABLE tbl_voterc (
  id bigint(20) unsigned NOT NULL auto_increment,
  from_id int(10) unsigned NOT NULL default '0',
  to_id int(10) unsigned NOT NULL default '0',
  i_ip bigint(20) unsigned NOT NULL default '0',
  aday date NOT NULL default '0000-00-00',
  classid int(10) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY from_id (from_id),
  KEY to_id (to_id),
  KEY i_ip (i_ip),
  KEY aday (aday),
  KEY classid (classid)
) TYPE=MyISAM;
*/
/*---------------�Զ����----------
id:���
cid:�����ĿID,һ����Ŀֻ����һ����Դ
sid:��ԴID,novels_links��ID
CREATE TABLE auto_add (
  id int(10) unsigned NOT NULL auto_increment,
  cid mediumint(8) unsigned NOT NULL default '0',
  sid mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

*/
/*--------------�����������±�-------------
lid:��������ID,��novels_links���id
last:�������ʱ��
title:��������½ڱ��� 
url:��������½�URL
CREATE TABLE novels_last (
	lid mediumint(8) unsigned NOT NULL,
	last datetime NOT NULL default '0000-00-00 00:00:00',
	title varchar(255) NOT NULL default '',
	url varchar(255) NOT NULL default '',
	PRIMARY KEY  (lid),
	key last(last)
) TYPE=MyISAM;
*/
/*-----------��������������---------
�������,2008-6-19
id:���
lid:��������ID,��novels_links���id
url:�½ڵ�ַ,md5ֵ
CREATE TABLE novels_index (
	id BIGINT(10) unsigned NOT NULL auto_increment,
	lid mediumint(8) unsigned NOT NULL default '0',
	url varchar(32) NOT NULL default '',
	PRIMARY KEY  (id),
	KEY lid (lid)
) TYPE=MyISAM;
*/
/*-----------��������������v2---------
lid:��������ID,��novels_links���id
url:�½ڵ�ַ�б�,md5ֵ,�ö��ŷָ�
CREATE TABLE novels_indexv2 (
	lid mediumint(8) unsigned NOT NULL,
	ls_url text NOT NULL default '',
	PRIMARY KEY  (lid)
) TYPE=MyISAM;
*/

/*--------------��̬�ļ�����-------------
oid:Ҫ���µ���Ŀ������ID
t:����C��Ŀ/A����
action:����Y����/Nɾ��/H����������ĿtΪCʱ��Ч
CREATE TABLE static_update (
  oid int(10) unsigned NOT NULL default '0',
  `t` enum('C','A') NOT NULL default 'A',
  `action` enum('Y','N','H') NOT NULL default 'Y'
) TYPE=MyISAM;
*/
/*-----------��Ŀ�ؼ��ʱ�---------
id:���
cid:��ĿID
kw:�ؼ���
CREATE TABLE class_kw (
	id mediumint(8) unsigned NOT NULL auto_increment,
	cid mediumint(8) unsigned NOT NULL default '0',
	kw varchar(128) NOT NULL default '',
	PRIMARY KEY  (id)
) TYPE=MyISAM;
*/

/*-----------ȫ������---------
id:���
name:������:book_lists/����б�����ҳ��,
classhome/��Ŀҳ����ID
author_lists/�����б�����ҳ��
authorpage/��������ID
out_lists/վ����Ʒ����ҳ��
fchar_author/��������ĸ��������ID
fchar_novels/��Ʒ����ĸ��������ID
chars_author/������ĸ�����б���������ID
chars_novels/��Ʒ��ĸ�����б�������ƷID
run_tasklist/�Ƿ����������������:Y/N
sitebook_n/nΪС˵վ�����,�����С˵Դ��վ��ʱ��
last_artid/��������ID,article��id
last_sid/������վ����ID,track_section��id
val:����ֵ
CREATE TABLE global_conf (
	id mediumint(8) unsigned NOT NULL auto_increment,
	name varchar(32) NOT NULL default '',
	val text NOT NULL default '',
	PRIMARY KEY  (id)
) TYPE=MyISAM;
*/
/*-----------������Ʒ---------
title:������Ʒ��
CREATE TABLE novels_dis (
  id mediumint(8) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
*/

?>