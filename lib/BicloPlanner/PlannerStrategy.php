<?php

namespace BicloPlanner;

use BicloPlanner\Strategy;

class PlannerStrategy
{
    private $strategies;

    public function __construct()
    {
        $this->strategies = array(
            // new Strategy\SecondScheduleStrategy(),
            // new Strategy\HasUpdatedStrategy(),
            // new Strategy\WasBigUpdateStrategy(),
            new Strategy\WasNotUpdatedStrategy(),
        );
    }

    public function addStrategy($name, StategyInterface $strategy)
    {
        $this->strategy[$name] = $strategy;
    }

    public function schedule(Task $task)
    {
        foreach ($this->strategies as $strategy) {
            $strategy->pawn($task);
        }

        return $task;
    }
}
