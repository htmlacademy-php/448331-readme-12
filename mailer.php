<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

require_once 'vendor/autoload.php';

$mail_dsn = $_ENV['SYMFONY_MAILER_DSN'];
$mail_transport = Transport::fromDsn($mail_dsn);