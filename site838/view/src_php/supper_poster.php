<?php
//------------------------------
//create time:2007-8-10
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:超级发贴器
//------------------------------
//echo "hello";
?>
<HTML>
<HEAD>
<TITLE> 超级发贴器 </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<script language="javascript">
var num = 0; //已发布片段数
var pos_start = 0; //起始位置
var max = 0; //一个片段最大长度
//var title_base = "VPN目前使用的隧道协议有哪些？各有什么特点？";
function init_default()
{
	//初始缺省值
	//输入:无
	//输出:无
	num = 0; //已发布片段数
	pos_start = 0; //起始位置
	max = 50000; //一个片段最大长度
}

function post_segment()
{
	//发送一个片段
	//输入:无
	//输出:无
	//alert("发送一个片段="+num);
	var txt=get_segment();
	if("" == txt)
		return alert("估计已全部发布完成");
	++num;
	var title = get_title_base();
	document.all["title"].value= title+"("+num+")";
	document.all["content"].value= txt;
	commit();
	//alert(title_base+"("+num+")\r\n"+txt);	
}
/*
function post_over()
{
	//完成一个片段
	//输入:无
	//输出:无

}
*/
function run()
{
	//运行
	//var all = document.all["content_all"].value;
	rm_ad(); //移除广告
	init_default();
	var txt = "";
	//alert(get_segment());
	var title = get_title_base();
	var clist = document.all["clist"].value;
	if("" == title || "" == clist)
		return alert("请填写标题与类目ID");
	post_segment();
	/*
	while("" != (txt=get_segment())){
		++num;
		document.all["txt_title"].value= title+"("+num+")";
		document.all["txt_content"].value= txt;
		commit();
		//alert(title_base+"("+num+")\r\n"+txt);
		
	}
	*/
}
function get_title_base()
{
	return document.all["title_all"].value;
}
function commit()
{
	//提交
	//输入:无
	//输出:无
	//alert(document.all["txt_title"].value);
	if("" == document.all["clist"].value)
		return alert("类目为空");
	if("" == document.all["title"].value)
		return alert("标题为空");
	if("" == document.all["content"].value)
		return alert("内容为空");
	//return;
	//----------提交---------
	//document.all["hd_clist"].value = list;
	document.all["frmsubmit"].action = '../cmd.php';
	//alert(document.all["frmsubmit"].action);
	//submitframe
	//alert("开始提交");
	document.all["frmsubmit"].submit();
}
function get_segment()
{
	//return "";
	//alert("aaa");
	//return "";
	var all = document.all["content_all"].value;
	//alert(pos_start+":"+all.length);
	if(pos_start >= all.length)
		return "";
	var pos = pos_start,pos_now=0,pos_last=0;
	var tmp = "",len=0;
	var count = 0;
	while(-1 !=(pos_now = all.indexOf("\n",pos))){
		//if(++count >= 3)
		//	return "over";
		//alert(pos_now);
		len = pos_now - pos_start;
		//alert(len);
		//return len;
		tmp = all.substr(pos_start,len);
		//alert(tmp);
		//return max;
		if(tmp.length > max){ //结束
			//alert(pos_last+":"+pos_now);
			len = pos_last - pos_start;
			tmp = all.substr(pos_start,len);
			pos_start = pos_last;
			return tmp;
		}
		pos = pos_now+1;
		pos_last = pos;
		//return all.indexOf("\n",pos);
	}
	//最后一段
	//alert(pos_start+":"+all.length);
	len = all.length-pos_start;
	//alert(len);
	tmp = all.substr(pos_start,len);
	pos_start = all.length;
	return tmp;
}
function init()
{
	//初始
	//run();
}
function rm_ad()
{
	//移除广告语
	//输入:无
	//输出:无
	var all = document.all["content_all"].value;
	all = all.replace(/（本书资料收集于网上，版权归原作者所有）/g,'');
	all = all.replace(/Xinty665 免费制作/g,'');
	all = all.replace(/说明：本书借用【云中孤雁】制作的模板/g,'');
	document.all["content_all"].value = all;
	//alert("ok");
}
</script>
</HEAD>

