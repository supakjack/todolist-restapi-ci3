<script>
	var rowNumber;
	var todolists = {
		name: '',
		discript: '',
		value: '',
		use: '',
	}

	function changeName() {
		todolists.name = event.currentTarget.value
	}

	function changeDiscript() {
		todolists.discript = event.currentTarget.value
	}

	function changeValue() {
		todolists.value = event.currentTarget.value
	}

	function changeUse() {
		todolists.use = event.currentTarget.value
	}

	function deleteTodolists(id) {
		rowNumber = 1;
		$.ajax({
			type: "DELETE",
			url: "<?= base_url('api/Todolists/todolists/id/') ?>" + id,
			dataType: "json",
			success: function(res) {
				$('#todolists').DataTable().ajax.reload();
			}
		});
	}

	function editTodolists(id) {
		$.ajax({
			type: "GET",
			url: "<?= base_url('api/Todolists/todolists/id/') ?>" + id,
			dataType: "json",
			success: function(res) {
				todolists.name = res[0].tl_name
				todolists.discript = res[0].tl_discript
				todolists.value = res[0].tl_value
				todolists.use = res[0].tl_use
				console.log(todolists)
				Swal.fire({
					title: '<strong>Add todolists</strong>',
					icon: 'info',
					html: `	<input onChange="changeName()" value="${todolists.name}" type="text" id="name" placeholder="name..." class="form-control">
					<input onChange="changeDiscript()" value="${todolists.discript}" type="text" id="discript" placeholder="discript..." class="form-control">
					<input onChange="changeValue()" value="${todolists.value}" type="number" id="value" placeholder="number..." class="form-control">
					<select onChange="changeUse()" class="custom-select"  id="use">
						<option value="y" ${todolists.use=='y'?'selected':''}>use</option>
						<option value="n" ${todolists.use=='n'?'selected':''}>not use</option>
					</select>`,
					showCloseButton: true,
					showCancelButton: false,
					focusConfirm: false,
					confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
					confirmButtonAriaLabel: 'Thumbs up, great!',
					cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
					cancelButtonAriaLabel: 'Thumbs down'
				}).then((result) => {
					if (result.value) {
						rowNumber = 1;
						$.ajax({
							type: "PUT",
							url: "<?= base_url('api/Todolists/todolists/id/') ?>" + id,
							data: todolists,
							dataType: "json",
							success: function(res) {
								console.log(todolists)
								console.log(res)
								$('#todolists').DataTable().ajax.reload();
							}
						});
						Swal.fire(
							'อัพเดทข้อมูลสำเร็จ!',
							'Your todolists has been add.',
							'success'
						)
					}
				})

			}
		});

	}

	function addTodolists() {
		Swal.fire({
			title: '<strong>Add todolists</strong>',
			icon: 'info',
			html: `	<input onChange="changeName()" type="text" id="name" placeholder="name..." class="form-control">
					<input onChange="changeDiscript()" type="text" id="discript" placeholder="discript..." class="form-control">
					<input onChange="changeValue()" type="number" id="value" placeholder="number..." class="form-control">
					<select onChange="changeUse()" class="custom-select"  id="use">
						<option value="y" selected>use</option>
						<option value="n">not use</option>
					</select>`,
			showCloseButton: true,
			showCancelButton: false,
			focusConfirm: false,
			confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
			confirmButtonAriaLabel: 'Thumbs up, great!',
			cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
			cancelButtonAriaLabel: 'Thumbs down'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "POST",
					url: "<?= base_url('api/Todolists/todolists') ?>",
					data: todolists,
					dataType: "json",
					success: function(res) {
						console.log(todolists)
						console.log(res)
						rowNumber = 1;
						$('#todolists').DataTable().ajax.reload();
					}
				});
				Swal.fire(
					'เพิ่มข้อมูลสำเร็จ!',
					'Your todolists has been add.',
					'success'
				)
			}
		})
	}
</script>

<div class="container">
	<button onclick="addTodolists()"> เพิ่ม </button>
	<table id="todolists" class="table">
		<thead>
			<tr>
				<th scope="col">id</th>
				<th scope="col">name</th>
				<th scope="col">discript</th>
				<th scope="col">value</th>
				<th scope="col">use</th>
				<th scope="col">operation</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>

<script>
	$(document).ready(function() {
		rowNumber = 1;
		$('#todolists').DataTable({
			ajax: {
				url: '<?= base_url('api/Todolists/todolists/') ?>',
				dataSrc: ''
			},
			columns: [{
					data: null,
					render: function() {
						return rowNumber++;
					}
				},
				{
					data: 'tl_name',
				},
				{
					data: 'tl_discript'
				},
				{
					data: 'tl_value'
				},
				{
					data: 'tl_use',
				},
				{
					data: 'tl_id',
					render: function(dataField) {
						return `<button onclick="editTodolists(${dataField})"> แก้ไข </button> 
								<button onclick="deleteTodolists(${dataField})"> ลบ </button>`;
					}
				},

			]
		});
	});
</script>