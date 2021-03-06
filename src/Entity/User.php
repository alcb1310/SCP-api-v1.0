<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            'validation_groups' => [
                'Default', 'create'
            ],
        ]
    ],
    itemOperations:[
        'get',
        'put' => [
            'security' => 'is_granted("ROLE_USER")',
        ]
    ],
    normalizationContext:[
        'groups' => ['user:read']
    ],
    denormalizationContext:[
        'groups' => ['user:write']
    ]
)]
#[ApiFilter(SearchFilter::class, properties:['username' => 'exact'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups([
        'user:read',
        'user:write'
    ])]
    #[Assert\NotBlank(
        message: 'Ingrese un nombre de usuario'
    )]
    #[Assert\Length(
        min: 5,
        minMessage: 'El nombre de usuario debe tener al menos 5 caracteres'
    )]
    private $username;

    #[ORM\Column(type: 'json')]
    #[Groups([
        'user:write'
    ])]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        'user:read',
        'user:write'
    ])]
    #[Assert\NotBlank(
        message: 'Ingrese el nombre del usuario'
    )]
    private $nombre;

    #[Groups([
        'user:write'
    ])]
    #[SerializedName('password')]
    #[Assert\NotBlank(
        message: 'Ingrese una contrase??a',
        groups: ['create']
    )]
    #[Assert\Length(
        min: 5,
        minMessage: 'Contrase??a debe ser de al menos 5 caracteres'
    )]
    private $plainPassword;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
