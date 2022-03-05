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
//跟进时间
laydate.render({ 
elem: '#datetime'
,type: 'datetime'
,value: new Date()
});	
var bind_name = 'input';
if (navigator.userAgent.indexOf("MSIE") != -1) { //（此处是为了兼容IE）
    bind_name = 'propertychange';
}
if (navigator.userAgent.match(/android/i) == "android") {
    bind_name = "keyup";
}

$("textarea[name='descs']").bind(bind_name, function() {
    var limitSub = $(this).val().substr(0, 300);
    $(this).val(limitSub); //截取字符长度
    $(this).next('.statistics').html(limitSub.length + '/300'); //获取实时输入字符长度并显示
    if (limitSub.length == 300) {
        $("textarea[name='descs']").css('color', 'red'); //超出指定字符长度标红提示
        alert('你已超出250个字！');
    } else {
        $("textarea[name='descs']").css('color', '#333');
    }
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