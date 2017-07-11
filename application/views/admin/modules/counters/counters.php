<? $counters = crud::getElements (array ('table' => 'counters')); ?>

<div id="counters_wrap" class="clearfix">
    <br />
<div id="counters_list">
<? if (!empty ($counters)) { ?>
    <table style="width: 60%" class="counter_tab">
    <tbody>
    <tr>
        <td style="width: 10%">&nbsp;№&nbsp;</td>
        <td style="width: 15%">Месяцев</td
        <td style="width: 15%">Дата</td>
        <td style="width: 15%">Часы</td>
        <td style="width: 15%">Минуты</td>
        <td style="width: 15%">Секунды</td>
        <td style="width: 15%"> &nbsp; </td>
    </tr> 
<?
foreach ($counters as $one): ?>
    <tr>
        <form id="counters_form_edit">
            <td style="width: 10%"><?=$one ['id']?></td>
            <td style="width: 15%"><input class="counter_month" type="text" name="month" value="<?=$one ['month']?>"></td>
            <td style="width: 15%"><input class="counter_day" type="text" name="day" value="<?=$one ['day']?>"></td>
            <td style="width: 15%"><input class="counter_hour" type="text" name="hour" value="<?=$one ['hour']?>"></td>
            <td style="width: 15%"><input class="counter_min" type="text" name="min" value="<?=$one ['min']?>"></td>
            <td style="width: 15%"><input class="counter_sec" type="text" name="sec" value="<?=$one ['sec']?>"></td>
            <input type="hidden" name="id" value="<?=$one ['id']?>">
            <input type="hidden" name="task" value="counter_edit">
            <td style="width: 15%"><input type="submit" value="Сохранить изменения"></td>
        </form>       
    </tr>                    
<? endforeach; ?>         

<? } else { echo "Счетчиков пока нет <br /><br />"; }  ?>
    </tbody>
    </table>
</div>

    <br />
    <br />   
</div>

<div class="clearfix"></div>