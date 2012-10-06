<?php

namespace Pv\Validate;

class Between extends \Pv\Validate\Validate
{
    public function run()
    {
        $start = null;
        $end   = null;

        try {
            $start = strtotime($this->getParam(0));
            $start = new \DateTime($start);
        } catch(\Exception $e) {
            throw new \InvalidArgumentException('Bad date/time format on range start');
            echo $e->getMessage();
            return false;
        }

        try {
            $end = strtotime($this->getParam(0));
            $end = new \DateTime($end);
        } catch(\Exception $e) {
            throw new \InvalidArgumentException('Bad date/time format on range end');
            echo $e->getMessage();
            return false;
        }

        if ($this->value instanceof \DateTime) {
            return ($this->value >= $start && $this->value <= $end)
                ? true : false;
        } else {
            return false;
        }
    }
}

?>