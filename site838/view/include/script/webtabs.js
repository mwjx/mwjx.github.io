/*
//------------------------------
//create time:2007-1-24
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:ԭ��Ϊpchome
//------------------------------
WebTabs 1.0 Trial Edition
http://www.phyrix.com
*/

var _bg="buttonface";
var _c0 ="#CACACA";
var _c1="#EEE";
var _c2="#EEE";
var _c3="#A4A4A4";
document.write("<style>.WebTabs-tab-container-bdr {position:absolute;overflow:hidden;}.WebTabs-tab-bdr {position:absolute;overflow:hidden;}.WebTabs-tab-cnr {position:absolute;overflow:hidden;height:1px;width:1px;}.WebTabs-external-page-container {display:none;}.WebTabs-tab {}.WebTabs-touchups {position:absolute;overflow:hidden;z-index:2;background:#FFFFFF;}.WebTabs-tab-text-container {background:#FFFFFF;}.WebTabs-internal-page-container {height:100%;background:#FFFFFF;overflow:auto;}</style>")


function _g(id){return document.getElementById(id)};var WebTabsHandler={idCounterWidget:0,idCounterTab:0,idPrefixWidget:"tab_container",idPrefixTab:"tab_",getId:

function(type){if(type=="widget"){return this.idPrefixWidget}
else if(type=="tab"){return this.idPrefixTab+this.idCounterTab++}},f_activate_tab:

function(tab){f_activate_tab(tab)}};

function WebTabs_widget(w,h,x,y,pos){this._tabs=[];this._pages=[];this.w=w;this.h=h;this.x=x;this.y=y;this.pos=pos;this.id=WebTabsHandler.getId("widget");this.f_init_tabs=f_init_tabs;this.f_init_pages=f_init_pages;this.f_preprocess_tabs=f_preprocess_tabs;this.f_resize_tabs=f_resize_tabs;this.f_redraw_tab=f_redraw_tab;this.f_activate_tab=f_activate_tab;this.f_move_to=f_move_to;this.f_move_by=f_move_by;};WebTabs_widget.prototype.add=

function(tab){this._tabs[this._tabs.length]=tab;};WebTabs_widget.prototype.toString=

function(){s='';s+='<div class=WebTabs-tab id='+this.id+' style="position:'+this.pos+';visibility:hidden">';s+='<!-- internal border -->';s+='<div class=WebTabs-tab-container-bdr id=tab_container_bdr_ext_t style="height:1px;background:'+_c0+'"></div>';s+='<div class=WebTabs-tab-container-bdr id=tab_container_bdr_ext_b style="height:1px;background:'+_c3+'"></div>';s+='<div class=WebTabs-tab-container-bdr id=tab_container_bdr_ext_l style="width:1px;background:'+_c0+'"></div>';s+='<div class=WebTabs-tab-container-bdr id=tab_container_bdr_ext_r style="width:1px;background:'+_c3+'"></div>';s+='<!-- external border -->';s+='<div class=WebTabs-tab-container-bdr id=tab_container_bdr_int_t style="height:1px;left:1px;background:'+_c1+'"></div>';s+='<div class=WebTabs-tab-container-bdr id=tab_container_bdr_int_b style="height:1px;left:1px;background:'+_c2+'"></div>';s+='<div class=WebTabs-tab-container-bdr id=tab_container_bdr_int_l style="width:1px;left:1px;background:'+_c1+'"></div>';s+='<div class=WebTabs-tab-container-bdr id=tab_container_bdr_int_r style="width:1px;background:'+_c2+'"></div>';s+='<!-- touchups -->';s+='<div class=WebTabs-touchups id=hideline style="height:4px"></div>';s+='<div class=WebTabs-touchups id=cyan style="width:1px;height:1px"></div>';s+='<div class=WebTabs-touchups id=lightgreen style="width:1px;height:1px"></div>';s+='<div class=WebTabs-touchups id=purple style="width:1px;height:1px"></div>';s+='<div class=WebTabs-touchups id=yellow style="width:1px;height:1px"></div>';s+='<div class=WebTabs-touchups id=green style="width:1px;height:1px"></div>';s+='<div class=WebTabs-touchups id=lightblue style="width:1px;height:1px"></div>';s+='<div class=WebTabs-touchups id=blue style="width:1px;height:1px"></div>';s+='<!-- tabs & pages-->';
for(i=0;i<this._tabs.length;i++){sTab=this._tabs[i];s+=sTab;}s+='</div>';return s;};

function WebTabs_tab(text,page,icon){this.text=text;this.page=_g(page).innerHTML;this.icon=icon;this.id=WebTabsHandler.getId("tab");};WebTabs_tab.prototype.toString=

