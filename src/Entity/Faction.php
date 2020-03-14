<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactionRepository")
 */
class Faction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $factionName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactionName(): ?string
    {
        return $this->factionName;
    }

    public function setFactionName(string $factionName): self
    {
        $this->factionName = $factionName;

        return $this;
    }
}
