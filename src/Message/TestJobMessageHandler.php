<?php

// src/MessageHandler/TestJobMessageHandler.php
namespace App\MessageHandler;

use App\Message\TestJobMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TestJobMessageHandler
{
	public function __invoke(TestJobMessage $message): void
	{
		dump('JOB EXECUTED', $message->jobId);
	}
}
