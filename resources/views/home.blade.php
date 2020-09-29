<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>はじめてのLaravel</title>
</head>
<body>
    <div class="helloCon">
        <h1>Hello!</h1>
        @if (Auth::check())
            {{ \Auth::user()->name }}さん
            <a href="{{ route('logout') }}">ログアウト</a>
            <a href="{{ route('database') }}">データベース管理</a>
        @else 
            <p>ゲストさん</p>
            <a href="{{ route('login') }}">ログイン</a>
            <a href="{{ route('register') }}">会員登録</a>
        @endif
    </div>
</body>
</html>