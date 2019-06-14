<?php
namespace App\Model;

class Post
{

    private $created_at;

    private $id;

    private $content;

    private $slug;

    private $name;

    private $categories = [];

    public function getCreatedAt($format = 'd/m/Y h:i') :string
    {
        return (new \DateTime($this->created_at))->format($format);
    }

    public function getId() :int
    {
        return (int)$this->id;
    }

    public function getContent() :string
    {
        return $this->content;
    }

    public function getSlug() :string
    {
        return $this->slug;
    }

    public function getName() :string
    {
        return $this->name;
    }

    public function setCategories($categoriesParam)
    {
        $this->categories = $categoriesParam;
    }

    public function getCategories() :array
    {
        return $this->categories;
    }

    public static function categoriesQuery(int $id) :array
    {
        $pdo = \App\Connexion::getPdo();
        $query = $pdo->prepare("
        SELECT c.id, c.slug, c.name
        FROM post_category pc
        JOIN category c ON pc.category_id = c.id
        WHERE pc.post_id = :id
        ");
        $query->execute([":id" => $id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        /** @var Post|false */
        return $query->fetchAll();
    }
}
