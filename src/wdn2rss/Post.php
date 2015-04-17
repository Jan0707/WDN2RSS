<?php

namespace WDN2RSS;

class Post {

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var \DateTime
     */
    protected $published;

    /**
     * @var string
     */
    protected $shares;

    /**
     * @return float
     */
    public function getSharesCount()
    {
        if (substr($this->shares, -1) == 'K') {
            return floatval(substr($this->shares, 0, -1)) * 1000;
        } else {
            return $this->shares;
        }
    }

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

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return \DateTime
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param \DateTime $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * @return string
     */
    public function getShares()
    {
        return $this->shares;
    }

    /**
     * @param string $shares
     */
    public function setShares($shares)
    {
        $this->shares = $shares;
    }
}