<?php
// 定数ファイルの読み込み
require_once '../conf/const.php';
// 汎用関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'item.php';
// 注文データに関する関数ファイルの読み込み
require_once MODEL_PATH . 'order.php';

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
// ページ数を計算（端数切り上げ）
$number_of_pages = ceil($number_of_results[0]['count']/RESULTS_PAGE);
 // $_GET['page']に合わせて、始まりの個数を求める
$this_page_first_result = ($page-1) * RESULTS_PAGE;

// 商品一覧用の商品データを取得
$items = get_open_items($db,$sort,$this_page_first_result,RESULTS_PAGE);

// ランキングデータを取得
$ranking = get_ranking($db);

// ビューの読み込み
include_once VIEW_PATH . 'index_view.php';