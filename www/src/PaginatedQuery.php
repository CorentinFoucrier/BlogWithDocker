<?php

namespace App;

class PaginatedQuery {

    private $queryCount;

    private $query;

    private $classMapping;

    private $url;

    private $perPage;

    private $pdo;

    public function __construct(
        string $queryCount,
        string $query,
        string $classMapping,
        string $url,
        int $perPage = 12)
    {
        $this->queryCount = $queryCount;
        $this->query = $query;
        $this->classMapping = $classMapping;
        $this->url = $url;
        $this->perPage = $perPage;
        $this->pdo = Connexion::getPdo();
    }

    public function getItems(): ?array
    {
        $nbpost = $this->pdo->query($this->queryCount)->fetch()[0];

        $nbPage = ceil($nbpost / $this->perPage);

        if ((int)$_GET["page"] > $nbPage) {
            throw new Exception('pas de pages');
        }

        if (isset($_GET["page"])) {
            $currentpage = (int)$_GET["page"];
        } else {
            $currentpage = 1;
        }

        $offset = ($currentpage - 1) * $this->perPage;

        $statement = $this->pdo->query($this->query . " LIMIT {$this->perPage} OFFSET {$offset}");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->classMapping);
        /**@var Post[]|false */
        return $statement->fetchAll();
    }

    public function getNav()
    {
        
    }
}