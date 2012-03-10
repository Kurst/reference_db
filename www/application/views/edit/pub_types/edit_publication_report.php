<script type="text/javascript">

        $(function() {

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


<label for="date">Год</label>&nbsp;&nbsp;<span id ="error"></span><br/>
<input type='text' id="year" name='date' value="<?=$date?>"/><br/><br/>

<label for="org">Организация</label><br/>
        <select name="org" id="org" onChange="" class="wide_select" >
                <?=$select_options;?>
        </select><br/><br/>
<label for="city">Город</label><br/>
<input class="city" id="field" type="text" name="city" value="<?=$city?>"/>
<input name="city_id" id="city_id" type="hidden" value="<?=$city_id?>"/><br/><br/>
<label for="pages">Кол-во страниц</label>&nbsp;&nbsp;<span id ="error"></span><br/>
<input type='text' id="field" name='pages'   value="<?=$pages?>"/><br/><br/>
<label for="pages">Тип отчета</label>&nbsp;&nbsp;<span id ="error"></span><br/>
<input type='text' id="field" name='report_type'   value="<?=$report_type?>"/><br/><br/>
<label for="pages">Краткое название</label>&nbsp;&nbsp;<span id ="error"></span><br/>
<input type='text' id="field" name='short_name'   value="<?=$short_name?>"/><br/><br/>
<label for="pages">Стандартный номер</label>&nbsp;&nbsp;<span id ="error"></span><br/>
<input type='text' id="field" name='standart_number'   value="<?=$standart_number?>"/><br/><br/>