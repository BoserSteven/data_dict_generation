<?php
/**
 * 遍历当前目录
 * Created by PhpStorm.
 * User: boser
 * Date: 2017/2/4
 * Time: 15:05
 */
function listDir($dir)
{
    $files = '';
    if(is_dir($dir))
    {
        if ($dh = opendir($dir))
        {
            while (($file = readdir($dh)) !== false)
            {
                if((is_dir($dir."/".$file)) && $file!="." && $file!="..")
                {
                    echo "<b><font color='red'>目录：</font></b>",$file,"<br><hr>";
                    listDir($dir."/".$file."/");
                }
                else
                {
                    if($file!="." && $file!="..")
                    {
                        $files .= '<div class="col col-3"><a href="' . $dir . '/' . $file . '" class="button success"><i class="fa fa-fw fa-database"></i>'.$file.'</a></div>';
                    }
                }
            }
            closedir($dh);
        }
    }
    return $files;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Kube CSS -->
    <link rel="stylesheet" href="kube-6.5.2/dist/css/all.min.css">
    <link rel="stylesheet" href="kube-6.5.2/dist/css/kube.demo.css">
    <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>数据字典总库</title>
    <style>
        header{
            height: 50px;
            background: #000;
            margin-bottom: 10px;
            text-align:center;
            line-height: 50px;
        }
        .col{
            margin-top:10px;
        }
    </style>
</head>
<body>
<header>
    <a href="/" class="button">返回首页</a>
</header>
<main id="main" class="contents">
    <div class="row">
        <?php echo listDir("table"); ?>
    </div>
</main>
</body>
</html>
