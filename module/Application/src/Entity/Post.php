<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a single post in a blog.
 * @ORM\Entity(repositoryClass="\Application\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post 
{
    // Post status constants.
    const STATUS_DRAFT       = 1; // Draft.
    const STATUS_PUBLISHED   = 2; // Published.

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** 
     * @ORM\Column(name="title")  
     */
    protected $title;

    /**
     * @ORM\Column(name="description")
     */
    protected $description;

    /**
     * @ORM\Column(name="short_description")
     */
    protected $shortDescription;

    /**
     * @ORM\Column(name="binomial_name")
     */
    protected $binomialName;

    /**
     * @ORM\Column(name="family")
     */
    protected $family;

    /**
     * @ORM\Column(name="genus")
     */
    protected $genus;

    /**
     * @ORM\Column(name="national_country")
     */
    protected $nationalCountry;

    /**
     * @ORM\Column(name="city")
     */
    protected $city;

    /**
     * @ORM\Column(name="bloom_start")
     */
    protected $bloomStart	;

    /**
     * @ORM\Column(name="bloom_end")
     */
    protected $bloomEnd;

    /**
     * @ORM\Column(name="image")
     */
    protected $image;

    /** 
     * @ORM\Column(name="status")  
     */
    protected $status;

    /**
     * @ORM\Column(name="date_created")  
     */
    protected $dateCreated;
    
    /**
     * @ORM\OneToMany(targetEntity="\Application\Entity\Comment", mappedBy="post")
     * @ORM\JoinColumn(name="id", referencedColumnName="post_id")
     */
    protected $comments;
    
    /**
     * @ORM\ManyToMany(targetEntity="\Application\Entity\Tag", inversedBy="posts")
     * @ORM\JoinTable(name="post_tag",
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     */
    protected $tags;
    
    /**
     * Constructor.
     */
    public function __construct() 
    {
        $this->comments = new ArrayCollection();        
        $this->tags = new ArrayCollection();        
    }

    /**
     * Returns ID of this post.
     * @return integer
     */
    public function getId() 
    {
        return $this->id;
    }

    /**
     * Sets ID of this post.
     * @param int $id
     */
    public function setId($id) 
    {
        $this->id = $id;
    }

    /**
     * Returns title.
     * @return string
     */
    public function getTitle() 
    {
        return $this->title;
    }

    /**
     * Sets title.
     * @param string $title
     */
    public function setTitle($title) 
    {
        $this->title = $title;
    }

    /**
     * Returns status.
     * @return integer
     */
    public function getStatus() 
    {
        return $this->status;
    }

    /**
     * Sets status.
     * @param integer $status
     */
    public function setStatus($status) 
    {
        $this->status = $status;
    }   
    
    /**
     * Returns post description.
     */
    public function getDescription()
    {
       return $this->description;
    }
    
    /**
     * Sets post description.
     * @param type $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns shortDescription.
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Sets post shortDescription.
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * Returns shortDescription.
     * @return string
     */
    public function getBinomialName()
    {
        return $this->binomialName;
    }

    /**
     * Sets post binomialName.
     * @param string $binomialName
     */
    public function setBinomialName($binomialName)
    {
        $this->binomialName = $binomialName;
    }

    /**
     * Returns family.
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Sets post family.
     * @param string $family
     */
    public function setFamily($family)
    {
        $this->family = $family;
    }

    /**
     * Returns genus.
     * @return string
     */
    public function getGenus()
    {
        return $this->genus;
    }

    /**
     * Sets post genus.
     * @param string $genus
     */
    public function setGenus($genus)
    {
        $this->genus = $genus;
    }

    /**
     * Returns nationalCountry.
     * @return string
     */
    public function getNationalCountry()
    {
        return $this->nationalCountry;
    }

    /**
     * Sets post nationalCountry.
     * @param string $nationalCountry
     */
    public function setNationalCountry($nationalCountry)
    {
        $this->nationalCountry = $nationalCountry;
    }

    /**
     * Returns city.
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets post city.
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns bloomStart.
     * @return integer
     */
    public function getBloomStart()
    {
        return $this->bloomStart;
    }

    /**
     * Sets post bloomStart.
     * @param integer $bloomStart
     */
    public function setBloomStart($bloomStart)
    {
        $this->bloomStart = $bloomStart;
    }

    /**
     * Returns bloomEnd.
     * @return integer
     */
    public function getBloomEnd()
    {
        return $this->bloomEnd;
    }

    /**
     * Sets post bloomEnd.
     * @param integer $bloomEnd
     */
    public function setBloomEnd($bloomEnd)
    {
        $this->bloomEnd = $bloomEnd;
    }

    /**
     * Returns image.
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets post image.
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
    
    /**
     * Returns the date when this post was created.
     * @return string
     */
    public function getDateCreated() 
    {
        return $this->dateCreated;
    }
    
    /**
     * Sets the date when this post was created.
     * @param string $dateCreated
     */
    public function setDateCreated($dateCreated) 
    {
        $this->dateCreated = $dateCreated;
    }
    
    /**
     * Returns comments for this post.
     * @return array
     */
    public function getComments() 
    {
        return $this->comments;
    }
    
    /**
     * Adds a new comment to this post.
     * @param $comment
     */
    public function addComment($comment) 
    {
        $this->comments[] = $comment;
    }
    
    /**
     * Returns tags for this post.
     * @return array
     */
    public function getTags() 
    {
        return $this->tags;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $tag
     */
    public function addTag($tag) 
    {
        $this->tags[] = $tag;        
    }
    
    /**
     * Removes association between this post and the given tag.
     * @param type $tag
     */
    public function removeTagAssociation($tag) 
    {
        $this->tags->removeElement($tag);
    }
}

