<?php

namespace App\Entity;

use App\Repository\PresenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresenceRepository::class)]
class Presence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_day = null;

    #[ORM\Column]
    private ?\DateTime $arrival_hour = null;

    #[ORM\Column]
    private ?\DateTime $departure_time = null;

    #[ORM\ManyToOne(inversedBy: 'presences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Child $child = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDay(): ?\DateTimeImmutable
    {
        return $this->date_day;
    }

    public function setDateDay(\DateTimeImmutable $date_day): static
    {
        $this->date_day = $date_day;

        return $this;
    }

    public function getArrivalHour(): ?\DateTime
    {
        return $this->arrival_hour;
    }

    public function setArrivalHour(\DateTime $arrival_hour): static
    {
        $this->arrival_hour = $arrival_hour;

        return $this;
    }

    public function getDepartureTime(): ?\DateTime
    {
        return $this->departure_time;
    }

    public function setDepartureTime(\DateTime $departure_time): static
    {
        $this->departure_time = $departure_time;

        return $this;
    }

    public function getChild(): ?Child
    {
        return $this->child;
    }

    public function setChild(?Child $child): static
    {
        $this->child = $child;

        return $this;
    }
}
