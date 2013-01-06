<?php

namespace GearmanWorker\Job;

interface JobInterface
{
	public function getName();
	public function setWorkload($workload);
	public function getWorkload();
	public function setHandle($handle);
	public function getHandle();
	public function sendStatus($numerator, $denominator);
	public function setSendStatusClosure(\Closure $function);
	public function work();
}