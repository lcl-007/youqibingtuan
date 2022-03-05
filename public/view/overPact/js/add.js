var w = parent.document.documentElement.clientWidth || parent.document.body.clientWidth;
var h = parent.document.documentElement.clientHeight || parent.document.body.clientHeight;
var width = w/1.6
layui.use(['form','layer','laydate','table','laytpl','element','util'],function(){
    var form = layui.form,
		layer = parent.layer === undefined ? layui.layer : top.layer,
		$ = layui.jquery,
		laydate = layui.laydate,
		laytpl = layui.laytpl,
		element = layui.element,
		util = layui.util,
		table = layui.table;
	//日期
		var start = laydate.render({ //开始
			elem: '#start',
			done:function(value,date){}
		});
		var end = laydate.render({ //开始
			elem: '#end',
			done:function(value,date){}
		});
		var date = laydate.render({ //开始
			elem: '#date',
			done:function(value,date){}
		});
		var dateSign = laydate.render({ //开始
			elem: '#dateSign',
			value: new Date(),
			done:function(value,date){}
		});
	//房客源不能为空
	$("#next").click(function(){
			if($("#home input[name='address']").val()==''){
				layer.msg('请选择有效房源！', {icon: 10});
				return false;
			}
			if($("#people input[name='client']").val()==''){
				layer.msg('请选择有效客源！', {icon: 10});
				return false;
			}
		form.on('submit(bind)', function(data){
			 var indexa = layui.layer.open({
					id:'print',
					title:false,
					type : 2,
					anim:2,
					content : "print.html",
					success: function(layero, index){
					/*var body = layui.layer.getChildFrame('body', index);
					var owner = $("input[name='owner']").val();	
					var card1 = $("input[name='card1']").val();	
					var manT = $("input[name='manT']").val();	
					var priceL = $("input[name='priceL']").val();	
					var man = $("input[name='man']").val();	
					var manPhone = $("input[name='manPhone']").val();	
					var client= $("input[name='client']").val();
					var cardK1= $("input[name='cardK1']").val();
					var manK = $("input[name='manK']").val();	
					var manPhoneK = $("input[name='manPhoneK']").val();
					var address = $("input[name='address']").val();	
					var address = $("input[name='address']").val();	
					var build = $("input[name='build']").val();	
					body.find("#owner").html(owner);*/
					}
				});
				layui.layer.full(indexa);
				$(window).on("resize",function(){
					layui.layer.full(indexa);
				});
			return false;
		});
	});
//选择房源
$("#add").click(function(){
	var index = parent.layer.open({
		type: 2
		,title:'选择房源'
		,content: 'choose_house.html'
		,btnAlign: 'c'
	});
	parent.layui.layer.full(index);
        parent.$(window).on("resize",function(){
            parent.layui.layer.full(index);
        });
});
//选择客源	
$("#addk").click(function(){
	var index = parent.layer.open({
		type: 2
		,title:'选择客源'
		,content: 'choose_people.html'
		,btnAlign: 'c'
	});
	parent.layui.layer.full(index);
        parent.$(window).on("resize",function(){
            parent.layui.layer.full(index);
        });
});	

//计算成交单价
$("input[name='price']").focus(function(){
	var total = $("input[name='total']").val()+'0000';
	var build = $("input[name='build']").val();
	var mean = total/build,result= mean.toFixed(2);
	$(this).val(result);
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
function num(obj){
	obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
	obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
	obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
	obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
	obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d\d\d\d\d\d\d).*$/,'$1$2.$3'); //控制可输入的小数
}
