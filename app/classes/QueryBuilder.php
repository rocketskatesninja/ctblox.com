<?php
/**
 * QueryBuilder Class
 * 
 * Provides a fluent interface for building SQL queries.
 * This class helps reduce repetitive SQL code and standardizes query construction.
 */
class QueryBuilder {
    /**
     * @var PDO Database connection
     */
    protected $pdo;
    
    /**
     * @var string Current query type (SELECT, INSERT, UPDATE, DELETE)
     */
    protected $type;
    
    /**
     * @var string Table name
     */
    protected $table;
    
    /**
     * @var array Columns to select
     */
    protected $columns = [];
    
    /**
     * @var array Values for INSERT or UPDATE
     */
    protected $values = [];
    
    /**
     * @var array WHERE conditions
     */
    protected $wheres = [];
    
    /**
     * @var array JOIN clauses
     */
    protected $joins = [];
    
    /**
     * @var array GROUP BY clauses
     */
    protected $groups = [];
    
    /**
     * @var array HAVING clauses
     */
    protected $havings = [];
    
    /**
     * @var array ORDER BY clauses
     */
    protected $orders = [];
    
    /**
     * @var int|null LIMIT clause
     */
    protected $limit = null;
    
    /**
     * @var int|null OFFSET clause
     */
    protected $offset = null;
    
    /**
     * @var array Query parameters
     */
    protected $parameters = [];
    
    /**
     * @var ErrorHandler Error handler instance
     */
    protected $errorHandler;
    
