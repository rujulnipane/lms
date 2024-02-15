<?php

// include_once("../config.php");
class Database
{
    private $server;
    private $dbUser;
    private $dbPassword;
    private $dbName;
    private $email;
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $array = array();
        $config = fopen("../config.txt", "r") or die("Unable to open file!");
        while (!feof($config)) {
            $line = fgets($config);
            $parts = explode('=', $line, 2);
            $key = trim($parts[0]);
            $value = isset($parts[1]) ? trim($parts[1]) : ''; // Handle case when there's no value
            $array[$key] = $value;
        }
        fclose($config);
        $this->server = $array['server'];
        $this->dbUser = $array['user'];
        $this->dbPassword = $array['password'];
        $this->dbName = $array['dbname'];
        $this->email = $array['email'];
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        $this->conn = new mysqli($this->server, $this->dbUser, $this->dbPassword, $this->dbName);
        if ($this->conn->connect_error) {
            die('Connection error' . $this->conn->connect_error);
        }
        echo "connected";
    }

    public function getRecord($table, $query){
        $name = $query["name"];
        $sql = "SELECT * FROM $table WHERE username = '$name'";
        $result = $this->conn->query($sql);
        var_dump($result);
        return $result;
    }

    public function insertRecord($table, $data){
        $name = $data["name"];
        $email = $data["email"];
        $password = $data["password"];
        $sql = "INSERT INTO $table (username, email, password) VALUES('$name', '$email', '$password')";
        if ($this->conn->query($sql) === TRUE) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
          }
    }

    public function initializeDatabase()
    {
        $this->conn = new mysqli("localhost", "root", "root");
        if (!$this->conn->connect_error) {
            echo "connected successfully";
        }

        $sql_user = "CREATE USER '$this->dbUser'@'$this->server' IDENTIFIED BY '$this->dbPassword'";
        if ($this->conn->query($sql_user) === TRUE) {
            echo "Created User Successfully";
        } else {
            echo "Error creating user: " . $this->conn->error;
        }
        $sql_db = "Create DATABASE $this->dbName";
        if ($this->conn->query($sql_db) === TRUE) {
            echo "Database created successfully";
        } else {
            echo "Error creating database: " . $this->conn->error;
        }

        $grant = "GRANT ALL ON *.* TO '$this->dbUser'@'localhost'";
        if ($this->conn->query($grant) === TRUE) {
            echo "Granted priviliges";
        } else {
            echo "Error creating database: " . $this->conn->error;
        }
        $this->conn->close();
        echo "connection closed";

    }
    public function createTables()
    {
        echo "USER";
        $table_user = "CREATE TABLE USER(
            id INT PRIMARY KEY AUTO_INCREMENT, 
            username VARCHAR(255) UNIQUE, email VARCHAR(255) UNIQUE, 
            password VARCHAR(255),
            isAdmin VARCHAR(50) DEFAULT 'no', 
            created_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $table_courses = "CREATE TABLE COURSE(
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255),
            details VARCHAR(255)
        )";
        
        $table_section = "CREATE TABLE SECTION(
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255),
            details VARCHAR(255),
            course_id INT,
            FOREIGN KEY (course_id) REFERENCES COURSE(id) ON DELETE CASCADE
        )";
        
        $table_video = "CREATE TABLE VIDEO(
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255),
            video_url VARCHAR(255),
            section_id INT,
            FOREIGN KEY (section_id) REFERENCES SECTION(id) ON DELETE CASCADE
        )";
        
        if ($this->conn->query($table_user) === TRUE) {
            echo "User table created successfully";
        } else {
            echo "Error creating database: " . $this->conn->error;
        }

        if ($this->conn->query($table_courses) === TRUE) {
            echo "Courses created successfully";
        } else {
            echo "Error creating database: " . $this->conn->error;
        }

        if ($this->conn->query($table_section) === TRUE) {
            echo "Section table created successfully";
        } else {
            echo "Error creating database: " . $this->conn->error;
        }

        if ($this->conn->query($table_video) === TRUE) {
            echo "Video table created successfully";
        } else {
            echo "Error creating database: " . $this->conn->error;
        }
        $this->conn->close();
    }

    public function createAdminUser(){
        $admin_user = "INSERT INTO USER (username, email, password, isAdmin) VALUES('$this->dbUser','$this->email','$this->dbPassword','yes')";
		if ($this->conn->query($admin_user) === TRUE) {
			echo "Admin User created successfully";
		} else {
			echo "Error creating database: " . $this->conn->error;
		}
        $this->conn->close();
    }
}
