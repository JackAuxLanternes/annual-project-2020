<?php

require_once "form.php";
require_once "subscriptionmanager.php";

class bookingmanager extends form
{
    /**
     * authmanager constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function add(
        string $customer_id,
        string $provider_id,
        string $service_id,
        string $quantity_booked,
        string $address,
        string $date,
        string $time
    ){
        $affectedrows = $this->db->exec('INSERT INTO booking VALUES (?,?,?,?,?,?,?)',
            [
                $this->db->uuid(),
                $customer_id,
                $provider_id,
                $service_id,
                $quantity_booked,
                $address,
                $date.' '.$time
            ]);

        if($affectedrows == 0) return 'database';

        $subscription = new subscriptionmanager();
        $subscription->update_hours_left($customer_id);

        $userdata = $this->db->find('SELECT hours_left FROM subscription WHERE customer_id=?', [$customer_id]);

        $affectedrows = $this->db->exec('UPDATE subscription set hours_left=? WHERE customer_id=?',
            [
                $userdata['hours_left']-$quantity_booked,
                $customer_id
            ]);

        if($affectedrows == 0) return 'database';
        else return 'done';
    }
}