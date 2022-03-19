<?php

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
// echo var_dump(json_decode($productList));
$productList  = json_decode($productList);

echo $productList[0]->id;
echo $productList[0]->images[0]->src;

?>