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
        <a href="javascript:history.go(-1);">返回列表</a>
    </div>
    <hr>
    <div class="row">
        <form id="postForm">
            <div class="form-group">
                <label>主题</label>
                <input type="text" name="subject" required class="form-control">
            </div>

            <div class="form-group">
                <label>作者</label>
                <input type="text" name="author" required class="form-control">
            </div>


            <div class="form-group">
                <label>作者</label>
                <textarea name="body" class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">发表</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
<script>
    $('#postForm').submit(function(){
        var data = $(this).serialize();
        $.post('<?= url('save')?>', data, function(res){
            if(res.code == 0){
                alert('发表成功');
                //window.location.href = '<?= url('/')?>';
                history.go(-1)
            }else{
                alert(res.msg);
            }
        }, 'json');

        return false;
    });
</script>
</body>
</html>