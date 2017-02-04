<!DOCTYPE html>
<html>
<head>
    <title>数据字典生成</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Kube CSS -->
    <link rel="stylesheet" href="kube-6.5.2/dist/css/all.min.css">
    <link rel="stylesheet" href="kube-6.5.2/dist/css/kube.demo.css">
    <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="navbar-demo" data-component="sticky" data-loaded="true">
    <div id="navbar-brand">
        <a class="h3" href="/" style="text-decoration:none;">
            Generating table
        </a>
    </div>
    <a href="dir.php" id="navbar-main" class="button round"><i class="fa fa-fw fa-database"></i>
        数据字典总库</button></a>
</div>
<!--navi-->
<main id="main" class="contents">
    <div class="row">
        <div class="col col-12">
            <form class="form" action="make.php" method="post">
                <div class="form-item">
                    <label class="label focus round">数据库地址</label>
                    <input type="text" name="host"
                           value="<?php echo isset($_COOKIE['host']) ? $_COOKIE['host'] : ''; ?>">
                    <div class="desc">例如：127.0.0.1</div>
                </div>
                <div class="form-item">
                    <label class="label focus round">数据库用户名</label>
                    <input type="text" name="usr" value="<?php echo isset($_COOKIE['usr']) ? $_COOKIE['usr'] : ''; ?>">
                    <div class="desc">例如：root</div>
                </div>
                <div class="form-item">
                    <label class="label focus round">数据库密码</label>
                    <input type="password" name="pwd"
                           value="<?php echo isset($_COOKIE['pwd']) ? $_COOKIE['pwd'] : ''; ?>">
                    <div class="desc">例如：123456</div>
                </div>
                <div class="form-item">
                    <label class="label focus round">数据库名称</label>
                    <input type="text" name="name"
                           value="<?php echo isset($_COOKIE['name']) ? $_COOKIE['name'] : ''; ?>">
                    <div class="desc">例如：test</div>
                </div>
                <div class="form-item">
                    <label class="checkbox label focus outline"><input type="checkbox" value="1"
                                                                       name="remember" <?php echo isset($_COOKIE['host']) ? 'checked' : ''; ?>>
                        记住7天</label>
                    <button class="button primary " style="float: right" type="submit">生成</button>
                </div>
            </form>
        </div>
    </div>
</main>
<!--/main-->
</body>
</html>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="kube-6.5.2/dist/js/kube.js"></script>