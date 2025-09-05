<?php

namespace App\Services;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;

class BrevoMailer
{
    protected $apiInstance;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', config('services.brevo.api_key'));

        $this->apiInstance = new TransactionalEmailsApi(new Client(), $config);
    }

    public function sendCustomEmail(string $toEmail, string $toName, string $subject, string $htmlContent)
    {
        $email = new SendSmtpEmail([
            'subject' => $subject,
            'sender' => [
                'name' => 'Agent Core',
                'email' => 'francyclimber@gmail.com',
            ],
            'to' => [[
                'email' => $toEmail,
                'name' => $toName,
            ]],
            'htmlContent' => $htmlContent,
        ]);

        return $this->apiInstance->sendTransacEmail($email);
    }

    public function sendBulkEmail(array $recipients, string $subject, string $htmlContent)
    {
        $to = array_map(function ($recipient) {
            return [
                'email' => $recipient['email'],
                'name' => $recipient['name'] ?? '',
            ];
        }, $recipients);

        $email = new SendSmtpEmail([
            'subject' => $subject,
            'sender' => [
                'name' => 'Agent Core',
                'email' => 'francyclimber@gmail.com',
            ],
            'to' => $to,
            'htmlContent' => $htmlContent,
        ]);

        return $this->apiInstance->sendTransacEmail($email);
    }

}
