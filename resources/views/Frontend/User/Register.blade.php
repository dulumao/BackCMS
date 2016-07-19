<form method="post">
    {{ csrf_field() }}
    用户名
    <input type="text" name="username"><br>
    密码
    <input type="text" name="password"><br>
    email
    <input type="text" name="email"><br>
    昵称
    <input type="text" name="nickname"><br>
    手机
    <input type="text" name="phone">
    <input type="submit">
</form>