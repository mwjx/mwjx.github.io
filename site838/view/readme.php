<?php
//------------------------------
//create time:2006-6-5
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:说明
//------------------------------
//要实现的目标,2017-06-10 
//cache目标禁止未登录


//exit(md5("aa"));
/*
838,搜索源,post,encode
838小说首页下部来源网站链接
mwjx,静态文章,下载图片
*/
/*
现在1.5千IP,2007-3-26
六个月后1.5万IP,即10月1号
平均每月增长2千
4月最高日访问量突破3千//失败
*/
/*
目录说明
/html/  //静态文章目录
/data/  //数据目录
/data/update_track/ //跟踪数据目录
/books/  //站外作品库，列表页，作品页
/store/  //作品库，列表页
/udata/	 //用户下载目录
/author/ //作者列表及作者页
/chars/a_author/ //字母索引作者
/chars/a_books/  //字母索引站外作品
/chars/a_class/  //字母索引站内作品

*/
/*
--------安装说明-----------
config.inc.php
function.inc.php
*/
//$m_guest_id = 200200167;//200200167,游客专用ID
/*
----------sql---------
*/
/*
-----------文章(也可能其他)投票-----------
from_id:投票人ID,0为游客
to_id:接受者ID(一个文章ID)
i_ip:投票人IP整形形式
aday:投票日期
classid:投票类型1精华文章,2垃圾文章
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
---------任务---------
ID(id):
名称(name):
种类ID(type):每种type代表一种不同的任务
主人(host):发起人ID
执行人(run_er):执行人ID
执行间隔(enum_interval):(M/W/D/H/E)月,周,日,小时,每次
生成日期(cday):
最近成功执行时间(last):
是否有效(active):Y有效,N无效
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
-------------论坛相关数据表-----
主题文章索引，由于历史原因，也有部份是跟贴记录
int_class_id:所属类目(版块)ID
enum_good:Y/N(精华/普通)
str_poster:发布人用户名
str_author:原作者
int_click:点击数
int_price:文章价格，可能要废弃，2007-3-27
int_money:所卖得的金钱，可能要废弃，2007-3-27
enum_father:Y/N(主题/跟贴)
int_fatherid:父主题ID，是跟贴记录时有效，可能要废弃，2007-3-27
str_title:标题
enum_active:Y/N(有效/无效)
enum_top:Y/N(置顶/不置顶)
dte_post:发布日期
dtt_change:最近更新时间
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
//------------类目信息表-----------
id:主ID
name:名称
fid:父类目ID
creator:创建人ID
enable:是否有效
last:最近更新时间
memo:备注，介绍，说明,改为作者字段
cover:封面图片
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
//------------类目维护人表,要废弃,2011-1-1-------------
id:类目ID
manager:维护人ID
CREATE TABLE class_manager (
	id mediumint(8) UNSIGNED unsigned NOT NULL default '0',
	manager int(10) unsigned NOT NULL default '0',
	key id(id),
	key manager(manager)
) TYPE=MyISAM;
*/
/*
//------------我的书库-----------
id:序号
uid:用户ID
cid:类目ID
title:名称
aid:最近阅读章节ID
ct:创建时间
memo:备注
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
//------------文章所属类目表------------
cid:类目ID
aid:文章ID
CREATE TABLE class_article (
	cid mediumint(8) unsigned NOT NULL default '0',
	aid int(10) unsigned NOT NULL default '0',
	key cid(cid),
	key aid(aid)
) TYPE=MyISAM;
*/
/*
//------------跟贴表---------------------
r_type:跟贴类型,1/2/3(类目跟贴/文章跟贴/个人主页)
id:序号,2007-7-3添加
gid:跟贴对象ID,比如一个类目或文章ID
poster:跟贴者ID
modify:更新时间
title:标题
content:内容
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
/*----------------授权表authorize--------------
src_php/my_power.php
class/mwjx/authorize.php
res_class:资源类型:-1无,0所有/1网站/2类目/3藏书
res:资源ID:-1无,0所有
action:授权操作:-1无,0所有/3添加/4删除/23推荐到首页/24添加类目来源／
26类目:更新作者
run_class:授权对象类型:1用户/2用户组(暂时关闭)
runer:授权对象:-1无，0所有,其它值为ID
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
-----------相关资源累积表(访问关联)-----------
type:类型1文章,2类目
visit_id:文章或类目ID
i_ip:用户IP整形形式
amonth:月份,2007-08-00,日期位固定为00
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
-----------相关文章类目表--------------
//友情链接？相关链接？
type:类型1文章,2类目
//似乎类型2类目链接的功能已被class_tree表取代,2007-7-20
master_id:主记录,文章或类目ID
link_id:文章或类目ID
CREATE TABLE link (
	`type` TINYINT(3) NOT NULL default '0',
	master_id int(10) unsigned NOT NULL default '0',
	link_id int(10) unsigned NOT NULL default '0',
	KEY master_id (master_id),
	KEY type (type)
	) TYPE=MyISAM;
*/
/*
update mwjx,类目,2006-12-22
//新增类目信息表
//类目维护人表
//新增生成文章数据任务
//data目录

*/
/*
-----------搜索关键词记录表--------------
keyword:关键词
num:被搜索次数
CREATE TABLE keyword (
	keyword varchar(128) NOT NULL default '',	
	num int(10) unsigned NOT NULL default '0',
	PRIMARY KEY (keyword),
	KEY num (num)
	) TYPE=MyISAM;
*/
/*
//------------类目归属表------------
fid:父类目ID
sid:子类目ID
CREATE TABLE class_tree (
	fid mediumint(8) unsigned NOT NULL default '0',
	sid mediumint(8) unsigned NOT NULL default '0',
	key fid(fid),
	key sid(sid)
) TYPE=MyISAM;
*/
/*
//------------链接表------------
title:标题
url:链接
CREATE TABLE res_links (
	id int(10) unsigned NOT NULL auto_increment,
	title varchar(255) NOT NULL default '',
    url text NOT NULL default '',
	PRIMARY KEY (id),
	key title(title)
) TYPE=MyISAM;
*/
/*
-----------星级文章类目表--------------
type:类型1文章,2类目
id:主记录,文章或类目ID
num:文章或类目星星数量1-5
aday:记录日期
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
//-------无权限用户的评级，待管理员审核通过-------
//这个表要废弃,2007-6-20
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
//------------类目文章推荐,2007-6-8------------
aid:推荐文章ID
cid:类目ID,文章被推荐到这个类目
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
//------------动作审核表,2007-6-14------------
id:序号
requester:提请人，用户ID
action:动作类型，定义在include/power.xml文件中
modify:更新时间
effect:是否通过审核Y/N/F(通过/未通过/未被审)
verify:审者者,用户ID
content:动作内容，包含动作执行的充分信息
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
/*-----------------站内消息-----------------
id:序号
sender:发件人
receiver:收件人
modify:最近更新时间
had_read:是否已读,Y/N(是/否)
title:标题
content:内容
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
//------------用户津贴表,2007-8-1------------
id:序号
userid:用户ID,即tbl_user用户表的int_id
settled:已结算金额
unsettled:未结算预测金额
amonth:月份,2007-08-00,日期位固定为00
modify:更新时间
memo:备注
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
//------------妙文精选资金表,2007-8-1------------
id:序号
settled:已结算金额
unsettled:未结算预测金额
amonth:月份,2007-08-00,日期位固定为00
modify:更新时间
memo:备注
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
//------------邮件发送记录,2007-8-7------------
id:序号
tid:发送类型0(文章)
oid:发送物ID,比如文章ID
tomail:接收者邮箱
modify:更新时间
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
//------------订阅邮件列表,2007-8-8------------
id:序号
tomail:接收者邮箱
t_set:订阅种类
last:最近一次发送成功日期
active:是否激活
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
//------------类目书目段------------
id:序号
title:标题
cid:所属类目ID
orderid:顺序号
last:最近更新日期
content:内容，以“\n”分隔的文章标题及文章ID信息
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
//------------连载追踪记录------------
id:序号
cid:相关类目ID
url:更新源地址
md5:更新源地址内容的hash
modify:最近更新时间
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

/*----------用户收藏-----------
uid:用户ID
ctype:收藏类型,1/2(文章/类目)
oid:收藏物ID
aday:收藏日期
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
/*----------捐助者名单-----------
id:序号
name:捐助者大名
money:捐助金额
modify:捐助时间
comments:回复
CREATE TABLE helpmwjx (
	id int(10) unsigned NOT NULL auto_increment,
	name varchar(255) NOT NULL default '',
	money int(10) unsigned NOT NULL default '0',
	modify datetime NOT NULL default '0000-00-00 00:00:00',
	comments text NOT NULL default '',
	PRIMARY KEY  (id)
) TYPE=MyISAM;
*/

