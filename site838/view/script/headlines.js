//------------------------------
//create time:2007-9-28
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:首页，最新发布
//------------------------------
HeadLineDL = {
i: 0,
dl: document.getElementById('HeadLines').getElementsByTagName('dl')[0],
x: function(dt) {
	var dts = this.dl.getElementsByTagName('dt');
	for (var i = 0; i < dts.length; i++) {
		dts[i].className = dts[i].className.replace(/\s*hover/, '');
		if (dts[i] == dt) this.i = i;
	}
	dt.className += ' hover';
	
	var dds = this.dl.getElementsByTagName('dd');
	for (var i = 0; i < dds.length; i++) {
		dds[i].style.display = 'none';
	}
	var dd = dt.nextSibling;
	while (dd.nodeType != 1) {
		dd = dd.nextSibling;
	}
	dd.style.display = 'block';
},
init: function() {
	var dts = this.dl.getElementsByTagName('dt');
	var parse = false;
	this.dl.onmouseover = function() {parse = true};
	this.dl.onmouseout = function() {parse = false};
	for (var i = 0; i < dts.length; i++) {
		dts[i].onmouseover = function(e) {
			var ev = !e ? window.event : e;
			var t = ev.srcElement || e.target;
			HeadLineDL.x(t);
		}
	}
	this.x(dts[0]);
	setInterval(function() {
		if (parse) return;
		HeadLineDL.x(dts[++HeadLineDL.i % 6]);
	}, 5000);
}
}
HeadLineDL.init();
