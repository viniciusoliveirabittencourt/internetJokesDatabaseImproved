<?php foreach ($jokes as $joke): ?>
<blockquote>
    <p>
        <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8');?>
        (by <a href="mailto:<?=htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8')?>">
            <?=htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8')?>
        </a>
        )
    </p>
   <form action="/delete.php" method="post">
       <input type="hidden" name="jokeId" value="<?=$joke['id']?>" />
       <input type="submit" value="Delete" />
   </form>
</blockquote>
<?php endforeach; ?>