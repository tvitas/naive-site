<?php
namespace App\Traits;

trait VerifyRecaptchaTrait
{
    /**
     * Verifies google recaptcha response
     * @return bool true if response success, otherwise false
     */
    public function verifyRecaptcha()
    {
        $verified = false;
        $recaptchaResponse = $this->request->request->get('g-recaptcha-response');

        if (null === $recaptchaResponse or '' === $recaptchaResponse) {
            return $verified;
        }

        $recaptchaUrl = $this->env->get('recaptcha_url');
        $recaptchaSecret = $this->env->get('recaptcha_secret');
        $verifyResponse = file_get_contents($recaptchaUrl
            . '?secret='
            . $recaptchaSecret
            . '&response='
            . $recaptchaResponse
        );
        $responseData = json_decode($verifyResponse);

        if ($responseData->success) {
            $verified = true;
        }

        return $verified;
    }
}
