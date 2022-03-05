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
						var data = item;
                var getTplForm = formBox.innerHTML
						var getTplForm1 = formBox1.innerHTML
						var getTplForm2 = formBox2.innerHTML
						var	viewForm = document.getElementById('viewForm');
						if(item.disabled == true){
							
						}else if(item.id == 21){
                	laytpl(getTplForm).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
						}else if(item.id == 22){
                	laytpl(getTplForm1).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
						}else if(item.id == 2){
                	laytpl(getTplForm2).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
					}

            }
            ,nodes: [ //节点
							{
									name: '房源管理'
									,id: 21
					   }, {
									name: '客源管理'
									,id: 22
					   }, {
									name: '系统设置'
									,id: 2
					   }
            ]
        });

        form.on('submit(component-form-element)', function(data){
            layer.msg(JSON.stringify(data.field));
            return false;
        });



});

