var w = parent.document.documentElement.clientWidth || parent.document.body.clientWidth;
var h = parent.document.documentElement.clientHeight || parent.document.body.clientHeight;
layui.use(['form','layer','laydate','table','laytpl','element','util','upload'],function(){
    var form = layui.form,
		layer = parent.layer === undefined ? layui.layer : top.layer,
		$ = layui.jquery,
		laydate = layui.laydate,
		laytpl = layui.laytpl,
		element = layui.element,
		upload = layui.upload,
		util = layui.util,
		table = layui.table;
	//日期
		var start = laydate.render({ //开始
			elem: '#start',
			done:function(value,date){}
		});
 
	table.render({
        elem: '#finance',
        url : 'json/results.json',
        cellMinWidth : 95,
        page : false,
        height : "auto",
        id : "finance",
        cols : [[
				{field:'man',title: '部门员工',width:300,align:"center"},
				{field:'jobs',title: '岗位',width:200,align:'center'},
				{field:'ratio',title: '分成比例',width:200,align:'center'},
				{field:'explain',title: '分成说明',width:200,align:'center'},
        ]]
    });
	//合同图片
	upload.render({
    elem: '#test1', //绑定元素
    accept: 'images', //允许上传的文件类型
    multiple: true, //允许多文件上传
    auto: false, //选完文件后不要自动上传
    bindAction: '#button', //指定一个按钮触发上传
    url: '/upload/', //上传接口
    choose: function(obj){
        var files = obj.pushFile(); //将每次选择的文件追加到文件队列
        //图像预览，如果是多文件，会逐个添加。(不支持ie8/9)
        obj.preview(function(index, file, result){
            var imgobj = new Image(); //创建新img对象
            imgobj.src = result; //指定数据源
            imgobj.className = 'thumb';
            imgobj.onclick = function(result) {
            //单击预览
            img_prev.src = this.src;
            var w = $(window).width() - 42, h = $(window).height() - 42;
            layer.open({
                title: '预览',
                type: 1,
                area: [w, h], //宽高
                content: $('#prevModal')
            });
        };
        document.getElementById("div_prev").appendChild(imgobj); //添加到预览区域
        });
    },
	done: function(res){},
	error: function(){}
    });
	//编辑合同
	$("#alter").click(function(){
		var edit = layer.open({
		type: 2
		,title:'添加跟进'
		,content: 'oldPact/alter.html'
		,area:['500px','550px']
		,btnAlign: 'c'
	});	
	});
	//添加跟进
$("#follow").click(function(){
	var amin = layer.open({
		type: 2
		,title:'添加跟进'
		,content: 'oldPact/follow.html'
		,area:['500px','550px']
		,skin:'s1 fadeInRight'
		,btnAlign: 'c'
	});
});
 //固定Bar
  util.fixbar({
	  bgcolor: '#177ce3'
  });
});
//步骤流程
layui.config({
  base: '../layui1/mods/extend/step/'
}).use('step',function(){
	var step = layui.step
	var data0 = {
		steps: [{"title" : "合同签署", "time" : "2018-07-22"},
			   {"title" : "办件中", "time" : "2018-07-23"},
			   {"title" : "过户成功", "time" : "2018-07-22"},
			   {"title" : "交割完毕", "time" : "2018-07-22"}]
		,current: 1
	}
	step.ready({
		elem: '#steps',
		data: data0,
		color: {
			success:'#177ce3',
			error:'#999'
		}
	});
});