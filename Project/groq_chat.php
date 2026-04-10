<?php
$apiKey = "YOUR_GROQ_API_KEY"; 
$model = "llama3-8b-8192";

$data = [
    "model" => $model,
    "messages" => [
        ["role" => "system", "content" => "You are a helpful assistant."],
        ["role" => "user", "content" => "Hello Groq, can you reply?"]
    ]
];

$ch = curl_init("https://api.groq.com/openai/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
]);

// SSL options (important for XAMPP/Windows)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_CAINFO, "C:/xampp/php/extras/ssl/cacert.pem"); // adjust path if needed

// Send JSON payload
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute request
$response = curl_exec($ch);

// Error handling
if ($response === false) {
    echo "cURL error: " . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Decode JSON safely
$result = json_decode($response, true);

if ($result === null) {
    echo "Failed to decode JSON response.";
    exit;
}

// Safely access the API response
if (isset($result["choices"][0]["message"]["content"])) {
    echo $result["choices"][0]["message"]["content"];
} else {
    echo "No content returned from API.";
}
?>
