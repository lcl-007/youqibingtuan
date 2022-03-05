layui.use(['jquery','form','layer','laydate','table','laytpl','element','util'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        laydate = layui.laydate,
        laytpl = layui.laytpl,
			element = layui.element,
			util = layui.util,
        table = layui.table;
	//提醒时间
laydate.render({ 
  elem: '#time'
  ,type: 'datetime'
  ,showBottom: true
  ,btns: ['clear', 'now', 'confirm']
  ,lang: 'cn'
  ,change: function(value, date, endDate){
    console.log(value); 
    console.log(date); 
    console.log(endDate); 
  }
  ,done: function(value, date, endDate){
    console.log(value); 
    console.log(date); 
    console.log(endDate);
  }
});
//签约时间
var dateSign = laydate.render({ 
	elem: '#dateSign',
	value: new Date(),
	done:function(value,date){}
});

	//确定
$("#ok").click(function(){
var index = parent.layer.getFrameIndex(window.name);
	/*	var section = $("select[name='section']").val();
	var desc=$("textarea[name='desc']").val();
	var man=$("input[name='man']").val();
	var datetime=$("input[name='datetime']").val();
	var contentWindow = window.parent.layui.$("#layui-layer-iframe" + index);
		
		contentWindow.parents().find('#detail').children('iframe').contents().find("#list").append();*/
		parent.layer.close(index);
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