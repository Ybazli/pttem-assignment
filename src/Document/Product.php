<?php

    namespace App\Document;

    use ApiPlatform\Core\Annotation\ApiResource;
    use Symfony\Component\Validator\Constraints as Assert;
    use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

    /**
     *  @ApiResource(attributes={"order"={"created_at": "DESC"}})
     * @ODM\HasLifecycleCallbacks()
     * @ODM\Document(db="pttem", collection="products")
     * @ApiResource(iri="http://schema.org/product")
     */
    class Product
    {

        public function __construct()
        {
            $this->created_at = new \DateTime();
        }

        /**
         * @ODM\Id(strategy="INCREMENT", type="integer")
         */
        public $id;

        public function setId(string $id): void
        {
            $this->id = $id;
        }

        public function getId(): ?string
        {
            return $this->id;
        }

        /**
         * @ODM\Field(type="string" , nullable=false)
         * @Assert\NotBlank()
         */
        public $name;

        public function setName(string $name): void
        {
            $this->name = $name;
        }

        public function getName(): ?string
        {
            return $this->name;
        }

        /**
         * @ODM\Field(type="string" , nullable=false)
         */
        public $url;

        public function setUrl(string $url): void
        {
            $this->url = $url;
        }

        public function getUrl(): ?string
        {
            return $this->url;
        }

        /**
         * @ODM\Field(type="string" , nullable=true)
         */
        public $image;

        public function setImage(string $image): void
        {
            $this->image = $image;
        }

        public function getImage(): ?string
        {
            return $this->image;
        }

        /**
         * @ODM\Field(type="string" , nullable=false)
         */
        public $category;

        public function setCategory(string $category): void
        {
            $this->category = $category;
        }

        public function getCategory(): ?string
        {
            return $this->category;
        }

        /**
         * @ODM\Field(type="string" , nullable=false)
         */
        public $provider;

        public function setProvider(string $provider): void
        {
            $this->provider = $provider;
        }

        public function getProvider(): ?string
        {
            return $this->provider;
        }

        /**
         * @ODM\Field(nullable=false)
         */
        public $description;

        public function getDescription(): ?string
        {
            return $this->description;
        }

        public function setDescription(string $description): void
        {
            $this->description = $description;
        }

        /**
         * @ODM\Field(type="float" , nullable=false)
         */
        public $price;

        public function setPrice(int $price): void
        {
            $this->price = $price;
        }

        /**
         * @ODM\Field(type="bool")
         * @Assert\NotBlank()
         */
        public $availability;

        public function setAvailability(bool $availability): void
        {
            $this->availability = $availability;
        }

        public function getAvailability(): ?string
        {
            return $this->availability;
        }

        /**
         * @ODM\Field(type="date")
         */
        public $created_at;

        /** @ODM\PreFlush() */
        public function preFlush(\Doctrine\ODM\MongoDB\Event\PreFlushEventArgs $eventArgs): void
        {
            $this->url = '/api/products/' .$this->getId();
        }

    }