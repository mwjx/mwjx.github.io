


function getstrlen(mystr)
{
	var thelen=0;
	mystr = mystr.toLowerCase(mystr);
	for (i=0;i<mystr.length;i++)
	{
		if (((mystr.charCodeAt(i)>31)&&(mystr.charCodeAt(i)<65))||((mystr.charCodeAt(i)>90)&&(mystr.charCodeAt(i)<127)))
		{
			thelen++;
		}else{
			thelen++;
			thelen++;
		}
	}
	return thelen;
}

function check_valid(v_str)
{  
   if( v_str.charAt(0) == '1')
   { 
      if(v_str.charAt(1) == '3' || v_str.charAt(1) == '5')
	  { 
	     return true;
	  }

   }
   return false;
}

function check_company(v_str)
{  
   if( v_str.charAt(2) >= '4')
   { 
      return true;
   }
   return false;
}
function is_number(v_str)
{
	for(i=0;i<v_str.length;i++)
	{
		if((v_str.charCodeAt(i)<48)||(v_str.charCodeAt(i)>57))
		{
			return true;
		}
	}
	if(v_str==0)
	{
		return true;
	}
	return false;
}

function signvalid(s,s1)
{
    var resign = "[" + s1 + "]";
    var re = new RegExp(resign);
    if (s.search(re) !== -1) {
          return true;
    } else {
          return false;
    }
}


function CheckForm(theform)
{
	
		if(theform.phonenum.value == "")
	{
		alert("�������ֻ����룡");
		return false;
	}
		
	if(is_number(theform.phonenum.value))
	{
		alert('�ֻ�����ӦΪ��Ч���֣�');
		
		theform.phonenum.focus();
		return false;
	}
	var length
	length = getstrlen(theform.phonenum.value);
	if(length > 11)  
	{
		alert('��������ֻ��������󣨳��ȳ�������');
		theform.phonenum.focus();
		return false;
	}
	else if (length < 11)
	{
		alert('��������ֻ��������󣨳��Ȳ�������');
		theform.phonenum.focus();
		return false;
	}
	else if(!check_valid(theform.phonenum.value))
	{
	   	alert('��������ֻ���������ͷ��λ����Ϊ"13"��"15"����');
		
		theform.phonenum.focus();
		return false;
	}
//	else if(!check_company(theform.phonenum.value))
//	{
//	   	alert('��������ֻ�����������ʱֻ֧���ƶ��û�����');
//	
//		theform.phonenum.focus();
//		return false;
//	}

	
	if(signvalid(theform.phonenum.value,"'"))
	{
		alert('��������ֻ������зǷ��ַ�(������)��');
		
		theform.phonenum.focus();
		return false;
	}

if(theform.name.value==""){
alert("������С˵������");
return false;
}

}








