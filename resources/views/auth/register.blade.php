<!DOCTYPE html>
<html lang="ja"">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録</title>
</head>
<body>
    <form action="/auth/register" name="registform" method="post">
        {{ csrf_field() }}
        <div class="name">
            名前: <input type="text" name="name">
            <span>{{ $errors->first('name') }}</span>
        </div>
        <div class="mail">
            メールアドレス: <input type="text" name="email">
            <span>{{ $errors->first('email') }}</span>
        </div>
        <div class="password">
            パスワード: <input type="password" name="password">
            <span>{{ $errors->first('password') }}</span>
        </div>
        <div class="password_confirm">
            パスワード: <input type="password" name="password_confirmation">
            <span>{{ $errors->first('password_confirmation') }}</span>
        </div>
        <button type="submit" name="action" value="send">送信</button>
    </form>
</body>
</html>