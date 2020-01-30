<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostsRepository")
 */
class Posts
{

    const CATEGORY = [
        8 => 'Plantes',
        1 => 'Boutures',
        2 => 'Graines',
        3 => 'Pot(s)/Cache-pot(s)',
        4 => 'Engrais',
        5 => 'Terreaux',
        6 => 'Outils',
        7 => 'Divers'
    ];

    const TYPE = [
        4 => 'Echange',
        1 => 'Don',
        2 => 'Vente',
        3 => 'Recherche'
    ];

    const DEPARTEMENT = [
        96 => 'Ain',
        1 => 'Aisne',
        2 => 'Allier',
        3 => 'Alpes-de-Haute-Provence',
        4 => 'Hautes-Alpes',
        5 => 'Alpes-Maritimes',
        6 => 'Ardèche',
        7 => 'Ardennes',
        8 => 'Ariège',
        9 => 'Aube',
        10 => 'Aude',
        11 => 'Aveyron',
        12 => 'Bouches-du-Rhône',
        13 => 'Calvados',
        14 => 'Cantal',
        15 => 'Charente',
        16 => 'Charente-Maritime',
        17 => 'Cher',
        18 => 'Corrèze',
        19 => 'Corse-du-Sud',
        20 => 'Haute-Corse',
        21 => 'Côte-d\'Or',
        22 => 'Côtes-d\'Armor',
        23 => 'Creuse',
        24 => 'Dordogne',
        25 => 'Doubs',
        26 => 'Drôme',
        27 => 'Eure',
        28 => 'Eure-et-Loir',
        29 => 'Finistère',
        30 => 'Gard',
        31 => 'Haute-Garonne',
        32 => 'Gers',
        33 => 'Gironde',
        34 => 'Hérault',
        35 => 'Ille-et-Vilaine',
        36 => 'Indre',
        37 => 'Indre-et-Loire',
        38 => 'Isère',
        39 => 'Jura',
        40 => 'Landes',
        41 => 'Loir-et-Cher',
        42 => 'Loire',
        43 => 'Haute-Loire',
        44 => 'Loire-Atlantique',
        45 => 'Loiret',
        46 => 'Lot',
        47 => 'Lot-et-Garonne',
        48 => 'Lozère',
        49 => 'Maine-et-Loire',
        50 => 'Manche',
        51 => 'Marne',
        52 => 'Haute-Marne',
        53 => 'Mayenne',
        54 => 'Meurthe-et-Moselle',
        55 => 'Meuse',
        56 => 'Morbihan',
        57 => 'Moselle',
        58 => 'Nièvre',
        59 => 'Nord',
        60 => 'Oise',
        61 => 'Orne',
        62 => 'Pas-de-Calais',
        63 => 'Puy-de-Dôme',
        64 => 'Pyrénées-Atlantiques',
        65 => 'Hautes-Pyrénées',
        66 => 'Pyrénées-Orientales',
        67 => 'Bas-Rhin',
        68 => 'Haut-Rhin',
        69 => 'Rhône',
        70 => 'Haute-Saône',
        71 => 'Saône-et-Loire',
        72 => 'Sarthe',
        73 => 'Savoie',
        74 => 'Haute-Savoie',
        75 => 'Paris',
        76 => 'Seine-Maritime',
        77 => 'Seine-et-Marne',
        78 => 'Yvelines',
        79 => 'Deux-Sèvres',
        80 => 'Somme',
        81 => 'Tarn',
        82 => 'Tarn-et-Garonne',
        83 => 'Var',
        84 => 'Vaucluse',
        85 => 'Vendée',
        86 => 'Vienne',
        87 => 'Haute-Vienne',
        88 => 'Vosges',
        89 => 'Yonne',
        90 => 'Territoire de Belfort',
        91 => 'Essonne',
        92 => 'Hauts-de-Seine',
        93 => 'Seine-Saint-Denis',
        94 => 'Val-de-Marne',
        95 => 'Val-d\'Oise'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(min=5)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $dpt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{5}$/")
     */
    private $postal;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2, max=255)
     * @Assert\Regex("/^[a-zA-Z\-\ ]+$/", message="Votre nom de ville ne peut pas contenir de chiffres")
     */
    private $city;

    /**
     * @ORM\Column(type="float", nullable=true, options={"default": 0})
     * @Assert\Range(min=0, max=1000)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", options={"default": 1})
     * @Assert\Range(min=1, max=1000)
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $category;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $posttype;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->created_at = new \Datetime();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDpt(): ?string
    {
        return $this->dpt;
    }

    public function getDepartement()
    {
        return self::DEPARTEMENT[$this->dpt];
    }

    public function setDpt(string $dpt): self
    {
        $this->dpt = $dpt;

        return $this;
    }

    public function getPostal(): ?int
    {
        return $this->postal;
    }

    public function setPostal(int $postal): self
    {
        $this->postal = $postal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(int $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCategoryType()
    {
        return self::CATEGORY[$this->category];
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPosttype(): ?int
    {
        return $this->posttype;
    }

    public function getPostNameType()
    {
        return self::TYPE[$this->posttype];
    }

    public function setPosttype(int $posttype): self
    {
        $this->posttype = $posttype;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
