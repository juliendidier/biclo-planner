<?php

namespace BicloPlanner\Strategy;

use BicloPlanner\Task;

class SecondScheduleStrategy implements StrategyInterface
{
    public function pawn(Task $task)
    {
        if ($this->isSecondSchedule($task)) {
            return $task->pawn(StrategyInterface::PWAN_EXTREM);
        }

        $bla = $task->pawn(StrategyInterface::PWAN_NONE);
    }

    private function isSecondSchedule(Task $task)
    {
        if ($task->hasSchedule(2)) {
            return !$task->hasSchedule(3);
        }
    }
}
