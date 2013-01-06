<?php

namespace GearmanWorker\Service;

/**
 * Work a gearman worker..
 *
 * @author james
 */
class Worker
{
	/**
	 * @var \GearmanWorker
	 */
	private $gearmanWorker;

	/**
	 * @param \GearmanWorker $worker
	 * @return GearmanWorker\Service\Worker
	 */
	public function setGearmanWorker(\GearmanWorker $worker)
	{
		$this->gearmanWorker = $worker;
		return $this;
	}

	/**
	 * @return \GearmanWorker
	 */
	public function getGearmanWorker()
	{
		return $this->gearmanWorker;
	}

	public function work()
	{
		$worker = $this->getGearmanWorker();

		$this->console("Started worker script");

		while($worker->work())
		{
			$this->console("Waiting for a new job");

			if ($worker->returnCode() != GEARMAN_SUCCESS)
			{
				$this->console("Worker failed: " . $worker->returnCode());
				break;
			}
		}
	}

	public function console($text)
	{
		echo "[" . getmypid() . "] " . date("Y-m-d H:i:s") . "   {$text}\n";
	}

	public function addJob(\GearmanWorker\Job\JobInterface $job, $alias = null)
	{
		$worker = $this->getGearmanWorker();

		if (is_null($alias))
		{
			$alias = $job->getName();
		}

		$worker->addFunction($alias, function($gmjob) use ($job) {

			$sendStatus = function($numerator, $denominator) use ($gmjob) {
				$gmjob->sendStatus($numerator, $denominator);
			};

			$job->setSendStatusClosure($sendStatus)
				->setHandle($gmjob->handle())
				->setWorkload($gmjob->workload())
				->work();
		});

		return $this;
	}
}