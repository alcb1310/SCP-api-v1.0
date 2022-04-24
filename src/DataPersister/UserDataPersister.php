<?php

namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements DataPersisterInterface
{
    private $em;
    private $passwordHasherInterface;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasherInterface)
    {
        $this->em = $em;
        $this->passwordHasherInterface = $passwordHasherInterface;
    }

    public function supports($data): bool
    {
        return $data instanceof User;
    }

    /**
     * persist
     *
     * @param  User $data
     */
    public function persist($data)
    {
        if ($data->getPlainPassword()){
            $hashedPassword = $this->passwordHasherInterface->hashPassword($data, $data->getPlainPassword());

            $data->setPassword($hashedPassword);
            $data->eraseCredentials();
        }
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}
