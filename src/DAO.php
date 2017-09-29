<?php


namespace Xandros15\Blog;

use PDO;

abstract class DAO
{
    /** @var \PDO */
    private $pdo;

    /**
     * DAO constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return string
     */
    abstract protected function getObjectClass(): string;

    /**
     * @param string $query
     * @param array $params
     *
     * @return mixed
     */
    protected function execute(string $query, array $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $execute = $stmt->execute($params);
        if ($execute && $this->isSelect($query)) {
            return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->getObjectClass());
        }

        return $execute;
    }

    /**
     * @param string $query
     *
     * @return bool
     */
    private function isSelect(string $query)
    {
        return strtoupper(substr($query, 0, 6)) == 'SELECT';
    }
}
