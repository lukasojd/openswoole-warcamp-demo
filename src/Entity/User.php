<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity]
#[ORM\Table(name: 'users_test')]
class User
{
    use IdIdentifier;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private string $email;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private string $description;

    public function __construct(
        string $name,
        string $email,
        string $description
    ) {
        $this->id = UuidV4::v4();
        $this->setName($name);
        $this->setEmail($email);
        $this->setDescription($description);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
