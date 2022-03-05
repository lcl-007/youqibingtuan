var w = parent.document.documentElement.clientWidth || parent.document.body.clientWidth;
var h = parent.document.documentElement.clientHeight || parent.document.body.clientHeight;
var width=w/3
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
	var nowTime = new Date().valueOf();
		 var start = laydate.render({ //开始
                elem: '#start',
                min:nowTime,
                done:function(value,date){
                    endMax = end.config.max;
                    end.config.min = date;
                    end.config.min.month = date.month -1;
                }
            });
         var end = laydate.render({ //结束
               elem: '#end',
               min : nowTime,
               done:function(value,date){
                   if($.trim(value) == ''){
                       var curDate = new Date();
                       date = {'date': curDate.getDate(), 'month': curDate.getMonth()+1, 'year': curDate.getFullYear()};
                   }
                   start.config.max = date;
                   start.config.max.month = date.month -1;
               }
            });
    //新闻列表
    var tableIns = table.render({
        elem: '#newsList',
        url : 'json/newsList.json',
        cellMinWidth : 95,
        page : true,
        height : "auto",
        limit : 20,
        limits : [10,15,20,25],
        id : "newsListTable",
        cols : [[
				{field:'address',title: '物业地址',width:250,align:"center",event:'setSign',style:'cursor: pointer;color:#177ce3'},
				{field:'number',title: '合同编号',width:150,align:'center'},
				{field:'name',title: '客户姓名',width:100,align:'center'},
				{field:'price',title: '合同金额',width:100,align:'center'},
				{field:'april',title: '应收金额',width:100,align:'center'},
				{field:'Real',title: '实收金额',width:100,align:'center'},
				{field:'notReal',title: '未收金额',width:100,align:'center'},
				{field:'endDate',title: '结佣日期',width:150,align:'center'},
				{field:'endDatea',title: '结盘日期',width:150,align:'center'},
				{field:'man',title: '签约员工',width:100,align:'center'},
				{field:'manDate',title: '签约日期',width:150,align:'center'},
				{field:'plan',title: '合同进度',width:100,align:'center',style:'color:#FF5722'},
            {title: '操作', width:250, templet:'#newsListBar',fixed:"right",align:"center"}
        ]]
    });

    //添加合同
	$("#add").click(function(){
		 var index = layui.layer.open({
			id:'main',
			title:"",
			type : 2,
			anim:2,
			closeBtn:0,
			btnAlign: 'c',
			content : "add.html",
        });
        layui.layer.full(index);
        $(window).on("resize",function(){
            layui.layer.full(index);
        });
	});
    //列表操作
    table.on('tool(newsList)', function(obj){
		var layEvent = obj.event,data = obj.data;
		if(layEvent === 'edit'){ //跟进
			var amin = layer.open({
				type: 2
				,title:'添加跟进'
				,content: 'oldPact/follow.html'
				,skin:'s1 fadeInRight'
				,btnAlign: 'c'
				,shift: -1
			});
			layer.style(amin,{
				width:width,
				height:h,
				left:'auto',
				right:'0',
				top:"0"
			});
		}else if(layEvent === 'setSign'){ //预览
			var index = layui.layer.open({
				id:'detail',	
				title:false,
				type : 2,
				anim:2,
				closeBtn:0,
				btn: ['关闭'], //按钮
				btnAlign: 'c',
				content : "detail.html"
			});
			layui.layer.full(index);
			$(window).on("resize",function(){
				layui.layer.full(index);
			});
		}else if(layEvent === 'exit'){ //退款
			layer.confirm('是否确认退款？', {
				title:"提示"
				,btn: ['确认','取消'] //按钮
				,btnAlign: 'c'
			});
		}else if(layEvent === 'over'){ //退款
			layer.confirm('是否确认作废合同？', {
				title:"提示"
				,btn: ['确认','取消'] //按钮
				,btnAlign: 'c'
			});
		}
    });
 //固定Bar
  util.fixbar({
	  bgcolor: '#177ce3'
  });
});