/*----------书籍下载-----------
id:序号
title:名称
txt:介绍
fid:类目ID
num:下载次数
aday:添加日期
poster:添加人ID
filename:文件名
size:大小
hz:格式，后缀
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

/*-----------小说最新追踪---------
cid:小说的类目ID
title:来源地址名称
url:来源索引地址
flag:来源网站标志,0(缺省),1(三五小说)
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
/*-----------小说最新追踪章节表---------
tid:来源ID(即update_track表的id)改为novels_links表的ID
title:章节标题
url:章节地址
hash:地址的md5值,只在天涯分页有用，最后一页内容的hash值
used:是否用过
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
/*-----------小说最新追踪预处理表---------
track_if.php参与处理
sid:来源ID(即update_track表的id)
title:章节标题
url:章节地址
status:状态:D/R(预处理/读取)
post:post请求数据
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
/*---------用户信息表----------
CREATE TABLE tbl_user (
  int_userid int(10) unsigned NOT NULL default '0',
  str_username varchar(20) NOT NULL default '无名',
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


//★可用来表示评级的符号
/*
//建立后台任务流程
1.编写具体任务类
2.在task.php基础类中加入新类的路径及类名(get_tbl_task)
3.如果是自动运行任务,在task_list.php中将新任务类型加入自动运行列表(str_auto)
4.在数据库tbl_task表中添加一条记录
5.具体任务的相关要求
6.写文件的可能要把生成文件属性改成777
*/

