

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-globe font-blue-hoki"></i>
            <span class="caption-subject font-blue-hoki bold uppercase">Страны и города</span>
            <span class="caption-helper"> управление</span>
        </div>
        <div class="pull-right">
            <a class="btn btn-sm green-haze dropdown-toggle" href="#" id="countriesTable_new">
                <i class="icon-plus"></i> создать</a>
            <a href="#" data-loading-text="Синхронизирую..." class="btn btn-sm default" autocomplete="off"   id="updateData">
                <i class="icon-refresh"></i> cинхронизировать</a>
        </div>
    </div>
    <div class="portlet-body form">
        <table class="table table-bordered table-hover" id="countriesTable">
            <thead>
            <tr>
                <th class="col-md-1">ID</th>
                <th class="col-md-2">Страна</th>
                <th class="col-md-2">Город</th>
                <th class="col-md-2">Город2</th>
                <th class="col-md-2">Город3</th>
                <th class="col-md-2">Транслит</th>
                <th class="col-md-1"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($result AS $p):?>
                <tr id='city-tr-<?=$p->id;?>'>
                    <td><input type="hidden" value="<?=$p->id;?>"><?=$p->id;?></td>
                    <td><?=$p->country_name;?></td>
                    <td id='name-<?=$p->id;?>'><?=$p->name;?></td>
                    <td id='name2-<?=$p->id;?>'><?=$p->name2;?></td>
                    <td id='name3-<?=$p->id;?>'><?=$p->name3;?></td>
                    <td id='eng_name-<?=$p->id;?>'><?=$p->eng_name;?></td>
                    <td>
                        <a href='javascript:void();' class="edit"><i class="fa fa-pencil"></i></a>
                        <a href='javascript:void();' class="delete"><i class="fa fa-times font-red"></i></a>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>


<script>
    var  countries = "<?=addslashes(json_encode( $countries )); ?>";
</script>



<script type="text/javascript">

    var TableEditable = function () {


        var options = {
            searching: true,
            "pageLength": 10,
            "bFilter": true,
            "bInfo": false,
            "destroy": false
        };


        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        var handleTable = function (options, places) {



            function getCountriesList(selectedCountry){
                var selectHtml = '<select name="country" class="form-control bs-select">';
                var ar = $.parseJSON(countries);
                ar.forEach(function(item, i){
                    var selected = '';
                    if( selectedCountry == item.country_name ){
                        selected = ' selected';
                    }
                    selectHtml += '<option value="'+item.country_id+'"'+selected+'>'+item.country_name+'</option>';
                });


                selectHtml += '</select>';
                return selectHtml;
            }

            function getCitiesList( nRow, selectedCity, countryId ){

                $.post("/admin/countries/getCities/"+countryId, function(data){
                    var selectCity = '<select>';
                    var ar = $.parseJSON(data);
                    var jqTds = $('>td', nRow);
                    ar.forEach(function(item, i){
                        var selected = '';
                        if( selectedCity == item.name ){
                            selected = ' selected';
                        }
                        selectCity += '<option value="'+i+'"'+selected+'>'+item.name+'</option>';
                    });
                    selectCity += '</select>';
                    jqTds[2].innerHTML = selectCity;

                });


            }



            function editRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                var jqInputs = $('input', nRow);
                jqTds[0].innerHTML = aData[0];
                jqTds[1].innerHTML = getCountriesList(aData[1]);
                jqTds[2].innerHTML = '<input type="text" value="'+aData[2]+'" class="form-control">';
                //getCitiesList(nRow, aData[2], jqInputs[0].value);
                jqTds[3].innerHTML = '<input type="text" value="'+aData[3]+'" class="form-control">';
                jqTds[4].innerHTML = '<input type="text" value="'+aData[4]+'" class="form-control">';
                jqTds[5].innerHTML = '<input type="text" value="'+aData[5]+'" class="form-control">';
                jqTds[6].innerHTML = '<a href="#" class="edit btn btn-xs btn-default" data-save="1"> <i class="fa fa-check"> </i></a>';
            }

            function saveRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqInputs = $('input', nRow);
                var jqSelects = $('select', nRow);

                oTable.fnUpdate(jqSelects[0][jqSelects[0].value-1].text, nRow, 1, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 3, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 4, false);
                oTable.fnUpdate(jqInputs[4].value, nRow, 5, false);
                oTable.fnUpdate('<a class="edit" href="javascript:;"  data-save="0"> <i class="fa fa-edit"></i> </a> ' +
                '<a class="delete font-red" href="javascript:;"> <i class="fa fa-times"></i> </a> ', nRow, 6, false);
                oTable.fnDraw();
                var postData = {
                    c_id: jqSelects[0].value,
                    city_id: jqInputs[0].value,
                    name: jqInputs[1].value,
                    name2: jqInputs[2].value,
                    name3: jqInputs[3].value,
                    translate: jqInputs[4].value
                };
                $.post("/admin/countries/edit/"+jqInputs[0].value, postData, function(data){
                    oTable.fnUpdate("<input type='hidden' value='"+data+"'>"+data, nRow, 0, false);
                });

            }

            var table = $('#countriesTable');
            var oTable = table.dataTable(options);

            var nEditing = null;
            var nNew = false;

            $('#countriesTable_new').click(function (e) {
                e.preventDefault();

                if (nNew && nEditing) {
                    if (confirm("Previose row not saved. Do you want to save it ?")) {
                        saveRow(oTable, nEditing); // save
                        $(nEditing).find("td:first").html("Untitled");
                        nEditing = null;
                        nNew = false;

                    } else {
                        oTable.fnDeleteRow(nEditing); // cancel
                        nEditing = null;
                        nNew = false;

                        return;
                    }
                }
                var aiNew = oTable.fnAddData(['<input type="hidden" value="0">0', '', '', '','','','']);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
                nNew = true;
            });

            table.on('click', '.delete', function (e) {
                e.preventDefault();

                if (confirm("Вы уверены, что хотите удалить локацию?") == false) {
                    return;
                }

                var jqInputs = $('input', $(this).parents('tr'));
                    $.post("/admin/countries/delete_city/"+jqInputs[0].value, function(data){

                });
                var nRow = $(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);
            });

            table.on('click', '.cancel', function (e) {
                e.preventDefault();
                if (nNew) {
                    oTable.fnDeleteRow(nEditing);
                    nEditing = null;
                    nNew = false;
                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });

            table.on('click', '.edit', function (e) {
                e.preventDefault();
                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];

                if (nEditing !== null && !$(this).data('save')) {
                    restoreRow(oTable, nEditing);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                } else if (nEditing == nRow && $(this).data('save')) {
                    saveRow(oTable, nEditing);
                    nEditing = null;
                } else {
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            });
        }


        return {
            //main function to initiate the module
            init: function () {
                handleTable(options, countries);

            }
        };

    }();

</script>