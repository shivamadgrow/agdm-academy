<?php
/**
 * AGDM Academy Captcha Helper
 * Highly effective self-hosted spam prevention using dynamic math challenges.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generate a new math captcha and store the answer in the session.
 */
function agdm_generate_captcha() {
    $num1 = rand(5, 12);
    $num2 = rand(1, 9);
    $ops = ['+', '-'];
    $op = $ops[rand(0, 1)];
    
    // Ensure we don't get negative results for simplicity
    if ($op === '-' && $num1 < $num2) {
        $temp = $num1;
        $num1 = $num2;
        $num2 = $temp;
    }
    
    if ($op === '+') {
        $answer = $num1 + $num2;
    } else {
        $answer = $num1 - $num2;
    }
    
    $_SESSION['agdm_captcha_answer'] = $answer;
    $_SESSION['agdm_captcha_question'] = "What is $num1 $op $num2?";
}

/**
 * Render the HTML for the captcha input.
 */
function agdm_render_captcha($isDark = false) {
    if (empty($_SESSION['agdm_captcha_question'])) {
        agdm_generate_captcha();
    }
    
    $question = $_SESSION['agdm_captcha_question'];
    
    // Theme options
    $labelColor = $isDark ? 'text-white-50' : 'text-dark';
    $inputBg = 'bg-light text-dark border-0';
    $addonBg = 'bg-dark text-white border-0';
    
    if ($isDark) {
        $inputBg = 'bg-dark text-white border-secondary';
        $addonBg = 'bg-dark text-white border-secondary';
    }
    
    return '
    <div class="mb-3 captcha-wrapper">
        <label for="agdm_captcha" class="form-label fw-semibold ' . $labelColor . ' d-flex align-items-center gap-2">
            <i class="bi bi-shield-lock-fill text-danger"></i> Human Verification <span class="text-danger">*</span>
        </label>
        <div class="input-group input-group-lg">
            <span class="input-group-text font-outfit fw-bold ' . $addonBg . '" id="captcha-question-addon" style="min-width: 140px; justify-content: center; letter-spacing: 0.05em; background: linear-gradient(135deg, #1b0005 0%, #0d0d0d 100%); border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                ' . $question . '
            </span>
            <input type="number" name="agdm_captcha" id="agdm_captcha" class="form-control ' . $inputBg . ' fs-6" placeholder="Enter answer" required aria-describedby="captcha-question-addon">
            <button class="btn btn-outline-danger px-3 d-flex align-items-center justify-content-center" type="button" id="refresh-captcha-btn" onclick="refreshCaptcha(this)" title="Refresh Verification Question" style="border-top-right-radius: 8px; border-bottom-right-radius: 8px;">
                <i class="bi bi-arrow-clockwise fs-5"></i>
            </button>
        </div>
    </div>';
}

/**
 * Validate the captcha submission.
 */
function agdm_validate_captcha($user_answer) {
    if (!isset($_SESSION['agdm_captcha_answer'])) {
        return false;
    }
    $isValid = ((int)trim($user_answer) === (int)$_SESSION['agdm_captcha_answer']);
    // Regenerate after a validation check to avoid replay attacks
    agdm_generate_captcha();
    return $isValid;
}