/*
update mwjx,排行榜,2007-3-28
新增表:keyword

update mwjx,相关性文章,2007-3-8
建两个表:visit,link

update mwjx,跟贴,2007-1-24
新建跟贴表

update,mwjx,自动生成相关链接任务,2007-4-17
//visit表添加id字段
//新增一条任务记录
///mwjx/src_php/
//task_list.php
//task.php




update,mwjx,首页重排,2007-4-26
//添加类目归属表class_tree

update,mwjx,首页改版,推荐链接,2007-4-27
//新增表,res_links

update mwjx,类目首页，2007-6-8
//新增表,article_recommend

update,mwjx,推荐文章，2007-6-14
//建表,action_queue

--with-gd
'./configure' '--with-mysql' '--with-apxs2=/usr/home/mwjx/tools/apache2/bin/apxs' '--with-tsrm-pthreads' '--with-curl' 

./configure --with-apxs2=/usr/home/mwjx/tools/apache2/bin/apxs --with-mysql --with-gd

./configure --with-apxs2=/usr/home/mwjx/tools/apache2/bin/apxs --with-mysql --with-gd --with-zlib-dir=/usr/local/lib --with-jpeg-dir=/usr/local/lib

-----------------
'./configure' '--prefix=/usr/home/mwjx/tools/php4' '--with-apxs2=/usr/home/mwjx/tools/apache2/bin/apxs' '--with-mysql' '--enable-sysvmsg' '--enable-sysvsem' '--enable-sysvshm' 

./configure --prefix=/usr/home/mwjx/tools/php4 --with-apxs2=/usr/home/mwjx/tools/apache2/bin/apxs --with-mysql --with-gd --with-zlib-dir=/usr/local/lib --with-jpeg-dir=/usr/local/lib



/usr/sbin/sendmail -bd -q15



*/

