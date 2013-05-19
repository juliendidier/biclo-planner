$task = $payload->getTask();

$schedule = $task->getSchedule(1);
$stationDetail = $this->process->processStationDetail($schedule);

$planner = new PlannerStrategy();
$time = $planner->schedule($task);

$lastDuration = $task->getDuration();
$this->write(sprintf('stationId: #%d - scoring: %d', $task->getStationId(), $task->getPawns()));
$task->schedule();
