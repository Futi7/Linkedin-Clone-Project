<?php

namespace App\Entity;

use App\Repository\EducationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EducationRepository::class)
 */
class Education
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $score;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $starting_date;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $graduation_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $userid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(?string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(?string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getStartingDate(): ?string
    {
        return $this->starting_date;
    }

    public function setStartingDate(string $starting_date): self
    {
        $this->starting_date = $starting_date;

        return $this;
    }

    public function getGraduationDate(): ?string
    {
        return $this->graduation_date;
    }

    public function setGraduationDate(string $graduation_date): self
    {
        $this->graduation_date = $graduation_date;

        return $this;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(int $userid): self
    {
        $this->userid = $userid;

        return $this;
    }
}
