<form method="post">
    {{ csrf_field() }}
    用户名
    <input type="text" name="username">
    密码
    <input type="text" name="password">
    <input type="submit">
</form>