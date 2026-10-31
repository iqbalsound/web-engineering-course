<?php
declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

$mailer = new Mailer(Transport::fromDsn('smtp://127.0.0.1:1025'));
$token = bin2hex(random_bytes(16));
$link = 'http://webeng.test/reset?token=' . $token;
$mail = (new Email())
    ->from('noreply@webeng.test')->to('student@example.com')
    ->subject('Reset your password')
    ->text("Open this link within 30 minutes: $link")
    ->html('<p>Open <a href="' . htmlspecialchars($link, ENT_QUOTES) . '">this link</a> within 30 minutes.</p>');
$mailer->send($mail);
echo "Sent. Store only hash('sha256', token) = " . hash('sha256', $token) . PHP_EOL;
