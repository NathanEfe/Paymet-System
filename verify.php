<?php
if (!isset($_GET['reference'])) {
    die('No reference supplied');
}

$reference = $_GET['reference'];
$secret_key = 'sk_live_648473a482ae2be16281b6b8e41500d7dddf27a4';


$ch = curl_init("https://api.paystack.co/transaction/verify/$reference");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $secret_key"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if ($result['status'] && $result['data']['status'] == 'success') {
    echo "<h2>Payment Successful!</h2>";
    echo "Reference: " . $result['data']['reference'];
    echo "<br>Amount: ₦" . ($result['data']['amount'] / 100);
    echo "<br>Customer: " . $result['data']['customer']['email'];
} else {
    echo "<h2>Payment Failed or Cancelled.</h2>";
}
