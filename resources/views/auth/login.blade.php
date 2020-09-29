<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
    <div class="loginCon">
        <h1>ログインフォーム</h1>
        @isset($message)
            <p style="color:red">{{ $message }}</p>
        @endisset
        <form action="/auth/login" name="loginform" method="post">
            {{ csrf_field() }}
            メールアドレス: <input type="text" name="email" value="{{ old('email') }}">
            パスワード: <input type="password" name="password">
            <button type="submit" name="action" vlaue="send">ログイン</button>
        </form>
    </div>
</body>
</html>