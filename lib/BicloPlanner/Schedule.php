<?php

namespace BicloPlanner;

class Schedule
{
    private $data;

    const ZERO_MINUTE     = 'time_0';
    const ONE_MINUTE      = 'time_1';
    const TWO_MINUTES     = 'time_2';
    const FIVE_MINUTES    = 'time_5';
    const TEN_MINUTES     = 'time_10';
    const FIFTEEN_MINUTES = 'time_15';
    const THIRTY_MINUTES  = 'time_30';

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getStationId()
    {
        return (int) $this->data['station_id'];
    }

    public function getAvailable()
    {
        return (int) $this->data['available_bikes'];
    }

    public function getFree()
    {
        return (int) $this->data['available_bike_stands'];
    }

    public function getTotal()
    {
        return (int) $this->data['bike_stands'];
    }

    public function getUpdated()
    {
        return (int) $this->data['last_update'];
    }

    public function getDateTime()
    {
        return \DateTime::createFromFormat(DATE_RFC822, $this->data['date_time']);
    }
}
