
var TableEditable = function () {


    var options = {
        searching: false,
        "pageLength": 20,
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false,
        "bSort": false,
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

    var handleTable = function (options) {




    $("#add_btn").click(function(){

        if( $(".goals_ids").val() ){
            return true;
        } else{
            $("#goals_editable_1").parent().css("border", "1px solid #ebccd1");
            $("#goals_editable_1").find(".dataTables_empty").html("Необходимо добавить хотя бы одну цель").css("color", "#a94442" );
            return false;
        }
    });


        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            var jqTrs = $('input[class=goals_ids]', oTable);
            if( !aData[0] ) {
                aData[0] = $("#lastGoal").val();
            }

                var goalId = aData[0];
            var idInput = '<input type="hidden" value="'+goalId+'">';
            jqTds[0].innerHTML = aData[0];
            jqTds[1].innerHTML = idInput + '<input type="text" class="form-control " value="' + aData[1] + '">';
            jqTds[2].innerHTML = '<a href="#" class="edit btn btn-xs btn-default" data-save="1"> <i class="fa fa-check"> </i></a>';
        }

        function saveRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqInputs = $('input', nRow);

            var next_id = jqInputs[0].value;
            var goalName = jqInputs[1].value;

            oTable.fnUpdate(goalName, nRow, 1, false);
            oTable.fnUpdate(
                '<input type="hidden" class="goals_ids" name="goals['+next_id+']" data-id="'+next_id+'" value="'+goalName+'"> ' +
                '<a class="edit" href="javascript:;"  data-save="0"> <i class="fa fa-edit"></i> </a> ' +
                '<a class="delete font-red" href="javascript:;"> <i class="fa fa-times"></i> </a> ', nRow, 2, false );
            oTable.fnDraw();
        }

        var table = $('#goals_editable_1');
        var oTable = table.dataTable(options);
        
        if (!$('#addOfferForm').data("offer")) {
            $("#lastGoal").val( parseInt($("#lastGoal").val()) + 1 );
            var newGoalId = $("#lastGoal").val();
            oTable.fnAddData([newGoalId, 'Заявка с сайта', '<input class="goals_ids" type="hidden" value="Заявка с сайта" name="goals['+newGoalId+']" data-id="'+newGoalId+'">']);
            oTable.fnDraw();
        }

        var tableWrapper = $("#goals_editable_1_wrapper");

        tableWrapper.find(".dataTables_length select").select2({
            showSearchInput: false //hide search box with special css class
        }); // initialize select2 dropdown

        var nEditing = null;
        var nNew = false;

        $('#goals_editable_1_new').click(function (e) {
            e.preventDefault();

            $("#lastGoal").val( parseInt($("#lastGoal").val()) + 1 );
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
            var aiNew = oTable.fnAddData(['', '', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("Вы уверены, что хотите удалить цель?") == false) {
                return;
            }
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
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && $(this).data('save') ) {
                /* Editing this row and want to save it */
                saveRow(oTable, nEditing);
                nEditing = null;
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });
    }






    var handleGasketTable = function (options) {

        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<input type="text" class="form-control " value="' + aData[0] + '">';
            jqTds[1].innerHTML = '<input type="text" class="form-control " value="' + aData[1] + '">';
            jqTds[2].innerHTML = '<a href="#" class="edit btn btn-xs btn-default" data-save="1"> <i class="fa fa-check"> </i></a>';
        }

        function saveRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            //oTable.fnUpdate(aData[0]+'<input type="hidden" name="goals[]" value="'+jqInputs[0].value+'">', nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);


            oTable.fnUpdate( '<td class="col-md-2 vcenter"> <a class="edit" href="javascript:;"  data-save="0"> <i class="fa fa-edit"></i> </a> <a class="delete font-red" href="javascript:;"> <i class="fa fa-times"></i> </a>' +
            '<input type="hidden" name="gaskets[links][]" value="'+jqInputs[1].value+'">' +
            '<input type="hidden" name="gaskets[names][]" value="'+jqInputs[0].value+'"></td>', nRow, 2, false );
            oTable.fnDraw();
        }


        var table = $('#gaskets_editable');
        var oTable = table.dataTable(options);



        var tableWrapper = $("#gaskets_editable_wrapper");

        tableWrapper.find(".dataTables_length select").select2({
            showSearchInput: false //hide search box with special css class
        }); // initialize select2 dropdown

        var nEditing = null;
        var nNew = false;

        $('#gaskets_editable_new').click(function (e) {
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

            var aiNew = oTable.fnAddData(['', '', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("Вы уверены, что хотите удалить прокладку?") == false) {
                return;
            }
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
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && $(this).data('save') ) {
                /* Editing this row and want to save it */
                saveRow(oTable, nEditing);
                nEditing = null;
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });
    }



    var handlePagesTable = function (options) {

        function getUtmGroupsData( checkedData ){

            var utm_groups_list = $.parseJSON($("#utm_groups").val());

            utm_groups_data = '<option disabled selected value="-1">Выберите UTM группу...</option>';
            $.each( utm_groups_list, function( i ){
                if( checkedData == utm_groups_list[i].id )
                    selected = ' selected';
                else selected = '';
                utm_groups_data += '<option value="'+utm_groups_list[i].id+'"'+selected+'>'+utm_groups_list[i].title+'</option>';
            });

            return utm_groups_data;
        }

        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            var jqInputs = $('input', nRow);
            var itm_group_id = 0;
            if(  jqInputs[2] !== undefined ){
                var itm_group_id = jqInputs[2].value;
            }
            var utmData = getUtmGroupsData(itm_group_id);

            if( jqInputs.length ) {
                pageId = jqInputs[4].value;
            } else{
                pageId = 0;
            }
            if( aData[2] == "Да" ) aData[2] = " checked";
            jqTds[0].innerHTML = '<input type="text" class="form-control " value="' + aData[0] + '">';
            jqTds[1].innerHTML = '<input type="text" class="form-control " value="' + aData[1] + '">';
            jqTds[2].innerHTML = '<select class="form-control selectUtm">'+utmData+'</select>' +
                                 '<input type="hidden" name="utm_group_id" value="'+itm_group_id+'">';            
            jqTds[3].innerHTML = '<input type="checkbox" name="pages[pageType][]" value="2"' + aData[2] + '>';
            jqTds[4].innerHTML = '<input type="hidden" name="pages[id][]" value="' + pageId + '"><a href="#" class="edit btn btn-xs btn-default" data-save="1"> <i class="fa fa-check"> </i></a>';
        }

        function saveRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var pageType = '';
            var jqSelects = $('select', nRow);
            var jqInputs = $('input', nRow);

            if( jqInputs[3].checked ) {
                jqInputs[3].value = "Да";
                pageType = 2;
            } else {
                jqInputs[3].value = "Нет";
                pageType = 1;
            }
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            if( jqSelects[0][jqSelects[0].selectedIndex].value > 0 ) {
                oTable.fnUpdate(jqSelects[0][jqSelects[0].selectedIndex].text, nRow, 2, false);
            } else {
                oTable.fnUpdate(jqSelects[0][0].text, nRow, 2, false);
            }
            oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);

            oTable.fnUpdate( '<td class="col-md-2 vcenter"> <a class="edit" href="javascript:;"  data-save="0"> <i class="fa fa-edit"></i> </a> <a class="delete font-red" href="javascript:;"> <i class="fa fa-times"></i> </a>' +
            '<input type="hidden" name="pages[links][]" value="'+jqInputs[1].value+'">' +
            '<input type="hidden" name="pages[names][]" value="'+jqInputs[0].value+'">' +
            '<input type="hidden" name="pages[utm_group_ids][]" value="'+jqInputs[2].value+'">' +
            '<input type="hidden" name="pages[pageType][]" value="'+pageType+'">'+
            '<input type="hidden" name="pages[id][]" value="'+jqInputs[4].value+'">'+
            '</td>', nRow, 4, false );
            oTable.fnDraw();
        }


        var table = $('#pages_editable');
        var oTable = table.dataTable(options);



        var tableWrapper = $("#gaskets_editable_wrapper");

        tableWrapper.find(".dataTables_length select").select2({
            showSearchInput: false //hide search box with special css class
        }); // initialize select2 dropdown

        var nEditing = null;
        var nNew = false;

        $('#pages_editable_new').click(function (e) {
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

            var aiNew = oTable.fnAddData(['', '', '','','']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

        table.on('change', '.selectUtm', function (e) {
            var nRow = $(this).parents('tr')[0];
            var jqInputs = $('input', nRow);
            jqInputs[2].value = e.target.value;
        });

        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("Вы уверены, что хотите удалить эту позицию?") == false) {
                return;
            }
            var nRow = $(this).parents('tr')[0];
            var offer_id = $('#addOfferForm').data("offer");
            if (offer_id) {
                var jqInputs = $('input', nRow);
                $.post("/admin/offer/delete_page/"+jqInputs[4].value+"/"+offer_id+"/", {}, function(data){ });
            }
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
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && $(this).data('save') ) {
                /* Editing this row and want to save it */
                saveRow(oTable, nEditing);
                nEditing = null;
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });
    }



    var handleBunchesTable = function (options) {

        function getGoalsSelect(checkedGoal){
            var goals = '<select name="bunches[goals][]" class="form-control bs-select">';

            $('input[class=goals_ids]').each(function() {

                if( checkedGoal == $(this).data("id") )
                    selected = " selected";
                else selected = '';
                goals += '<option value="'+$(this).data("id")+'"'+selected+'>'+$(this).val()+'</option>';
            });

            goals += '</select>';
            return goals;
        }



        function getGeoData( checkedData ){

            var countries_list = $.parseJSON($("#countries").val());

            geo_data = '<option disabled selected value="-1">Выберите страну...</option>';
            $.each( countries_list, function( i ){
                if( checkedData == countries_list[i].country_id )
                    selected = ' selected';
                else selected = '';
                geo_data += '<option value="'+countries_list[i].country_id+'"'+selected+'>'+countries_list[i].country_name+'</option>';
            });

            return geo_data;
        }



        function editRow(oTable, nRow) {

            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            var goals = getGoalsSelect(aData[0]);
            var geoData = getGeoData(aData[1]);
            var geoCityData = 0;

            // подхватываем спрятанные данные
            var jqInputs = $('input', jqTds[5]);

            // если существует выгранная страна
            if(  jqInputs[4] !== undefined ){
                var geoData = getGeoData(jqInputs[4].value);
            }
            // если существует выбранные город
            if(  jqInputs[5] !== undefined ){
                var geoCityData = jqInputs[5].value;
            }


            if(  jqInputs[6] !== undefined )
                var bunche = jqInputs[6].value;
            else {
                var resJqInputs = $('input[name=bunche]', jqTds[5]);
                if( resJqInputs.legnth == undefined)
                    var bunche = 0;
                else
                    var bunche = resJqInputs[0].value;
            }

            jqTds[0].innerHTML = goals;
            jqTds[1].innerHTML = '<select class="form-control selectCountry">'+geoData+'</select>';
            jqTds[2].innerHTML = '<input type="text" class="form-control " value="' + aData[2] + '">';
            jqTds[3].innerHTML = '<input type="text" class="form-control " value="' + aData[3] + '">';
            jqTds[4].innerHTML = '<input type="text" class="form-control " value="' + aData[4] + '">';
            jqTds[5].innerHTML = '<input type="hidden" name="city" value="'+geoCityData+'">' +
                                 '<input type="hidden" name="bunche" value="'+bunche+'">' +
                                 '<a href="#" class="edit btn btn-xs btn-default" data-save="1"> ' +
                                 '<i class="fa fa-check"> </i></a>';

            if(  jqInputs[4] !== undefined ){
                $( ".selectCountry" ).trigger( "change",  jqInputs[4].value );
            }


        }

        function saveRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqInputs = $('input', nRow);
            var jqSelects = $('select', nRow);
            var jqButtons = $('button', nRow);
            
            if (!jqButtons[0]) {
                oTable.fnDeleteRow(nRow); // cancel
                return;
            }
            
            var c_id = jqButtons[0].getAttribute("data-selectCity");
            var city_id = jqSelects[1][jqSelects[1].selectedIndex].value;
            var offer_id = $('#addOfferForm').data("offer");
            if (offer_id) {
                $.post( "/admin/offer/edit_geo_goal/", 
                    { id: jqInputs[4].value,
                      offer_id: offer_id,
                      goal_id: jqSelects[0].value,
                      country_id: c_id,
                      city_id: city_id, 
                      price: jqInputs[1].value,  
                      real_price: jqInputs[0].value,  
                      lid_count: jqInputs[2].value,  
                      status: 1 })
                .done(function( id ) {
                    oTable.fnUpdate(jqSelects[0].value, nRow, 0, false);
                    if( jqSelects[1][jqSelects[1].selectedIndex].value > 0 ) {
                        oTable.fnUpdate(jqSelects[1][jqSelects[1].selectedIndex].text, nRow, 1, false);
                    } else{
                        oTable.fnUpdate(jqButtons[0].innerHTML, nRow, 1, false);
                    }
                    oTable.fnUpdate(jqInputs[0].value, nRow, 2, false);
                    oTable.fnUpdate(jqInputs[1].value, nRow, 3, false);
                    oTable.fnUpdate(jqInputs[2].value, nRow, 4, false);
                    var actionData = '<a class="setStatus" data-status="1" data-offer="'+offer_id+'" data-id="'+id+'" href="javascript:;"><i class="fa fa-pause"></i></a>' +
                            '<a class="edit" href="javascript:;"  data-save="0"> <i class="fa fa-edit"></i> </a> ' +
                            '<a class="delete font-red" data-id="'+id+'" data-offer="'+offer_id+'" href="javascript:;"> <i class="fa fa-times"></i> </a>' +
                            '<input type="hidden" name="bunches[goal][]" value="'+jqSelects[0].value+'">' +
                            '<input type="hidden" name="bunches[real_price][]" value="'+jqInputs[0].value+'">' +
                            '<input type="hidden" name="bunches[price][]" value="'+jqInputs[1].value+'">' +
                            '<input type="hidden" name="bunches[lid_count][]" value="'+jqInputs[2].value+'">' +
                            '<input type="hidden" name="bunches[country][]" value="'+c_id+'">' +
                            '<input type="hidden" name="bunches[city][]" value="'+city_id+'">' +
                            '<input type="hidden" name="bunches[id][]" value="'+id+'">';
                    oTable.fnUpdate( actionData, nRow, 5, false );
                    oTable.fnDraw(); })
                .fail(function() {
                        nEditing = nRow;
                        alert( "Ошибка! По данной гео цели уже существует запись!" );
                        return;                    
                });
            } else {
                oTable.fnUpdate(jqSelects[0].value, nRow, 0, false);
                if( jqSelects[1][jqSelects[1].selectedIndex].value > 0 ) {
                    oTable.fnUpdate(jqSelects[1][jqSelects[1].selectedIndex].text, nRow, 1, false);
                } else{
                    oTable.fnUpdate(jqButtons[0].innerHTML, nRow, 1, false);
                }
                oTable.fnUpdate(jqInputs[0].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 3, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 4, false);
                var actionData = '<a class="edit" href="javascript:;"  data-save="0"> <i class="fa fa-edit"></i> </a> ' +
                        '<a class="delete font-red" href="javascript:;"> <i class="fa fa-times"></i> </a>' +
                        '<input type="hidden" name="bunches[goal][]" value="'+jqSelects[0].value+'">' +
                        '<input type="hidden" name="bunches[real_price][]" value="'+jqInputs[0].value+'">' +
                        '<input type="hidden" name="bunches[price][]" value="'+jqInputs[1].value+'">' +
                        '<input type="hidden" name="bunches[lid_count][]" value="'+jqInputs[2].value+'">' +
                        '<input type="hidden" name="bunches[country][]" value="'+c_id+'">' +
                        '<input type="hidden" name="bunches[city][]" value="'+city_id+'">' +
                        '<input type="hidden" name="bunches[id][]" value="'+jqInputs[4].value+'">';
                oTable.fnUpdate( actionData, nRow, 5, false );
                oTable.fnDraw();
            }
        }

        var table = $('#bunches_editable');
        var oTable = table.dataTable(options);

        var tableWrapper = $("#bunches_editable_wrapper");

        tableWrapper.find(".dataTables_length select").select2({
            showSearchInput: false //hide search box with special css class
        }); // initialize select2 dropdown

        var nEditing = null;
        var nNew = false;

        $('#bunches_editable_new').click(function (e) {
            e.preventDefault();
            if( !$("input[class=goals_ids]").length ) {
                alert( 'Создайте хотя бы одну цель' );
                return false;
            }
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

            var aiNew = oTable.fnAddData(['', '', '','','','']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

        table.on('click', '.setStatus', function (e) {
            e.preventDefault();
            var status = $(this).data("status");
            var icon = $(this).find("i");
            if( status == "0" ){
                setStatus = 1;
                icon.attr('class', 'fa fa-pause');
            } else{
                setStatus = 0;
                icon.attr('class', 'fa fa-play');
            }
            $(this).data("status", setStatus );
            $.post("/admin/offer/bunch/"+$(this).data("offer")+"/"+$(this).data("id")+"/"+setStatus, {}, function(data){ });

        });

        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("Вы уверены, что хотите удалить эту позицию?") == false) {
                return;
            } else {
                $.post("/admin/offer/delete_geo_goal/"+$(this).data("id")+"/"+$(this).data("offer")+"/", {}, function(data){ });
            }


            var nRow = $(this).parents('tr')[0];
            oTable.fnDeleteRow(nRow);
        });

        table.on('click', '.backToCountry', function(e) {
            var nRow = $(this).parents('tr')[0];
            editRow(oTable, nRow);
        });

        table.on('change', '.selectCountry', function (e) {


            $.post("/admin/countries/getCities", {c_id: $(this).val()}, function(data){


                // ищем активный город
                var nRow = $(".selectCountry").parents()[2];
                var jqInputs = $('input:hidden[name=city]', nRow);
                var activeCity = 0;
                if(  jqInputs[0] !== undefined ){
                    activeCity = jqInputs[0].value;
                }


                var ar = $.parseJSON(data);

                var city_block = "<div class='row'><div class='backToCountry col-md-4'><button class='btn btn-default' data-selectCity='"+$(".selectCountry").val()+"'>"+$(".selectCountry option:selected").text()+"</button></div><div class='col-md-8'><select name='geo[city][]' class='selectCity form-control'><option selected value='0'>Выберите город</option>";
                ar.forEach(function(item, i, arr){
                    var selected = '';
                    if( activeCity == item.id ){
                        selected = ' selected';
                    }

                    city_block += '<option value="'+item.id+'"'+selected+'>'+item.name+'</option>';
                });
                city_block += "</select></div></div>";
                $(".selectCountry").parent().html( city_block );

            });


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
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && $(this).data('save') ) {
                /* Editing this row and want to save it */
                saveRow(oTable, nEditing);
                nEditing = null;
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });
    }



    return {
        //main function to initiate the module
        init: function () {
            handleTable(options);
            handleGasketTable(options);
            handlePagesTable(options);
            handleBunchesTable(options);

        }
    };

}();

