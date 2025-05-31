<?php
/**
 * DatabaseRepository Class
 * 
 * Provides a centralized database abstraction layer for common database operations.
 * This class reduces code duplication and standardizes error handling across the application.
 */
class DatabaseRepository {
    /**
     * @var PDO Database connection
     */
    protected $pdo;
    
    /**
     * @var string Table name
     */
    protected $table;
    
    /**
     * @var string Primary key column name
     */
    protected $primaryKey = 'id';
    
    /**
     * @var ErrorHandler Error handler instance
     */
    protected $errorHandler;
    
    /**
     * Constructor
     * 
     * @param string $table Table name
     * @param PDO $pdo Optional PDO connection (uses global $pdo if not provided)
     */
    public function __construct($table, $pdo = null) {
        global $pdo as $globalPdo;
        $this->pdo = $pdo ?? $globalPdo;
        $this->table = $table;
        
        // Initialize error handler if available
        if (class_exists('ErrorHandler')) {
            $this->errorHandler = ErrorHandler::getInstance();
        }
    }
    
    /**
     * Log an error
     * 
     * @param string $message Error message
     * @param Exception $exception Exception object
     * @return void
     */
    protected function logError($message, $exception = null) {
        $errorMessage = $message;
        
        if ($exception) {
            $errorMessage .= ': ' . $exception->getMessage();
        }
        
        if ($this->errorHandler) {
            $this->errorHandler->logError($errorMessage);
        } else {
            error_log($errorMessage);
        }
    }
    
