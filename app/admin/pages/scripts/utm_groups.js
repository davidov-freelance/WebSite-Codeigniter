
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




        var tableList = $('#terms_list');
        var oterms_list = tableList.dataTable(options);




        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var groupId = aData[0];

            var jqTds = $('>td', nRow);
            var idInput = '<input type="hidden" value="'+groupId+'">';
            jqTds[0].innerHTML = aData[0];
            jqTds[1].innerHTML = idInput + '<input type="text" class="form-control " value="' + aData[1] + '">';
            jqTds[2].innerHTML = '<input type="text" class="form-control " value="' + aData[2] + '">';
            jqTds[3].innerHTML = '<a href="#" class="edit btn btn-xs btn-default" data-save="1"> <i class="fa fa-check"> </i></a>';
        }

        function saveRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
            oTable.fnUpdate(
                '<a class="edit" href="javascript:;"  data-save="0"> <i class="fa fa-edit"></i> </a> ' +
                '<a class="delete font-red" href="javascript:;"> <i class="fa fa-times"></i> </a> ', nRow, 3, false );
            oTable.fnDraw();
            $.post("/admin/utm/update_group", {id: jqInputs[0].value, name:jqInputs[1].value, title:jqInputs[2].value}, function(data) {

                if( data ){

                    oTable.fnUpdate(data, nRow, 0, false);
                }
            });


        }

        var table = $('#groups');
        var oTable = table.dataTable(options);

        var tableWrapper = $("#groups_wrapper");

        tableWrapper.find(".dataTables_length select").select2({
            showSearchInput: false //hide search box with special css class
        }); // initialize select2 dropdown

        var nEditing = null;
        var nNew = false;

        $('#add_group').click(function (e) {
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
            var aiNew = oTable.fnAddData(['', '', '', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });




        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("ВНИМАНИЕ\nВсе метки, связанные с группой, будут также удалены. \nУдалить группу?") == false) {
                return;
            }



            var nRow = $(this).parents('tr')[0];
            var aData = oTable.fnGetData(nRow);
            $.post("/admin/utm/delete_group/"+aData['0'], {}, function(data){ });
            oTable.fnDeleteRow(nRow);
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

        }
    };

}();

