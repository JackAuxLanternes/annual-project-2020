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

        $affectedrows = $this->db->exec('INSERT INTO subscription VALUES (?,?,?,?,?)',
            [
                $customerid,
                $type,
                $date,
                $date,
                '0'
            ]);

        if($affectedrows == 0) return 'database';
        else return 'done';
    }
    public function remove(string $customermail){
        $userdata = $this->db->find('SELECT id FROM user where email=?', [$customermail]);
        return $this->db->exec('DELETE FROM subscription where customer_id=?', [$userdata['id']]);
    }
}