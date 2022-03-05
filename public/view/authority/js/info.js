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
                var getTplForm = formBox.innerHTML,viewForm = document.getElementById('viewForm');
                laytpl(getTplForm).render(data, function(html){
                    viewForm.innerHTML = html;
                });
                form.render(null, 'component-form-element');

            }
            ,nodes: [ //节点
							{ name: '房源管理'
                    ,id: 1
							,disabled:true
                    ,spread: true
							 ,children: [
                        {
									name: '房源操作'
									,id: 11
                       }, {
									name: '基本信息'
									,id: 12
                       }, {
									name: '其他信息'
									,id: 13
                       }
                    ]
                },{ name: '客源管理'
                    ,id: 2
							,disabled:true
                    ,spread: true
							 ,children: [
                        {
									name: '客源操作'
									,id: 21
                       }, {
									name: '基本信息'
									,id: 22
                       }, {
									name: '其他信息'
									,id: 23
                       }
                    ]
                },{ name: '业务管理'
                    ,id: 3
							,disabled:true
                    ,spread: true
							 ,children: [
                        {
									name: '合同管理'
									,id: 31
                       }, {
									name: '财务管理'
									,id: 32
                       }, {
									name: '业务管理'
									,id: 33
                       }, {
									name: '办件'
									,id: 34
                       }
                    ]
                },{ name: '系统管理'
                    ,id: 4
							,disabled:true
                    ,spread: true
							 ,children: [
                        {
									name: '其他设置'
									,id: 41
                       },{
									name: '楼盘字典'
									,id: 42
                       }
                    ]
                }
            ]
        });
form.on('select(business)', function(data){
	var value = data.value
	var html = '<label class="layui-form-label">岗位：</label> \
				<div class="layui-input-block block"> \
					<select id="gw"></select> \
				</div>'
	var html1 = '<div class="layui-inline"> \
      <label class="layui-form-label">员工</label> \
      <div class="layui-input-inline" style="width: 120px;"> \
       	<select id="bm"></select> \
      </div> \
      <div class="layui-form-mid">-</div> \
      <div class="layui-input-inline" style="width: 120px;"> \
        	<select id="yg"></select> \
      </div> \
    </div>'
		if(value == 1){
			$("#choose").html(html);
		}else if(value == 2){
			$("#choose").html(html1);
		}
    form.render();

})

        form.on('submit(component-form-element)', function(data){
            layer.msg(JSON.stringify(data.field));
            return false;
        });



});

