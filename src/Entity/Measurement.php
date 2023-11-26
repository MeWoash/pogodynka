<?php

namespace App\Entity;

use App\Repository\MeasurementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasurementRepository::class)]
class Measurement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'measurements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_of_measurement = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: '0')]
    private ?string $temperature = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: '0', nullable: true)]
    private ?string $wind_speed = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2, nullable: true)]
    private ?string $humidity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: '0', nullable: true)]
    private ?string $atm_pressure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDateOfMeasurement(): ?\DateTimeInterface
    {
        return $this->date_of_measurement;
    }

    public function setDateOfMeasurement(\DateTimeInterface $date_of_measurement): static
    {
        $this->date_of_measurement = $date_of_measurement;

        return $this;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(string $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getWindSpeed(): ?string
    {
        return $this->wind_speed;
    }

    public function setWindSpeed(?string $wind_speed): static
    {
        $this->wind_speed = $wind_speed;

        return $this;
    }

    public function getHumidity(): ?string
    {
        return $this->humidity;
    }

    public function setHumidity(?string $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getAtmPressure(): ?string
    {
        return $this->atm_pressure;
    }

    public function setAtmPressure(?string $atm_pressure): static
    {
        $this->atm_pressure = $atm_pressure;

        return $this;
    }

    public function getFahrenheit(): ?string
    {
        $fahrenheit = $this->temperature * 9 / 5 + 32;
        return "$fahrenheit";
    }
}