<BODY onload="javascript:init();">
<table>
<tr><td>
说明:可以将很大的文本自动拆分成多段发布,2007-8-22<br/>
全部内容
</td></tr>
<tr><td>
标题:<input type="text" name="title_all" value="" size="50"/>
</td></tr>
<tr><td>
<textarea cols="80" name="content_all" rows="17" style="FONT-SIZE: 9pt"></textarea>
<!--VPN目前使用的隧道协议有哪些？各有什么特点？

虚拟专用网(VPN)被定义为通过一个公用网络(通常是因特网)建立一个临时的、安全的连接，是一条穿过混乱的公用网络的安全、稳定的隧道。虚拟专用网是对企业内部网的扩展。

虚拟专用网可以帮助远程用户、公司分支机构、商业伙伴及供应商同公司的内部网建立可信的安全连接，并保证数据的安全传输。通过将数据流转移到低成本的压网络上，一个企业的虚拟专用网解决方案将大幅度地减少用户花费在城域网和远程网络连接上的费用。同时，这将简化网络的设计和管理，加速连接新的用户和网站。另外，虚拟专用网还可以保护现有的网络投资。随着用户的商业服务不断发展，企业的虚拟专用网解决方案可以使用户将精力集中到自己的生意上，而不是网络上。虚拟专用网可用于不断增长的移动用户的全球因特网接入，以实现安全连接；可用于实现企业网站之间安全通信的虚拟专用线路，用于经济有效地连接到商业伙伴和用户的安全外联网虚拟专用网。

目前很多单位都面临着这样的挑战：分公司、经销商、合作伙伴、客户和外地出差人员要求随时经过公用网访问公司的资源,这些资源包括:公司的内部资料、办公OA、ERP系统、CRM系统、项目管理系统等。现在很多公司通过使用IPSec VPN来保证公司总部和分支机构以及移动工作人员之间安全连接。

对于很多IPSec VPN用户来说，IPSec VPN的解决方案的高成本和复杂的结构是很头疼的。存在如下事实：在部署和使用软硬件客户端的时候，需要大量的评价、部署、培训、升级和支持，对于用户来说，这些无论是在经济上和技术上都是个很大的负担，将远程解决方案和昂贵的内部应用相集成，对任何IT专业人员来说都是严峻的挑战。由于受到以上 IPSec VPN的限制，大量的企业都认为IPSec VPN是一个成本高、复杂程度高，甚至是一个无法实施的方案。为了保持竞争力，消除企业内部信息孤岛，很多公司需要在与企业相关的不同的组织和个人之间传递信息，所以很多公司需要找一种实施简便，不需改变现有网络结构，运营成本低的解决方案。


---- 从概念上讲，IP-VPN是运营商(即服务提供者)支持企业用户应用的方案。一个通用的方法可以适用于由一个运营商来支持的、涉及其他运营商网络的情况（如运营商的运营商）。
---- 图1给出了实现IP-VPN的一个通用方案。其中，CE路由器是用于将一个用户站点接入服务提供者网络的用户边缘路由器。而PE路由器则是与用户CE路由器相连的、服务提供者的边缘路由器。



---- 站点是指这样一组网络或子网，它们是用户网络的一部分，并且通过一条或多条PE/CE链路接至VPN。VPN是指一组共享相同路由信息的站点，一个站点可以同时位于不同的几个VPN之中。

---- 图2显示了一个服务提供者网络支持多个VPN的情况。如图2所示，一个站点可以同时属于多个VPN。依据一定的策略，属于多个VPN的站点既可以在两个 VPN之间提供一定的转发能力，也可以不提供这种能力。当一个站点同时属于多个VPN时，它必须具有一个在所有VPN中唯一的地址空间。



---- MPLS为实现IP-VPN提供了一种灵活的、具有可扩展性的技术基础，服务提供者可以根据其内部网络以及用户的特定需求来决定自己的网络如何支持IP-VPN。所以，在MPLS/ATM网络中,有多种支持IP-VPN的方法，本文介绍其中两种方法。

