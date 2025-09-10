<?php foreach ($jokes as $joke): ?>
<blockquote>
    <p>
        <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8');?>
    </p>
   <form action="/delete.php" method="post">
       <input type="hidden" name="jokeId" value="<?=$joke['id']?>" />
       <input type="submit" value="Delete" />
   </form>
</blockquote>
<?php endforeach; ?>