    /**
     * Constructor
     * 
     * @param PDO $pdo Optional PDO connection (uses global $pdo if not provided)
     */
    public function __construct($pdo = null) {
        global $pdo as $globalPdo;
        $this->pdo = $pdo ?? $globalPdo;
        
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
     * Start a SELECT query
     * 
     * @param string $table Table name
     * @param array|string $columns Columns to select
     * @return QueryBuilder
     */
    public function select($table, $columns = ['*']) {
        $this->type = 'SELECT';
        $this->table = $table;
        $this->columns = is_array($columns) ? $columns : [$columns];
        return $this;
    }
    
    /**
     * Start an INSERT query
     * 
     * @param string $table Table name
     * @param array $values Values to insert (column => value pairs)
     * @return QueryBuilder
     */
    public function insert($table, $values) {
        $this->type = 'INSERT';
        $this->table = $table;
        $this->values = $values;
        return $this;
    }
    
    /**
     * Start an UPDATE query
     * 
     * @param string $table Table name
     * @param array $values Values to update (column => value pairs)
     * @return QueryBuilder
     */
    public function update($table, $values) {
        $this->type = 'UPDATE';
        $this->table = $table;
        $this->values = $values;
        return $this;
    }
    
    /**
     * Start a DELETE query
     * 
     * @param string $table Table name
     * @return QueryBuilder
     */
    public function delete($table) {
        $this->type = 'DELETE';
        $this->table = $table;
        return $this;
    }
    
    /**
     * Add a WHERE clause
     * 
     * @param string $column Column name
     * @param string $operator Comparison operator
     * @param mixed $value Value to compare against
     * @param string $boolean Boolean operator (AND, OR)
     * @return QueryBuilder
     */
    public function where($column, $operator = null, $value = null, $boolean = 'AND') {
        // Handle different parameter formats
        if ($operator === null && $value === null) {
            $this->wheres[] = [
                'type' => 'raw',
                'sql' => $column,
                'boolean' => $boolean
            ];
            return $this;
        }
        
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $this->wheres[] = [
            'type' => 'basic',
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'boolean' => $boolean
        ];
        
        $this->parameters[] = $value;
        
        return $this;
    }
    
    /**
     * Add an OR WHERE clause
     * 
     * @param string $column Column name
     * @param string $operator Comparison operator
     * @param mixed $value Value to compare against
     * @return QueryBuilder
     */
    public function orWhere($column, $operator = null, $value = null) {
        return $this->where($column, $operator, $value, 'OR');
    }
    
    /**
     * Add a WHERE IN clause
     * 
     * @param string $column Column name
     * @param array $values Values to compare against
     * @param string $boolean Boolean operator (AND, OR)
     * @return QueryBuilder
     */
    public function whereIn($column, $values, $boolean = 'AND') {
        $this->wheres[] = [
            'type' => 'in',
            'column' => $column,
            'values' => $values,
            'boolean' => $boolean
        ];
        
        $this->parameters = array_merge($this->parameters, $values);
        
        return $this;
    }
    
    /**
     * Add an OR WHERE IN clause
     * 
     * @param string $column Column name
     * @param array $values Values to compare against
     * @return QueryBuilder
     */
    public function orWhereIn($column, $values) {
        return $this->whereIn($column, $values, 'OR');
    }
    
    /**
     * Add a JOIN clause
     * 
     * @param string $table Table name
     * @param string $first First column
     * @param string $operator Comparison operator
     * @param string $second Second column
     * @param string $type Join type (INNER, LEFT, RIGHT)
     * @return QueryBuilder
     */
    public function join($table, $first, $operator = null, $second = null, $type = 'INNER') {
        // Handle different parameter formats
        if ($operator === null && $second === null) {
            $this->joins[] = [
                'type' => $type,
                'table' => $table,
                'sql' => $first
            ];
            return $this;
        }
        
        $this->joins[] = [
            'type' => $type,
            'table' => $table,
            'first' => $first,
            'operator' => $operator,
            'second' => $second
        ];
        
        return $this;
    }
    
    /**
     * Add a LEFT JOIN clause
     * 
     * @param string $table Table name
     * @param string $first First column
     * @param string $operator Comparison operator
     * @param string $second Second column
     * @return QueryBuilder
     */
    public function leftJoin($table, $first, $operator = null, $second = null) {
        return $this->join($table, $first, $operator, $second, 'LEFT');
    }
    
    /**
     * Add a RIGHT JOIN clause
     * 
     * @param string $table Table name
     * @param string $first First column
     * @param string $operator Comparison operator
     * @param string $second Second column
     * @return QueryBuilder
     */
    public function rightJoin($table, $first, $operator = null, $second = null) {
        return $this->join($table, $first, $operator, $second, 'RIGHT');
    }
    
    /**
     * Add a GROUP BY clause
     * 
     * @param string|array $columns Columns to group by
     * @return QueryBuilder
     */
    public function groupBy($columns) {
        $this->groups = array_merge($this->groups, is_array($columns) ? $columns : [$columns]);
        return $this;
    }
    
    /**
     * Add a HAVING clause
     * 
     * @param string $column Column name
     * @param string $operator Comparison operator
     * @param mixed $value Value to compare against
     * @param string $boolean Boolean operator (AND, OR)
     * @return QueryBuilder
     */
    public function having($column, $operator = null, $value = null, $boolean = 'AND') {
        // Handle different parameter formats
        if ($operator === null && $value === null) {
            $this->havings[] = [
                'type' => 'raw',
                'sql' => $column,
                'boolean' => $boolean
            ];
            return $this;
        }
        
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $this->havings[] = [
            'type' => 'basic',
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'boolean' => $boolean
        ];
        
        $this->parameters[] = $value;
        
        return $this;
    }
    
    /**
     * Add an OR HAVING clause
     * 
     * @param string $column Column name
     * @param string $operator Comparison operator
     * @param mixed $value Value to compare against
     * @return QueryBuilder
     */
    public function orHaving($column, $operator = null, $value = null) {
        return $this->having($column, $operator, $value, 'OR');
    }
    
    /**
     * Add an ORDER BY clause
     * 
     * @param string $column Column name
     * @param string $direction Sort direction (ASC, DESC)
     * @return QueryBuilder
     */
    public function orderBy($column, $direction = 'ASC') {
        $this->orders[] = [
            'column' => $column,
            'direction' => strtoupper($direction)
        ];
        return $this;
    }
    
    /**
     * Add a LIMIT clause
     * 
     * @param int $limit Limit
     * @return QueryBuilder
     */
    public function limit($limit) {
        $this->limit = $limit;
        return $this;
    }
    
    /**
     * Add an OFFSET clause
     * 
     * @param int $offset Offset
     * @return QueryBuilder
     */
    public function offset($offset) {
        $this->offset = $offset;
        return $this;
    }
    
    /**
     * Build the SQL query
     * 
     * @return string SQL query
     */
    public function toSql() {
        switch ($this->type) {
            case 'SELECT':
                return $this->buildSelectQuery();
            case 'INSERT':
                return $this->buildInsertQuery();
            case 'UPDATE':
                return $this->buildUpdateQuery();
            case 'DELETE':
                return $this->buildDeleteQuery();
            default:
                throw new Exception("Unsupported query type: {$this->type}");
        }
    }
    
    /**
     * Build a SELECT query
     * 
     * @return string SQL query
     */
    protected function buildSelectQuery() {
        $sql = "SELECT " . $this->buildColumns();
        $sql .= " FROM {$this->table}";
        $sql .= $this->buildJoins();
        $sql .= $this->buildWheres();
        $sql .= $this->buildGroups();
        $sql .= $this->buildHavings();
        $sql .= $this->buildOrders();
        $sql .= $this->buildLimit();
        $sql .= $this->buildOffset();
        
        return $sql;
    }
    
    /**
     * Build an INSERT query
     * 
     * @return string SQL query
     */
    protected function buildInsertQuery() {
        $columns = array_keys($this->values);
        $placeholders = array_fill(0, count($columns), '?');
        
        $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ")";
        $sql .= " VALUES (" . implode(', ', $placeholders) . ")";
        
        $this->parameters = array_values($this->values);
        
        return $sql;
    }
    
    /**
     * Build an UPDATE query
     * 
     * @return string SQL query
     */
    protected function buildUpdateQuery() {
        $sets = [];
        $this->parameters = [];
        
        foreach ($this->values as $column => $value) {
            $sets[] = "{$column} = ?";
            $this->parameters[] = $value;
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets);
        $sql .= $this->buildWheres();
        
        return $sql;
    }
    
    /**
     * Build a DELETE query
     * 
     * @return string SQL query
     */
    protected function buildDeleteQuery() {
        $sql = "DELETE FROM {$this->table}";
        $sql .= $this->buildWheres();
        
        return $sql;
    }
    
    /**
     * Build the columns part of a SELECT query
     * 
     * @return string Columns part
     */
    protected function buildColumns() {
        return implode(', ', $this->columns);
    }
    
    /**
     * Build the JOIN clauses
     * 
     * @return string JOIN clauses
     */
    protected function buildJoins() {
        if (empty($this->joins)) {
            return '';
        }
        
        $sql = '';
        
        foreach ($this->joins as $join) {
            $sql .= " {$join['type']} JOIN {$join['table']}";
            
            if (isset($join['sql'])) {
                $sql .= " ON {$join['sql']}";
            } else {
                $sql .= " ON {$join['first']} {$join['operator']} {$join['second']}";
            }
        }
        
        return $sql;
    }
    
    /**
     * Build the WHERE clauses
     * 
     * @return string WHERE clauses
     */
    protected function buildWheres() {
        if (empty($this->wheres)) {
            return '';
        }
        
        $sql = ' WHERE';
        $first = true;
        
        foreach ($this->wheres as $where) {
            if ($first) {
                $first = false;
            } else {
                $sql .= " {$where['boolean']}";
            }
            
            if ($where['type'] === 'raw') {
                $sql .= " {$where['sql']}";
            } elseif ($where['type'] === 'in') {
                $placeholders = array_fill(0, count($where['values']), '?');
                $sql .= " {$where['column']} IN (" . implode(', ', $placeholders) . ")";
            } else {
                $sql .= " {$where['column']} {$where['operator']} ?";
            }
        }
        
        return $sql;
    }
    
    /**
     * Build the GROUP BY clauses
     * 
     * @return string GROUP BY clauses
     */
    protected function buildGroups() {
        if (empty($this->groups)) {
            return '';
        }
        
        return ' GROUP BY ' . implode(', ', $this->groups);
    }
    
    /**
     * Build the HAVING clauses
     * 
     * @return string HAVING clauses
     */
    protected function buildHavings() {
        if (empty($this->havings)) {
            return '';
        }
        
        $sql = ' HAVING';
        $first = true;
        
        foreach ($this->havings as $having) {
            if ($first) {
                $first = false;
            } else {
                $sql .= " {$having['boolean']}";
            }
            
            if ($having['type'] === 'raw') {
                $sql .= " {$having['sql']}";
            } else {
                $sql .= " {$having['column']} {$having['operator']} ?";
            }
        }
        
        return $sql;
    }
    
    /**
     * Build the ORDER BY clauses
     * 
     * @return string ORDER BY clauses
     */
    protected function buildOrders() {
        if (empty($this->orders)) {
            return '';
        }
        
        $sql = ' ORDER BY';
        $first = true;
        
        foreach ($this->orders as $order) {
            if ($first) {
                $first = false;
            } else {
                $sql .= ',';
            }
            
            $sql .= " {$order['column']} {$order['direction']}";
        }
        
        return $sql;
    }
    
    /**
     * Build the LIMIT clause
     * 
     * @return string LIMIT clause
     */
    protected function buildLimit() {
        if ($this->limit === null) {
            return '';
        }
        
        return " LIMIT {$this->limit}";
    }
    
    /**
     * Build the OFFSET clause
     * 
     * @return string OFFSET clause
     */
    protected function buildOffset() {
        if ($this->offset === null) {
            return '';
        }
        
        return " OFFSET {$this->offset}";
    }
    
    /**
     * Execute the query and get all results
     * 
     * @return array Query results
     */
    public function get() {
        try {
            $sql = $this->toSql();
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($this->parameters);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError("Error executing query: {$sql}", $e);
            return [];
        }
    }
    
    /**
     * Execute the query and get the first result
     * 
     * @return array|bool Query result or false if not found
     */
    public function first() {
        try {
            $sql = $this->toSql();
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($this->parameters);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logError("Error executing query: {$sql}", $e);
            return false;
        }
    }
    
    /**
     * Execute the query and get a single column value
     * 
     * @param string $column Column name
     * @return mixed Column value or false if not found
     */
    public function value($column) {
        try {
            $sql = $this->toSql();
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($this->parameters);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            $this->logError("Error executing query: {$sql}", $e);
            return false;
        }
    }
    
    /**
     * Execute the query and get the count
     * 
     * @return int Count
     */
    public function count() {
        // Save original columns
        $originalColumns = $this->columns;
        
        // Set count column
        $this->columns = ['COUNT(*) as count'];
        
        try {
            $sql = $this->toSql();
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($this->parameters);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) ($result['count'] ?? 0);
        } catch (PDOException $e) {
            $this->logError("Error executing count query: {$sql}", $e);
            return 0;
        } finally {
            // Restore original columns
            $this->columns = $originalColumns;
        }
    }
    
    /**
     * Execute a non-query statement
     * 
     * @return bool Whether the statement was executed successfully
     */
    public function execute() {
        try {
            $sql = $this->toSql();
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($this->parameters);
        } catch (PDOException $e) {
            $this->logError("Error executing statement: {$sql}", $e);
            return false;
        }
    }
    
    /**
     * Execute an INSERT query and get the last insert ID
     * 
     * @return int|bool Last insert ID or false on failure
     */
    public function insertGetId() {
        try {
            $sql = $this->toSql();
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($this->parameters);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            $this->logError("Error executing insert query: {$sql}", $e);
            return false;
        }
    }
}