    /**
     * Find a record by ID
     * 
     * @param int $id Record ID
     * @param array $columns Columns to select (default: all)
     * @return array|bool Record data if found, false otherwise
     */
    public function find($id, $columns = ['*']) {
        try {
            $columnsString = $columns === ['*'] ? '*' : implode(', ', $columns);
            $stmt = $this->pdo->prepare("SELECT {$columnsString} FROM {$this->table} WHERE {$this->primaryKey} = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError("Error finding record in {$this->table}", $e);
            return false;
        }
    }
    
    /**
     * Find a record by a specific column value
     * 
     * @param string $column Column name
     * @param mixed $value Column value
     * @param array $columns Columns to select (default: all)
     * @return array|bool Record data if found, false otherwise
     */
    public function findBy($column, $value, $columns = ['*']) {
        try {
            $columnsString = $columns === ['*'] ? '*' : implode(', ', $columns);
            $stmt = $this->pdo->prepare("SELECT {$columnsString} FROM {$this->table} WHERE {$column} = ?");
            $stmt->execute([$value]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError("Error finding record in {$this->table} by {$column}", $e);
            return false;
        }
    }
    
    /**
     * Get all records
     * 
     * @param array $columns Columns to select (default: all)
     * @param string $orderBy Order by clause (default: empty)
     * @param int $limit Limit (default: 0 = no limit)
     * @param int $offset Offset (default: 0)
     * @return array Records
     */
    public function getAll($columns = ['*'], $orderBy = '', $limit = 0, $offset = 0) {
        try {
            $columnsString = $columns === ['*'] ? '*' : implode(', ', $columns);
            $sql = "SELECT {$columnsString} FROM {$this->table}";
            
            if (!empty($orderBy)) {
                $sql .= " ORDER BY {$orderBy}";
            }
            
            if ($limit > 0) {
                $sql .= " LIMIT {$limit}";
                
                if ($offset > 0) {
                    $sql .= " OFFSET {$offset}";
                }
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError("Error getting all records from {$this->table}", $e);
            return [];
        }
    }
    
    /**
     * Find records by criteria
     * 
     * @param array $criteria Criteria (column => value pairs)
     * @param array $columns Columns to select (default: all)
     * @param string $orderBy Order by clause (default: empty)
     * @param int $limit Limit (default: 0 = no limit)
     * @param int $offset Offset (default: 0)
     * @return array Records
     */
    public function findWhere($criteria, $columns = ['*'], $orderBy = '', $limit = 0, $offset = 0) {
        try {
            $columnsString = $columns === ['*'] ? '*' : implode(', ', $columns);
            $sql = "SELECT {$columnsString} FROM {$this->table}";
            
            $conditions = [];
            $values = [];
            
            foreach ($criteria as $column => $value) {
                $conditions[] = "{$column} = ?";
                $values[] = $value;
            }
            
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
            
            if (!empty($orderBy)) {
                $sql .= " ORDER BY {$orderBy}";
            }
            
            if ($limit > 0) {
                $sql .= " LIMIT {$limit}";
                
                if ($offset > 0) {
                    $sql .= " OFFSET {$offset}";
                }
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($values);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError("Error finding records in {$this->table} with criteria", $e);
            return [];
        }
    }
    
    /**
     * Count records by criteria
     * 
     * @param array $criteria Criteria (column => value pairs)
     * @return int Count
     */
    public function count($criteria = []) {
        try {
            $sql = "SELECT COUNT(*) FROM {$this->table}";
            
            $conditions = [];
            $values = [];
            
            foreach ($criteria as $column => $value) {
                $conditions[] = "{$column} = ?";
                $values[] = $value;
            }
            
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($values);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            $this->logError("Error counting records in {$this->table}", $e);
            return 0;
        }
    }
    
    /**
     * Insert a new record
     * 
     * @param array $data Record data (column => value pairs)
     * @return int|bool Last insert ID if successful, false otherwise
     */
    public function insert($data) {
        try {
            $columns = array_keys($data);
            $placeholders = array_fill(0, count($columns), '?');
            
            $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array_values($data));
            
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            $this->logError("Error inserting record into {$this->table}", $e);
            return false;
        }
    }
    
    /**
     * Update a record
     * 
     * @param int $id Record ID
     * @param array $data Record data (column => value pairs)
     * @return bool Whether the update was successful
     */
    public function update($id, $data) {
        try {
            $sets = [];
            $values = [];
            
            foreach ($data as $column => $value) {
                $sets[] = "{$column} = ?";
                $values[] = $value;
            }
            
            $values[] = $id;
            
            $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE {$this->primaryKey} = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            $this->logError("Error updating record in {$this->table}", $e);
            return false;
        }
    }
    
    /**
     * Update records by criteria
     * 
     * @param array $criteria Criteria (column => value pairs)
     * @param array $data Record data (column => value pairs)
     * @return bool Whether the update was successful
     */
    public function updateWhere($criteria, $data) {
        try {
            $sets = [];
            $values = [];
            
            foreach ($data as $column => $value) {
                $sets[] = "{$column} = ?";
                $values[] = $value;
            }
            
            $conditions = [];
            
            foreach ($criteria as $column => $value) {
                $conditions[] = "{$column} = ?";
                $values[] = $value;
            }
            
            $sql = "UPDATE {$this->table} SET " . implode(', ', $sets);
            
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            $this->logError("Error updating records in {$this->table} with criteria", $e);
            return false;
        }
    }
    
    /**
     * Delete a record
     * 
     * @param int $id Record ID
     * @return bool Whether the deletion was successful
     */
    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            $this->logError("Error deleting record from {$this->table}", $e);
            return false;
        }
    }
    
    /**
     * Delete records by criteria
     * 
     * @param array $criteria Criteria (column => value pairs)
     * @return bool Whether the deletion was successful
     */
    public function deleteWhere($criteria) {
        try {
            $conditions = [];
            $values = [];
            
            foreach ($criteria as $column => $value) {
                $conditions[] = "{$column} = ?";
                $values[] = $value;
            }
            
            $sql = "DELETE FROM {$this->table}";
            
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            $this->logError("Error deleting records from {$this->table} with criteria", $e);
            return false;
        }
    }
    
    /**
     * Execute a raw SQL query
     * 
     * @param string $sql SQL query
     * @param array $params Query parameters
     * @param bool $fetchAll Whether to fetch all results (default: true)
     * @return mixed Query results
     */
    public function query($sql, $params = [], $fetchAll = true) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            if ($fetchAll) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            $this->logError("Error executing query: {$sql}", $e);
            return $fetchAll ? [] : false;
        }
    }
    
    /**
     * Execute a raw SQL statement (non-query)
     * 
     * @param string $sql SQL statement
     * @param array $params Statement parameters
     * @return bool Whether the statement was executed successfully
     */
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            $this->logError("Error executing statement: {$sql}", $e);
            return false;
        }
    }
    
    /**
     * Begin a transaction
     * 
     * @return bool Whether the transaction was started successfully
     */
    public function beginTransaction() {
        try {
            return $this->pdo->beginTransaction();
        } catch (PDOException $e) {
            $this->logError("Error beginning transaction", $e);
            return false;
        }
    }
    
    /**
     * Commit a transaction
     * 
     * @return bool Whether the transaction was committed successfully
     */
    public function commit() {
        try {
            return $this->pdo->commit();
        } catch (PDOException $e) {
            $this->logError("Error committing transaction", $e);
            return false;
        }
    }
    
    /**
     * Rollback a transaction
     * 
     * @return bool Whether the transaction was rolled back successfully
     */
    public function rollback() {
        try {
            return $this->pdo->rollBack();
        } catch (PDOException $e) {
            $this->logError("Error rolling back transaction", $e);
            return false;
        }
    }
    
    /**
     * Get the PDO instance
     * 
     * @return PDO The PDO instance
     */
    public function getPdo() {
        return $this->pdo;
    }
}
