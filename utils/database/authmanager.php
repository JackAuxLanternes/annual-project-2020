<?php

require_once "form.php";

class authmanager extends form
{

    /**
     * authmanager constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function signup(
        string $lastname,
        string $firstname,
        string $email,
        string $phone,
        string $address,
        string $city,
        string $zip,
        string $password,
        string $repassword
    ):?string
    {

        if($password != $repassword) return 'p_nomatch';
        if($this->db->exists($email)) return 'e_taken';

        $hashed = password_hash($password, PASSWORD_ARGON2ID);

        $affectedRows = $this->db->internalexec(
            "INSERT INTO user VALUES (?,?,?,?,?,?,?,?,?,?)",
            [$this->db->uuid(), $lastname, $firstname, $email, $phone, $address, $city, $zip, $hashed, 'customer']
        );
        if($affectedRows === 0) return "database";

        return 'done';
    }

    public function signin(string $email, string $password): ?string {

        $userData = $this->db->find('SELECT password FROM user WHERE email = ?', [$email]);

        if ($userData === null) return "notfound";

        $hash = $userData['password'];

        if (!password_verify($password, $hash)) return "notgood";

        return 'done';
    }

    public function update(
        string $lastname,
        string $firstname,
        string $email,
        string $phone,
        string $address,
        string $city,
        string $zip,
        string $password,
        string $newpassword,
        bool $isrepassword
    ):string
    {

        $userData = $this->db->find('SELECT * FROM user WHERE email = ?', [$email]);
        if ($userData === null) return "notfound";
        $hash = $userData['password'];
        if (!password_verify($password, $hash)) return "notgood";

        if(!$isrepassword) $hashed = password_hash($password, PASSWORD_ARGON2ID);
        else $hashed = password_hash($newpassword, PASSWORD_ARGON2ID);

        $affectedRows = $this->db->exec(
            "UPDATE user SET last_name=?, first_name=?, password=?, phone=?, address=?, city=?, zip=? WHERE email=?",
            [$lastname, $firstname, $hashed, $phone, $address, $city, $zip, $email]);

        if($affectedRows === 0) return "database";
        return "done";
    }

}