方案一
---- 本节介绍一种在公共网中使用MPLS提供IPVPN业务的方法。该方法使用LDP的一般操作方式，即拓扑驱动方式来实现基本的LSP建立过程，同时使用两级LSP隧道(标记堆栈)来支持VPN的内部路由。

---- 图3 给出了在MPLS/ATM核心网络中提供IPVPN业务的一种由LER和LSR构成的网络配置。



---- LER (标记边缘路由器)

---- LER是MPLS的边缘路由器，它位于MPLS/ATM服务提供者网络的边缘。对于VPN用户的IP业务量，LER将是VPN隧道的出口与入口节点。如果一个LER同时为多个用户所共享，它还应当具有执行虚拟路由的能力。这就是说，它应当为自己服务的各个VPN分别建立一个转发表，这是因为不同VPN的IP地址空间可能是有所重叠的。

---- LSR(标记交换路由器)

---- MPLS/ATM核心网络是服务提供者的下层网络，它为用户的IP-VPN业务所共享。

---- 建立IP-VPN区域的操作

---- 希望提供IP-VPN的网络提供者必须首先对MPLS域进行配置。这里的MPLS域指的就是IPVPN区域。作为一种普通的LDP操作，基本的LSP 建立过程将使用拓扑驱动方法来进行，这一过程被定义为使用基本标记的、基本的或是单级LSP建立。而对于VPN内部路由，则将使用两级LSP隧道（标记堆栈）。

---- VPN成员

---- 每一个LER都有一个任务，即发现在VPN区域中为同一 IPVPN服务的其他所有LER。由于本方案最终目的是要建立第二级MPLS隧道，所以 LER发现对等实体的过程也就是LDP会话初始化的过程。每一个LER沿着能够到达其他 LER的每一条基本网络LSP，向下游发送一个LDP Hello消息。LDP Hello消息中会包含一个基本的MPLS标记，以方便这些消息能够最终到达目的LER。

---- LDP Hello消息实际上是一种查询消息，通过这一消息，发送方可以获知在目的LER处是否存在与发送方LSR同属一个VPN的LER（对等实体）。新的 Hello消息相邻实体注册完成之后，相关的两个LER之间将开始发起LDP会话。随后，其中一个LER将初始化与对方的TCP连接。当TCP连接建立完成而且必要的初始化消息交互也完成之后，对等LER之间的会话便建立起来了。此后，双方各自为对方到自己的LSP 隧道提供一个标记。如果LSP隧道是嵌套隧道，则该标记将被推入标记栈中，并被置于原有的标记之上。

---- VPN成员资格和可到达性信息的传播

---- 通过路由信息的交换，LER可以学习与之直接相连的、用户站点的IP地址前缀。LER需要找到对等LER，还需要找到在一个VPN中哪些LER 是为同一个VPN服务的。LER将与其所属的VPN区域中其他的LER建立直接的LDP会话。换言之，只有支持相同VPN的LER之间才能成功地建立 LDP会话。

---- VPN内的可到达性

---- 最早在嵌套隧道中传送的数据流是LER之间的路由信息。当一个LER被配置成一个IPVPN的一员时，配置信息将包含它在VPN内部要使用的路由协议。在这一过程中，还可能会配置必要的安全保密特性，以便该LER能够成为其他LER的相邻路由器。在VPN内部路由方案中，每一次发现阶段结束之后，每一个 LER 都将发布通过它可以到达的、VPN用户的地址前缀。

---- IP分组转发

---- LER之间的路由信息交互完成之后，各个LER都将建立起一个转发表，该转发表将把VPN用户的特定地址前缀(FEC转发等价类) 与下一跳联系起来。当收到的IP分组的下一跳是一个LER时，转发进程将首先把用于该LER的标记（嵌套隧道标记）推入标记栈，随后把能够到达该LER的基本网络LSP上下一跳的基本标记推入标记分组，接着带有两个标记的分组将被转发到基本网络LSP中的下一个LSR；当该分组到达目的LER时，最外层的标记可能已经发生许多次的改变，而嵌套在内部的标记始终保持不变；当标记栈弹出后，继续使用嵌套标记将分组发送至正确的LER。在LER上，每一个VPN 使用的嵌套标记空间必须与该LER所支持的其他所有VPN使用的嵌套标记空间不同。

