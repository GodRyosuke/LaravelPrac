<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>家計簿</title>
</head>
<body>
<?php
    $ToMonth = 10; // 今月
    foreach($MonthDates as $MonthDate):
        $Thisyear = $MonthDate->year;
        $ThisMonth = $MonthDate->month;
        $ThisMaxDate = $MonthDate->maxDate;
?>
    <header style="margin: 30px 0;">
        <div class="header container-lg">
            <h1>こんにちは、<?php echo $authorName; ?> さん</h1>
            <h2><?php echo $Thisyear; ?>年</h2>
            <h2 class="text-right"><?php echo $ThisMonth; ?>月</h2>
            <a href="{{ route('kLogout') }}"><div class="btn btn-secondary">ログアウトする</div></a>
        </div>
    </header>

    <div class="container">
    {{ $MonthDates->links() }}
        <table class=" table table-striped">
            <thead class="thead">
                <tr>
                    <th>日</th>
                    <th>1日のお金の動き</th>
                    <th>残高</th>
                    <th></th>
                    <!-- <th>何に？</th>
                    <th>残高</th>
                    <th>メモ</th>
                    <th></th> -->
                </tr>
            </thead>
            <tbody class="tbody">
<?php
    for($date = 1; $date <= $ThisMaxDate; $date++):
        $ThisKakeibos = $Kakeibo->filter(function ($kb) use ($ThisMonth, $date, $authorID, $Thisyear) { // $month 月 $date日 の$authorIDの家計簿
            return ($kb->month == $ThisMonth) && ($kb->day == $date) && ($kb->author_id == $authorID) && ($kb->year == $Thisyear);
        });
        $sumDiff = 0;
        $ThisSavings = 0;
        foreach($ThisKakeibos as $ThisKakeibo) {
            $sumDiff += $ThisKakeibo->diff;
            $ThisSavings = $ThisKakeibo->savings;
        }
?>
                <tr>
                    <th><?php echo $date; ?></th>
                    <td><?php 
                    if ($sumDiff > 0) {
                        echo '+'.$sumDiff;
                    } else {
                        echo $sumDiff;
                    }
                    ?></td>
                    <td><?php echo $ThisSavings; ?></td>
                    <td>
                        <a href="#additional<?php echo $date; ?>" class="btn btn-primary"data-toggle="collapse">詳細</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="collapse" id="additional<?php echo $date; ?>">
                            <table class="table table-stripped">
                                <thead class="thead">
                                    <tr>
                                        <th>何に？</th>
                                        <th>どれだけ？</th>
                                        <th>メモ</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                <?php
                                    foreach($ThisKakeibos as $ThisKakeibo):
                                ?>
                                    <tr>
                                        <td><?php echo $ThisKakeibo->what; ?></td>
                                        <td><?php echo $ThisKakeibo->diff; ?></td>
                                        <td><?php echo $ThisKakeibo->memo; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <form action="{{ route('add') }}" method="post" name="addMoney">
                            {{ csrf_field() }}
                                <input type="text" name="year" value="<?php echo $Thisyear; ?>" style="display: none;">
                                <input type="text" name="authorID" value="<?php echo $authorID ?>" style="display: none;">
                                <input type="text" name="month" value="<?php echo $ThisMonth; ?>" style="display: none;">
                                <input type="text" name="day" value="<?php echo $date; ?>" style="display: none;">
                                <input type="text" name="what" placeholder='何に使用しましたか？'>に
                                <input type="text" name="diff" placeholder='金額はいくらですか？'>円
                                <select name="PlusMinus">
                                    <option value="plus">貯金しました</option>
                                    <option value="minus">消費しました</option>
                                </select>
                                <textarea name="memo" id="" cols="30" rows="10" placeholder='メモ'></textarea>
                                <button class="btn btn-primary" type="submit" value="send" name="action">登録する</button>
                            </form>
                        </div>
                    </td>
                </tr>
    <?php endfor; ?>
            </tbody>
        </table>
        {{ $MonthDates->links() }}
    </div>

        <?php endforeach; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>