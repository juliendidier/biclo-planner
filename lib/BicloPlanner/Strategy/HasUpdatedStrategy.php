<?php

namespace BicloPlanner\Strategy;

use BicloPlanner\Task;
use BicloPlanner\Schedule;

class HasUpdatedStrategy implements StrategyInterface
{
    public function pawn(Task $task)
    {
        $equal = $this->isEqual($task);
        if (!$equal) {
            return $task->pawn(StrategyInterface::PWAN_CRITICAL);
        }

        return $task->pawn(StrategyInterface::PWAN_NONE);
    }

    private function isEqual(Task $task)
    {
        if (!$task->hasSchedule(2)) {
            return true;
        }

        $current = $task->getSchedule(1);
        $previous = $task->getSchedule(2);

        return (
            $current->getAvailable() === $previous->getAvailable()
            &&
            $current->getFree() === $previous->getFree()
        );
    }
}
