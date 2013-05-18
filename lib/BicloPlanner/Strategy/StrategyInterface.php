<?php

namespace BicloPlanner\Strategy;

use BicloPlanner\Task;

interface StrategyInterface
{
    const PWAN_NONE = 0;
    const PWAN_TRIVIAL = 1;
    const PWAN_MINOR = 2;
    const PWAN_MAJOR = 3;
    const PWAN_CRITICAL = 4;
    const PWAN_EXTREM = 5;

    function pawn(Task $task);
}
