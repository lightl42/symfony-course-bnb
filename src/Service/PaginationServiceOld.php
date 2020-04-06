<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class PaginationServiceOld {
    private $limit = 10;
    private $entityClass;
    private $currentPage = 1;
    private $manager;
    private $twig;
    private $route;
    private $templatePath;

    public function __construct(EntityManagerInterface $manager, Environment $twig, RequestStack $request, $templatePath) {
        $this->route = $request->getCurrentRequest()->attributes->get('_route');
        $this->manager = $manager;
        $this->twig = $twig;
        $this->templatePath = $templatePath;
    }

    /**
     * Appel du moteur Twig pour afficher un template en particulier
     *
     * @return void
     */
    public function display() {
        $this->twig->display($this->templatePath, [
            'page' => $this->currentPage,
            'pages' => $this->getPages(),
            'route' => $this->route
        ]);
    }

    /**
     * Recuperer les donnees via un Repository
     *
     * @return $pages
     */
    public function getPages() {
        if(empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécifié l'entité sur laquelle nous devons paginer ! Utilisez la méthode setEntityClass() de votre objet PaginationService !");
        }
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());
        $pages = ceil($total / $this->limit);
        return $pages;
    }

    /**
     * Recupere les donnees
     *
     * @return void
     */
    public function getData() {
        if(empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécifié l'entité sur laquelle nous devons paginer ! Utilisez la méthode setEntityClass() de votre objet PaginationService !");
        }
        // Calcul de l'offset
        $offset = $this->currentPage * $this->limit - $this->limit;
        // Demander au repo de trouver les elements
        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([], [], $this->limit, $offset);
        // Renvoyer les elements en question
        return $data;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setEntityClass($entityClass) {
        $this->entityClass = $entityClass;
        return $this;
    }

    public function getEntityClass() {
        return $this->entityClass;
    }

    public function setPage($page) {
        $this->currentPage = $page;
        return $this;
    }

    public function getPage() {
        return $this->currentPage;
    }

    public function setRoute($route) {
        $this->route = $route;
        return $this;
    }

    public function getRoute() {
        return $this->route;
    }

    public function setTemplatePath($templatePath) {
        $this->templatePath = $templatePath;
        return $this;
    }

    public function getTemplatePath() {
        return $this->templatePath;
    }
}