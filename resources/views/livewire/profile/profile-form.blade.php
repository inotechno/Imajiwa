<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Employee', 'url' => route('employee.index')], ['name' => 'Edit profile ' . $employee->user->name]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Edit Profile</h4>
                    <form wire:submit.prevent="save" class="needs-validation" wire:ignore.self>

                        {{-- Profile Image  --}}
                        <div class="row mb-4">
                            <label for="avatar_url" class="col-form-label col-lg-2">Profile Image</label>
                            <div class="col-lg-10">
                                <input type="file" id="avatar_url" name="avatar_url" wire:model="avatar_url"
                                    class="form-control @error('avatar_url') is-invalid @enderror">

                                @if (isset($avatar_url) && strpos($avatar_url, 'http') === 0)
                                    <img src="{{ $avatar_url }}" alt="Avatar Preview" class="img-thumbnail mt-2"
                                        width="150">
                                @elseif ($user->avatar_url)
                                    <img src="{{ Storage::url($user->avatar_url) }}" alt="Avatar"
                                        class="img-thumbnail mt-2" width="150">
                                @else
                                    <img src="{{ asset('images/avatar-1.jpg') }}" alt="Default Avatar"
                                        class="img-thumbnail mt-2" width="150">
                                @endif

                                <!-- Menampilkan pesan kesalahan jika ada -->
                                @error('avatar_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="personal_information" class="col-form-label col-lg-2"> Personal
                                Information</label>
                            <div class="col-lg-10">
                                <textarea id="personal_information" name="personal_information" wire:model="personal_information"
                                    class="form-control @error('personal_information') is-invalid @enderror"
                                    placeholder="Enter Personal Information ..." rows="5"></textarea>
                                @error('personal_information')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        {{-- citizen  --}}
                        <div class="row mb-4">
                            <label for="citizen_id" class="col-form-label col-lg-2"> Citizen ID</label>
                            <div class="col-lg-10">
                                <input id="citizen_id" name="citizen_id" wire:model="citizen_id" type="text"
                                    class="form-control @error('citizen_id') is-invalid @enderror"
                                    placeholder="Enter Citizen ID ...">
                                @error('citizen_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- name  --}}
                        <div class="row mb-4">
                            <label for="name" class="col-form-label col-lg-2"> Name</label>
                            <div class="col-lg-10">
                                <input id="name" name="name" wire:model="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter User Name...">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- username  --}}
                        <div class="row mb-4">
                            <label for="username" class="col-form-label col-lg-2"> User Name</label>
                            <div class="col-lg-10">
                                <input id="username" name="username" wire:model="username" type="text"
                                    class="form-control @error('username') is-invalid @enderror"
                                    placeholder="Enter Username...">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- email  --}}
                        <div class="row mb-4">
                            <label for="email" class="col-form-label col-lg-2"> Email</label>
                            <div class="col-lg-10">
                                <input id="email" name="email" wire:model="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Enter User Email...">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- ttl  --}}
                        <div class="row mb-4">
                            <label for="join_date" class="col-form-label col-lg-2"> Place, Birth Date</label>
                            <div class="col-lg-4 mb-3">
                                <input id="place_of_birth" name="place_of_birth" wire:model="place_of_birth"
                                    type="text" class="form-control @error('place_of_birth') is-invalid @enderror"
                                    placeholder="Enter Place Of Birth...">
                                @error('place_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <input id="birth_date" name="birth_date" wire:model="birth_date" type="date"
                                    class="form-control @error('birth_date') is-invalid @enderror"
                                    placeholder="Enter User Birth Date...">
                                @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- select-gender --}}
                        <div class="row mb-4" wire:ignore>
                            <label for="gender" class="col-form-label col-lg-2">Select Gender</label>
                            <div class="col-lg-10">
                                <select
                                    class="form-control select2 @error('gender') is-invalid @enderror select-gender"
                                    id="gender" wire:model="gender" data-placeholder="Select Gender">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>

                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- select-religion --}}
                        <div class="row mb-4" wire:ignore>
                            <label for="religion" class="col-form-label col-lg-2">Select Religion</label>
                            <div class="col-lg-10">
                                <select
                                    class="form-control select2 @error('religion') is-invalid @enderror select-religion"
                                    id="religion" wire:model="religion" data-placeholder="Select Religion">
                                    <option value="">Select Religion</option>
                                    <option value="islam">Islam</option>
                                    <option value="kristen">Kristen</option>
                                    <option value="katholik">Katholik</option>
                                    <option value="hindu">Hindu</option>
                                    <option value="budha">Budha</option>
                                    <option value="konghucu">Konghucu</option>
                                </select>

                                @error('religion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- select-marital-status --}}
                        <div class="row mb-4" wire:ignore>
                            <label for="marital_status" class="col-form-label col-lg-2">Select Marital Status</label>
                            <div class="col-lg-10">
                                <select
                                    class="form-control select2 @error('marital_status') is-invalid @enderror select-marital-status"
                                    id="marital_status" wire:model="marital_status"
                                    data-placeholder="Select Marital Status">
                                    <option value="">Select Marital Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                </select>

                                @error('marital_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Input untuk Password Lama -->
                        <div class="row mb-4">
                            <label for="old_password" class="col-form-label col-lg-2"> Change Password</label>
                            <div class="col-md-3 mb-4">
                                <div class="input-group auth-pass-inputgroup">
                                    <input id="old_password" name="old_password" wire:model="old_password"
                                        type="password"
                                        class="form-control @error('old_password') is-invalid @enderror"
                                        placeholder="Enter Old Password...">
                                    <button class="btn btn-light" type="button" id="password-addon"><i
                                            class="mdi mdi-eye-outline"></i></button>
                                </div>
                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3  mb-4">
                                <div class="input-group auth-pass-inputgroup">
                                    <input id="new_password" name="new_password" wire:model="new_password"
                                        type="password"
                                        class="form-control @error('new_password') is-invalid @enderror"
                                        placeholder="Enter New Password...">
                                    <button class="btn btn-light" type="button" id="new-password-addon"><i
                                            class="mdi mdi-eye-outline"></i></button>
                                </div>

                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3  mb-4">
                                <div class="input-group auth-pass-inputgroup">
                                    <input id="confirm_password" name="confirm_password"
                                        wire:model="confirm_password" type="password"
                                        class="form-control @error('confirm_password') is-invalid @enderror"
                                        placeholder="Enter Confirm Password...">
                                    <button class="btn btn-light" type="button" id="confrim-password-addon"><i
                                            class="mdi mdi-eye-outline"></i></button>
                                </div>
                                @error('confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                    wire:target="save">Update User</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

        <script>
            document.addEventListener('livewire:init', function() {
                $('.select2').select2();

                $('.select-religion').on('change', function() {
                    Livewire.dispatch('changeSelectForm', ['religion', this.value]);
                });

                $('.select-marital-status').on('change', function() {
                    Livewire.dispatch('changeSelectForm', ['marital_status', this.value]);
                });



                $('.select-gender').on('change', function() {
                    Livewire.dispatch('changeSelectForm', ['gender', this.value]);
                });

                Livewire.on('change-select-form', () => {
                    var religion = @json($religion);
                    var marital_status = @json($marital_status);
                    var gender = @json($gender);


                    $('.select-religion').val(religion).trigger('change');
                    $('.select-marital-status').val(marital_status).trigger('change');
                    $('.select-gender').val(gender).trigger('change');
                });

                Livewire.on('reset-select2', () => {
                    $('.select-religion').val(null).trigger('change');
                    $('.select-marital-status').val(null).trigger('change');
                    $('.select-gender').val(null).trigger('change');
                })

                document.getElementById('new-password-addon').addEventListener('click', function() {
                    const newPasswordInput = document.getElementById('new_password');
                    const type = newPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    newPasswordInput.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('mdi-eye-outline');
                    this.querySelector('i').classList.toggle('mdi-eye-off-outline');
                });

                document.getElementById('confrim-password-addon').addEventListener('click', function() {
                    const confirmPasswordInput = document.getElementById('confirm_password');
                    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPasswordInput.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('mdi-eye-outline');
                    this.querySelector('i').classList.toggle('mdi-eye-off-outline');
                });
            });
        </script>
    @endpush
</div>
