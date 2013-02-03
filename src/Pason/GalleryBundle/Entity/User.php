<?php


namespace Pason\GalleryBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @Gedmo\Slug(fields={"username"})
	 * @ORM\Column(length=128, unique=false, nullable=true)
	 */
	private $slug;
	
	/**
	 * @ORM\OneToMany(targetEntity="File", mappedBy="user")
	 */
	private $file;
	
	
	/**
	 * @ORM\Column(type="boolean", name="is_private", nullable=false)
	 */
	private $isPrivate = false;

	
	public function __construct()
	{
		parent::__construct();		
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
     * Set slug
     *
     * @param string $slug
     * @return User
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add file
     *
     * @param \Pason\GalleryBundle\Entity\File $file
     * @return User
     */
    public function addFile(\Pason\GalleryBundle\Entity\File $file)
    {
        $this->file[] = $file;
    
        return $this;
    }

    /**
     * Remove file
     *
     * @param \Pason\GalleryBundle\Entity\File $file
     */
    public function removeFile(\Pason\GalleryBundle\Entity\File $file)
    {
        $this->file->removeElement($file);
    }

    /**
     * Get file
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set isPrivate
     *
     * @param boolean $isPrivate
     * @return User
     */
    public function setIsPrivate($isPrivate)
    {
        $this->isPrivate = $isPrivate;
    
        return $this;
    }

    /**
     * Get isPrivate
     *
     * @return boolean 
     */
    public function getIsPrivate()
    {
        return $this->isPrivate;
    }
}