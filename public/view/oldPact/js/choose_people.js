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
        url : 'json/people.json',
        cellMinWidth : 95,
        page : true,
        height : "auto",
        limit : 20,
        limits : [10,15,20,25],
        cols : [[
				{type:'radio',fixed: 'left',field:'id'},
				{field:'number',title: '客源编号',width:100,align:"center"},
				{field:'name',title: '客户姓名',width:100,align:"center"},
				{field:'area',title: '区县',width:200,align:'center'},
				{field:'block',title: '板块',width:150,align:'center'},
				{field:'room',title: '户型',width:150,align:'center'},
				{field:'use',title: '用途',width:150,align:'center'},
				{field:'state',title: '状态',width:150,align:'center'},
				{field:'man',title: '员工',width:100,align:'center'},
				{field:'form',title: '来源',width:100,align:"center",hide:true},
				{field:'card',title: '身份证',width:100,align:"center",hide:true},
				{field:'cardN',title: '证件号码',width:100,align:"center",hide:true},
				{field:'address',title: '通讯地址',width:100,align:"center",hide:true},
				{field:'phone',title: '电话',width:100,align:"center",hide:true},
				{field:'phone1',title: '电话1',width:100,align:"center",hide:true}
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
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='client']").val(data[0].name);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='phoneK1']").val(data[0].phone);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='phoneK2']").val(data[0].phone1);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='formK']").val(data[0].form);
		contentWindow.parents().find('#main').children('iframe').contents().find('#cardK').children("select[name='cardK']").val(data[0].card);
		contentWindow.parents().find('#main').children('iframe').contents().find('#cardK').children("select[name='cardK']").siblings().children("div[class='layui-select-title']").children("input").val(data[0].card);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='cardK1']").val(data[0].cardN);
		contentWindow.parents().find('#main').children('iframe').contents().find("input[name='addressK']").val(data[0].address);
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