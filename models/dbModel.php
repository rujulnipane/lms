<?php

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
        $config = fopen("../config.txt", "r");
        if (!$config) {
            throw new Exception("Cannot get config file");
        }
        while (!feof($config)) {
            $line = fgets($config);
            $parts = explode('=', $line, 2);
            $key = trim($parts[0]);
            $value = isset($parts[1]) ? trim($parts[1]) : '';
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
            throw new Exception('Connection error: ' . $this->conn->connect_error);
        }
        // echo "connected";
    }

    public function closeConnection()
    {
        $this->conn->close();
    }

    public function getRecord($table, $query)
    {
        $sql = "SELECT * FROM $table WHERE ";
        foreach ($query as $key => $value) {
            $sql .= $key . "=" . "'" . $value . "'";
        }

        $result = $this->conn->query($sql);
        if (!$result) {
            throw new Exception('Query execution error: ' . $this->conn->error);
        }
        return $result;
    }
    public function getRecords($table)
    {
        $sql = "SELECT * FROM $table";
        $result = $this->conn->query($sql);
        if (!$result) {
            throw new Exception('Query execution error: ' . $this->conn->error);
        }
        return $result;
    }
    public function insertRecord($table, $data)
    {
        // $sql = "INSERT INTO $table(";
        // foreach ($data as $key => $value) {
        //     $sql .= $key . ',';
        // }
        // $sql = substr($sql, 0, -1) . ') values(';
        // foreach ($data as $key => $value) {
        //     $sql .= "'" . $value . "'" . ',';
        // }
        // $sql = substr($sql, 0, -1) . ')';
        // if ($this->conn->query($sql) === TRUE) {
        //     echo "New record created successfully";
        // } else {
        //     throw new Exception('Query execution error: ' . $this->conn->error);
        // }

        $sql = "INSERT INTO $table (";
        $placeholders = '';
        $dataType = '';

        foreach ($data as $key => $value) {
            $sql .= $key . ',';
            $placeholders .= '?,';
            if (is_int($value)) {
                $dataType .= 'i';
            } elseif (is_float($value)) {
                $dataType .= 'd'; 
            } elseif (is_string($value)) {
                $dataType .= 's';
            } else {
                $dataType .= 'b'; 
            }
        }
        $sql = rtrim($sql, ',') . ') VALUES (' . rtrim($placeholders, ',') . ')';
        $stmt = $this->conn->prepare($sql);
        echo $dataType . ' ' . array_values($data);
        if ($stmt) {
            $params = array_values($data);
            $stmt->bind_param($dataType,...$params);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new Exception('Query execution error: ' . $this->conn->error);
        }
    }

    public function initializeDatabase()
    {
        $this->conn = new mysqli("localhost", "root", "root");
        if (!$this->conn->connect_error) {
            echo "connected successfully";
        } else {
            throw new Exception("Connection failed" . $this->conn->connect_error);
        }

        $sql_user = "CREATE USER '$this->dbUser'@'$this->server' IDENTIFIED BY '$this->dbPassword'";
        if ($this->conn->query($sql_user) === TRUE) {
            echo "Created User Successfully";
        } else {
            throw new Exception("User Creation Failed" . $this->conn->error);
        }
        $sql_db = "Create DATABASE $this->dbName";
        if ($this->conn->query($sql_db) === TRUE) {
            echo "Database created successfully";
        } else {
            throw new Exception("Dtabase not created" . $this->conn->error);
        }

        $grant = "GRANT ALL ON *.* TO '$this->dbUser'@'localhost'";
        if ($this->conn->query($grant) === TRUE) {
            echo "Granted priviliges";
        } else {
            throw new Exception("priviliges failed" . $this->conn->error);
        }
        $this->conn->close();
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
            url VARCHAR(255),
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
            throw new Exception("Cannot create user table" . $this->conn->error);
        }

        if ($this->conn->query($table_courses) === TRUE) {
            echo "Courses created successfully";
        } else {
            throw new Exception("Cannot create course table" . $this->conn->error);
        }

        if ($this->conn->query($table_section) === TRUE) {
            echo "Section table created successfully";
        } else {
            throw new Exception("Cannot create section table" . $this->conn->error);
        }

        if ($this->conn->query($table_video) === TRUE) {
            echo "Video table created successfully";
        } else {
            throw new Exception("Cannot create video table" . $this->conn->error);
        }
        $this->conn->close();
    }

    public function createAdminUser()
    {
        $options = [
            'cost' => 10,
        ];
        $hashed_password = password_hash($this->dbPassword, PASSWORD_BCRYPT, $options);
        $admin_user = "INSERT INTO USER (username, email, password, isAdmin) VALUES('$this->dbUser','$this->email','$hashed_password','yes')";
        if ($this->conn->query($admin_user) === TRUE) {
            echo "Admin User created successfully";
        } else {
            throw new Exception("Cannot create admin user" . $this->conn->error);
        }
        $this->conn->close();
    }
}
