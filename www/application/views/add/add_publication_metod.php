<label for="issue">Издательство</label><br/>
<select name="publisher" class="wide_select">
        <?=$select_publisher?>
</select><br/><br/>


<label for="date">Год</label>&nbsp;&nbsp;<span id ="error"><?=$errors["date"]?></span><br/>

<input type='text' id="year" name='date' value="<?=$form['date']?>"/><br/><br/>
<label for="circulation">Тираж</label>&nbsp;&nbsp;<span id ="error"><?=$errors["circulation"]?></span><br/>
<input type='text' id="field" name='circulation'   value="<?=$form['circulation']?>"/><br/><br/>
<label for="pages">Кол-во страниц</label>&nbsp;&nbsp;<span id ="error"><?=$errors["pages"]?></span><br/>
<input type='text' id="field" name='pages'   value="<?=$form['pages']?>"/><br/><br/>