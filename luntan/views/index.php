<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>论坛 - 首页</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->
    <style>
        .container{
            padding: 30px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <a href="<?= url('/create')?>">新建</a>
    </div>
    <hr>
    <div class="row">
        <ul class="tiezi-box">
            <li>暂无帖子。。。</li>
        </ul>
        <nav aria-label="page">
            <ul class="pager" data-page="1">
                <li><a href="javascript:getPageData(-1);">上一页</a></li>
                <li><a href="javascript:getPageData(1);">下一页</a></li>
            </ul>
        </nav>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
<script>

    getPageData(0);

    function getPageData(next){
        var page = $('.pager').data('page');
        if(next == -1){
            page--;
        }else if(next==1){
            page++;
        }
        $.getJSON('<?= url('/list')?>?page='+page, function(res){
            if(res.code == 0){
                $('.pager').data('page', res.data.page);
                var tpl = '';
                for (var i=0; i < res.data.list.length; i++ ){
                    var item = res.data.list[i];
                    tpl += '<li>'+item['id']+'. '+item['subject']+' 作者：'+item['author']
                        +' <a href="javascript:deleteRow('+item['id']+');">删除</a>'
                        +'</li>';
                }
                $(".tiezi-box").html(tpl);

            }else{
                alert(res.msg);
            }
        });
    }

    function deleteRow(id) {
        if(confirm('确定要删除吗？')){
            $.post('<?= url('/delete')?>', {id:id}, function(res){
                if(res.code == 0){
                    alert('删除成功');
                    window.location.reload();
                }else{
                    alert(res.msg);
                }
            }, 'json');

        }
    }
</script>
</body>
</html>