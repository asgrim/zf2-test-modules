<?php

namespace GearmanWorker\Job;

class TestJob extends AbstractJob
{
	public function getName()
	{
		return "bar";
	}

	public function work()
	{
		$this->console("Workload is: " . $this->getWorkload());
		$max = 3;
		for ($i = 1; $i <= $max; $i++)
		{
			$this->console("$i of $max...");
			$this->sendStatus($i, $max);
			sleep(1);
		}
	}
}