function(){s='';s+='<div onselectstart="return false" id='+this.id+' style="position:absolute;z-index:0;width:1001px;left:2px;top:1px;height:18px" onmousedown="WebTabsHandler.f_activate_tab('+this.id.split('_')[1]+')">';s+='<!-- internal border -->';s+='<div class=WebTabs-tab-bdr id=tab_bdr_ext_t_'+this.id.split("_")[1]+' style="height:1px;left:2px;background:'+_c0+'"></div>';s+='<div class=WebTabs-tab-bdr id=tab_bdr_ext_l_'+this.id.split("_")[1]+' style="width:1px;height:16px;top:2px;background:'+_c0+'"></div>';s+='<div class=WebTabs-tab-bdr id=tab_bdr_ext_r_'+this.id.split("_")[1]+' style="width:1px;height:16px;top:2px;background:'+_c3+'"></div>';s+='<!-- external border -->';s+='<div class=WebTabs-tab-bdr id=tab_bdr_int_t_'+this.id.split("_")[1]+' style="height:1px;left:1px;top:1px;background:'+_c1+'"></div>';s+='<div class=WebTabs-tab-bdr id=tab_bdr_int_l_'+this.id.split("_")[1]+' style="width:1px;height:17px;left:1px;top:1px;background:'+_c1+'"></div>';s+='<div class=WebTabs-tab-bdr id=tab_bdr_int_r_'+this.id.split("_")[1]+' style="width:1px;height:17px;top:1px;background:'+_c2+'"></div>';s+='<!-- corners -->';s+='<div class=WebTabs-tab-cnr id=tab_cnr_l_'+this.id.split("_")[1]+' style="left:1px;top:1px;background:'+_c0+'"></div>';s+='<div class=WebTabs-tab-cnr id=tab_cnr_r_'+this.id.split("_")[1]+' style="top:1px;background:'+_c3+'"></div>';s+='<div class=WebTabs-tab-text-container id=tab_text_container_'+this.id.split("_")[1]+' style="z-index:-1;position:absolute;width:100%;height:16px;left:1px;top:2px">';s+='<div id=tab_text_'+this.id.split("_")[1]+' style="position:absolute;cursor:default">';
if(this.icon==null||this.icon==""){padding_left=0;bgi="";}
else{padding_left=20;bgi='background:url('+this.icon+')';}s+='<div style="position:absolute;overflow:hidden;width:16px;height:16px;'+bgi+'"></div>';s+='<div style="position:relative;top:1px;padding-left:'+padding_left+'px">'+ this.text+'</div>';s+='</div>';s+='<div style="position:absolute;left:1px;width:100%;height:100%"></div>';s+='</div>';s+='</div>';s+='<div id=page_'+this.id.split("_")[1]+' style="position:absolute;visibility:hidden">';s+=' '+this.page;s+='</div>';return s;};

function f_init_tabs(){total_tabs=this._tabs.length;tab_container_width=this.w;tab_container_height=this.h;tab_container_left=this.x;tab_container_top=this.y;text_side_pad=8;this.f_preprocess_tabs();
if(total_rows>1){this.f_resize_tabs();}
for(row=0;row<total_rows;row++){
for(rel_tab=0;rel_tab<ary_row_mem[row].length;rel_tab++){this.f_redraw_tab(ary_row_mem[row][rel_tab]);}};_g("tab_container")
.style.width=tab_container_width;_g("tab_container")
.style.height=tab_container_height;_g("tab_container")
.style.left=tab_container_left;_g("tab_container")
.style.top=tab_container_top;_g("tab_container_bdr_ext_t")
.style.width=tab_container_width;_g("tab_container_bdr_ext_t")
.style.top=0+total_rows*18+2;_g("tab_container_bdr_ext_b")
.style.width=tab_container_width;_g("tab_container_bdr_ext_b")
.style.top=tab_container_height-1+2-2;_g("tab_container_bdr_ext_l")
.style.height=tab_container_height-1-total_rows*18-2;_g("tab_container_bdr_ext_l")
.style.top=0+total_rows*18+2;_g("tab_container_bdr_ext_r")
.style.height=tab_container_height-total_rows*18-2;_g("tab_container_bdr_ext_r")
.style.left=tab_container_width-1;_g("tab_container_bdr_ext_r")
.style.top=0+total_rows*18+2;_g("tab_container_bdr_int_t")
.style.width=tab_container_width-2;_g("tab_container_bdr_int_t")
.style.top=1+total_rows*18+2;_g("tab_container_bdr_int_b")
.style.width=tab_container_width-2;_g("tab_container_bdr_int_b")
.style.top=tab_container_height-2+2-2;_g("tab_container_bdr_int_l")
.style.height=tab_container_height-3-total_rows*18-2;_g("tab_container_bdr_int_l")
.style.top=1+total_rows*18+2;_g("tab_container_bdr_int_r")
.style.height=tab_container_height-2-total_rows*18-2;_g("tab_container_bdr_int_r")
.style.left=tab_container_width-2;_g("tab_container_bdr_int_r")
.style.top=1+total_rows*18+2;this.f_init_pages();this.f_activate_tab(0);_g("tab_container").style.visibility="";};

