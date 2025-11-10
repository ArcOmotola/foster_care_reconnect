
<?php

class Database
{
    /**
     * host.
     *
     * @var string
     */
    private $host = 'localhost';

    /**
     * dbname.
     *
     * @var string
     */
    private $dbname = 'swiftresponse';

    /**
     * username.
     *
     * @var string
     */
    private $username = 'root';

    /**
     * password.
     *
     * @var string
     */
    private $password = '';
    /**
     * pdo.
     */
    private $pdo;

    /**
     * __construct.
     *
     * @return void
     */
    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8mb4';
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);

            $this->createAdminsTable();
            $this->createFosterHomeTable();
            $this->createFosterTable();
            $this->createFosterPlacementTable();
            $this->createFosterExperienceTable();
            $this->createFosterConnectionTable();
            $this->createLoggerTable();
            $this->createFosterConnectTable();
            $this->Chat();
            $this->ChatMessage();
            $this->AppNotifications();
            $this->CreateTwoFactorAuthenticationTable();
            $this->SocialWorkerMessages();
        } catch (PDOException $e) {
            exit('Database Connection Failed: ' . $e->getMessage());
        }
    }

    // Create admins table if it doesn't exist
    /**
     * createAdminsTable.
     *
     * @return void
     */
    private function createAdminsTable()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) UNIQUE NOT NULL,
            status BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )';
        $this->pdo->exec($sql);
    }

    // Create foster home table if it doesn't exist
    /**
     * createBinCategoryTable.
     *
     * @return void
     */
    private function createFosterHomeTable()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS foster_homes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            foster_name VARCHAR(255) NOT NULL,
            country_id INT NOT NULL,
            state_id INT NOT NULL,
            home_address VARCHAR(255) NOT NULL,
            contact_number VARCHAR(255) NOT NULL,
            cover_image VARCHAR(255) NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            status BOOLEAN DEFAULT TRUE,
            contact_number VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
            FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE CASCADE
        )';
        $this->pdo->exec($sql);
    }

    // Create Foster table if it doesn't exist
    /**
     * createCustomerTable.
     *
     * @return void
     */
    private function createFosterTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS fosters (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                foster_home_id INT NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                address VARCHAR(255) NOT NULL,
                ssn VARCHAR(255) NOT NULL,
                phone_number VARCHAR(255)  NULL,
                profile_image VARCHAR(255) NULL,
                dob VARCHAR(255) NULL,
                maiden_name VARCHAR(255) NULL,
                status BOOLEAN DEFAULT TRUE,
                role ENUM('user') DEFAULT 'user',
                is_verified BOOLEAN DEFAULT FALSE,
                verification_token VARCHAR(255) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (foster_home_id) REFERENCES foster_homes(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    // Create Foster Placement table if it doesn't exist
    /**
     * createCustomerTable.
     *
     * @return void
     */
    private function createFosterPlacementTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS foster_placements (
                id INT AUTO_INCREMENT PRIMARY KEY,
                foster_id INT NOT NULL,
                placement_name VARCHAR(255)  NULL,
                placement_reason VARCHAR(255)  NULL,
                last_pickup_date VARCHAR(255) NULL,
                last_pickup_name VARCHAR(255) NULL,
                last_pickup_addresss VARCHAR(255) NULL,
                final_placement_outcome VARCHAR(255) NULL,
                status BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (foster_id) REFERENCES fosters(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    /*************  ✨ Windsurf Command 🌟  *************/
    /**
     * Create foster experience table if it doesn't exist
     *
     * @return void
     */
    // Foster Experience Table
    private function createFosterExperienceTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS foster_experiences (
                id INT AUTO_INCREMENT PRIMARY KEY,
                foster_id INT NOT NULL,
                school_name VARCHAR(255) NOT NULL,
                events_attended VARCHAR(255) NULL,
                favourite_activities VARCHAR(255) NULL,
                pets VARCHAR(255) NULL,
                holidays VARCHAR(255) NULL,
                status BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (foster_id) REFERENCES fosters(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Create foster connection table if it doesn't exist
     * 
     * This table stores the connections a foster has with other people
     * 
     * @return void
     */
    /*******  26edf1db-5e92-4d8b-a69e-8f1a90515478  *******/
    private function createFosterConnectionTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS foster_experiences (
                id INT AUTO_INCREMENT PRIMARY KEY,
                foster_id INT NOT NULL,
                friend_name VARCHAR(255) NOT NULL,
                relation VARCHAR(255) NULL,
                favourite_teacher VARCHAR(255) NULL,
                pets VARCHAR(255) NULL,
                tagline VARCHAR(300000) NULL,
                status BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (foster_id) REFERENCES fosters(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Create loggers table if it doesn't exist
     *
     * This function creates a loggers table to store all the logs
     * of the foster home system. The table has the following columns:
     * - id: The primary key of the table, auto incrementing
     * - foster_id: The id of the foster home that made the log
     * - log_type: The type of the log (e.g. login, logout, etc.)
     * - actions: The actions that were taken when the log was made
     * - message: A message describing the log
     * - status: The status of the log (e.g. true or false)
     * - created_at: The timestamp when the log was made
     *
     * If the table already exists, the function does nothing.
     *
     * @return void
     */
    /*******  8e9f5064-2d27-49fd-ac5b-0f9d2b38dcea  *******/
    private function createLoggerTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS loggers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                foster_id INT NOT NULL,
                log_type VARCHAR(255) NOT NULL,
                actions VARCHAR(255) NULL,
                message VARCHAR(255) NULL,
                status BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (foster_id) REFERENCES fosters(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }


    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Create foster connects table if it doesn't exist
     *
     * This function creates a foster connects table to store all the connections
     * between fosters. The table has the following columns:
     * - id: The primary key of the table, auto incrementing
     * - foster_id: The id of the foster home that made the connection
     * - connect_id: The id of the foster home that was connected to
     * - status: The status of the connection (pending, accepted, rejected)
     * - created_at: The timestamp when the connection was made
     *
     * If the table already exists, the function does nothing.
     *
     * @return void
     */
    /*******  0c4ed1a1-4bb1-4645-9338-cb137cf85071  *******/
    private function createFosterConnectTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS foster_connects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        foster_id INT NOT NULL,
        connect_id INT NOT NULL,        
        status ENUM('pending', 'accepted', 'rejected') DEFAULT 'accepted',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (foster_id) REFERENCES fosters(id) ON DELETE CASCADE,
        FOREIGN KEY (connect_id) REFERENCES fosters(id) ON DELETE CASCADE
    )";
        $this->pdo->exec($sql);
    }

    public function Chat()
    {
        $sql = "CREATE TABLE IF NOT EXISTS chat (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sender_id INT NOT NULL,
            receiver_id INT NOT NULL,
            online_status BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sender_id) REFERENCES fosters(id) ON DELETE CASCADE,
            FOREIGN KEY (receiver_id) REFERENCES fosters(id) ON DELETE CASCADE
        )";
        $this->pdo->exec($sql);
    }

    public function ChatMessage()
    {
        $sql = "CREATE TABLE IF NOT EXISTS chat_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            chat_id INT NOT NULL,
            sender_id INT NOT NULL,
            message TEXT NULL,
            image VARCHAR(2550) NULL,
            message_status ENUM('sent', 'received') DEFAULT 'sent',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (chat_id) REFERENCES chat(id) ON DELETE CASCADE,
            FOREIGN KEY (sender_id) REFERENCES fosters(id) ON DELETE CASCADE
        )";
        $this->pdo->exec($sql);
    }


    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Creates the app_notifications table if it doesn't exist.
     * 
     * This function creates a table to store all the app notifications
     * for each foster home. The table has the following columns:
     * - id: The primary key of the table, auto incrementing
     * - foster_id: The id of the foster home that the notification belongs to
     * - message: The message of the notification
     * - status: The status of the notification (true or false)
     * - created_at: The timestamp when the notification was created
     * 
     * If the table already exists, the function does nothing.
     * 
     * @return void
     */
    /*******  3e1dcb44-3d70-4080-9490-4efd72de592e  ****** */

    public function AppNotifications()
    {
        $sql =  "CREATE TABLE IF NOT EXISTS app_notifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            foster_id INT NOT NULL,
            message VARCHAR(255) NOT NULL,
            status BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (foster_id) REFERENCES fosters(id) ON DELETE CASCADE
        )";
        $this->pdo->exec($sql);
    }

    public function CreateTwoFactorAuthenticationTable()
    {
        $sql =  "CREATE TABLE IF NOT EXISTS two_factor_auth (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            token VARCHAR(255) NOT NULL,
            is_used BOOLEAN DEFAULT FALSE,
            expires_at TIMESTAMP NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }


    public function SocialWorkerMessages()
    {
        $sql =  "CREATE TABLE IF NOT EXISTS social_worker_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            foster_home_id INT NOT NULL,
            foster_id INT NOT NULL,
            message VARCHAR(255) NOT NULL,
            status BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (foster_id) REFERENCES fosters(id) ON DELETE CASCADE,
            FOREIGN KEY (foster_home_id) REFERENCES foster_homes(id) ON DELETE CASCADE
        )";
        $this->pdo->exec($sql);
    }
    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Executes a SELECT query and returns all the results.
     *
     * @param string $query The SQL query to execute.
     * @param array $params An array of parameters to bind to the query.
     *
     * @return array The results of the query, or an empty array if no results.
     */

    /*******  ad7c0477-a6e5-49ef-95c2-8081559f4a2e  *******/
    public function fetchAll($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }


    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Executes a SELECT query and returns one result.
     *
     * @param string $query The SQL query to execute.
     * @param array $params An array of parameters to bind to the query.
     *
     * @return mixed The result of the query, or false if no results.
     */
    /*******  d583a3a9-dd96-4a33-adf0-fadd28020940  *******/
    public function fetch($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch();
    }


    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Executes a SQL query with parameters.
     *
     * @param string $query The SQL query to execute.
     * @param array $params An array of parameters to bind to the query.
     *
     * @return bool True if the query was executed successfully, false otherwise.
     */
    /*******  9f280762-cba7-4643-8587-921297383b3e  *******/
    public function execute($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }

    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Returns the ID of the last inserted row or sequence value.
     *
     * @return string The last inserted ID.
     */
    /*******  814e6052-ed2f-41e6-94cc-2a71ba8ebe0c  *******/
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Checks if the user is logged in.
     *
     * @return bool True if the user is logged in, false otherwise.
     */
    /*******  4b389a7f-5472-44e6-99e3-d13b8068b91b  *******/
    public function CheckLogin()
    {
        if (isset($_SESSION['last_login_time'])) {
            return true;
        } else {
            return false;
        }
    }
}
