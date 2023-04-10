<?php

namespace Harryn\Jacobn\SupportCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleFeedback
 * @ORM\Entity(repositoryClass=null)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="uv_article_feedback")
 */
class ArticleFeedback
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $isHelpful;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \Harryn\Jacobn\SupportCenterBundle\Entity\Article
     * @ORM\ManyToOne(targetEntity="Harryn\Jacobn\SupportCenterBundle\Entity\Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $article;

    /**
     * @var \Harryn\Jacobn\CoreFrameworkBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Harryn\Jacobn\CoreFrameworkBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $ratedCustomer;


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
     * Set isHelpful
     *
     * @param boolean $isHelpful
     * @return ArticleFeedback
     */
    public function setIsHelpful($isHelpful)
    {
        $this->isHelpful = $isHelpful;

        return $this;
    }

    /**
     * Get isHelpful
     *
     * @return boolean 
     */
    public function getIsHelpful()
    {
        return $this->isHelpful;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ArticleFeedback
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ArticleFeedback
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
     * Set article
     *
     * @param \Harryn\Jacobn\SupportCenterBundle\Entity\Article $article
     * @return ArticleFeedback
     */
    public function setArticle(\Harryn\Jacobn\SupportCenterBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Harryn\Jacobn\SupportCenterBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set ratedCustomer
     *
     * @param \Harryn\Jacobn\CoreFrameworkBundle\Entity\User $ratedCustomer
     * @return ArticleFeedback
     */
    public function setRatedCustomer(\Harryn\Jacobn\CoreFrameworkBundle\Entity\User $ratedCustomer = null)
    {
        $this->ratedCustomer = $ratedCustomer;

        return $this;
    }

    /**
     * Get ratedCustomer
     *
     * @return \Harryn\Jacobn\CoreFrameworkBundle\Entity\User 
     */
    public function getRatedCustomer()
    {
        return $this->ratedCustomer;
    }
}
