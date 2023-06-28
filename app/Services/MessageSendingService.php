<?php
namespace App\Services;
use App\Models\Message;
class MessageSendingService
{
    public function send(Message $message):Message
    {

        return $message;
    }
}
