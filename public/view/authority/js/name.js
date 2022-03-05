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
//                $('#demo2-view').html('当前节名称：'+ item.name + '<br>全部参数：'+ JSON.stringify(item));

                var data = item;
                var getTplForm = formBox.innerHTML,viewForm = document.getElementById('viewForm');
                laytpl(getTplForm).render(data, function(html){
                    viewForm.innerHTML = html;
                });
                form.render(null, 'component-form-element');
               

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
     });
     form.render('checkbox');
 });
form.on('checkbox(allman)',function (data) {
     var child = $(':checkbox[name="man"]');

     child.each(function(index, item){
         item.checked = data.elem.checked;
     });
     form.render('checkbox');
 });
	form.on('checkbox(allqy)',function (data) {
     var child = $(':checkbox[name="write"]');

     child.each(function(index, item){
         item.checked = data.elem.checked;
     });
     form.render('checkbox');
 });
form.on('checkbox(allcw)',function (data) {
     var child = $(':checkbox[name="mony"]');

     child.each(function(index, item){
         item.checked = data.elem.checked;
     });
     form.render('checkbox');
 });
		form.on('checkbox(allbj)',function (data) {
     var child = $(':checkbox[name="bj"]');

     child.each(function(index, item){
         item.checked = data.elem.checked;
     });
     form.render('checkbox');
 });
		form.on('checkbox(allset)',function (data) {
     var child = $(':checkbox[name="set"]');

     child.each(function(index, item){
         item.checked = data.elem.checked;
     });
     form.render('checkbox');
 });
	form.on('checkbox(allzz)',function (data) {
     var child = $(':checkbox[name="zz"]');

     child.each(function(index, item){
         item.checked = data.elem.checked;
     });
     form.render('checkbox');
 });
form.on('checkbox(allqx)',function (data) {
     var child = $(':checkbox[name="qx"]');

     child.each(function(index, item){
         item.checked = data.elem.checked;
     });
     form.render('checkbox');
 });
	form.on('checkbox(alllp)',function (data) {
     var child = $(':checkbox[name="lp"]');

     child.each(function(index, item){
         item.checked = data.elem.checked;
     });
     form.render('checkbox');
 });
        form.on('submit(component-form-element)', function(data){
            layer.msg(JSON.stringify(data.field));
            return false;
        });
$("body").on("click",".qx",function(){
	var index = layui.layer.open({
				title : "权限设置",
				type : 2,
				content : "index1.html",
				success : function(layero, index){
					setTimeout(function(){
						layui.layer.tips('点击此处返回首页面', '.layui-layer-setwin .layui-layer-close', {
							tips: 3
						});
					},500)
				}
			})			
			layui.layer.full(index);
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

