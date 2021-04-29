<?php
// 定数ファイルの読み込み
require_once '../conf/const.php';
// 汎用関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'item.php';

// ログインチェックを行うため、sessionを開始する
session_start();
// ログインチェック関数を呼び出し
if(is_logined() === false){
  // ログインしていない場合は、ログインページにリダイレクト
  redirect_to(LOGIN_URL);
}

// PDOを取得
$db = get_db_connect();
// ログインユーザーのデータを取得
$user = get_login_user($db);

// POSTリクエストのデータを取得
$sort = get_get('sort');
// POSTリクエストのデータを取得
if( ($page = get_get('page')) === ''){
  $page = 1;
}
// 結果の行数を取得
$number_of_results = get_items_count($db);
$results_per_page = 8;
// ページ数を計算（端数切り上げ）
$number_f_pages = ceil($number_of_results[0]['count']/$results_per_page);
 // ページ数に応じてLIMITに設定
$this_page_first_result = ($page-1) * $results_per_page;

// 商品一覧用の商品データを取得
$items = get_open_items($db,$sort,$this_page_first_result,$results_per_page);

// ビューの読み込み
include_once VIEW_PATH . 'index_view.php';