方案二
---- 本节将对一种在公共网中使用MPLS和多协议边界网关协议来提供IP-VPN业务的方法进行介绍，其技术细节可以参见RFC 2547。

---- 图1 给出了在MPLS/ATM核心网络中提供IPVPN业务的、由LER和LSR构成的网络配置，图4则给出了使用RFC 2547的网络模型。

---- 提供者边缘(PE)路由器

---- PE路由器是与用户路由器相连的服务提供者边缘路由器。

---- 实际上，它就是一个边缘LSR（即MPLS网络与不使用 MPLS的用户或服务提供者之间的接口）。

---- 用户边缘 (CE)路由器

---- CE路由器是用于将一个用户站点接至PE路由器的用户边缘路由器。在这一方案中，CE路由器不使用MPLS，它只是一台IP路由器。CE不必支持任何VPN的特定路由协议或信令。

---- 提供者(P)路由器

---- P路由器是指网络中的核心LSR。

---- 站点（Site）

---- 站点是指这样一组网络或子网：它们是用户网络的一部分，通过一条或多条PE/CE链路接至VPN。VPN是指一组共享相同路由信息的站点。一个站点可以同时位于不同的几个VPN之中。

---- 路径区别标志

---- 服务提供者将为每一个VPN分配一个唯一的标志符，该标志符称为路径区别标志（RD）,它对应于服务提供者网络中的每一个Intranet或 Extranet 都是不同的。PE路由器中的转发表里将包含一系列唯一的地址，这些地址称为VPNIP 地址，它们是由RD与用户的IP地址连接而成的。VPNIP地址对于服务提供者网络中的每一个端点都是唯一的，对于VPN中的每一个节点（即VPN中的每一个PE路由器），转发表中都将存储有一个条目。

---- 连接模型

---- 图4给出了MPLS/BGP VPN的连接模型。



---- 从图4中可以看出，P路由器位于MPLS网络的核心。 PE路由器将使用MPLS与核心MPLS网络通信，同时使用IP路由技术来与CE路由器通信。 P与PE路由器将使用IP路由协议（内部网关协议）来建立MPLS核心网络中的路径，并且使用LDP实现路由器之间的标记分发。

---- PE路由器使用多协议BGP4来实现彼此之间的通信，完成标记交换和每一个VPN策略。除非使用了路径映射标志（route reflector），否则PE 之间是BGP全网状连接。特别地，图4中的PE处于同一自治域中，它们之间使用内部BGP （iBGP）协议。

---- P路由器不使用BGP协议而且对VPN一无所知，它们使用普通的MPLS协议与进程。

---- PE路由器可以通过IP路由协议与CE路由器交换IP路径，也可以使用静态路径。在CE与PE路由器之间使用普通的路由进程。CE路由器不必实现MPLS或对VPN有任何特别了解。

---- PE路由器通过iBGP将用户路径分发到其他的PE路由器。为了实现路径分发，BGP使用VPN-IP地址（由RD和IPv4地址构成）。这样，不同的VPN可以使用重叠的IPv4地址空间而不会发生VPN-IP地址重复的情况。

---- PE路由器将BGP计算得到的路径映射到它们的路由表中，以便把从CE路由器收到的分组转发到正确的LSP上。

---- 这一方案使用两级标记：内部标记用于PE路由器对于各个VPN的识别，外部标记则为MPLS网络中的LSR所用——它们将使用这些标记把分组转发给正确的PE。

---- 建立IP-VPN区域的操作

