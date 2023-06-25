<?php

namespace App\model;

class SousArticle
{
    private $id;
    private $titre;
    private $contenu;

    /**
     * @param $id
     * @param $titre
     * @param $contenu
     */
    public function __construct($id = "", $titre ="", $contenu="")
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->contenu = $contenu;
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
    public function setId($id): self
    {
        $this->id = $id;
        return  $this;
    }

    /**
     * @return mixed
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre): self
    {
        $this->titre = $titre;
        return  $this;
    }

    /**
     * @return mixed
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param mixed $contenu
     */
    public function setContenu($contenu): self
    {
        $this->contenu = $contenu;
        return  $this;
    }




}