<?php

namespace App\Entity;

use App\Repository\InstallementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InstallementRepository::class)
 */
class Installement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $debt_id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $installement_no;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $principal;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebtId(): ?int
    {
        return $this->debt_id;
    }

    public function setDebtId(?int $debt_id): self
    {
        $this->debt_id = $debt_id;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getInstallementNo(): ?int
    {
        return $this->installement_no;
    }

    public function setInstallementNo(?int $installement_no): self
    {
        $this->installement_no = $installement_no;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrincipal(): ?float
    {
        return $this->principal;
    }

    public function setPrincipal(?float $principal): self
    {
        $this->principal = $principal;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->Status;
    }

    public function setStatus(?bool $Status): self
    {
        $this->Status = $Status;

        return $this;
    }
}
