@extends('__layouts.app')

@section('title', 'Peminjaman')

@section('content')

	<div class="card shadow mb-4">
		<div class="card-header d-flex align-items-center justify-content-between">
			<h6 class="font-weight-bold text-primary m-0">Data Peminjaman</h6>
			<div>
				<button class="btn btn-sm btn-success" data-toggle="collapse" data-target="#filter">Filter</button>
				<a href="{{ route('loan.create') }}" class="btn btn-primary btn-sm">Tambah Peminjaman</a>
			</div>
		</div>
		<div class="card-body border-bottom collapse" id="filter">
			<form class="form-row">
				<div class="col-sm-4">
					<div class="form-group">
						<label>Anggota</label>
						<input type="text" class="form-control" data-filter="member" placeholder="Anggota">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label>Kembali</label>
						<input type="date" class="form-control" data-filter="return" placeholder="Kembali">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label>Status</label>
						<select data-filter="status" class="form-control custom-select">
							<option value="1">Aktif</option>
							<option value="0">Kembali</option>
							<option value="2">Belum Diambil</option>
							<option value="-1">Batal</option>
						</select>
					</div>
				</div>
			</form>
		</div>
		<div class="card-body">
			<div id="alert">
				@if(session('success'))
					<div class="alert alert-success alert-dismissible">
						{{ session('success') }}
						<button class="close" data-dismiss="alert">&times;</button>
					</div>
				@endif
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-striped" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Buku</th>
							<th>Anggota</th>
							<th>Kembali</th>
							<th>Telat</th>
							<th>Status</th>
							<th>#</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>

	@include('loan.return')
	@include('loan.extend')

@endsection

@push('styles')

	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}">

@endpush

@push('scripts')

	<script>
		let ajaxUrl = "{{ route('loan.index') }}"
		let returnUrl = "{{ route('loan.return', ':id') }}";
		let extendUrl = "{{ route('loan.extend', ':id') }}";
		let abortUrl = "{{ route('loan.abort', ':id') }}"
		let takedUrl = "{{ route('loan.taked', ':id') }}"
		let deleteUrl = "{{ route('loan.destroy', ':id') }}"
		let csrf = "{{ csrf_token() }}"
	</script>

	<script src="{{ asset('sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

	<script src="{{ asset('js/loan.js') }}"></script>

@endpush