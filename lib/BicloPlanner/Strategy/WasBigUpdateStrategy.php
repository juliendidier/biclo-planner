<?php

namespace BicloPlanner\Strategy;

use BicloPlanner\Schedule;
use BicloPlanner\Task;

class WasBigUpdateStrategy implements StrategyInterface
{
    public function pawn(Task $task)
    {
        if ($this->wasBigUpdate($task)) {
            return $task->pawn(StrategyInterface::PWAN_CRITICAL);
        }

        return $task->pawn(StrategyInterface::PWAN_NONE);
    }

    private function wasBigUpdate(Task $task)
    {
        if (!$task->hasSchedule(2)) {
            return false;
        }

        $last = $task->getSchedule(1);
        $history = $task->getSchedule(2);

        // total 40 stations / 10 = 4 updates = big update
        $total = $last->getTotal();
        // working with available and free to prevent a possible bad future
        $diffAvailable = abs($last->getAvailable() - $history->getAvailable());
        $diffFree = abs($last->getFree() - $history->getFree());

        return (($total/10) <= (($diffAvailable + $diffFree) / 10));
    }
}
