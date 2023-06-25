<?php 

    namespace App\crud;

    use App\Model\Article;
    use App\model\SousArticle;
    use App\Model\User;

    class ArticleCRUD extends CRUD{

        public function insert($article){
            $this->persist($article);
        }

        /*public function selectAll(){
            //define("SELECT_ARTICLES","SELECT * FROM articles");
           // $stmt = $this->db->prepare(SELECT_ARTICLES);
            //$stmt->execute();
           // return $stmt->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE,Article::class);
            define("SELECT_ARTICLES","SELECT a.id 'article_id', a.titre 'article_titre', a.contenu 'article_contenu', a.auteur 'article_auteur',
                                        u.id 'user_id', u.prenom 'user_prenom', u.nom 'user_nom', u.email 'user_email', u.password 'user_password', u.ip 'user_ip', u.userAgent 'user_userAgent'
                                        FROM articles a
                                        INNER JOIN users u ON a.auteur = u.id");

            $stmt = $this->db->prepare(SELECT_ARTICLES);
            $stmt->execute();
            $articles = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $user = new User();
                $user->setId($row['user_id']);
                $user->setPrenom($row['user_prenom']);
                $user->setNom($row['user_nom']);
                $user->setEmail($row['user_email']);
                // Set other user properties as needed

                $article = new Article();
                $article->setId($row['article_id']);
                $article->setTitre($row['article_titre']);
                $article->setContenu($row['article_contenu']);
                $article->setAuteur($user);

                $articles[] = $article;
            }
           return $articles;
        }*/
        public function selectAll()
        {
            define("SELECT_ARTICLES", "SELECT a.id 'article_id', a.titre 'article_titre', a.contenu 'article_contenu',
        u.id 'user_id', u.prenom 'user_prenom', u.nom 'user_nom', u.email 'user_email', u.password 'user_password', u.ip 'user_ip', u.userAgent 'user_userAgent',
        sa.id 'sousarticle_id', sa.titre 'sousarticle_titre', sa.contenu 'sousarticle_contenu'
        FROM articles a
        INNER JOIN users u ON a.auteur = u.id
        LEFT JOIN sousarticles sa ON sa.article = a.id");

            $stmt = $this->db->prepare(SELECT_ARTICLES);
            $stmt->execute();
            $articles = [];
            $currentArticleId = null;
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                if ($row['article_id'] !== $currentArticleId) {
                    $user = new User();
                    $user->setId($row['user_id']);
                    $user->setPrenom($row['user_prenom']);
                    $user->setNom($row['user_nom']);
                    $user->setEmail($row['user_email']);
                    // Set other user properties as needed

                    $article = new Article();
                    $article->setId($row['article_id']);
                    $article->setTitre($row['article_titre']);
                    $article->setContenu($row['article_contenu']);
                    $article->setAuteur($user);
                    $articles[] = $article;

                    $currentArticleId = $row['article_id'];
                }

                // Check if the row has sous-article data
                if ($row['sousarticle_id']) {
                    $sousArticle = new SousArticle();
                    $sousArticle->setId($row['sousarticle_id']);
                    $sousArticle->setTitre($row['sousarticle_titre']);
                    $sousArticle->setContenu($row['sousarticle_contenu']);

                    $currentArticle = $articles[count($articles) - 1];
                    $currentArticle->addSousArticle($sousArticle);
                }
            }

            return $articles;
        }


        public function selectByTitle($titre){
            define("SEARCH_ARTICLES","SELECT * FROM articles INNER JOIN users on aticles.id = users.id WHERE titre LIKE :title");
            $stmt = $this->db->prepare(SEARCH_ARTICLES);
            $stmt->bindValue(":title","%$titre%");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE,Article::class);
        }        

        public function delete($id){
            define("DELETE_ARTICLE","DELETE FROM articles WHERE id = :id ");
            $stmt = $this->db->prepare(DELETE_ARTICLE);
            $stmt->bindValue(":id",$id);
            $stmt->execute();
            return $stmt->rowCount();
        }

    }