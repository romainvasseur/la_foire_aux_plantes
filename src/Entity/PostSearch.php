<?php

namespace App\Entity;

class PostSearch {
    
    private $dpt;

    private $posttype;

    private $category;

    private $description;

    private $title;

    public function getDpt()
    {
        return $this->dpt;
    }

    public function setDpt($dpt)
    {
        $this->dpt = $dpt;
        return $this;
    }

    public function getPosttype()
    {
        return $this->posttype;
    }

    public function setPosttype($posttype)
    {
        $this->posttype = $posttype;
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

}