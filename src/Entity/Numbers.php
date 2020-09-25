<?php

namespace App\Entity;

use App\Repository\NumbersRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NumbersRepository::class)
 */
class Numbers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $list;

    private $median;

    private $average;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getList(): ?array
    {
        return $this->list;
    }

    public function setList(array $list): self
    {
        $this->list = $list;

        return $this;
    }

    public function addToList($var = null)
    {
        if (is_array($var)) {
            foreach ($var as $value) {
                $this->addIfInt($value);
            }
        } else {
            $this->addIfInt($var);
        }

        return $this;
    }

    private function addIfInt($var = null)
    {
        if(is_integer($var))
            array_push($this->list, $var);
    }

    public function removeFromList(int $number)
    {
        if(array_search($number, $this->list) !== FALSE) {
            unset($this->list[array_search($number, $this->list)]);
            $this->list = array_values($this->list);
        }

        return $this;
    }
    
    public function add(int $amount)
    {
        foreach ($this->list as $key => $value) {
            $this->list[$key] = $value + $amount;
        }
    
        return $this;
    }

    public function substract(int $amount)
    {
        foreach ($this->list as $key => $value) {
            $this->list[$key] = $value - $amount;
        }
    
        return $this;
    }
    
    public function multiply(int $amount)
    {
        foreach ($this->list as $key => $value) {
            $this->list[$key] = $value * $amount;
        }
    
        return $this;
    }

    public function divide(int $amount)
    {
        if($amount !== 0)
            foreach ($this->list as $key => $value)
                $this->list[$key] = $value / $amount;
    
        return $this;
    }
    
    public function getAverage()
    {
        return array_sum($this->list) / count($this->list);
    }

    public function getMedian()
    {
        if(empty($this->list)){
            return false;
        }

        $arr = $this->list;
        sort($arr);
        $count = count($arr);
        $middle = floor(($count - 1) / 2);

        if($count % 2) { 
            return $arr[$middle];
        } else {
            $lowMid = $arr[$middle];
            $highMid = $arr[$middle + 1];

            return (($lowMid + $highMid) / 2);
        }
    }
}
