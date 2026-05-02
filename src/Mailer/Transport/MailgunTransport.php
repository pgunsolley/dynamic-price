<?php
declare(strict_types=1);

namespace App\Mailer\Transport;

use Cake\Mailer\AbstractTransport;
use Cake\Mailer\Message;
use Override;

class MailgunTransport extends AbstractTransport
{
    #[Override]
    public function send(Message $message): array
    {
        /*
        TODO: See list below

        - Extract necessary data from $message
        - Use the mailgun sdk to send the email
        - Setup configuration to read from
        */
        throw new \Exception('Not implemented');
    }
}