@extends('__layouts.app')

@section('title', 'Tambah Anggota')

@section('content')


	<div class="col-md-6 mx-auto">
		<div class="card shadow mb-4">
			<div class="card-header">
				<h6 class="font-weight-bold text-primary m-0">Tambah Anggota</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('member.store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required>
		
								@error('email')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Password</label>
								<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
		
								@error('password')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Konfirmasi Password</label>
								<input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Nama</label>
								<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama" value="{{ old('name') }}" required>

								@error('name')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>No Telp</label>
								<input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="No Telp" value="{{ old('phone') }}" required>

								@error('phone')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select name="gender" class="form-control custom-select @error('gender') is-invalid @enderror" required>
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>

								@error('gender')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Tgl Lahir</label>
								<input type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" placeholder="birthday" value="{{ old('birthday') }}" required>

								@error('birthday')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Alamat</label>
						<textarea class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Alamat" required>{{ old('address') }}</textarea>

						@error('address')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label>Foto</label>
						<div class="custom-file">
							<label class="custom-file-label">Unggah</label>
							<input type="file" class="custom-file-input @error('file') is-invalid @enderror" name="file" placeholder="Foto" value="{{ old('file') }}" required>
							
							@error('file')
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

@push('scripts')

	<script src="{{ asset('sbadmin/vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

	<script>
		bsCustomFileInput.init()
	</script>

@endpush