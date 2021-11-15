<?php
namespace Helpers\Date;

use Iterator;
use Exception;

class DateRangeIterator implements Iterator
{
      private $from;
      private $to;
      private $format;
      private $interval;

      private $current;
      private $key;

      function __construct($from, $to, $format = 'Y-m-d', $interval = '+1 days')
      {
         if (false === ($this->from = strtotime($from))) {
                  throw new Exception("Could not parse $from");
            }
            if (false === ($this->to = strtotime($to))) {
                  throw new Exception("Could not parse $to");
            }
            $this->format = $format;
            $this->interval = $interval;
      }

      function rewind()
      {
            $this->current = $this->from;
            $this->key = 0;
      }

      function valid()
      {
            return $this->current <= $this->to;
      }

      function next()
      {
            $this->current = strtotime($this->interval, $this->current);
            ++$this->key;
      }

      function key()
      {
            return $this->key;
      }

      function current()
      {
            return date($this->format, $this->current);
      }
}
