<?php 

    namespace App\Controller;

    use App\crud\ArticleCRUD;
    use App\crud\CRUDFactory;
    use App\Model\Article;
    use App\Annotation\Route;
    #[Route("/articles")]
    class ArticleController extends AbstractController{
        private ArticleCRUD $articleCRUD;

        public function __construct(ArticleCRUD $articleCRUD)
        {
            $this->articleCRUD = $articleCRUD;
        }
        #[Route("/add")]
        public function addArticle($request){
            if(isset($request["titre"]) && isset($request["contenu"])){
                $article = new Article($request["titre"],$request["contenu"],1);                
                CRUDFactory::getArticleCRUD()->insert($article);              
            }
            return $this->renderView("article/add-article",[],"Ajouter un article");
        }
        #[Route("/")]
        public function getArticles(){
            //$articles = CRUDFactory::getArticleCRUD()->selectAll();
            $articles = $this->articleCRUD->selectAll();
            return $this->renderView("article/articles",compact("articles"),"Articles");
        }
        #[Route("/delete")]
        public function deleteArticle($request){           
            if(isset($request["supprimer"])){
                $flag = CRUDFactory::getArticleCRUD()->delete($request["supprimer"]);
                $this->redirect("articles");
            }
        }

        #[Route("/search/{search}")]
        public function search($request){
            if(isset($request["s"])){
                $titre = htmlspecialchars($request["s"]);
                $articles = CRUDFactory::getArticleCRUD()->selectByTitle($titre);
                return $this->renderView("article/articles",compact("articles"),"Articles");
            }else{
                $this->redirect("articles");
            }
        }

    }