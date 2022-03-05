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
						var getTplForm3 = formBox3.innerHTML
						var getTplForm4 = formBox4.innerHTML
						var getTplForm5 = formBox5.innerHTML
						var getTplForm6 = formBox6.innerHTML
						var getTplForm7 = formBox7.innerHTML
						var getTplForm8 = formBox8.innerHTML
						var getTplForm9 = formBox9.innerHTML
						var getTplForm10 = formBox10.innerHTML
						var getTplForm11 = formBox11.innerHTML
						var	viewForm = document.getElementById('viewForm');
						if(item.disabled == true){
							
						}else if(item.id == 11){
                	laytpl(getTplForm).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
						}else if(item.id == 12){
                	laytpl(getTplForm1).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
						}else if(item.id == 13){
                	laytpl(getTplForm2).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
					}else if(item.id == 21){
                	laytpl(getTplForm3).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
					}else if(item.id == 22){
                	laytpl(getTplForm4).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
					}else if(item.id == 23){
                	laytpl(getTplForm5).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
					}else if(item.id == 31){
                	laytpl(getTplForm6).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
					}else if(item.id == 32){
                	laytpl(getTplForm7).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
					}else if(item.id == 33){
                	laytpl(getTplForm8).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
					}else if(item.id == 34){
                	laytpl(getTplForm9).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
					}else if(item.id == 41){
                	laytpl(getTplForm10).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
					}else if(item.id == 42){
                	laytpl(getTplForm11).render(data, function(html){
                    viewForm.innerHTML = html;
                });

                form.render(null, 'component-form-element');
                element.render('breadcrumb', 'breadcrumb');
					}

            }
            ,nodes: [ //节点
                { name: '合同管理'
                    ,id: 1
                 
                }
            ]
        });


        form.on('submit(component-form-element)', function(data){
            layer.msg(JSON.stringify(data.field));
            return false;
        });



});

