<?php

namespace App\Entity;

use App\Repository\UrlRepository;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[Orm\Entity(repositoryClass: UrlRepository::class)]
#[Orm\Table(name: "short_urls")]
#[Orm\HasLifecycleCallbacks]
class Url
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'original_url', type: 'string',length: 2048)]
    private string $originalUrl;

    #[ORM\Column(name: 'short_code', type: 'string', length: 64, unique: true)]
    private string $shortCode;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalUrl(): string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl): self
    {
        $this->originalUrl = $originalUrl;
        return $this;
    }

    public function getShortCode(): string
    {
        return $this->shortCode;
    }

    public function setShortCode(string $shortCode): self
    {
        $this->shortCode = $shortCode;
        return $this;
    }


    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new DateTimeImmutable('now');
    }

}
