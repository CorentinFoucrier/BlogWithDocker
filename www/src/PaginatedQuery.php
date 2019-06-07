<?php

namespace App;

class PaginatedQuery {

    private $queryCount;

    private $query;

    private $classMapping;

    private $url;

    private $perPage;

    private $pdo;

    private $nbPage;

    public function __construct
    (
        string $queryCount,
        string $query,
        string $classMapping,
        string $url,
        int    $perPage = 12
    )
    {
        $this->queryCount   = $queryCount;
        $this->query        = $query;
        $this->classMapping = $classMapping;
        $this->url          = $url;
        $this->perPage      = $perPage;
        $this->pdo          = Connexion::getPdo();
    }

    public function getItems(): ?array
    {
        $nbpost = $this->pdo->query($this->queryCount)->fetch()[0];

        $this->nbPage = ceil($nbpost / $this->perPage);

        if ($this->getCurrentpage() > $this->nbPage) {
            throw new \Exception('pas de pages');
        }

        $offset = ($this->getCurrentpage() - 1) * $this->perPage;

        $statement = $this->pdo->query($this->query . " LIMIT {$this->perPage} OFFSET {$offset}");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->classMapping);
        /**@var Post[]|false */
        return $statement->fetchAll();
    }

    public function getNav(): array
    {
        for ($i = 1; $i <= $this->nbPage; $i++) :
            $class = $this->getCurrentPage() == $i ? "active" : "";
            $this->url = $i == $this->url ? "" : "?page=" . $i;
            "<li><a class='{$class}' href='/{$uri}'>{$i}</a></li>";
        endfor;
    }

    public function getPage(): int
    {
        $nbpost = $this->pdo->query($this->queryCount)->fetch()[0];
        $nbPage = ceil($nbpost / $this->perpage);
        return $nbPage;
    }

    private function getCurrentPage()
    {
        return URL::getPositiveInt('page', 1);
    }
}