<label for="issue">Издательство</label><br/>
<select name="publisher" class="wide_select">
        <?=$publisher?>
</select><br/><br/>

<!--<label for="isbn">ISBN</label><br/>
<input type='text' id="field" name='isbn' value="=$form['isbn']?>"/> =$errors['isbn']?><br/><br/>-->
<label for="date">Год</label>&nbsp;&nbsp;<span id ="error"></span><br/>
<!--<select name="date" class="wide_select">
       
</select><br/><br/>-->
<input type='text' id="year" name='date' value="<?=$date?>"/><br/><br/>
<label for="circulation">Тираж</label>&nbsp;&nbsp;<span id ="error"></span><br/>
<input type='text' id="field" name='circulation'   value="<?=$circulation?>"/><br/><br/>
<label for="pages">Кол-во страниц</label>&nbsp;&nbsp;<span id ="error"></span><br/>
<input type='text' id="field" name='pages'   value="<?=$pages?>"/><br/><br/>