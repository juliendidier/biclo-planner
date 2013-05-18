<?php

namespace BicloPlanner;

use BicloPlanner\Strategy\StrategyInterface;

class Task
{
    private $contractName;
    private $stationId;
    private $schedules;
    private $duration;
    private $pawns;

    public function __construct($contractName, $stationId, $duration = 'time_0', array $schedules = array(), array $pawns = array())
    {
        $this->contractName = $contractName;
        $this->stationId    = $stationId;
        $this->duration     = $duration;
        $this->schedules    = $schedules;
        $this->pawns        = $pawns;
    }

    public function getContractName()
    {
        return $this->contractName;
    }

    public function getStationId()
    {
        return $this->stationId;
    }

    public function getPawns()
    {
        return $this->pawns;
    }

    public function setPawns($pawns)
    {
        $this->pawns = $pawns;

        return $this;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    public function hasSchedule($int)
    {
        return ($int <= count($this->schedules));
    }

    public function addSchedule(Schedule $schedule)
    {
        if (count($this->schedules) >= 11) {
            array_shift($this->schedules);
        }

        array_push($this->schedules, $schedule);

        return $this;
    }

    public function pawn($int)
    {
        $this->pawns[] = $int;

        return $this;
    }

    public function getSchedule($int)
    {
        $count = count($this->schedules);
        $key = $count - $int;

        if (!$this->hasSchedule($key)) {
            throw new \RuntimeException('No scheduled found for '.$key.'. Scheddules count: '.$count);
        }

        return $this->schedules[$key];
    }

    public function getSchedules()
    {
        return new \ArrayIterator($this->schedules);
    }

    public function schedule()
    {
        $pawns = array_sum($this->pawns);

        switch ($pawns) {
            case StrategyInterface::PWAN_EXTREM:
                $this->setDuration(Schedule::ZERO_MINUTE);
                break;
            case StrategyInterface::PWAN_CRITICAL:
                $this->setDuration(Schedule::ONE_MINUTE);
                break;
            case StrategyInterface::PWAN_MAJOR:
                $this->setDuration(Schedule::TWO_MINUTES);
                break;
            case StrategyInterface::PWAN_MINOR:
                $this->setDuration(Schedule::FIVE_MINUTES);
                break;
            case StrategyInterface::PWAN_TRIVIAL:
                $this->setDuration(Schedule::TEN_MINUTES);
                break;
            default:
                $this->setDuration(Schedule::FIFTEEN_MINUTES);
                break;
        }

        $this->setPawns(array());
    }
}
