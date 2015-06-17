<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Url
 *
 * @package AppBundle\Entity
 * @author Arkadius Stefanski <arkste@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table
 */
class Url
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Url()
     * @Assert\Length(min="3", max="255")
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max="32")
     */
    private $urlKey;

    /**
     * @ORM\Column(type="integer")
     */
    private $bookmarks = 0;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     * @Serializer\Exclude()
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     * @Serializer\Exclude()
     */
    private $updatedAt;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Url
     */
    public function setUrl($url)
    {
        $this->url = $url;
        $this->setUrlKey(md5($url));

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set urlKey
     *
     * @param string $urlKey
     * @return Url
     */
    public function setUrlKey($urlKey)
    {
        $this->urlKey = $urlKey;

        return $this;
    }

    /**
     * Get urlKey
     *
     * @return string
     */
    public function getUrlKey()
    {
        return $this->urlKey;
    }

    /**
     * Set bookmarks
     *
     * @param integer $bookmarks
     * @return Url
     */
    public function setBookmarks($bookmarks)
    {
        $this->bookmarks = $bookmarks;

        return $this;
    }

    /**
     * Get bookmarks
     *
     * @return integer
     */
    public function getBookmarks()
    {
        return $this->bookmarks;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Url
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Url
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
