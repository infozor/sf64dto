<?php

// src/Message/TestJobMessage.php
namespace App\Message;

class TestJobMessage
{
	public function __construct(public readonly int $jobId)
	{
	}
}
