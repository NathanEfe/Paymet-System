<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Make a Payment</h2>
  <form action="index.php" method="POST">
    <label>Email</label><br>
    <input type="email" name="email" required><br><br>
    <label>Amount</label><br>
    <input type="number" name="amount" required><br><br>
    <button type="submit">Pay Now</button>
  </form>
</body>
</html>

<?php
$email = $_POST['email'];
$amount = $_POST['amount'] * 100;

$secret_key = 'sk_live_648473a482ae2be16281b6b8e41500d7dddf27a4'; 

$data = [
    'email' => $email,
    'amount' => $amount,
    'callback_url' => 'verify.php'
];

// cURL request
$ch = curl_init('https://api.paystack.co/transaction/initialize');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $secret_key",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if ($result['status']) {
    
    header('Location: ' . $result['data']['authorization_url']);
} else {
    echo "Payment failed: " . $result['message'];
}




?>