<?php
$email = $_POST['email'];
$amount = $_POST['amount'] * 100;

$secret_key = 'pk_live_d935bdcfaf6ec41e2e9679dfd8775865da2b85ac'; 

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
    echo "Payment initialization failed: " . $result['message'];
}




?>