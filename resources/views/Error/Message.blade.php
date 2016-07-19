<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>提示 - {{ $config['web_name'] }}</title>

    <style type="text/css">
        body {
            font-size: 14px;
            color: #777777;
            font-family: arial;
            text-align: center;
        }

        h1 {
            font-size: 180px;
            color: #99A7AF;
            margin: 70px 0 0 0;
        }

        h2 {
            color: #DE6C5D;
            font-family: arial;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: -1px;
            margin: -3px 0 39px;
        }

        p {
            width: 375px;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            margin-top: 30px
        }

        div {
            width: 375px;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }

        a:link {
            color: #34536A;
            text-decoration: none;
        }

        a:visited {
            color: #34536A;
        }

        a:active {
            color: #34536A;
        }

        a:hover {
            color: #34536A;
        }
    </style>
</head>
<body>
<h1>{{ $code }}</h1>
<h2>{{ $message }}</h2>
<div>
    <a href="/">首页</a> 或者 <a href="javascript:history.go(-1)">上一步</a>
</div>
</body>
</html>

