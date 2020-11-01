<!DOCTYPE html>
<html lang="ja"">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>家計簿にようこそ！</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <header class="container">
    <h1><span class="text-primary">無料</span>家計簿アプリ!!</h1>
    </header>
    <div class="container">
        <div class="card" style="padding: 20px;">
            <h3>新規登録</h3>
            <form action="{{ route('kRegister') }}" name="registform" method='post' class="form">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">名前</label>
                    <input type="text" class="form-control <?php if($errors->has('name')){ echo 'is-invalid'; } ?>" id="name" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                    <div class="alert alert-danger">
                    <?php foreach($errors->get('name') as $error): ?>
                        <?php echo $error; ?>
                    <?php endforeach; ?>
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="text" class="form-control <?php if($errors->has('email')){ echo 'is-invalid'; } ?>" id="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}">
                    <?php
                    if ($errors->has('email')):
                    ?>
                    <div class="alert alert-danger">
                    <?php foreach($errors->get('email') as $error): ?>
                        <?php echo $error; ?>
                    <?php endforeach; ?>
                    </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control <?php if($errors->has('password')){ echo 'is-invalid'; } ?>" id="password" name="password" value="{{ old('password') }}">
                    @if ($errors->has('password'))
                    <div class="alert alert-danger">
                    <?php foreach($errors->get('password') as $error): ?>
                        <?php echo $error; ?>
                    <?php endforeach; ?>
                    </div>
                    @endif
                </div>
                <button class="btn btn-danger" type="submit" name="action" value="send">送信</button>
            </form>
            <p>会員の方は<a href="{{ route('showLogin') }}">こちら</a>から</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>