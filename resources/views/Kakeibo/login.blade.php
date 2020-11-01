<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <p>
        家計簿にログインする
    </p>

    <div class="container">
        <h1>ログインフォーム</h1>
        <div class="card" style="padding: 20px;">
            <form action="{{ route('login') }}" name="loginform" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                <?php if (isset($errorflg)): ?>
                    <div class="alert alert-danger">ログインできませんでした。名前、パスワードが正しいか確認してください</div>
                <?php endif; ?>
                    <label for="name">名前</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                    <div class="alert alert-danger">
                    <?php foreach($errors->get('name') as $error): ?>
                        <?php echo $error; ?>
                    <?php endforeach; ?>
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                    @if ($errors->has('password'))
                    <div class="alert alert-danger">
                    <?php foreach($errors->get('password') as $error): ?>
                        <?php echo $error; ?>
                    <?php endforeach; ?>
                    </div>
                    @endif
                </div>
                <!-- username: <input type="text" name="name">
                パスワード: <input type="password" name="password"> -->
                <button type="submit" class="btn btn-primary name="action" vlaue="send">ログイン</button>
            </form>
        </div>
    </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>