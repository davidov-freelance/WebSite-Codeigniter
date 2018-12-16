

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-direction font-blue-hoki"></i>
			<span class="caption-subject font-blue-hoki bold uppercase">Площадки</span>
			<span class="caption-helper"> управление</span>
		</div>
		<div class="pull-right">
			<a class="btn btn-sm green-haze dropdown-toggle" href="#" id="places_table_new">
				<i class="icon-plus"></i> создать</a>
		</div>
	</div>
	<div class="portlet-body form">


      <table class="table table-bordered table-hover" id="places_table">
         <thead>
            <tr>
				<th>ID</th>
               	<th>Название</th>
	     	  	<th>Тип трафика</th>
              	<th class="col-md-2">Действия</th>
            </tr>
         </thead>
         <tbody>
		 <?php $c = config_item("places_traffic");?>
		 <?php foreach($result AS $p):?>
		 <tr>
			<td><?=$p->id;?><input type="hidden" value="<?=$p->id;?>"> </td>
			<td><?=$p->name;?></td> 
			<td><?=$c[$p->type];?></td>
			 <td>
				 <a class="edit"><i class="fa fa-edit"></i></a>
				 <a class="delete font-red"><i class="fa fa-times"></i></a>
			 </td>
		 </tr>
		<?php endforeach;?>
         </tbody>
      </table>
</div>
</div>

<script>
	var  places = "<?=addslashes(json_encode( config_item("places_traffic") )); ?>";
</script>



<script type="text/javascript">

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

		var handleTable = function (options, places) {



			function getPlacesType(checkedType){
				var selectHtml = '<select name="place_type" class="form-control bs-select">';
				var ar = $.parseJSON(places);
				ar.forEach(function(item, i){
					var selected = '';
					if( checkedType == item ){
						selected = ' selected';
					}

					selectHtml += '<option value="'+i+'"'+selected+'>'+item+'</option>';
				});


				selectHtml += '</select>';
				return selectHtml;
			}



			function editRow(oTable, nRow) {
				var aData = oTable.fnGetData(nRow);
				var jqTds = $('>td', nRow);
				jqTds[0].innerHTML = aData[0];
				jqTds[1].innerHTML = '<input type="text" class="form-control " value="' + aData[1] + '">';
				jqTds[2].innerHTML = getPlacesType(aData[2]);
				jqTds[3].innerHTML = '<a href="#" class="edit btn btn-xs btn-default" data-save="1"> <i class="fa fa-check"> </i></a>';
			}

			function saveRow(oTable, nRow) {
				var aData = oTable.fnGetData(nRow);
				var jqInputs = $('input', nRow);
				var jqSelects = $('select', nRow);

				if( !jqInputs[1].value ) return false;
				oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
				oTable.fnUpdate(jqSelects[0][jqSelects[0].value].text, nRow, 2, false);
				oTable.fnUpdate('<a class="edit" href="javascript:;"  data-save="0"> <i class="fa fa-edit"></i> </a> ' +
					'<a class="delete font-red" href="javascript:;"> <i class="fa fa-times"></i> </a> ', nRow, 3, false);
				oTable.fnDraw();


				$.post("/webmaster/places/edit/"+jqInputs[0].value, {name: jqInputs[1].value, type: jqSelects[0].value}, function(data){

					oTable.fnUpdate("<input type='hidden' value='"+data+"'>"+data, nRow, 0, false);
				});

			}

			var table = $('#places_table');
			var oTable = table.dataTable(options);

			var nEditing = null;
			var nNew = false;

			$('#places_table_new').click(function (e) {
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
				var aiNew = oTable.fnAddData(['<input type="hidden" value="0">', '', '', '']);
				var nRow = oTable.fnGetNodes(aiNew[0]);
				editRow(oTable, nRow);
				nEditing = nRow;
				nNew = true;
			});

			table.on('click', '.delete', function (e) {
				e.preventDefault();

				if (confirm("Вы уверены, что хотите удалить место?") == false) {
					return;
				}

				var jqInputs = $('input', $(this).parents('tr'));
				$.post("/webmaster/places/delete/"+jqInputs[0].value, function(data){

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
					/* Currently editing - but not this row - restore the old before continuing to edit mode */
					restoreRow(oTable, nEditing);
					editRow(oTable, nRow);
					nEditing = nRow;
				} else if (nEditing == nRow && $(this).data('save')) {
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
				handleTable(options, places);

			}
		};

	}();

</script>