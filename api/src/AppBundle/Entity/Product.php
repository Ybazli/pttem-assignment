<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Any offered product or service. For example: a pair of shoes; a concert ticket; the rental of a car; a haircut; or an episode of a TV show streamed online.
 *
 * @see http://schema.org/Product Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Product" , attributes={"order"={"created_at": "DESC"}} )
 */
class Product
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @var string|null the name of the item
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\")
     * @ApiProperty(iri="http://schema.org/name")
     */
    private $name;

    /**
     * @var string|null URL of the item
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\")
     * @ApiProperty(iri="http://schema.org/url")
     */
    private $url;

    /**
     * @var string|null An image of the item. This can be a \[\[URL\]\] or a fully described \[\[ImageObject\]\].
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\")
     * @ApiProperty(iri="http://schema.org/image")
     */
    private $image;

    /**
     * @var bool|null
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $availability;

    /**
     * @var string|null a description of the item
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/description")
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\")
     * @ORM\JoinColumn(nullable=false)
     */
    private $provider;

    /**
     * @var Collection<String>|null A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
     * @ApiProperty(iri="http://schema.org/category")
     */
    private $categories;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date
     */
    private $created_at;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->created_at = new \DateTime();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string|null $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string|null $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return string|null
     */
    public function getImage()
    {
        return $this->image;
    }

    public function setAvailability(?bool $availability): void
    {
        $this->availability = $availability;
    }

    public function getAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $provider
     */
    public function setProvider($provider): void
    {
        $this->provider = $provider;
    }

    /**
     * @return string|null
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param string $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }


    public function getCategory(): string
    {
        return $this->category;
    }


    public function setCreated_at(?\DateTimeInterface $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getCreated_at(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /** @ORM\PreFlush() */
    public function preFlush(PreFlushEventArgs $eventArgs): void
    {
        $this->url = $_ENV['APP_URL'] . 'api/products/' .$this->getId();
    }
}
