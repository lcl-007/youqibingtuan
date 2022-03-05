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
      
        layui.tree({
            elem: '#demo2' //指定元素
            ,target: '_blank' //是否新选项卡打开（比如节点返回href才有效）
            ,click: function(item){ //点击节点回调
            $("input[name='fullname']").val(item.name)

            }
            ,nodes: [ //节点
                {
                    name: '总管理员'
                    ,id: 1
                    ,alias: 'changyong'
                }, {
                    name: '初级经纪人'
                    ,id: 2
                }
            ]
        });
      
	form.on('checkbox(allhome)',function (data) {
     var child = $(':checkbox[name="home"]');

     child.each(function(index, item){
         item.checked = data.elem.checked;
        if(item.checked){
               $('.lis').show();
        }else{
            $('.lis').hide();
        }
        
     });
     form.render('checkbox');
 });
 form.on('checkbox(home)',function (data) {
     var index = $(':checkbox[name="home"]').index(this);
    
  if(data.elem.checked){
    $('.lis').eq(index).show();
  }else{
    $('input:checkbox[name="allhome"]').prop("checked",false)
    $('.lis').eq(index).hide();
  }
    form.render('checkbox');
});


	$("#add").click(function(){
		var index = layui.layer.open({
				title:"添加角色",
				type : 2,
				area:['480px','220px'],
				btnAlign: 'c',
				content : "add.html"
			});
});

});

