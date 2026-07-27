@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Name *</label><input required class="form-control" name="name" value="{{ old('name',$user->name ?? '') }}"></div>
<div class="col-md-6"><label class="form-label">Email *</label><input required type="email" class="form-control" name="email" value="{{ old('email',$user->email ?? '') }}"></div>
<div class="col-md-4"><label class="form-label">Mobile</label><input class="form-control" name="mobile" value="{{ old('mobile',$user->mobile ?? '') }}"></div>
<div class="col-md-4"><label class="form-label">Role *</label><select required class="form-select" name="role"><option value="">Select role</option>@foreach($roles as $value=>$label)<option value="{{ $value }}" @selected(old('role',$user->role ?? '')===$value)>{{ $label }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Department</label><select class="form-select" name="department"><option value="">Select department</option>@foreach($departments as $department)<option value="{{ $department }}" @selected(old('department',$user->department ?? '')===$department)>{{ $department }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Status *</label><select required class="form-select" name="status"><option value="active" @selected(old('status',$user->status ?? 'active')==='active')>Active</option><option value="inactive" @selected(old('status',$user->status ?? '')==='inactive')>Inactive</option></select></div>
<div class="col-md-4"><label class="form-label">Password {{ isset($user)?'(leave blank to keep)':'*' }}</label><input {{ isset($user)?'':'required' }} type="password" class="form-control" name="password"></div>
<div class="col-md-4"><label class="form-label">Confirm Password</label><input type="password" class="form-control" name="password_confirmation"></div>
<div class="col-md-6"><label class="form-label">Photo</label><input type="file" class="form-control" name="photo" accept="image/*"></div>
<div class="col-12"><label class="form-label">Address</label><textarea class="form-control" name="address">{{ old('address',$user->address ?? '') }}</textarea></div>
<div class="col-12"><label class="form-label">Remarks</label><textarea class="form-control" name="remarks">{{ old('remarks',$user->remarks ?? '') }}</textarea></div>
</div>
