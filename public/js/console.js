"use strict";
layui.use(["okUtils", "table", "okCountUp", "okMock","upload"], function () {
    var countUp = layui.okCountUp;
    var table = layui.table;
    var upload = layui.upload;
    var okUtils = layui.okUtils;
    var okMock = layui.okMock;
    var $ = layui.jquery;
    okLoading.close();
    /**
     * 收入、商品、博客、用户
     */
    function statText() {
        var elem_nums = $(".stat-text");
        elem_nums.each(function (i, j) {
            var ran = parseInt(Math.random() * 99 + 1);
            !new countUp({
                target: j,
                endVal: 20 * ran
            }).start();
        });
    }

    var userSourceOption = {
        "title": {"text": ""},
        "tooltip": {"trigger": "axis", "axisPointer": {"type": "cross", "label": {"backgroundColor": "#6a7985"}}},
        "legend": {"data": ["待完成", "已结束","作废"]},
        "toolbox": {"feature": {"saveAsImage": {}}},
        "grid": {"left": "3%", "right": "4%", "bottom": "3%", "containLabel": true},
        "xAxis": [{"type": "category", "boundaryGap": false, "data": ["周一", "周二", "周三", "周四", "周五", "周六", "周日"]}],
        "yAxis": [{"type": "value"}],
        "series": [
            {"name": "待完成", "type": "line", "stack": "总量", "areaStyle": {}, "data": [120, 132, 101, 134, 90, 230, 210]},
            {"name": "已结束", "type": "line", "stack": "总量", "areaStyle": {}, "data": [220, 182, 191, 234, 290, 330, 310]},
            {"name": "作废", "type": "line", "stack": "总量", "areaStyle": {}, "data": [200, 162, 171, 214, 220, 380, 280]}
        ]
    };

    /**
     * 用户访问
     */
    function userSource() {
        var userSourceMap = echarts.init($("#userSourceMap")[0], "theme");
        userSourceMap.setOption(userSourceOption);
        okUtils.echartsResize([userSourceMap]);
    }

    upload.render({
        elem: '#upload'
        ,url: 'https://httpbin.org/post' //改成您自己的上传接口
        ,accept: 'file'
        ,ext: 'pdf|doc|docx|jpg|png|bmp'
        ,done: function(res){
          layer.msg('上传成功');
          console.log(res)
        }
      });
      

  

    statText();
    userSource();
});