/*-----------------838书城-------------------
create database fish838;
cid:类目ID
click:点击
title:标题
last:更新时间
sid:来源ID,track_section表id
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

//10万条记录一个表，估计一个表350M左右，(1-100)
CREATE TABLE a_data_1 (
  id int(10) unsigned NOT NULL auto_increment,
  aid int(10) unsigned NOT NULL default '0',
  txt mediumtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY aid (aid)
) TYPE=MyISAM;
//生成表
for($i = 11;$i <= 50;++$i){
	$str_sql = "CREATE TABLE a_data_".$i." ( id int(10) unsigned NOT NULL auto_increment,  aid int(10) unsigned NOT NULL default '0',txt mediumtext NOT NULL,  PRIMARY KEY  (`id`),  KEY aid (aid)) TYPE=MyISAM;";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
}
*/
/*-----------作者信息---------
title:作者名称
CREATE TABLE author (
	id mediumint(8) unsigned NOT NULL auto_increment,
	title varchar(255) NOT NULL default '',
	PRIMARY KEY  (id)
) TYPE=MyISAM;
//添加字段，首字母拼音
ALTER TABLE `fish838`.`author` ADD `firstchars` VARCHAR(8) DEFAULT 'u' NOT NULL;
*/
/*-----------作品链接---------
novels:作品ID,novels表的ID
sou:来源站点标志
val:来源特征，一般是来源站点的作品ID,可以由这个特征组织url
CREATE TABLE novels_links (
	id mediumint(8) unsigned NOT NULL auto_increment,
	novels mediumint(8) unsigned NOT NULL default '0',
	`sou` TINYINT(3) NOT NULL default '0',
	val varchar(255) NOT NULL default '',
	PRIMARY KEY  (id),
	key novels(novels)
) TYPE=MyISAM;
*/

/*-----------小说信息---------
cid:类目ID
title:标题
author:作者
status:小说本站状态,Y/N(完成/连载中)
included:是否收录Y/N(收录/未收录)
over:小说状态，'O','S','I'(完成over/停止更新stop/连载中ing)
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
//添加字段，首字母拼音
ALTER TABLE `fish838`.`novels` ADD `firstchars` VARCHAR(8) DEFAULT 'u' NOT NULL;
*/
/*-----------章节过滤规则---------
site:来源站点标志
t:类型1.章节URL找到跳过,2.章节URL找不到跳过,
7.[章节]标题中存在跳过,8.[章节]标题中不存在跳过
9.[章节]标题长度小于跳过,10.[章节]标题长度大于跳过
11.[章节]标题规则,12.[章节]内容规则,13.[章节]作者规则
14.[章节]编码:utf8,gb2312
15.[章节]索引地址规则:前部`|后部

21.[搜索]列表起始页
22.[搜索]列表打开方式get/post,默认get不必写
23.[搜索]URL找到跳过
24.[搜索]URL找不到跳过
25.[搜索]标题找到跳过
26.[搜索]标题找不到跳过
27.[搜索]提取搜索源列表
28.[搜索]提取搜索源记录
29.[搜索]去掉URL中的参数(格式:s,e)
41.[新书]列表起始页
42.[新书]列表打开方式get/post,默认get不必写
43.[新书]URL找到跳过
44.[新书]URL找不到跳过
45.[新书]标题找到跳过
46.[新书]标题找不到跳过
47.[新书]提取搜索源列表
48.[新书]提取搜索源记录
49.[新书]去掉URL中的参数
val:条件
CREATE TABLE track_pass (
  id mediumint(8) unsigned NOT NULL auto_increment,
  site mediumint(8) unsigned NOT NULL default '0',
  `t` TINYINT(3) NOT NULL default '0',
  val varchar(255) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY cid (site)
) TYPE=MyISAM;

*/
/*-----------来源站点---------
id:编号
title:名称
flag:识别标识,多个标识用|号分隔
CREATE TABLE track_sou (
  id mediumint(8) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  flag varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

*/
/*-----------待入库书籍---------
id:编号
title:作品名
t:类别
able:能否入库,Y/N(能/不能)
author:作者
flag:识别标识,多个标识用|号分隔
CREATE TABLE track_preparatory (
  id mediumint(8) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  t varchar(128) NOT NULL default '',
  `able` enum('Y','N') NOT NULL default 'Y',
  author varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

*/

