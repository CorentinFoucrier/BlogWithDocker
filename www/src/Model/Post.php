<?php
namespace App\Model;

class Post
{
    /**
     * @var string
     * @access private
     */
    private $created_at;
    /**
     * @var int
     * @access private
     */
    private $id;
    /**
     * @var string
     * @access private
     */
    private $content;
    /**
     * @var string
     * @access private
     */
    private $slug;
    /**
     * @var string
     * @access private
     */
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