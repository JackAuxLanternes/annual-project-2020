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
        if($provider_id == 'empty') $provider_id = "5c589a7f-2ee0-4497-b7b9-b75caaaac461";
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

        $userdata = $this->db->find('SELECT hours_left FROM subscription WHERE customer_id=?', [$customer_id]);

        if($userdata !== null){

            $subscription->update_hours_left($customer_id);

            $affectedrows = $this->db->exec('UPDATE subscription set hours_left=? WHERE customer_id=?',
                [
                    $userdata['hours_left']-$quantity_booked,
                    $customer_id
                ]);

            if($affectedrows == 0) return 'database';
        }

        return 'done';
    }

    public function modify(
        string $book_id,
        string $provider_id,
        string $address,
        string $date,
        string $time
    ){
        if($this->db->exec("UPDATE booking SET provider_id=?, address=?, datetime=? WHERE id=?", [$provider_id, $address, $date.' '.$time, $book_id]) != 0)
            return 'done';
        else return 'database';
    }

    public function delete(string $id){
        return $this->db->exec("DELETE FROM booking WHERE id = '$id'");
    }
}