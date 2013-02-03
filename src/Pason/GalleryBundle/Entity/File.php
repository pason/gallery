<?php

namespace Pason\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pason\GalleryBundle\Entity\File
 *
 * @ORM\Table(name="file")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Pason\GalleryBundle\Entity\FileRepository")
 */
class File
{
	
	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	
	/**
	 * @var string $name
	 * @ORM\Column(name="name", type="string", length=255, nullable=true)
	 */
	private $name;
	
	/**
	 * @var string $path
	 * @ORM\Column(name="path", type="string", length=255, nullable=true)
	 */
	private $path;
	
	/**
	 * @var string $url
	 */
	private $url;
	
	/**
	 * @var string $width
	 * @ORM\Column(name="width", type="string", length=255, nullable=true)
	 */
	private $width;
	
	/**
	 * @var string $height
	 * @ORM\Column(name="height", type="string", length=255, nullable=true)
	 */
	private $height;
		
	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="file", cascade={"persist"})
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $user;
	
	
	/**
	 * @Assert\NotBlank()
     * @Assert\File(maxSize="10M", mimeTypes = {
     *   "image/gif",
     *   "image/jpeg",
     *   "image/pjpeg",
     *   "image/png"
     * }) 
	 */
	public $file;
	
	/**
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(name="created", type="datetime")
	 */
	private $created;

	/**
	 * @ORM\Column(name="updated", type="datetime", nullable=true)
	 * @Gedmo\Timestampable(on="update")
	 */
	private $updated;

	/**
	 * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
	 */
	private $deletedAt;

    
	
	
	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function preUpload()
	{
		if (null !== $this->file) {
			$this->name = $this->file->getClientOriginalName();			
			$filename = sha1(uniqid(mt_rand(), true));
			$this->path = $filename.'.'.$this->file->guessExtension();
		}
	}
	
	/**
	 * @ORM\PostPersist()
	 * @ORM\PostUpdate()
	 */
	public function upload()
	{
		if (null === $this->file) {
			return;
		}
	
		$this->file->move($this->getUploadRootDir(), $this->path);
	
		unset($this->file);
	}
	
	/**
	 * @ORM\PostRemove()
	 */
	public function removeUpload()
	{
		if ($file = $this->getAbsolutePath()) {
			unlink($file);
		}
	}
	
	public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }
    
    protected function getUploadRootDir()
    {
    	
    	return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {   	
    	return 'uploads/media';
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
     * Set orginal
     *
     * @param string $orginal
     * @return File
     */
    public function setOrginal($orginal)
    {
        $this->orginal = $orginal;
    
        return $this;
    }

    /**
     * Get orginal
     *
     * @return string 
     */
    public function getOrginal()
    {
        return $this->orginal;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set width
     *
     * @param string $width
     * @return File
     */
    public function setWidth($width)
    {
        $this->width = $width;
    
        return $this;
    }

    /**
     * Get width
     *
     * @return string 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param string $height
     * @return File
     */
    public function setHeight($height)
    {
        $this->height = $height;
    
        return $this;
    }

    /**
     * Get height
     *
     * @return string 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return File
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return File
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return File
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return File
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    
        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set user
     *
     * @param \Pason\GalleryBundle\Entity\User $user
     * @return File
     */
    public function setUser(\Pason\GalleryBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Pason\GalleryBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}