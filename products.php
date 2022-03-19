<?php
// The amounts of products to show on each page
$num_products_on_each_page = 10;
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
// $stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT ?,?');
// // bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
// $stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
// $stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
// $stmt->execute();
// // Fetch the products from the database and return the result as an Array
// $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of products
// $total_products = $pdo->query('SELECT * FROM products')->rowCount();
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
$total_products = count($productList)

?>

<?=template_header('Products')?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <p><?=$total_products?> Products</p>
    <div class="products-wrapper">
        <?php foreach ($productList as $product): ?>
        <a href="index.php?page=product&id=<?=$product->id?>" class="product">
            <img src="<?=$product->images[0]->src?>" width="200" height="200" alt="<?=$product->name?>">
            <span class="name"><?=$product->name?></span>
            <span class="price">
                &dollar;<?=$product->regular_price?>
                <?php if ($product->regular_price > 0): ?>
                <span class="rrp">&dollar;<?=$product->regular_price?></span>
                <?php endif; ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
    <div class="buttons">
        <?php if ($current_page > 1): ?>
        <a href="index.php?page=products&p=<?=$current_page-1?>">Prev</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($productList)): ?>
        <a href="index.php?page=products&p=<?=$current_page+1?>">Next</a>
        <?php endif; ?>
    </div>
</div>

<?=template_footer()?>