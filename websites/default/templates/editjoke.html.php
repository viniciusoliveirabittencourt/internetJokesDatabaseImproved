<form action="" method="post">
    <input type="hidden" name="joke[id]" value="<?=htmlspecialchars($joke['joketext'] ?? '', ENT_QUOTES, 'UTF-8')?>">
    <label form="joketext">Type your joke here:</label>
    <textarea id="joketext" name="joke[joketext]" rows="3" cols="40">
        <?=htmlspecialchars($joke['joketext'] ?? '', ENT_QUOTES, 'UTF-8')?>
    </textarea>
    <input type="submit" value="Save">
</form>