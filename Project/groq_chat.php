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
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo "cURL error: " . curl_error($ch);
}
curl_close($ch);

$result = json_decode($response, true);
echo $result["choices"][0]["message"]["content"];
?>
