<?php


class user
{
    private $id;
    private $firtname;
    private $lastname;
    private $email;
    private $address;
    private $city;
    private $password;
    private $group;

    /**
     * services constructor.
     * @param $id
     * @param $firtname
     * @param $lastname
     * @param $email
     * @param $address
     * @param $city
     * @param $password
     * @param $group
     */
    public function __construct($id, $firtname, $lastname, $email, $address, $city, $password, $group)
    {
        $this->id = $id;
        $this->firtname = $firtname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->address = $address;
        $this->city = $city;
        $this->password = $password;
        $this->group = $group;
    }

}