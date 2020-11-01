<?php

namespace App\Http\Controllers;

use App\Kakeibo;
use App\MonthDate;
use App\Rules\cantlogin;
use App\KakeiboAuth;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;

class KakeiboController extends Controller
{
    public function index(Request $request) {
        if ($request->session()->has('username')) {
            $Kakeibo = Kakeibo::all();
            $MonthDates = DB::table('month_date')->orderByRaw('year, month')->paginate(1);
            $username = $request->session()->get('username'); // 現在ログイン中のユーザー名
            $author = DB::table('kakeibo_auth')->whereRaw('name=?', [$username])->first();
            $authorID = $author->id;
            $authorName = $author->name;
            // $Kakeibo = DB::table('kakeibo')->whereRaw('author_id=?', [$authorID]);
            return view ('Kakeibo.index', compact('MonthDates', 'Kakeibo', 'authorID', 'authorName'));
        } 
        return redirect('/');
    }

    public function add(Request $request) // 情報を追加する
    {
        // --- お金の変動が正か負かを決める ---
        $diff = $request->diff;
        if ($request->PlusMinus == "minus") {
            $diff *= -1;
        }

        // --- 残高計算 ---
        // 今日の家計簿データを取得
        $Kakeibo = Kakeibo::all();
        $ToYear = $request->year;
        $ToMonth = $request->month;
        $today = $request->day;
        $authorID = $request->authorID;
        $ThisKakeibos = $Kakeibo->filter(function ($kb) use ($ToMonth, $today, $authorID, $ToYear) { // 更新があった家計簿データ
            return ($kb->day == $today) && ($kb->month == $ToMonth) && ($kb->author_id == $authorID) && ($kb->year == $ToYear);
        });
        $savings = 0;
        // 直近の家計簿の記録から過去の残高をもとめる
        $yesSavings = 0; // 残高
        $DlastDay = 1;
        $ThisDay = $today - $DlastDay;
        $ThisMonth = $ToMonth;
        $ThisYear = $ToYear;
        $dayArray = array();
        for (;$DlastDay <= 1000; $ThisDay -= 1, $DlastDay++) { // MAX 1000 日前までさかのぼる
            if ($ThisDay == 0) { // 月をまたぐ場合
                $ThisMonth -= 1;
                if ($ThisMonth <= 0) { // 年をまたぐ場合
                    $ThisYear -= 1;
                    $ThisMonth = 12;
                }
                // ThisYear年 ThisMonth月 の最大日数
                $lastMonths = DB::table('month_date')->whereRaw('(year=?)and(month=?)', [$ThisYear, $ThisMonth])->first();
                array_push($dayArray, $lastMonths);
                if (isset($lastMonths)) {
                    $ThisDay = $lastMonths->maxDate;
                } else { // まだ登録されていない場合
                break;
                }
            }
            $lastKakeibo = DB::table('kakeibo')->whereRaw('(author_id=?)and(year=?)and(day=?)and(month=?)', [$request->authorID,$ThisYear,  $ThisDay, $ThisMonth])->first(); // 家計簿の記録が残っている直近の日
            if (!empty($lastKakeibo)) {
                $yesSavings = $lastKakeibo->savings;
                break;
            }
        }


        // 今日のお金の総変動を求める
        $sumDiff = 0;
        foreach($ThisKakeibos as $ThisKakeibo) {
            $sumDiff += $ThisKakeibo->diff;
        }
        $sumDiff += $diff;
        // 残高計算
        $savings = $yesSavings + $sumDiff;
        // return view ('Kakeibo.test', compact('savings', 'yesSavings', 'dayArray'));
        // 今日の残高を更新
        DB::table('kakeibo')->whereRaw('(author_id=?)and(year=?)and(day=?)and(month=?)', [$request->authorID, $ToYear, $today, $ToMonth])->update(['savings' => $savings]);
        // データベースに登録
        Kakeibo::create([
            'author_id' => $request->authorID,
            'year' => $request->year,
            'month' => $request->month,
            'day' => $request->day,
            'diff' => $diff,
            'what' => $request->what,
            'savings' => $savings,
            'memo' => $request->memo,
        ]);
        // 今日以降の残高を更新
        $FutureKakeibos = DB::table('kakeibo')->whereRaw('(author_id=?)and(((month=?)&(day>?))or((year=?)and(month>?))or(year>?))', [$request->authorID, $ToMonth, $today, $ToYear, $ToMonth, $ToYear])->get();
        foreach($FutureKakeibos as $FutureKakeibo) {
            $futuresavings = $FutureKakeibo->savings;
            $futuresavings += $diff;
            DB::table('kakeibo')->whereRaw('(author_id=?)and(year=?)and(month=?)&(day=?)', [$request->authorID,$FutureKakeibo->year, $FutureKakeibo->month, $FutureKakeibo->day])->update(['savings' => $futuresavings]);
        }
      

        return redirect("/kakeibo");
    }

    public function register(Request $request) {
        $messages = [
            'required' => 'このフィールドは必須入力です',
            'alpha_num' => '記号文字は使用できません'
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|alpha_num',
            'email' =>'required',
            'password' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect(route('welcome'))
                ->withErrors($validator)
                ->withInput($request->all());
        }
        
        $userAddress = $request->email;
        Mail::send('Kakeibo.emailContent', [], function($message) use ($userAddress) {
            $message->to($userAddress, 'Test')
                ->from('webkanesex@gmail.com', 'Reffect')
                ->subject('This is the subject of Oregairu');
        });

        return redirect('/');

        // KakeiboAuth::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);
        // $request->session()->put('username', $request->name);
        
        // return redirect('/kakeibo');
    }

    public function login(Request $request) {
        $users = DB::table('kakeibo_auth')->whereRaw('(name=?)&(password=?)', [$request->name, $request->password])->first();
        $errorflg = 0;
        if (!isset($users)) {
            $errorflg = 1;
        } 
        $messages = [
            'required' => 'このフィールドは必須入力です',
            'cantlogin' => 'ログインできませんでした(名前、パスワードが正確か確認してください)'
        ];
        $validator = Validator::make($request->all(), [
            'name' => ['required', new cantlogin],
            'password' => ['required', new cantlogin],
        ], $messages);
        if ($validator->fails()) {
            return redirect(route('showLogin'))->withErrors($validator)->withInput($request->all());
        }

        if ($errorflg == 1) {
            return view('Kakeibo.login', compact('errorflg'));
        } else {
            $request->session()->put('username', $request->name);
            return  redirect('/kakeibo');
        }
    }
    
    public function logout(Request $request) {
        if ($request->session()->has('username')) {
            $request->session()->forget('username');
            return view('Kakeibo.logout');
        } else {
            return redirect('/');
        }
    }

    public function kTest() {
        $pKakeibos = DB::table('kakeibo')->orderByRaw('month, day')->paginate(1);

        return view('Kakeibo.test', compact('pKakeibos'));
    }
}