function f_init_pages(){
for(abs_tab=0;abs_tab<total_tabs;abs_tab++){_g("page_"+abs_tab)
.style.top=parseInt(_g("tab_container_bdr_ext_t")
.style.top.split("p")[0])+2;_g("page_"+abs_tab)
.style.left=2;_g("page_"+abs_tab)
.style.height=parseInt(_g("tab_container_bdr_ext_l")
.style.height.split("p")[0])-3;_g("page_"+abs_tab)
.style.width=parseInt(_g("tab_container_bdr_ext_t")
.style.width.split("p")[0])-4;}};

function f_preprocess_tabs(){ta="v";tb="o";tc="b";current_tab=null;test_row_width=0;row_count=0;ary_row_width=new Array();ary_tab_loc=new Array();ary_row_mem=new Array();ary_row_mem[0]=new Array();row_count=0;tab_count=0;tab_left=2;prev_tab_width=null;
for(abs_tab=0;abs_tab<total_tabs;abs_tab++){_g("tab_"+abs_tab)
.style.width=_g("tab_text_"+abs_tab).offsetWidth+4+2*text_side_pad;
if(abs_tab>0){prev_tab_width=tab_width;}tab_width=parseInt(_g("tab_"+abs_tab)
.style.width.split("p")[0]);test_row_width+=tab_width;
if(test_row_width>tab_container_width-4){row_count++;tab_count=0;tab_left=2;test_row_width=tab_width;ary_row_mem[row_count]=new Array();}
else{tab_left+=prev_tab_width;}ary_row_width[row_count]=test_row_width;ary_tab_loc[abs_tab]=row_count;ary_row_mem[row_count][tab_count]=abs_tab;_g("tab_"+abs_tab)
.style.left=tab_left;_g("tab_"+abs_tab)
.style.top=row_count*18+2;tab_count++;};total_rows=row_count+1;current_row=row_count;};

function f_resize_tabs(){
for(row=0;row<total_rows;row++){row_padding=tab_container_width-4-ary_row_width[row];tab_pad=row_padding/ary_row_mem[row].length/2;
if((tab_pad/2).toString().split(".")[1]!=null){bln_odd_pad=true;tab_pad=parseInt(tab_pad.toString().split(".")[0]);}
else{bln_odd_pad=false;}new_row_padding=tab_pad*ary_row_mem[row].length*2;row_trail_pad=row_padding-new_row_padding;Btest_row_width=0;Brow=0;Btab_count=0;Btab_left=2;Bprev_tab_width=null;
for(rel_tab=0;rel_tab<ary_row_mem[row].length;rel_tab++){_g("tab_"+ary_row_mem[row][rel_tab])
.style.width=parseInt(_g("tab_"+ary_row_mem[row][rel_tab])
.style.width.split("p")[0])+tab_pad*2;
if(rel_tab>0){Bprev_tab_width=Btab_width;}Btab_width=parseInt(_g("tab_"+ary_row_mem[row][rel_tab])
.style.width.split("p")[0]);Btest_row_width+=Btab_width;
if(Btest_row_width>tab_container_width-4){Btab_count=0;Btab_left=2;Btest_row_width=Btab_width;}
else{Btab_left+=Bprev_tab_width;}_g("tab_"+ary_row_mem[row][rel_tab])
.style.left=Btab_left;Btab_count++;}c=0;
for(i=0;i<row_trail_pad;i++){_g("tab_"+ary_row_mem[row][c])
.style.width=parseInt(_g("tab_"+ary_row_mem[row][c])
.style.width.split("p")[0])+1;
if(c==ary_row_mem[row].length-1){c=0;}
else{c++;}}
if(ary_row_mem[row].length>1){c=0;
for(i=0;i<row_trail_pad;i++){
for(x=c+1;x<ary_row_mem[row].length;x++){_g("tab_"+ary_row_mem[row][x])
.style.left=parseInt(_g("tab_"+ary_row_mem[row][x])
.style.left.split("p")[0])+1;}
if(c==ary_row_mem[row].length-1){c=0;}
else{c++;}}}}};

