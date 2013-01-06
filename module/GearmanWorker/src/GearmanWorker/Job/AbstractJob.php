<?php

namespace GearmanWorker\Job;

abstract class AbstractJob implements JobInterface
{
	private $workload;
	private $handle;
	private $sendStatusClosure;

	/**
	 * Output to the console
	 * @param string $text
	 */
	public function console($text)
	{
		echo "[" . getmypid() . "] " . date("Y-m-d H:i:s") . " [" . $this->getName() . "(" . $this->getHandle() . ")]   {$text}\n";
	}

	/**
	 * (non-PHPdoc)
	 * @see GearmanWorker\Job.JobInterface::setSendStatusClosure()
	 */
	public function setSendStatusClosure(\Closure $function)
	{
		$this->sendStatusClosure = $function;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see GearmanWorker\Job.JobInterface::sendStatus()
	 */
	public function sendStatus($numerator, $denominator)
	{
		return $this->sendStatusClosure->__invoke($numerator, $denominator);
	}

	/**
	 * (non-PHPdoc)
	 * @see GearmanWorker\Job.JobInterface::setWorkload()
	 */
	public function setWorkload($workload)
	{
		$this->workload = $workload;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see GearmanWorker\Job.JobInterface::getWorkload()
	 */
	public function getWorkload()
	{
		return $this->workload;
	}

	/**
	 * (non-PHPdoc)
	 * @see GearmanWorker\Job.JobInterface::setHandle()
	 */
	public function setHandle($handle)
	{
		$this->handle = $handle;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see GearmanWorker\Job.JobInterface::getHandle()
	 */
	public function getHandle()
	{
		return $this->handle;
	}
}