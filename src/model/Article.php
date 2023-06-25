<?php 

namespace App\Model;

class Article{


    private $id;
    private $titre;
    private $contenu;
    private $auteur;
    private $sousArticles;

    public function __construct($titre="",$contenu="", $auteur=null, $sousArticles = [])
    {
        $this->titre = $titre;        
        $this->contenu = $contenu;
        $this->auteur = $auteur;
        $this->sousArticles = $sousArticles;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of titre
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     */
    public function setTitre($titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of contenu
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set the value of contenu
     */
    public function setContenu($contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get the value of auteur
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set the value of auteur
     */
    public function setAuteur($auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSousArticles()
    {
        return $this->sousArticles;
    }

    /**
     * @param mixed $sousArticles
     */
    public function setSousArticles($sousArticles): void
    {
        $this->sousArticles = $sousArticles;
    }

    public function addSousArticle($sousArticle)
    {
        $this->sousArticles[] = $sousArticle;
    }


}