function f_redraw_tab(tab){_g("tab_bdr_ext_t_"+tab)
.style.width=_g("tab_"+tab)
.style.width.split("p")[0]-4;_g("tab_bdr_ext_r_"+tab)
.style.left=_g("tab_"+tab)
.style.width.split("p")[0]-1;_g("tab_bdr_int_t_"+tab)
.style.width=_g("tab_"+tab)
.style.width.split("p")[0]-2;_g("tab_bdr_int_r_"+tab)
.style.left=_g("tab_"+tab)
.style.width.split("p")[0]-2;_g("tab_cnr_r_"+tab)
.style.left=_g("tab_"+tab)
.style.width.split("p")[0]-2;x=(_g("tab_"+tab)
.style.width.split("p")[0]-_g("tab_text_"+tab).offsetWidth)/2;
if((x/2).toString().split(".")[1]!=null){x=x.toString().split(".")[0];}_g("tab_text_"+tab)
.style.left=x;};

function f_activate_tab(tab){
if(current_tab!=null){
if(tab==current_tab){return;}_g("tab_"+current_tab)
.style.width=parseInt(_g("tab_"+current_tab)
.style.width.split("p")[0])-4;this.f_redraw_tab(current_tab);_g("tab_"+current_tab)
.style.left=parseInt(_g("tab_"+current_tab)
.style.left.split("p")[0])+2;_g("tab_"+current_tab)
.style.top=parseInt(_g("tab_"+current_tab)
.style.top.split("p")[0])+2;_g("tab_bdr_ext_l_"+current_tab)
.style.height=parseInt(_g("tab_bdr_ext_l_"+current_tab)
.style.height.split("p")[0])-2;_g("tab_bdr_ext_r_"+current_tab)
.style.height=parseInt(_g("tab_bdr_ext_r_"+current_tab)
.style.height.split("p")[0])-2;_g("tab_bdr_int_l_"+current_tab)
.style.height=parseInt(_g("tab_bdr_int_l_"+current_tab)
.style.height.split("p")[0])-2;_g("tab_bdr_int_r_"+current_tab)
.style.height=parseInt(_g("tab_bdr_int_r_"+current_tab)
.style.height.split("p")[0])-2;_g("tab_"+current_tab).style.zIndex=0;_g("page_"+current_tab).style.visibility="hidden";}_g("tab_"+tab)
.style.width=parseInt(_g("tab_"+tab)
.style.width.split("p")[0])+4;this.f_redraw_tab(tab);_g("tab_"+tab)
.style.left=parseInt(_g("tab_"+tab)
.style.left.split("p")[0])-2;_g("tab_"+tab)
.style.top=parseInt(_g("tab_"+tab)
.style.top.split("p")[0])-2;_g("tab_bdr_ext_l_"+tab)
.style.height=parseInt(_g("tab_bdr_ext_l_"+tab)
.style.height.split("p")[0])+2;_g("tab_bdr_ext_r_"+tab)
.style.height=parseInt(_g("tab_bdr_ext_r_"+tab)
.style.height.split("p")[0])+2;_g("tab_bdr_int_l_"+tab)
.style.height=parseInt(_g("tab_bdr_int_l_"+tab)
.style.height.split("p")[0])+2;_g("tab_bdr_int_r_"+tab)
.style.height=parseInt(_g("tab_bdr_int_r_"+tab)
.style.height.split("p")[0])+2;_g("tab_"+tab).style.zIndex=1;counter=null;target_row=ary_tab_loc[tab];
for(row=0;row<total_rows;row++){
for(rel_tab=0;rel_tab<ary_row_mem[row].length;rel_tab++){abs_tab=ary_row_mem[row][rel_tab];
if(target_row!=current_row){
if(row==target_row){tab_top=2+(total_rows-1)*18;
if(abs_tab==tab){tab_top -=2;}}
else if(row==current_row){tab_top=2;}
else{if(counter==null){counter=1;}
else if(rel_tab==0){counter++;}tab_top=2+counter*18;}_g("tab_"+abs_tab)
.style.top=tab_top;}
if(abs_tab==tab){
if(ary_row_mem[row].length==1){_g("cyan")
.style.background=_c1;_g("lightgreen")
.style.background=_c0;_g("purple")
.style.background=_c1;_g("yellow")
.style.background=_c2;_g("green")
.style.background=_c3;_g("lightblue")
.style.background=_c2;_g("blue")
.style.background=_c3;}
else{if(rel_tab==0){_g("cyan")
.style.background=_c1;_g("lightgreen")
.style.background=_c0;_g("purple")
.style.background=_c1;_g("yellow")
.style.background=_c2;_g("green")
.style.background=_c3;_g("lightblue")
.style.background=_bg;_g("blue")
.style.background=_bg;}
else if(rel_tab==ary_row_mem[row].length-1){_g("cyan")
.style.background=_c1;_g("lightgreen")
.style.background=_bg;_g("purple")
.style.background=_bg;_g("yellow")
.style.background=_c2;_g("green")
.style.background=_c3;
if(total_rows==1){
if(ary_row_width[row]==tab_container_width-5){_g("lightblue")
.style.background=_bg;_g("blue")
.style.background=_c2;}
else if(ary_row_width[row]<tab_container_width-4){_g("lightblue")
.style.background=_bg;_g("blue")
.style.background=_bg;}
else{_g("lightblue")
.style.background=_c2;_g("blue")
.style.background=_c3;}}
else{_g("lightblue")
.style.background=_c2;_g("blue")
.style.background=_c3;}}
else{_g("cyan")
.style.background=_c1;_g("lightgreen")
.style.background=_bg;_g("purple")
.style.background=_bg;_g("yellow")
.style.background=_c2;_g("green")
.style.background=_c3;_g("lightblue")
.style.background=_bg;_g("blue")
.style.background=_bg;}}}}}_g("hideline")
.style.top=parseInt(_g("tab_"+tab)
.style.top.split("p")[0])+parseInt(_g("tab_"+tab)
.style.height.split("p")[0]);_g("hideline")
.style.left=parseInt(_g("tab_"+tab)
.style.left.split("p")[0])+2;_g("hideline")
.style.width=parseInt(_g("tab_"+tab)
.style.width.split("p")[0])-4;_g("cyan")
.style.top=parseInt(_g("tab_"+tab)
.style.top.split("p")[0])+parseInt(_g("tab_"+tab)
.style.height.split("p")[0])+2;_g("cyan")
.style.left=parseInt(_g("tab_"+tab)
.style.left.split("p")[0])+1;_g("lightgreen")
.style.top=parseInt(_g("tab_"+tab)
.style.top.split("p")[0])+parseInt(_g("tab_"+tab)
.style.height.split("p")[0])+3;_g("lightgreen")
.style.left=parseInt(_g("tab_"+tab)
.style.left.split("p")[0]);_g("purple")
.style.top=parseInt(_g("tab_"+tab)
.style.top.split("p")[0])+parseInt(_g("tab_"+tab)
.style.height.split("p")[0])+3;_g("purple")
.style.left=parseInt(_g("tab_"+tab)
.style.left.split("p")[0])+1;_g("yellow")
.style.top=parseInt(_g("tab_"+tab)
.style.top.split("p")[0])+parseInt(_g("tab_"+tab)
.style.height.split("p")[0])+2;_g("yellow")
.style.left=parseInt(_g("tab_"+tab)
.style.left.split("p")[0])+parseInt(_g("tab_"+tab)
.style.width.split("p")[0])-2;_g("green")
.style.top=parseInt(_g("tab_"+tab)
.style.top.split("p")[0])+parseInt(_g("tab_"+tab)
.style.height.split("p")[0])+2;_g("green")
.style.left=parseInt(_g("tab_"+tab)
.style.left.split("p")[0])+parseInt(_g("tab_"+tab)
.style.width.split("p")[0])-1;_g("lightblue")
.style.top=parseInt(_g("tab_"+tab)
.style.top.split("p")[0])+parseInt(_g("tab_"+tab)
.style.height.split("p")[0])+3;_g("lightblue")
.style.left=parseInt(_g("tab_"+tab)
.style.left.split("p")[0])+parseInt(_g("tab_"+tab)
.style.width.split("p")[0])-2;_g("blue")
.style.top=parseInt(_g("tab_"+tab)
.style.top.split("p")[0])+parseInt(_g("tab_"+tab)
.style.height.split("p")[0])+3;_g("blue")
.style.left=parseInt(_g("tab_"+tab)
.style.left.split("p")[0])+parseInt(_g("tab_"+tab)
.style.width.split("p")[0])-1;_g("page_"+tab).style.visibility="";current_tab=tab;current_row=target_row;};

function f_move_to(x,y){tab_container_left=x;tab_container_top=y;_g("tab_container")
.style.left=tab_container_left;_g("tab_container")
.style.top=tab_container_top;};

function f_move_by(x,y){tab_container_left+=x;tab_container_top+=y;_g("tab_container")
.style.left=tab_container_left;_g("tab_container")
.style.top=tab_container_top;};