<?php
namespace DataBase\Implementations;

class TableManipulator
{
    public function __construct($conn)
    {
        $this->partOfNamespace = "DataBase\Tables\\";
        $this->conn = $conn;

        $this->tablesNamespaces = [
            'users' => $this->partOfNamespace . "Users",
            'user_components' => $this->partOfNamespace . "UserComponents",
        ];
    }

    public function create($keyForStatement)
    {
        $tableImplementorNamespace = $this->getTableImplementorNamespace($keyForStatement);
        $tableImplementation = new $tableImplementorNamespace();
        $tableCreationStatement = $tableImplementation->getTableDef();

        $this->conn->exec($tableCreationStatement);
        
        return $tableImplementation->getTableName();
        
    }

    private function getTableImplementorNamespace($keyForStatement)
    {
        foreach($this->tablesNamespaces as $key => $namespace) {
            if ($key === $keyForStatement) {
                return $namespace;
            }
        }

        throw new InvalidArgumentException('Passed in ' . $keyForStatement . ' is not being supported');
    }
}