---- 希望提供IP-VPN业务的网络提供者必须按照连接需求对网络进行设计与配置，这包括：PE必须为其支持的VPN以及与之相连的CE所属的VPN 进行配置；MPLS网络或者是一个路径映射标志中的PE路由器之间必须进行对等关系的配置；为了与CE进行通信，还必须进行普通的路由协议配置；为了与 MPLS核心网络进行通信，还必须进行普通的MPLS配置（如LDP、IGP）。另外，P路由器除了要求能够支持MPLS之外，还要能够支持VPN。

>---- VPN成员资格和可到达性信息的传播
---- PE路由器使用IP路由协议或者是静态路径的配置来交换路由信息，并且通过这一过程获得与之直接相连的用户网站IP地址前缀。

---- PE路由器通过与其BGP对等实体交换VPN-IP地址前缀来获得到达目的VPN站点的路径。另外，PE路由器还要通过BGP与其PE路由器对等实体交换标记，以此确定PE路由器间连接所使用的LSP。这些标记用作第二级标记，P 路由器看不到这些标记。

---- PE路由器将为其支持的每一个VPN分别建立路由表和转发表，与一个PE路由器相连的CE路由器则根据该连接所使用的接口选择合适的路由表。

---- IP分组转发

---- PE之间的路由信息交换完成之后，每一个PE都将为每一个VPN建立一个转发表，该转发表将把VPN用户的特定地址前缀与下一跳PE路由器联系起来。

---- 当收到发自CE路由器的IP分组时，PE路由器将在转发表中查询该分组对应的VPN。

---- 如果找到匹配的条目，路由器将执行以下操作：

---- 如果下一跳是一个PE路由器，转发进程将首先把从路由表中得到的、该PE路由器所对应的标记（嵌套隧道标记）推入标记栈；PE路由器把基本的标记推入分组，该标记用于把分组转发到到达目的PE路由器的、基本网络LSP上的第一跳；带有两级标记的分组将被转发到基本网络LSP上的下一个LSR。

---- P路由器（LSR）使用顶层标记及其路由表对分组继续进行转发。当该分组到达目的LER时，最外层的标记可能已发生多次改变，而嵌套在内部的标记保持不变。

---- 当PE收到分组时，它使用内部标记来识别VPN。此后， PE将检查与该VPN相关的路由表，以便决定对分组进行转发所要使用的接口。

---- 如果在VPN路由表中找不到匹配的条目，PE路由器将检查Internet路由表（如果网络提供者具备这一能力）。如果找不到路由，相应分组将被丢弃。

---- VPNIP转发表中包含VPNIP地址所对应的标记，这些标记可以把业务流路由至VPN中的每一个站点。这一过程由于使用的是标记而不是IP 地址，所以在企业网中，用户可以使用自己的地址体系，这些地址在通过服务提供者网络进行业务传输时无需网络地址翻译（NAT）。通过为每一个VPN使用不同的逻辑转发表，不同的VPN业务将可以被分开。使用BGP协议，交换机可以根据入口选择一个特定的转发表，该转发表可以只列出一个VPN有效目的地址。

---- 为了建立企业的Extranet，服务提供者需要对VPN之间的可到达性进行明确指定(可能还需要进行NAT配置)。

---- 安全

---- 在服务提供者网络中，PE所使用的每一个分组都将与一个RD相关联，这样，用户无法将其业务流或者是分组偷偷送入另一个用户的VPN。要注意的是，在用户数据分组中没有携带RD，只有当用户位于正确的物理端口上或拥有PE路由器中已经配置的、适当的RD时，用户才能加入一个Intranet或 Extranet。这一建立过程可以保证非法用户无法进入VPN，从而为用户提供与帧中继、租用线或ATM业务相同的安全等级

