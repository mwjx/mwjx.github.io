//------------------------------
//create time:2007-12-25
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�ƶ�ͼƬ
//------------------------------
var m_index = 4; //������ͼƬ
function pics_move(direct)
{
	//�ƶ�������
	//����:direct(int)����-1/1(��/��)
	//���:��
	//return alert(direct);
	var index = m_index;
	//����
	if(1 == direct) //����
		index = m_index;
	else
		index = m_index-4;	
	//return;
	document.all["pic_li_"+index].style.display = "none";
	//return;
	//��ʾ
	if(1 == direct) //����
		index = m_index-5;
	else
		index = m_index+1;	
	document.all["pic_li_"+index].style.display = "block";
	//λ��
	m_index -= direct; 
	//return;
	//��ť
	if(-1 == direct) //���ƣ��ұ߿϶���ʾ
		document.all["p_right"].style.display = "block";
	if(1 == direct) //���ƣ���߿϶���ʾ
		document.all["p_left"].style.display = "block";
	if(m_index <= 4) //�ҵ�����
		document.all["p_right"].style.display = "none";
	if("undefined" == typeof(document.all["pic_li_"+(m_index+1)]))
		document.all["p_left"].style.display = "none"; //�󵽼���
	//alert(m_index);
	//index = m_index-direct;
	//alert("�ƶ�������");
	//var obj = document.all["div_movie_pics"];
	//document.all["li_1"].style.display = "none";
	//obj.style.left = 155;
	//alert(obj.style.left);
}