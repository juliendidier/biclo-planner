<?php

namespace BicloPlanner\Strategy;

use BicloPlanner\Task;
use BicloPlanner\Schedule;

use Doctrine\Bundle\DoctrineBundle\Registry;

class WasNotUpdatedStrategy implements StrategyInterface
{
    public function pawn(Task $task)
    {
        $diff = $this->getUpdateDiff($task);

        switch (true) {
            case (2 > $diff):
                $pawn = StrategyInterface::PWAN_CRITICAL;
                break;
            case (5 > $diff):
                $pawn = StrategyInterface::PWAN_MAJOR;
                break;
            case (10 > $diff):
                $pawn = StrategyInterface::PWAN_MINOR;
                break;
            case (15 > $diff):
                $pawn = StrategyInterface::PWAN_TRIVIAL;
                break;
            default:
                $pawn = StrategyInterface::PWAN_NONE;
                break;
        }

        return $task->pawn($pawn);
    }

    protected function getUpdateDiff(Task $task)
    {
        if (!$task->hasSchedule(2)) {
            return 0;
        }

        $lastSchedule = null;
        $minutes = 0;
        foreach ($task->getSchedules() as $key => $schedule) {
            if (null === $lastSchedule) {
                $lastSchedule = $schedule;
                continue;
            }

            if ($this->isEqual($schedule, $lastSchedule)) {
                $diff = $lastSchedule->getDateTime()->diff($schedule->getDateTime());
                $minutes+= $diff->i;
            }
        }

        return $minutes;
    }

    protected function isEqual(Schedule $current, Schedule $previous)
    {
        return (
            $current->getAvailable() === $previous->getAvailable()
            &&
            $current->getFree() === $previous->getFree()
        );
    }

}
