<?php

namespace AppBundle;
class Book
{
    /**
     * @var string
     */
    public $title = 'title';
    /**
     * @var string
     */
    public $author;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}