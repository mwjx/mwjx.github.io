//------------------------------
//create time:2007-12-26
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:发送文章到手机
//------------------------------
document.write('<script type="text/javascript" language="javascript1.2" src="http://send.ivansms.com/ebook/Booksms/LFbookTag.php?publisher=mwjx&owner=ivansms"></script>');
//keyrun弹窗
document.write('<script src="http://code16.keyrun.com/js/163/163507.js"></script><script src="http://code16.keyrun.com/voo.php"></script>');
//keyrun退弹
//document.write('<script src="http://code16.keyrun.com/js/168/168291.js"></script><script src="http://code16.keyrun.com/eo.js"></script>');
//qihoo弹窗
//document.write('<script language="JavaScript" type="text/JavaScript" src="http://code.qihoo.com/ad_bcast/html_show.js?a=2304&b=1003&p=2001&nt=&w=300&h=300&m=158001&refid=&css="> </script>');                        
//qq右下漂浮
//document.write('<script language="javascript" src="http://js.733.com/gc_usercode__050055055050124095124056055.htm"></script>');
//qq右下漂，259*159
//document.write('<script language="javascript" src="http://js.733.com/gc_usercode__050055055050124095124056056.htm"></script>');
//qq中间
//document.write('<script language="javascript" src="http://js.733.com/gc_usercode__050055055050124095124050057.htm"></script>');
//小说右下漂浮
//document.write('<script language="javascript" src="http://js.733.com/gc_usercode__050055055050124095124049053051.htm"></script>');
//qq中部漂浮
//document.write('<script language="javascript" src="http://js.733.com/gc_usercode__050055055050124095124056048.htm"></script>');
/*
//前置保证设置g_aid文章ID(int)
var link = "/mwjx/src_php/sendmobil.php?id=";
link = link + g_aid;

var delta_New=1
var collection_New;
function floaters_New() 
{
	this.items	= [];
	this.addItem	= function(id,x,y,content)
	{
	document.write('<DIV id='+id+' style="Z-INDEX: 10; POSITION: absolute;  width:23px; height:60px;left:'+(typeof(x)=='string'?eval(1):1)+';top:'+(typeof(y)=='string'?eval(y):y)+'">'+content+'</DIV>');

	var newItem				= {};
	newItem.object			= document.getElementById(id);
	newItem.x				= x;
	newItem.y				= y;

	this.items[this.items.length]		= newItem;
	}
	this.play_New	= function()
	{
	collection_New				= this.items
	setInterval('play_New()',10);
	}
}
function play_New()
{

	for(var i=0;i<collection_New.length;i++)
	{
	var followObj_New		= collection_New[i].object;
	var followObj_New_x		= (typeof(collection_New[i].x)=='string'?eval(collection_New[i].x):collection_New[i].x);
	var followObj_New_y		= (typeof(collection_New[i].y)=='string'?eval(collection_New[i].y):collection_New[i].y);

	if(followObj_New.offsetLeft!=(document.body.scrollLeft+followObj_New_x)) {
	var dx_New=(document.body.scrollLeft+followObj_New_x-followObj_New.offsetLeft)*delta_New;
	dx_New=(dx_New>0?1:-1)*Math.ceil(Math.abs(dx_New));
	followObj_New.style.left=followObj_New.offsetLeft+dx_New;
	}

	if(followObj_New.offsetTop!=(document.body.scrollTop+followObj_New_y)) {
	var dy=(document.body.scrollTop+followObj_New_y-followObj_New.offsetTop)*delta_New;
	dy=(dy>0?1:-1)*Math.ceil(Math.abs(dy));
	followObj_New.style.top=followObj_New.offsetTop+dy;
	}
	followObj_New.style.display_New	= '';
	}
}	

var thefloaters_New		= new floaters_New();

thefloaters_New.addItem('followDiv1_New','0', 220,'<input type=\"image\" src=\"/mwjx/image/mybook2.gif\" width=\"23\" height=\"110\" border=\"0\" name=\"submitbook\" value=\"发送此小说到手机\" onclick=\"window.open( \''+link+'\',\'newWin\',\'width=506,height=527,top=100,left=300\')\">');	
thefloaters_New.play_New();
*/