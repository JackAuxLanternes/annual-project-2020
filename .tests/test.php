<?php
$startTime = new \DateTime('2020-12-12 20:00:00');

$rule = new \Scheduler\Job\RRule('FREQ=MONTHLY;COUNT=5', $startTime); //run monthly, at 20:00:00 starting from the 12th of December 2017, 5 times

$job = new \Scheduler\Job\Job($rule, function () {

    //do something

});