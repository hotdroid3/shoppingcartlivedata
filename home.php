<?php
/* <?php
// Get the 4 most recently added products
// $stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT 4');
// $stmt->execute();
// $recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// ?>
*/

$cURLConnection = curl_init();

curl_setopt($cURLConnection, CURLOPT_URL, 'https://mangomart-autocount.myboostorder.com/wp-json/wc/v1/products');
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
    'Authorization: Basic Y2tfMjY4MmIzNWM0ZDlhOGI2YjZlZmZhYzEyNmFjNTUyZTBiZmIzMTVhMDpjc19jYWI4YzlhNzI5ZGZiNDljNTBjZTgwMWE5ZWE0MWI1NzdjMDBhZDcx',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:98.0) Gecko/20100101 Firefox/98.0',
    'Accept-Encoding: gzip, deflate',
    'Upgrade-Insecure-Requests: 1'
));

$productList = curl_exec($cURLConnection);
curl_close($cURLConnection);
$productList = json_decode($productList);

?>

<?=template_header('Home')?>

<div class="featured">
    <h2>Products</h2>
    <p>Essential products offered by boostorder</p>
</div>
<div class="recentlyadded content-wrapper">
    <h2>Recently Added Products</h2>
    <div class="products">
        <?php for($i = 0; $i < 4; $i++): ?>
        <a href="index.php?page=product&id=<?=$productList[$i]->id?>" class="product">
            <img src="<?=$productList[$i]->images[0]->src?>" width="200" height="200" alt="<?=$productList[$i]->name?>">
            <span class="name"><?=$productList[$i]->name?></span>
            <span class="price">
                &dollar;<?=$productList[$i]->regular_price?>
                <?php if ($productList[$i]->regular_price > 0): ?>
                <span class="rrp">&dollar;<?=$productList[$i]->regular_price?></span>
                <?php endif; ?>
            </span>
        </a>
        <?php endfor; ?>
    </div>
</div>

<?=template_footer()?>