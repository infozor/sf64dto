<?php

namespace App\ModuleProcess\Orchestrator;
use Doctrine\DBAL\Connection;
use Symfony\Component\Messenger\MessageBusInterface;

final class ProcessOrchestrator
{
	public function __construct(private Connection $db, private MessageBusInterface $bus)
	{
	}
	public function handleStep(int $processId, string $step): void
	{
		$this->db->beginTransaction();

		try
		{
			$process = $this->db->fetchAssociative('SELECT * FROM process_instance WHERE id = :id FOR UPDATE', [
					'id' => $processId
			]);

			if (!$process || $process['state'] === 'done')
			{
				$this->db->commit();
				return;
			}

			$this->db->executeStatement('
                UPDATE process_instance
                SET state = :state, current_step = :step, updated_at = now()
                WHERE id = :id
                ', [
					'state' => 'running',
					'step' => $step,
					'id' => $processId
			]);

			match ($step) {
					'calculate' => $this->calculate($processId),
					'apply' => $this->apply($processId),
					default => throw new \LogicException("Unknown step {$step}")
			};

			$this->db->commit();
		}
		catch ( \Throwable $e )
		{
			$this->db->rollBack();

			$this->db->executeStatement('
                UPDATE process_instance
                SET state = :state, error_message = :err
                WHERE id = :id
                ', [
					'state' => 'failed',
					'err' => $e->getMessage(),
					'id' => $processId
			]);

			throw $e;
		}
	}
}