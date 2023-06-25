<extends>layouts/base</extends>
<h1>Articles</h1>

<?php if (isset($articles)) {
    foreach($articles as $val): ?>
        <span> <?=  $val->getTitre() ?> <?= $val->getContenu() ?> <?= $val->getAuteur()->getNom() ?>  </span>
        <?php
            foreach ($val->getSousArticles() as $sa)
            {
                ?>
                <br/>
                <span><?= $sa->getTitre() ?></span>
                <?php
            }
        ?>
        <form action="delete-article" method="post">
            <button type="submit" name="supprimer" value="<?=$val->getId()?>" >Supprimer</button>
        </form>
        <br>
    <?php endforeach;
} ?>