<script type="text/javascript">

        $(function() {


            $("#datepicker").datepicker( { dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: '1950:-20'} );
            $("#datepicker").datepicker($.datepicker.regional['ru']);
            $("#datepicker2").datepicker( { dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: '1950:-20'} );
            $("#datepicker2").datepicker($.datepicker.regional['ru']);
        });
</script>
<label for="pages">Ученая степень</label>&nbsp;&nbsp;<span id ="error"><?=$errors["rank"]?></span><br/>
<input type='text' id="field" name='rank'   value="<?=$form['rank']?>"/><br/><br/>
<label for="pages">Дата защиты</label>&nbsp;&nbsp;<span id ="error"><?=$errors["protection"]?></span><br/>
<input type='text' class="date" id="datepicker" size='10' name='protection'   value="<?=$form['protection']?>"/><br/><br/>
<label for="pages">Дата утверждения</label>&nbsp;&nbsp;<span id ="error"><?=$errors["statement"]?></span><br/>
<input type='text' class="date" id="datepicker2" size='10' name='statement'   value="<?=$form['statement']?>"/><br/><br/>
<label for="issue">Издательство</label><br/>
<select name="publisher" class="wide_select">
        <?=$select_publisher?>
</select><br/><br/>


<label for="date">Год</label>&nbsp;&nbsp;<span id ="error"><?=$errors["date"]?></span><br/>

<input type='text' id="year" name='date' value="<?=$form['date']?>"/><br/><br/>

<label for="pages">Кол-во страниц</label>&nbsp;&nbsp;<span id ="error"><?=$errors["pages"]?></span><br/>
<input type='text' id="field" name='pages'   value="<?=$form['pages']?>"/><br/><br/>

