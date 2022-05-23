<?php

namespace App\Entity;

use App\Repository\CreditCardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CreditCardRepository::class)
 */
class CreditCard
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $bank_info;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $card_holder;

    /**
     * @ORM\Column(type="string", length=40,  nullable=true)
     */
    private $card_no;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $card_limit;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $useful_limit;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $card_image_url;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $debt_type;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCardHolder(): ?int
    {
        return $this->card_holder;
    }

    public function setCardHolder(?int $card_holder): self
    {
        $this->card_holder = $card_holder;

        return $this;
    }

    public function getCardNo(): ?string
    {
        return $this->card_no;
    }

    public function setCardNo(?string $card_no): self
    {
        $this->card_no = $card_no;

        return $this;
    }

    public function getCardLimit(): ?float
    {
        return $this->card_limit;
    }

    public function setCardLimit(?float $card_limit): self
    {
        $this->card_limit = $card_limit;

        return $this;
    }

    public function getUsefulLimit(): ?float
    {
        return $this->useful_limit;
    }

    public function setUsefulLimit(?float $useful_limit): self
    {
        $this->useful_limit = $useful_limit;

        return $this;
    }

    public function getCardImageUrl(): ?string
    {
        return $this->card_image_url;
    }

    public function setCardImageUrl(?string $card_image_url): self
    {
        $this->card_image_url = $card_image_url;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getDebtType(): ?int
    {
        return $this->debt_type;
    }

    public function setDebtType(?int $debt_type): self
    {
        $this->debt_type = $debt_type;

        return $this;
    }


}
