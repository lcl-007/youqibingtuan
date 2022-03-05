layui.use(['jquery','form','layer','laydate','table','laytpl','element','util'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        laydate = layui.laydate,
        laytpl = layui.laytpl,
			element = layui.element,
			util = layui.util,
        table = layui.table;
    //新闻列表
    table.render({
        elem: '#newsList',
        url : 'json/home.json',
        cellMinWidth : 95,
        page : true,
        height : "auto",
        limit : 20,
        limits : [10,15,20,25],
        cols : [[
				{type:'radio',fixed: 'left',field:'id'},
				{field:'number',title: '房源编号',align:"center"},
				{field:'address',title: '物业地址',align:"center"},
				{field:'room',title: '户型',align:'center'},
				{field:'area',title: '建筑面积(㎡)',align:'center'},
				{field:'useArea',title: '使用面积(㎡)',align:'center'},
				{field:'man',title: '员工',align:'center'},
				{field:'name',title: '业主姓名',align:"center",hide:true},
				{field:'form',title: '来源',align:"center",hide:true},
				{field:'use',title: '物业用途',align:"center",hide:true},
				{field:'card',title: '证件号码',align:"center",hide:true},
				{field:'floor',title: '楼层',align:"center",hide:true},
				{field:'payment',title: '付款方式',align:"center",hide:true},
				{field:'phone',title: '电话',align:"center",hide:true},
				{field:'phone1',title: '电话1',align:"center",hide:true}
        ]]
    });
	//确定
$("#getCheckData").click(function(){
	var index = parent.layer.getFrameIndex(window.name);
	var checkStatus = table.checkStatus('newsList'),data=checkStatus.data;
	if(data==''){
		layer.msg('请选择！', {icon: 10});
	}else{
		var contentWindow = window.parent.layui.$("#layui-layer-iframe" + index);
		var floor = data[0].floor;
		var	strs = floor.split("/");
		var room = data[0].room;
		var arr = room.replace(/\d+\.\d+/g, ",").replace(/\d+/g, ",").split(",");
		var resultArray = [];
		for(var i=0;i<arr.length;i++){
			if(arr[i] != ""){
				resultArray[resultArray.length] = room.substring(room.indexOf(arr[i-1]) + arr[i-1].length, room.indexOf(arr[i]));
			}
		}

		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='address']").val(data[0].address);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='form']").val(data[0].form);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='papersN']").val(data[0].card);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='use']").val(data[0].use);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='build']").val(data[0].area);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='actual']").val(data[0].useArea);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='floor']").val(strs[0]);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='floorT']").val(strs[1]);
		//室
		contentWindow.parents().find('#main').children('iframe').contents().find('#room').children("select[name='room']").val(resultArray[0]);
		contentWindow.parents().find('#main').children('iframe').contents().find('#room').children("select[name='room']").siblings().children("div[class='layui-select-title']").children("input").val(resultArray[0]);
		//厅
		contentWindow.parents().find('#main').children('iframe').contents().find('#hall').children("select[name='hall']").val(resultArray[0]);
		contentWindow.parents().find('#main').children('iframe').contents().find('#hall').children("select[name='hall']").siblings().children("div[class='layui-select-title']").children("input").val(resultArray[1]);
		//卫
		contentWindow.parents().find('#main').children('iframe').contents().find('#who').children("select[name='who']").val(resultArray[0]);
		contentWindow.parents().find('#main').children('iframe').contents().find('#who').children("select[name='who']").siblings().children("div[class='layui-select-title']").children("input").val(resultArray[2]);
		//阳台
		contentWindow.parents().find('#main').children('iframe').contents().find('#balcony').children("select[name='balcony']").val(resultArray[0]);
		contentWindow.parents().find('#main').children('iframe').contents().find('#balcony').children("select[name='balcony']").siblings().children("div[class='layui-select-title']").children("input").val(resultArray[3]);
		//付款方式
		contentWindow.parents().find('#main').children('iframe').contents().find("select[name='payment']").val(data[0].payment);	
		contentWindow.parents().find('#main').children('iframe').contents().find("select[name='payment']").siblings().children("div[class='layui-select-title']").children("input").val(data[0].payment);

		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='owner']").val(data[0].name);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='phone1']").val(data[0].phone);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='phone2']").val(data[0].phone1);
		parent.layer.close(index);
	}
});
	//取消
$("#close").click(function(){
	var index = parent.layer.getFrameIndex(window.name);
	 parent.layer.close(index);
});
 //固定Bar
  util.fixbar({
	  bgcolor: '#177ce3'
  });
});