<?php
class Student {
    private $conn;
    private $table_name = "horizonstudents";

    public $index_no;
    public $first_name;
    public $last_name;
    public $city;
    public $district;
    public $province;
    public $email;
    public $mobile_number;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getStudents() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  (Index_No, First_Name, Last_Name, City, District, Province, Email_Address, Mobile_Number)
                  VALUES
                  (:index_no, :first_name, :last_name, :city, :district, :province, :email, :mobile_number)";

        $stmt = $this->conn->prepare($query);

        $this->index_no = htmlspecialchars(strip_tags($this->index_no));
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->district = htmlspecialchars(strip_tags($this->district));
        $this->province = htmlspecialchars(strip_tags($this->province));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile_number = htmlspecialchars(strip_tags($this->mobile_number));

        $stmt->bindParam(":index_no", $this->index_no);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":district", $this->district);
        $stmt->bindParam(":province", $this->province);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mobile_number", $this->mobile_number);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function delete($index_no) {
        // Define the DELETE query
        $query = "DELETE FROM " . $this->table_name . " WHERE Index_No = :index_no";
    
        // Prepare the query
        $stmt = $this->conn->prepare($query);
    
        // Sanitize the input
        $index_no = htmlspecialchars(strip_tags($index_no));
    
        // Bind the parameter
        $stmt->bindParam(":index_no", $index_no);
    
        // Execute the query
        if ($stmt->execute()) {
            return true; // Deletion was successful
        } else {
            return false; // Deletion failed
        }
    }
    
    public function update() {
        // UPDATE query
        $query = "UPDATE " . $this->table_name . "
                  SET First_Name = :first_name,
                      Last_Name = :last_name,
                      City = :city,
                      District = :district,
                      Province = :province,
                      Email_Address = :email,
                      Mobile_Number = :mobile_number
                  WHERE Index_No = :index_no";

        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Sanitize the input
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->district = htmlspecialchars(strip_tags($this->district));
        $this->province = htmlspecialchars(strip_tags($this->province));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mobile_number = htmlspecialchars(strip_tags($this->mobile_number));
        $this->index_no = htmlspecialchars(strip_tags($this->index_no));

        // Bind the parameters
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":district", $this->district);
        $stmt->bindParam(":province", $this->province);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mobile_number", $this->mobile_number);
        $stmt->bindParam(":index_no", $this->index_no);

        // Execute the query
        if ($stmt->execute()) {
            return true; // Update was successful
        } else {
            return false; // Update failed
        }
    }

}
