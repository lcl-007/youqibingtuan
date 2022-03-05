layui.use(['form','layer','laydate','table','laytpl','element','util'],function(){
	var form = layui.form,
	layer = parent.layer === undefined ? layui.layer : top.layer,
	laydate = layui.laydate,
	laytpl = layui.laytpl,
	element = layui.element,
	util = layui.util,
	table = layui.table;
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