<?php
namespace App\Model;

class Post {
    private $created_at;

    private $id;

    private $content;

    private $slug;

    private $name;

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

}