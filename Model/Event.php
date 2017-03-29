<?php

/**
 * Created by PhpStorm.
 * User: Kenan
 * Date: 29/03/2017
 * Time: 23:03
 */
class Event
{
    private $id, $start_date, $end_date, $location;


    public function __construct($id, $start_date, $end_date, $location)
    {
        $this->setStartDate(date("Y-m-d H:i:s",$start_date));
        $this->setEndDate(date("Y-m-d H:i:s",$end_date));
        $this->setLocation($location);
    }

    /**
     * @return false|string
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param false|string $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param mixed $end_date
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


}