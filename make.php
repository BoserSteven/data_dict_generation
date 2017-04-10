<?php
/**
 * 生成数据表字典
 * Created by PhpStorm.
 * User: boser
 * Date: 2017/2/3
 * Time: 16:25
 */
/**
 * 生成mysql数据字典
 */
// 配置数据库
$database = array();
$database['DB_HOST'] = $_POST['host'];
$database['DB_NAME'] = $_POST['name'];
$database['DB_USER'] = $_POST['usr'];
$database['DB_PWD'] = $_POST['pwd'];
//是否记住7天
$rem = isset($_POST['remember']) ? $_POST['remember'] : 0;
if ($rem) {
    setcookie('host', $database['DB_HOST'], time() + 3600 * 24 * 7);
    setcookie('name', $database['DB_NAME'], time() + 3600 * 24 * 7);
    setcookie('usr', $database['DB_USER'], time() + 3600 * 24 * 7);
    setcookie('pwd', $database['DB_PWD'], time() + 3600 * 24 * 7);
} else {
    setcookie('host', $database['DB_HOST'], time() - 3600 * 24 * 7);
    setcookie('name', $database['DB_NAME'], time() - 3600 * 24 * 7);
    setcookie('usr', $database['DB_USER'], time() - 3600 * 24 * 7);
    setcookie('pwd', $database['DB_PWD'], time() - 3600 * 24 * 7);
}

date_default_timezone_set('Asia/Chongqing');

$mysql_conn = mysqli_connect("{$database['DB_HOST']}", "{$database['DB_USER']}", "{$database['DB_PWD']}") or die("数据库连接失败");

mysqli_select_db($mysql_conn, $database['DB_NAME']);

$result = $mysql_conn->query('show tables');
$mysql_conn->query('SET NAME UTF8');
// 取得所有表名
while ($row = mysqli_fetch_array($result)) {
    $tables[]['TABLE_NAME'] = $row[0];
}

// 循环取得所有表的备注及表中列消息
foreach ($tables as $k => $v) {
    $sql = 'SELECT * FROM ';
    $sql .= 'INFORMATION_SCHEMA.TABLES ';
    $sql .= 'WHERE ';
    $sql .= "table_name = '{$v['TABLE_NAME']}' AND table_schema = '{$database['DB_NAME']}'";
    $table_result = $mysql_conn->query($sql);
    while ($t = mysqli_fetch_array($table_result)) {
        $tables[$k]['TABLE_COMMENT'] = $t['TABLE_COMMENT'];
    }
    $sql = 'SELECT * FROM ';
    $sql .= 'INFORMATION_SCHEMA.COLUMNS ';
    $sql .= 'WHERE ';
    $sql .= "table_name = '{$v['TABLE_NAME']}' AND table_schema = '{$database['DB_NAME']}'";

    $fields = array();
    $field_result = $mysql_conn->query($sql);
    while ($t = mysqli_fetch_array($field_result)) {
        $fields[] = $t;
    }
    $tables[$k]['COLUMN'] = $fields;
}
mysqli_close($mysql_conn);
$for = $for_table = '';
// 循环所有表
foreach ($tables as $k => $v) {
    if ($v['TABLE_NAME']) {
        $for_table .= '<li><a href="#' . $v['TABLE_NAME'] . '">' . $v['TABLE_NAME'] . str_repeat("&nbsp;", 10) . $v['TABLE_COMMENT'] . '</a></li>';
        $for .= '<div class="col col-12" id="' . $v['TABLE_NAME'] . '">';
        $for .= '<fieldset class="contents">';
        $for .= '<legend><a href="#" class="label upper focus">表名：' . $v['TABLE_NAME'] . ' - - ' . $v['TABLE_COMMENT'] . ' <i class="fa fa-fw fa-link" style="display: none"></i></a></legend>';
        $for .= '<table class="bordered striped">';
        $for .= '<tr>';
        $for .= '<th>字段名</th>';
        $for .= '<th>数据类型</th>';
        $for .= '<th>默认值</th>';
        $for .= '<th>允许非空</th>';
        $for .= '<th>自动递增</th>';
        $for .= '<th>备注</th>';
        $for .= '</tr>';
        foreach ($v['COLUMN'] AS $f) {
            $for .= '<tr>';
            $for .= '<td>' . $f['COLUMN_NAME'] . '</td>';
            $for .= '<td>' . $f['COLUMN_TYPE'] . '</td>';
            $for .= '<td>' . $f['COLUMN_DEFAULT'] . '</td>';
            $for .= '<td>' . $f['IS_NULLABLE'] . '</td>';
            $for .= '<td>' . ($f['EXTRA'] == 'auto_increment' ? '是' : ' ') . '</td>';
            $for .= '<td>' . $f['COLUMN_COMMENT'] . '</td>';
            $for .= '</tr>';
        }
        $for .= '</table>';
        $for .= '</fieldset>';
        $for .= '</div>';
    }
}
// 输出
$head = '<!DOCTYPE html>
<html>
<head>
    <title>Basic Template</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Kube CSS -->
    <link rel="stylesheet" href="../kube-6.5.2/dist/css/all.min.css">
    <link rel="stylesheet" href="../kube-6.5.2/dist/css/kube.demo.css">
    <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head><body>';
$header = '<header id="navbar-demo" data-component="sticky" data-loaded="true">
    <div id="navbar-brand">
        <a class="h3" href="/" style="text-decoration:none;">
            数据字典 <label class="label black">' . $database['DB_NAME'] . '</label> 生成时间 <label class="label black">' . date('Y-m-d', time()) . '</label>
            总共 <label class="label black">' . count($tables) . '</label> 张数据表
        </a>
    </div>
</header>';
$main = '<main id="main">
    <div class="row">
        <div class="col col-12">
            <nav id="contents">
                <ol>
                    ' . $for_table . '
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        ' . $for . '
    </div>
</main>';
$footer = '<footer>
    <a class="top" href="#"><i class="fa fa-angle-up fa-2x"></i><span style="display: none">返回<br>顶部</span></a>
    <i class="fa fa-fw fa-copyright"></i> 版权所有 编写 - - boser 2017/2/4
</footer>
</body>
</html>
<script src="../js/jquery-2.1.4.min.js"></script>
<script src="../kube-6.5.2/dist/js/kube.js"></script>';
file_put_contents('table/' . $database['DB_NAME'] . '.html', $head . $header . $main . $footer);
if (file_exists('table/' . $database['DB_NAME'] . '.html') && file_get_contents('table/' . $database['DB_NAME'] . '.html')) {
    header('Location:table/' . $database['DB_NAME'] . '.html');
} else {
    echo '<div style="width:200px;height: 50px;line-height:50px;text-align:center;font-family:Microsoft YaHei;font-size:20px;">生成失败 <a href="localhost/table_live/" style="font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
    font-size: 15px;
    color: #fff;
    background-color: #1c86f2;
    border-radius: 3px;
    min-height: 40px;
    padding: 8px 20px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    display: inline-block;
    line-height: 20px;
    border: 1px solid transparent;
    vertical-align: middle;
    -webkit-appearance: none;">点击重试</a></div>';
}

