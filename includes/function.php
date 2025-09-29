
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
        } catch (PDOException $e) {
            exit('Database Connection Failed: ' . $e->getMessage());
        }
    }

    // Create admins table if it doesn't exist

    /**
     * createRegionTable.
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
            country_id VARCHAR(255) NOT NULL,
            state_id VARCHAR(255) NOT NULL,
            address VARCHAR(255) NOT NULL,
            contact_number VARCHAR(255) NOT NULL,
            cover_image VARCHAR(255) NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            status BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE,
            FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE CASCADE,
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
                phone_number VARCHAR(255)  NULL,
                profile_image VARCHAR(255) NULL,
                status BOOLEAN DEFAULT TRUE,
                role ENUM('user') DEFAULT 'user',
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
                name VARCHAR(255) NOT NULL,
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

    // Method to execute SELECT queries
    public function fetchAll($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    // Method to execute single row SELECT queries
    public function fetch($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetch();
    }

    // Method to execute INSERT, UPDATE, DELETE queries
    public function execute($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);

        return $stmt->execute($params);
    }

    // Get last inserted ID
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function CheckLogin()
    {
        if (isset($_SESSION['last_login_time'])) {
            return true;
        } else {
            return false;
        }
    }
}
