@extends('__layouts.app')

@section('title', 'Kategori')

@section('content')

	<div class="row">
		<div class="col-md-4">
			<div class="card shadow mb-4">
			<form action="" id="create">
				<div class="card-header">
					<h6 class="card-title my-0 font-weight-bold text-primary">Tambah Kategori</h6>
				</div>
				<div class="card-body">
					@csrf
					<div class="form-group">
						<label>Nama</label>
						<input type="text" name="name" class="form-control" placeholder="Nama" required></input>

						<span class="invalid-feedback"></span>
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-primary" type="primary">Tambah</button>
				</div>
			</div>
			</form>
		</div>
		<div class="col-md-8">
			<div class="card shadow">
				<div class="card-header">
					<h6 class="card-title my-0 font-weight-bold text-primary">Data Kategori</h6>
				</div>
				<div class="card-body">
					<div id="alert"></div>
					<div class="table-responsive">
						<table class="table table-bordered table-striped" width="100%">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama</th>
									<th>#</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="edit">
	<div class="modal-dialog">
	<div class="modal-content">
	<form>
		<div class="modal-header">
			<h5 class="modal-title">Edit Data</h5>
			<button class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
			@csrf
			@method('put')
			<div class="form-group">
				<label>Nama</label>
				<input type="text" class="form-control" name="name" placeholder="Nama" autofocus>

				<span class="invalid-feedback"></span>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" type="submit">Update</button>
			<button class="btn btn-danger" data-dismiss="modal">Batal</button>
		</div>
	</form>
	</div>
	</div>
	</div>

@endsection

@push('styles')

	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}">

@endpush

@push('scripts')

	<script>
		let ajaxUrl = "{{ route('category.index') }}"
		let createUrl = "{{ route('category.store') }}"
		let updateUrl = "{{ route('category.update', ':id') }}"
		let deleteUrl = "{{ route('category.destroy', ':id') }}"
		let csrf = "{{ csrf_token() }}"
	</script>

	<script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

	<script src="{{ asset('js/category.js') }}"></script>

@endpush