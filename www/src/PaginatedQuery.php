<?php

namespace App;

class PaginatedQuery {

    /**
     * @var string
     * @access private
     */
    private $queryCount;

    /**
     * @var string
     * @access private
     */
    private $query;

    /**
     * @var string
     * @access private
     */
    private $classMapping;

    /**
     * @var string
     * @access private
     */
    private $url;

    /**
     * @var int
     * @access private
     */
    private $perPage;

    /**
     * @var string
     * @access private
     */
    private $pdo;

    /**
     * @var array
     * @access private
     */
    private $items;

    /**
     * @var int
     * @access private
     */
    private $count;

    /**
     * Constructeur
     */
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

    /**
     * Liste des éléments d'une pages
     */
    public function getItems(): ?array
    {
        $nbPage = $this->getNbPages();

        if ($this->getCurrentpage() > $nbPage) {
            throw new \Exception('pas de pages');
        }
        
        if ($this->items === null) {
            $offset = ($this->getCurrentpage() - 1) * $this->perPage;
            $statement = $this->pdo->query($this->query . " LIMIT {$this->perPage} OFFSET {$offset}");
            $statement->setFetchMode(\PDO::FETCH_CLASS, $this->classMapping);
            /** @var Post[]|false */
            $this->items = $statement->fetchAll();
        }

        return $this->items;
    }

    /**
     * retourne un tableau [(int)noPage => url, ...]
     */
    public function getNav(): array
    {
        $uri = $this->url;
        $nbPage = $this->getNbPages();

        $navArray = [];
        for ($i=1; $i <= $nbPage; $i++) { 
            $url = $i == 1 ? $uri : $uri . "?page=" . $i;
            $navArray[$i] = $url;
        }
        return $navArray;
    }

    public function getNavHtml(): string
    {
        $urls = $this->getNav();
        $html = "";
        $currentPage = $this->getCurrentPage();

        $classBefore = $currentPage  == 1 ? "dnone" : "";
        $html .= "<li class=\"{$classBefore}\">";
        if ($currentPage  == 1) :
            $html .= "<a>&laquo</a>";
        else :
            $html .= "<a href=\"?page=". ($currentPage - 1) ."\">&laquo;</a>";
        endif;
        $html .= "</li>";

        foreach ($urls as $key => $url) {
            $class = $currentPage  == $key ? "active" : "";
            $html .= "<li><a class=\"{$class}\" href=\"{$url}\">{$key}</a></li>";
        }

        $classAfter = $currentPage  == $this->getNbPages() ? "dnone" : "";
        $html .= "<li class=\"{$classAfter}\">";
        if ($currentPage  == $this->getNbPages()) {
            $html .= "<a>&raquo</a>";
        } else {
            $html .= "<a href=\"?page=". ($currentPage + 1) ."\">&raquo;</a>";
        }
        $html .= "</li>";

        return <<<HTML
        <nav class="footer">
            <div>
                <ul class="pagination">
                    {$html}
                </ul>
            </div>
        </nav>
HTML;
    }

    /**
     * Retourne le nb de la page courrante recup dans le GET
     */
    private function getCurrentPage()
    {
        return URL::getPositiveInt('page', 1);
    }

    /**
     * retourne le nb total de pages en fonction du nb de post affiché par page
     */
    private function getNbPages(): float
    {
        if ($this->count === null) {
            $this->count = $this->pdo
                ->query($this->queryCount)
                ->fetch()[0];
        }
        return ceil($this->count / $this->perPage);
    }
}