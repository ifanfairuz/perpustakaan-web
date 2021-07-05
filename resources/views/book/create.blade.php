@extends('__layouts.app')

@section('title', 'Tambah Buku')

@section('content')


	<div class="col-md-6 mx-auto">
		<div class="card shadow mb-4">
			<div class="card-header">
				<h6 class="font-weight-bold text-primary m-0">Tambah Buku</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('book.store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>Kode</label>
						<input type="text" class="form-control @error('code') is-invalid @enderror" name="code" placeholder="Kode" value="{{ old('code') }}" autofocus>
						<small class="form-text text-muted">Opsional, Maks: 15</small>

						@error('code')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Nama</label>
						<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama" value="{{ old('name') }}" required>

						@error('name')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Penulis</label>
						<input type="text" class="form-control @error('writer') is-invalid @enderror" name="writer" placeholder="Penulis" value="{{ old('writer') }}" required>

						@error('writer')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Kategori</label>
						<select name="category_id" class="form-control custom-select" required></select>

						@error('category_id')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Tahun</label>
						<input type="number" maxlength="4" class="form-control @error('year') is-invalid @enderror" name="year" placeholder="Tahun" value="{{ old('year') }}" required>

						@error('year')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Deskripsi</label>
						<textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Deskripsi">{{ old('description') }}</textarea>

						@error('description')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Sampul</label>
						<div class="custom-file">
							<label class="custom-file-label">Unggah</label>
							<input type="file" class="custom-file-input @error('cover') is-invalid @enderror" name="cover" placeholder="Sampul" value="{{ old('cover') }}" required>
							
							@error('cover')
								<span class="invalid-feedback">{{ $message }}</span>
							@enderror
						</div>

					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Tambah</button>
						<a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

@push('styles')
	
	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('sbadmin/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endpush

@push('scripts')
	
	<script src="{{ asset('sbadmin/vendor/select2/js/select2.min.js') }}"></script>

	<script>
		$('[name=category_id]').select2({
			placeholder: 'Kategori',
			ajax: {
				url: '{{ route("category.get") }}',
				type: 'post',
				data: params => ({
					_token: '{{ csrf_token() }}',
					name: params.term
				}),
				dataType: 'json',
				processResults: res => ({
					results: res
				}),
				cache: true
			}
		})
	</script>

@endpush