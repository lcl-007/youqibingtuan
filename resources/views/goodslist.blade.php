<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>用户列表</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="../../css/oksub.css">
	<script type="text/javascript" src="../../lib/loading/okLoading.js"></script>
</head>
<body>
<div class="ok-body">
	<!--模糊搜索区域-->
	<div class="layui-row">
		<form class="layui-form layui-col-md12 ok-search">
			<input class="layui-input" placeholder="开始日期" autocomplete="off" id="startTime" name="startTime">
			<input class="layui-input" placeholder="截止日期" autocomplete="off" id="endTime" name="endTime">
			<input class="layui-input" placeholder="编号" autocomplete="off" name="username">
			<button class="layui-btn" lay-submit="" lay-filter="search">
				<i class="layui-icon">&#xe615;</i>
			</button>
		</form>
	</div>
	<!--数据表格-->
	<table class="layui-hide" id="tableId" lay-filter="tableFilter"></table>
</div>
<!--js逻辑-->
<script src="../../lib/layui/layui.js"></script>
<script>
	layui.use(["element", "jquery", "table", "form", "laydate", "okLayer", "okUtils", "okMock"], function () {
		let table = layui.table;
		let form = layui.form;
		let laydate = layui.laydate;
		let okLayer = layui.okLayer;
		let okUtils = layui.okUtils;
		let okMock = layui.okMock;
		let $ = layui.jquery;

		laydate.render({elem: "#startTime", type: "datetime"});
		laydate.render({elem: "#endTime", type: "datetime"});
		okLoading.close($);
		let userTable = table.render({
			elem: '#tableId',
			url: '../../data/list.json',
			limit: 20,
			cellMinWidth: 80,
			page: true,
			toolbar: true,
			toolbar: "#toolbarTpl",
			size: "sm",
			cols: [[
				{type: "checkbox", fixed: "left"},
				{field: "id", title: "编号"},
				{field: "name", title: "文件名"},
				{field: "startname", title: "发起方"},
				{field: "writename", title: "签署方"},
				{field: "time", title: "发起时间"},
				{title: "操作", align: "center", fixed: "right", templet: "#operationTpl"}
			]],
			done: function (res, curr, count) {
				console.info(res, curr, count);
			}
		});

		form.on("submit(search)", function (data) {
			userTable.reload({
				where: data.field,
				page: {curr: 1}
			});
			return false;
		});

		table.on("toolbar(tableFilter)", function (obj) {
			switch (obj.event) {
				case "batchEnabled":
					batchEnabled();
					break;
				case "batchDisabled":
					batchDisabled();
					break;
				case "batchDel":
					batchDel();
					break;
				case "add":
					add();
					break;
			}
		});

		table.on("tool(tableFilter)", function (obj) {
			let data = obj.data;
			switch (obj.event) {
				case "edit":
					edit(data);
					break;
				case "del":
					del(data.id);
					break;
			}
		});

		function batchEnabled() {
			okLayer.confirm("确定要批量启用吗?", function (index) {
				layer.close(index);
				let idsStr = okUtils.tableBatchCheck(table);
				if (idsStr) {
					okUtils.ajax("/user/normalUser", "put", {idsStr: idsStr}, true).done(function (response) {
						console.log(response);
						okUtils.tableSuccessMsg(response.msg);
					}).fail(function (error) {
						console.log(error)
					});
				}
			});
		}

		function batchDisabled() {
			okLayer.confirm("确定要批量停用吗?", function (index) {
				layer.close(index);
				let idsStr = okUtils.tableBatchCheck(table);
				if (idsStr) {
					okUtils.ajax("/user/stopUser", "put", {idsStr: idsStr}, true).done(function (response) {
						console.log(response);
						okUtils.tableSuccessMsg(response.msg);
					}).fail(function (error) {
						console.log(error)
					});
				}
			});
		}

		function batchDel() {
			okLayer.confirm("确定要批量删除吗?", function (index) {
				layer.close(index);
				let idsStr = okUtils.tableBatchCheck(table);
				if (idsStr) {
					okUtils.ajax("/user/deleteUser", "delete", {idsStr: idsStr}, true).done(function (response) {
						console.log(response);
						okUtils.tableSuccessMsg(response.msg);
					}).fail(function (error) {
						console.log(error)
					});
				}
			});
		}

		function add() {
		
		}

		function edit(data) {
		
			var index = layui.layer.open({
						id:'main',
						title:"",
						type : 2,
						anim:2,
						area:["90%","90%"],
						closeBtn:0,
						btnAlign: 'c',
						content : "add.html",
					});
					layui.layer.full(index);
					$(window).on("resize",function(){
						layui.layer.full(index);
					});
		}

		function del(id) {
			okLayer.confirm("确定要删除吗?", function () {
				okUtils.ajax("/user/deleteUser", "delete", {idsStr: id}, true).done(function (response) {
					console.log(response);
					okUtils.tableSuccessMsg(response.msg);
				}).fail(function (error) {
					console.log(error)
				});
			})
		}
	})
</script>
<!-- 头工具栏模板 -->
<script type="text/html" id="toolbarTpl">
	<div class="layui-btn-container">
		
	</div>
</script>
<!-- 行工具栏模板 -->
<script type="text/html" id="operationTpl">
	<a href="javascript:" title="编辑" lay-event="edit"><i class="layui-icon">&#xe642;</i></a>
	<a href="javascript:" title="删除" lay-event="del"><i class="layui-icon">&#xe640;</i></a>
</script>
<!-- 启用|停用模板 -->

</body>
</html>
