<?php

require_once "form.php";

class subscriptionmanager extends form
{

    /**
     * servicemanager constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function add(
        string $customermail,
        string $type
    ){
        $userData = $this->db->find('SELECT id FROM user WHERE email = ?', [$customermail]);

        $customerid = $userData['id'];

        $today = getdate();
        $day = $today['mday'];
        $mount = $today['mon'];
        $year = $today['year'];

        if($today['mday'] < 10) $date = '0'.$day;
        if($today['mon'] < 10) $mount = '0'.$mount;

        $date = $year.'-'.$mount.'-'.$day;
        $hours = 0;

        switch ($type){
            case 'base' :
                $hours = 12;
                break;
            case 'familly' :
                $hours = 25;
                break;
            case 'premium' :
                $hours = 50;
                break;
        }

        $affectedrows = $this->db->exec('INSERT INTO subscription VALUES (?,?,?,?,?)',
            [
                $customerid,
                $type,
                $date,
                $date,
                $hours
            ]);

        if($affectedrows == 0) return 'database';
        else return 'done';
    }
    public function remove(string $customermail){
        $userdata = $this->db->find('SELECT id FROM user where email=?', [$customermail]);
        return $this->db->exec('DELETE FROM subscription where customer_id=?', [$userdata['id']]);
    }

    public function update_hours_left($customerid){
        $userdata = $this->db->find('SELECT id FROM user where id=?', [$customerid]);
        $subdata =  $this->db->find('SELECT last_update FROM subscription where customer_id=?', [$userdata['id']]);

        $today = date_create("now");
        $lastupdate = date_create($subdata['last_update']);

        $interval = date_diff($today, $lastupdate);

        if($interval->format('%m') >= 1) $this->db->exec("UPDATE subscription SET last_update=? WHERE customer_id=?",
            [date("Y-m-j"),$userdata['id']]);
    }
}