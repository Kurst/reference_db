<script type="text/javascript">

        $(function() {
                $(".new_org_box").colorbox({width:"450px", height:"270px"});
                $(".city").autocomplete(url+"add/author/get_cities", {
                    delay:10,
                    autoFill:true,
                    minChars:1,
                    matchSubset:1,
                    autoFill:true,
                    matchContains:1,
                    cacheLength:10,
                    selectFirst:true,
                    maxItemsToShow:10,
                    onItemSelect:selectItem

                });

            
        });
        function selectItem(li)
        {
                $("#city_id").val(li.extra[0]);
        }
</script>


<label for="date">Год</label>&nbsp;&nbsp;<span id ="error"><?=$errors["date"]?></span><br/>
<input type='text' id="year" name='date' value="<?=$form['date']?>"/><br/><br/>

<label for="org">Организация</label><br/>
        <select name="org" id="org_field" onChange="" class="wide_select" >
                <?=$select_options;?>
        </select><br/><br/>
 <a href="/add/publication/add_new_org/" class="new_org_box"><img src="/static/images/add_auth.png" />&nbsp;Добавить новую организацию</a>
<br/><br/>
<label for="city">Город</label><br/>
<input class="city" id="field" type="text" name="city" value="<?=$form['city']?>"/>
<input name="city_id" id="city_id" type="hidden" value="<?=$form['city_id']?>"/><br/><br/>
<label for="pages">Кол-во страниц</label>&nbsp;&nbsp;<span id ="error"><?=$errors["pages"]?></span><br/>
<input type='text' id="field" name='pages'   value="<?=$form['pages']?>"/><br/><br/>
<label for="pages">Тип отчета</label>&nbsp;&nbsp;<span id ="error"><?=$errors["report_type"]?></span><br/>
<input type='text' id="field" name='report_type'   value="<?=$form['report_type']?>"/><br/><br/>
<label for="pages">Краткое название</label>&nbsp;&nbsp;<span id ="error"><?=$errors["short_name"]?></span><br/>
<input type='text' id="field" name='short_name'   value="<?=$form['short_name']?>"/><br/><br/>
<label for="pages">Стандартный номер</label>&nbsp;&nbsp;<span id ="error"><?=$errors["standart_number"]?></span><br/>
<input type='text' id="field" name='standart_number'   value="<?=$form['standart_number']?>"/><br/><br/>