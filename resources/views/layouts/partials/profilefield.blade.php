<div class="form-group">
	<label for="full_name" class="control-label">Nama Lengkap</label>
	<input type="text" class="form-control" id="full_name" name="full_name" placeholder="Masukan nama lengkap Anda" value="{{ old('full_name') }}">
</div>

<div class="form-group">
	<label for="phone_number" class="control-label">No Telopon/Hp</label>
	<input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukan no telepon/Hp Anda" value="{{ old('phone_number') }}">
</div>

<div class="form-group">
	<label for="address" class="control-label">Alamat</label>
	<input type="text" class="form-control" id="address" name="address" placeholder="Masukan alamat Anda" value="{{ old('address') }}">
</div>

<div class="form-group">
	<label for="city" class="control-label">Kota</label>
	<input type="text" class="form-control" id="city" name="city" placeholder="Kota" value="{{ old('city') }}">
</div>

<div class="form-group">
	<label for="province" class="control-label">Provinsi</label>
	<input type="text" class="form-control" id="province" name="province" placeholder="Provinsi" value="{{ old('province') }}">
</div>

<div class="form-group">
	<label for="postal_code" class="control-label">Kode Pos</label>
	<input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Masukan kode pos misal: 28114" value="{{ old('postl_code') }}">
</div>

<div class="input-group">
	<input type="submit" class="btn btn-primary" value="{{ $actions }}">
</div>