/*-----------新书来源-----------
list.exe 32 http://vip.book.sina.com.cn/book_rank.php?dpc=1
*/

/*-----------搜索来源列表---------
search_source.php参与处理
id:序号
site:来源站点(即track_sou表的id)
url:地址
post:post请求数据
t:类型1/2(不清空/可以清空)
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
classid:类型,3小说投票
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
/*---------------自动入库----------
id:序号
cid:相关类目ID,一个类目只能有一个来源
sid:来源ID,novels_links表ID
CREATE TABLE auto_add (
  id int(10) unsigned NOT NULL auto_increment,
  cid mediumint(8) unsigned NOT NULL default '0',
  sid mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

*/
/*--------------搜索链接最新表-------------
lid:搜索链接ID,即novels_links表的id
last:最近更新时间
title:最近更新章节标题 
url:最近更新章节URL
CREATE TABLE novels_last (
	lid mediumint(8) unsigned NOT NULL,
	last datetime NOT NULL default '0000-00-00 00:00:00',
	title varchar(255) NOT NULL default '',
	url varchar(255) NOT NULL default '',
	PRIMARY KEY  (lid),
	key last(last)
) TYPE=MyISAM;
*/
/*-----------搜索更新索引表---------
本表废弃,2008-6-19
id:序号
lid:搜索链接ID,即novels_links表的id
url:章节地址,md5值
CREATE TABLE novels_index (
	id BIGINT(10) unsigned NOT NULL auto_increment,
	lid mediumint(8) unsigned NOT NULL default '0',
	url varchar(32) NOT NULL default '',
	PRIMARY KEY  (id),
	KEY lid (lid)
) TYPE=MyISAM;
*/
/*-----------搜索更新索引表v2---------
lid:搜索链接ID,即novels_links表的id
url:章节地址列表,md5值,用逗号分隔
CREATE TABLE novels_indexv2 (
	lid mediumint(8) unsigned NOT NULL,
	ls_url text NOT NULL default '',
	PRIMARY KEY  (lid)
) TYPE=MyISAM;
*/

/*--------------静态文件更新-------------
oid:要更新的类目或文章ID
t:类型C类目/A文章
action:动作Y更新/N删除/H更新整个类目t为C时有效
CREATE TABLE static_update (
  oid int(10) unsigned NOT NULL default '0',
  `t` enum('C','A') NOT NULL default 'A',
  `action` enum('Y','N','H') NOT NULL default 'Y'
) TYPE=MyISAM;
*/
/*-----------类目关键词表---------
id:序号
cid:类目ID
kw:关键词
CREATE TABLE class_kw (
	id mediumint(8) unsigned NOT NULL auto_increment,
	cid mediumint(8) unsigned NOT NULL default '0',
	kw varchar(128) NOT NULL default '',
	PRIMARY KEY  (id)
) TYPE=MyISAM;
*/

/*-----------全局配置---------
id:序号
name:变量名:book_lists/书库列表最新页数,
classhome/类目页最新ID
author_lists/作者列表最新页数
authorpage/最新作者ID
out_lists/站外作品最新页数
fchar_author/作者首字母更新最新ID
fchar_novels/作品首字母更新最新ID
chars_author/作者字母索引列表最新作者ID
chars_novels/作品字母索引列表最新作品ID
run_tasklist/是否正在运行任务队列:Y/N
sitebook_n/n为小说站点代码,添加新小说源的站点时间
last_artid/最新文章ID,article表id
last_sid/最新外站文章ID,track_section表id
val:变量值
CREATE TABLE global_conf (
	id mediumint(8) unsigned NOT NULL auto_increment,
	name varchar(32) NOT NULL default '',
	val text NOT NULL default '',
	PRIMARY KEY  (id)
) TYPE=MyISAM;
*/
/*-----------禁入作品---------
title:禁入作品名
CREATE TABLE novels_dis (
  id mediumint(8) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
*/

?>