---------------------------------
2.1 L2TP
PPTP（点到点隧道协议）是在Window95/98中支持的，为中小企业提供的一个VPN解决方案。但根据一群安全专家的研究，PPTP在实现上存在着重大的安全问题，它的安全性甚至比PPP（点到点协议）还要弱，因此PPTP协议存在着重大安全缺陷。L2F协议的主要缺陷是没有把标准加密方法包括在内，因此它基本上已经成为一个过时的隧道协议。
L2TP协议结合了Microsoft的PPTP和Cisco的L2F（二层前向转发）的优点。L2TP提供了一种PPP包的机制，特别适合于通过VPN 拨号进入一个专用网络的用户。L2TP支持在各种网络连接上提供PPP包的封装，支持一个用户同时使用多个并发的隧道。它同样适用于非IP协议，支持动态寻址，是目前唯一能够提供全网状Intranet VPN连接的多协议隧道。
2.2 IPSec
IPSec是一组开放的 网络安全 网络安全协议的总称，提供访问控制、无连接的完整性、数据来源验证、防重放保护、加密以及数据流分类加密等服务。IPSec在IP层提供这些安全服务，它包括两个安全协议AH（报文验证头协议）和ESP（报文安全封装协议）。AH主要提供的功能有数据来源验证、数据完整性验证和防报文重放功能。ESP在AH协议的功能之外再提供对IP报文的加密功能。AH和ESP同时具有认证功能，IPSec存在两个不同的认证协议是因为ESP要求使用高强度密码学算法，无论产际上是否在使用。而高强度密码学算法在很多国家都存在很多严格的政策限制。但认证措施是不受限制的，因此AH可以在全世界自由使用。另外一个原因是很多情况下人们只使用认证服务。AH或ESP协议都支持两种模式的使用：隧道模式和传输模式。隧道模式对传经不安全的链路或Internet的专用IP内部数据包进行加密和封装（此种模式适合于有NAT的环境）。传输模式直接对IP负载内容（即TCP或UDP数据）加密（适合于无NAT的环境）。
2.3 MPLS VPN
MPLS实际上就是一种隧道技术，所以使用它来建立VPN隧道是十分容易的。同时，MPLS是一种完备的网络技术，可以用它来建立起VPN成员之间简单而高效的VPN。MPLS VPN适用于实现对于服务质量、服务等级划分以及网络资源的利用率，网络的可靠性有较高要求的VPN业务。用户边缘（CE） 路由器 路由器是用于将一个用户站点接入服务提供者网络的用户边缘路由器。CE路由器不使用MPLS，它可以只是一台IP路由器。CE不必支持任何VPN的特定路由协议或信令。提供者边缘（PE）路由器是与用户CE路由器相连的服务提供者边缘路由器。PE实际上就是MPLS中的边缘标记交换路由器（LER），它需要能够支持BGP协议，一种或几种IGP路由协议以及MPLS协议，需要能够执行IP包检查，协议转换等功能。用户站点是指这样一组网络或多条PE/CE链路接至VPN。一组共享相同路由信息的站点就构成了VPN。一个站点可以同时位于不同的几个VPN之中。
与前面几种VPN技术不同，MPLS VPRN网络中的主角虽然仍然是边缘路由器（此时是MPLS网络的边缘LSR），但是它将需要公共IP网内部的所有相关路由器都能够支持MPLS，所以这种技术对网络有较为特殊的要求。2.4 GRE
通用路由协议封装（GRE）规定了如何用一种网络协议去封装另一种网络协议的方法。


http://zhidao.baidu.com/question/28435098.html
//-->
</td></tr>
<tr><td>
<br/><br/>
折分提交区
</td></tr>
<form id="frmsubmit" name="frmsubmit" accept-charset="GB2312" enctype="multipart/form-data;application/x-www-form-urlencoded" action="../cmd.php" method="POST" target="submitframe">
<input name="fun" type="hidden" value="post_article838"/>
<input name="ref" type="hidden" value="supper"/>
<tr><td>
类目ID:<input type="text" name="clist" value="" size="5"/>&nbsp;&nbsp;&nbsp;标题:<input type="text" name="title" value="" size="48"/>
</td></tr>
<tr><td>
<tr><td>
本次提交片段
</td></tr>
<tr><td>
<textarea cols=80 name="content" rows="7" style="FONT-SIZE: 9pt"></textarea>
</td></tr>
<tr><td>
<button onclick="javascript:run();">发布</button>
</td></tr>
</form>
</table>
<iframe name="submitframe" width="0" height="0"></iframe>
</BODY>
</HTML>
