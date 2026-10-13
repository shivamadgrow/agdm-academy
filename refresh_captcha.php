<?php
/**
 * AGDM Academy Captcha Refresher
 * Returns a new random captcha question in JSON format.
 */
require_once __DIR__ . '/bootstrap.php';

agdm_generate_captcha();

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'question' => $_SESSION['agdm_captcha_question']
]);
