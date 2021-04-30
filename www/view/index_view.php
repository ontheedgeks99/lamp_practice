<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>商品一覧</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
  <script src="<?php print(JAVASCRIPT_PATH . 'eventlistener.js'); ?>"></script> 
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  

  <div class="container">
  <div class="row">
    <h1>商品一覧</h1>
    <div class="sort">
    <?php if(isset($_GET['sort'])) :?>
      <script>
      jQuery(function(){
      // 全ての選択を外す
        $("select option").attr("selected", false);
        $("select option[value='<?php print h($_GET['sort']);?>']").attr("selected", true);
      });
     </script>
    <?php endif; ?>
      <form action="index.php" method="get" name="select_form">
        <select id="select_box" name="sort">
          <option value="0" selected>新着順</option>
          <option value="1" >価格の安い順</option>
          <option value="2">価格の高い順</option>
        </select>
        <input type="submit" value="並び替え" class="btn btn-primary" style="display:none;">
      </form>
    </div>
  </div>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <div class="card-deck">
      <div class="row">
      <!-- csrf_tokenの生成 -->
      <?php $token = get_csrf_token();?>
      <?php foreach($items as $item){ ?>
        <div class="col-6 item">
          <div class="card h-100 text-center">
            <div class="card-header">
              <?php print(h($item['name'])); ?>
            </div>
            <!-- <figure>は図表を表す -->
            <figure class="card-body">
              <img class="card-img" src="<?php print(IMAGE_PATH . $item['image']); ?>">
              <figcaption>
                <?php print(number_format($item['price'])); ?>円
                <?php if($item['stock'] > 0){ ?>
                  <form action="index_add_cart.php" method="post">
                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                    <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                    <input type="hidden" name="csrf_token" value="<?php print($token);?>">
                  </form>
                <?php } else { ?>
                  <p class="text-danger">現在売り切れです。</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
      <?php } ?>
      </div> 
    </div>
      <nav class="navbar navbar-expand-sm">
          <ul class="navbar-nav mr-auto">
          <?php if ( (int)$page !== 1 ) : ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=<?php echo h($page - 1); ?> ">前へ</a>
            </li>
          <?php endif; ?>
          <?php for ( $i=1; $i <= $number_of_pages; $i++) : ?>
            <li class="nav-item">
             <a class="btn btn-secondary btn-block" href="index.php?page=<?php echo h($i); ?> "><?php echo h($i); ?></a>
            </li>
          <?php endfor; ?>
          <?php if ( (int)$page < $number_of_pages) : ?>
            <li class="nav-item">
             <a class="nav-link" href="index.php?page=<?php echo h($page + 1); ?> ">次へ</a>
            </li>
          <?php endif; ?>
          <?php if ( ($this_page_first_result + 1 + RESULTS_PAGE) <= $number_of_results[0]['count']) { ?>
            <div class="nav-item">
             <div class="nav-link"><?php echo h( $number_of_results[0]['count'] .'件中' . ($this_page_first_result + 1) . '-' .  ($this_page_first_result + RESULTS_PAGE) . '件目の商品' ); ?></div>
            </div>
          <?php } else { ?>
            <div class="nav-item">
            <div class="nav-link"><?php echo h( $number_of_results[0]['count'] .'件中' . ($this_page_first_result + 1) . '-' .  $number_of_results[0]['count'] . '件目の商品' ); ?></div>
            </div>
          <?php } ?>
        </ul>
      </nav>

     </div>
  </div>
  
</body>
</html>