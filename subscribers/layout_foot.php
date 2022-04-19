	</div>
	<!-- /container -->

<!-- jQuery library -->
<script src="libs/js/jquery.js"></script>

<!-- bootbox for confirm pop up -->
<script src="libs/js/bootbox.min.js"></script>

<!-- bootstrap JavaScript -->
<script src="libs/js/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="libs/js/bootstrap/docs-assets/js/holder.js"></script>

<script type='text/javascript'>
$(document).ready(function() {
	//check/uncheck script
	$(document).on('click', '#checker', function(){
		$('.checkboxes').prop('checked', $(this).is(':checked'));
	});

	// delete record
	$(document).on('click', '.delete-object', function(){

		var id = $(this).attr('delete-id');

		bootbox.confirm({
		    message: "<h4>Are you sure?</h4>",
		    buttons: {
		        confirm: {
		            label: '<span class="glyphicon glyphicon-ok"></span> Yes',
		            className: 'btn-danger'
		        },
		        cancel: {
		            label: '<span class="glyphicon glyphicon-remove"></span> No',
		            className: 'btn-primary'
		        }
		    },
		    callback: function (result) {

		        if(result==true){
					$.post('delete.php', {
						object_id: id
					}, function(data){
						location.reload();
					}).fail(function() {
						alert('Unable to delete.');
					});
		    	}
			}
		});

		return false;
	});

	// delete selected records
	$(document).on('click', '#delete-selected', function(){

		var at_least_one_was_checked = $('.checkboxes:checked').length > 0;

		if(at_least_one_was_checked){

			bootbox.confirm({
				message: "<h4>Are you sure?</h4>",
				buttons: {
					confirm: {
						label: '<span class="glyphicon glyphicon-ok"></span> Yes',
						className: 'btn-danger'
					},
					cancel: {
						label: '<span class="glyphicon glyphicon-remove"></span> No',
						className: 'btn-primary'
					}
				},
				callback: function (result) {

					if(result==true){
						//get converts it to an array
						var del_checkboxes = $('.checkboxes:checked').map(function(i,n) {
							return $(n).val();
						}).get();

						if(del_checkboxes.length==0) {
							del_checkboxes = "none";
						}

						$.post("delete_selected.php", {'del_checkboxes[]': del_checkboxes},
							function(response) {
								// refresh page
								location.reload();
							});
					}
				}
			});
		}

		else{
			bootbox.alert("Please select at least one record to delete.");
		}
	});
});
</script>

</body>
</html>
