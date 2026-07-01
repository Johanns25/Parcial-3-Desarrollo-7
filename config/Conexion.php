<?php
class Conexion
{
    private static ?self $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $dsn = 'mysql:host=127.0.0.1;port=3306;dbname=parcial_3;charset=utf8mb4';

        try {
            $this->pdo = new PDO($dsn, 'root', '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new Exception('No fue posible conectar con la base de datos: ' . $e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function fetchOne(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();
        return $result ?: null;
    }

    public function insert(string $table, array $data): int
    {
        $fields = array_keys($data);
        $placeholders = array_map(static fn($field) => ':' . $field, $fields);
        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, implode(', ', $fields), implode(', ', $placeholders));
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $sets = array_map(static fn($field) => $field . ' = :' . $field, array_keys($data));
        $sql = sprintf('UPDATE %s SET %s WHERE %s', $table, implode(', ', $sets), $where);
        $stmt = $this->pdo->prepare($sql);
        $params = array_merge($data, $whereParams);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
}
