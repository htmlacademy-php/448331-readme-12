<?php

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

require_once 'vendor/autoload.php';

$mail_dsn = 'smtp://phptest@ni-bel.ru:j8kmz201A@mail.nic.ru';
$mail_transport = Transport::fromDsn($mail_dsn);
