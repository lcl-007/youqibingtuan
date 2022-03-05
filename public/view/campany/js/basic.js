layui.use(['form','layer','laydate','table','laytpl','element','util','laypage','tree'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        laydate = layui.laydate,
			tree = layui.tree,
			laypage = layui.laypage,
        laytpl = layui.laytpl,
			element = layui.element,
			util = layui.util,
        table = layui.table;
//仅节点左侧图标控制收缩
var data1 = [{
    title: '合同管理'
	,id: 1
	,spread: true
    ,children: [{
      title: '200'
	  ,id: 1000
	  ,spread: true
      ,children: [{
        title: '房产抵押'
        ,id: 10001
      }]
  }]
}]
tree.render({
    elem: '#demo2'
    ,data: data1
    ,onlyIconControl: true  //是否仅允许节点左侧图标控制展开收缩
    ,click: function(obj){
      layer.msg(JSON.stringify(obj.data));
    }
  });

var tableIns = table.render({
        elem: '#LAY-app-table-all',
        url : 'json/newsList.json',
        cellMinWidth : 95,
        page : true,
        height : "auto",
        limit : 20,
        limits : [10,15,20,25],
        cols : [[
				{field:'area',title: '编号',align:"center"},
				{field:'shop',title: '选项',align:'center'},
				{title: '操作',templet:'#newsListBar',align:"center"}
        ]]
    });
	$("#add").click(function(){
		var index = layui.layer.open({
				title:"添加选项",
				type : 2,
				area:['480px','320px'],
				btnAlign: 'c',
				content : "area.html",
			});

});
	  //列表操作
    table.on('tool(LAY-app-table-all)', function(obj){
		var layEvent = obj.event,data = obj.data;
		if(layEvent === 'edit'){ //跟进
		var index = layui.layer.open({
				title:"修改选项",
				type : 2,
				area:['480px','320px'],
				btnAlign: 'c',
				content : "area.html",
			});
		}else if(layEvent === 'del'){ //预览
			layer.confirm('是否删除？', {
				  btn: ['是','否'] //按钮
				}, function(){
				  layer.msg('的确很重要', {icon: 1});
				});

		}
    });
});

