<label for="issue">Издание</label><br/>
<select name="issue" class="wide_select">
        <?=$select_issues?>
</select><br/><br/>
<label for="pages">Первая страница</label><br/>
<input type='text' id="field" name='pages'   value="<?=$form['pages']?>"/> <?=$errors['pages']?><br/><br/>
<label for="pages">Последняя страница</label><br/>
<input type='text' id="field" name='last_page' value="<?=$form['pages']?>"/> <?=$errors['pages']?><br/><br/>