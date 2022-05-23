<?php

namespace App\Entity;

use App\Repository\DebtRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DebtRepository::class)
 */
class Debt
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
    private $debt_owner_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $debt_type_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $installement_count;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $total_amount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $debt_start_date;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $bank_info;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_url;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $principal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebtOwnerId(): ?int
    {
        return $this->debt_owner_id;
    }

    public function setDebtOwnerId(?int $debt_owner_id): self
    {
        $this->debt_owner_id = $debt_owner_id;

        return $this;
    }

    public function getDebtTypeId(): ?int
    {
        return $this->debt_type_id;
    }

    public function setDebtTypeId(?int $debt_type_id): self
    {
        $this->debt_type_id = $debt_type_id;

        return $this;
    }

    public function getInstallementCount(): ?int
    {
        return $this->installement_count;
    }

    public function setInstallementCount(?int $installement_count): self
    {
        $this->installement_count = $installement_count;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->total_amount;
    }

    public function setTotalAmount(?float $total_amount): self
    {
        $this->total_amount = $total_amount;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getLastPaymentDate(): ?\DateTimeInterface
    {
        return $this->last_payment_date;
    }

    public function setLastPaymentDate(?\DateTimeInterface $last_payment_date): self
    {
        $this->last_payment_date = $last_payment_date;

        return $this;
    }

    public function getDebtStartDate(): ?\DateTimeInterface
    {
        return $this->debt_start_date;
    }

    public function setDebtStartDate(?\DateTimeInterface $debt_start_date): self
    {
        $this->debt_start_date = $debt_start_date;

        return $this;
    }

    public function getBankInfo(): ?string
    {
        return $this->bank_info;
    }

    public function setBankInfo(?string $bank_info): self
    {
        $this->bank_info = $bank_info;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $image_url): self
    {
        $this->image_url = $image_url;

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
}
