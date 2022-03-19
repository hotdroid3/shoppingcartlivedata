<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Prepare statement and execute, prevents SQL injection
    // $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    // $stmt->execute([$_GET['id']]);
    // // Fetch the product from the database and return the result as an Array
    // $product = $stmt->fetch(PDO::FETCH_ASSOC);
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
    foreach($productList as $product)
    {
        if ($product->id == $_GET['id'])
        {
            $item = $product;
            break;
        }
    }
    // Check if the product exists (array is not empty)
    if (!$item) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
?>

<?=template_header('Product')?>

<div class="product content-wrapper">
    <img src="<?=$item->images[0]->src?>" width="500" height="500" alt="<?=$item->name?>">
    <div>
        <h1 class="name"><?=$item->name?></h1>
        <span class="price">
            &dollar;<?=$item->regular_price?>
            <?php if ($item->regular_price > 0): ?>
            <span class="rrp">&dollar;<?=$item->regular_price?></span>
            <?php endif; ?>
        </span>
        <form action="index.php?page=cart" method="post">
            <input type="number" name="quantity" value="1" min="1" max="<?=$item->stock_quantity?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$item->id?>">
            <input type="submit" value="Add To Cart">
        </form>
        <div class="description">
            <?=$item->description?>
        </div>
    </div>
</div>

<?=template_footer()?>