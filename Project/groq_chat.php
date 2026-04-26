<?php
session_start();
require_once "db.php"; 
// brings in $conn

// Replace with your actual Groq API key
$apiKey = "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"; 
$model = "llama-3.1-8b-instant"; // supported Groq model

$userMessage = $_POST['message'] ?? '';

$data = [
    "model" => $model,
    "messages" => [
        ["role" => "system", "content" => "You are Catbalogan’s helpful municipal assistant."],
        ["role" => "user", "content" => $userMessage]
    ]
];

$ch = curl_init("https://api.groq.com/openai/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
]);

// Force CA file, fallback disable for local testing
$caPath = "C:\xampp\php\extras\ssl\cacert.pem";
if (file_exists($caPath)) {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_CAINFO, $caPath);
} else {
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
}

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if ($response === false) {
    echo "cURL error: " . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

$result = json_decode($response, true);

// Debug: dump raw response if parsing fails
if (!$result) {
    echo "Invalid JSON response: " . $response;
    exit;
}

if (isset($result["error"])) {
    echo "API error: " . $result["error"]["message"];
    exit;
}

// Flexible parsing
$assistantReply = null;
if (isset($result["choices"][0]["message"]["content"])) {
    $assistantReply = $result["choices"][0]["message"]["content"];
} elseif (isset($result["choices"][0]["delta"]["content"])) {
    $assistantReply = $result["choices"][0]["delta"]["content"];
} elseif (isset($result["choices"][0]["text"])) {
    $assistantReply = $result["choices"][0]["text"];
} elseif (isset($result["choices"][0]["content"])) {
    $assistantReply = $result["choices"][0]["content"];
}

// Final output
if ($assistantReply) {
    echo $assistantReply;
} else {
    echo "No content returned from API. Raw response: " . $response;
}
