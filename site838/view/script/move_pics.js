//------------------------------
//create time:2007-12-25
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:移动图片
//------------------------------
var m_index = 4; //第五张图片
function pics_move(direct)
{
	//移动剧照栏
	//输入:direct(int)方向-1/1(左/右)
	//输出:无
	//return alert(direct);
	var index = m_index;
	//隐藏
	if(1 == direct) //右移
		index = m_index;
	else
		index = m_index-4;	
	//return;
	document.all["pic_li_"+index].style.display = "none";
	//return;
	//显示
	if(1 == direct) //右移
		index = m_index-5;
	else
		index = m_index+1;	
	document.all["pic_li_"+index].style.display = "block";
	//位置
	m_index -= direct; 
	//return;
	//按钮
	if(-1 == direct) //左移，右边肯定显示
		document.all["p_right"].style.display = "block";
	if(1 == direct) //右移，左边肯定显示
		document.all["p_left"].style.display = "block";
	if(m_index <= 4) //右到极致
		document.all["p_right"].style.display = "none";
	if("undefined" == typeof(document.all["pic_li_"+(m_index+1)]))
		document.all["p_left"].style.display = "none"; //左到极致
	//alert(m_index);
	//index = m_index-direct;
	//alert("移动剧照栏");
	//var obj = document.all["div_movie_pics"];
	//document.all["li_1"].style.display = "none";
	//obj.style.left = 155;
	//alert(obj.style.left);
}