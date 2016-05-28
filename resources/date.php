<?php
  $today =  strtotime(getdate()); 
  $today =  strtotime(time());
  $today =  (time());

  /* function IntDiv */
  function IntDiv($a, $b) {
    return ($a - ($a % $b) ) / $b;
  }
  
  /* functions for handling dates */
  function relativeTime($date) {
    $today =  (time());
    $today =  (time());
    $date = strtotime($date);
    $minute = 60;
    $hour = $minute * 60;
    $day = $hour * 24;
    $week = $day * 7;
    $year = $week * 52;
    $returnString = "";
    $difference = $today - $date;

    if($difference < $hour)
    {
      $units = IntDiv($difference , $minute);
      if($units < 2)
      {
        $returnString = "an minute ago";
      }
      else
      {
        $returnString = "$units minutes ago";
      }
    }
    elseif($difference < $day)
    {
      $units = IntDiv($difference , $hour);
      if($units < 2)
      {
        $returnString = "an hour ago";
      }
      else
      {
        $returnString = "$units hours ago";
      }
    }
    elseif($difference < $year)
    {
      if($difference < $week)
      {
        $units = IntDiv($difference , $day);
        if($units < 2)
        {
          $returnString = "yesterday";
        }
        else
        {
          $returnString = "$units days ago";
        }
      }
      elseif($difference < $month)
      {
        $units = IntDiv($difference , $week);
        if($units < 2)
        {
          $returnString = "last week";
        }
        else
        {
          $returnString = "$units weeks ago";
        }
      }
      elseif($difference < $year)
      {
        $units = IntDiv($difference , $month);
        if($units < 2)
        {
          $returnString = "last month";
        }
        else
        {
          $returnString = "$units months ago";
        }
      }
    }
    else
    {
      $returnString  = "sometime in the past";
    }

    //return ($returnString . "" . date($date));
    return $returnString;

  }
  ?>


    

