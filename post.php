<?php
/**
 * A simple dd() (Dump and Die) function, similar to the one in Laravel
 */
function dd($data) {
    echo '<div style="background-color: #18171B; color: #56DB3A; padding: 20px; font-family: Menlo, Consolas, monospace; border-radius: 8px;">';
    echo '<h3 style="color: #FF8400; border-bottom: 1px solid #333; padding-bottom: 10px;">📦 Gelen Form Verileri (Ayrı Ayrı)</h3>';
    
    foreach ($data as $key => $value) {
        echo '<div style="margin-bottom: 15px; border-bottom: 1px dashed #444; padding-bottom: 10px;">';
        echo '<strong style="color: #FF1493;">[' . htmlspecialchars($key) . ']</strong> => ';
        
        if (is_array($value)) {
            echo '<pre style="color: #00BFFF; margin-top: 5px;">' . htmlspecialchars(print_r($value, true)) . '</pre>';
        } else {
            echo '<div style="color: #FFF; background:  max-width:100%;
    overflow-wrap:anywhere;
    word-break:break-word;
    white-space:pre-wrap;
    box-sizing:border-box; #222; padding: 10px; margin-top: 5px; border-radius: 4px;">';
            echo nl2br(htmlspecialchars($value));
            echo '</div>';
        }
        echo '</div>';
    }
    
    echo '</div>';
    die();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request = $_POST;
    dd($request);
} else {
    echo "<h2 style='font-family: sans-serif; text-align: center; margin-top: 50px;'>Please submit the form via Reditor (a POST request is expected).</h2>";
}
