<?php

require_once "form.php";

class servicemanager extends form
{

    /**
     * servicemanager constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function add(
        string $name,
        int $price,
        string $flowfrequency,
        int $minhours,
        string $picturename
    ):string{

        echo "<br>name :" . $name;
        echo "<br>price :" . $price;
        echo "<br>flow :" . $flowfrequency;
        echo "<br>hours :" . $minhours;
        echo "<br>picture :" . $picturename;

        $affectedrows = $this->db->exec('INSERT INTO service VALUES (?,?,?,?,?,?)',
            [
                $this->db->uuid(),
                $name,
                $price,
                $flowfrequency,
                $picturename,
                $minhours
            ]);

        if($affectedrows == 0) return 'database';
        else return 'done';
    }

    public function remove(string $id){

        $servicedata = $this->db->find("SELECT picture_name FROM service WHERE id ='$id'");
        $filename = __DIR__ . '/../../ressources/pictures/' . $servicedata['picture_name'];
        if (!unlink($filename)) {
            echo ("$filename cannot be deleted due to an error");
        }
        else {
            echo ("$filename has been deleted");
        }

        return $this->db->exec("DELETE FROM service WHERE id = '$id'");
    }

    public function modify(
        string $id,
        string $name,
        int $price,
        string $flowfrequency,
        int $minhours,
        string $picturename,
        string $actualpicturename
    ){
        $query = "UPDATE service SET name=?, price=?, flow_frequency_shape=?, min_hours_required=?";

        if($picturename != "" && $picturename != $actualpicturename){
            $query .= ", picture_name=?";

            $picturepath = __DIR__ . '/../../ressources/pictures/' . $actualpicturename;
            if (!unlink($picturepath)) {
                echo ("$picturepath cannot be deleted due to an error");
            }
            else {
                echo ("$picturepath has been deleted");
            }
        }

        $query .= " WHERE id=?";

        $params = [];

        array_push($params, $name);
        array_push($params, $price);
        array_push($params, $flowfrequency);
        array_push($params, $minhours);
        if($picturename != "" && $picturename != $actualpicturename)
            array_push($params, $picturename);
        array_push($params, $id);

        echo $query . "<br>";
        print_r($params);

        if($this->db->exec($query, $params) != 0) return 'done';
        else return 'database';
    }
}