<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Client', 'url' => route('client.index')], ['name' => $type == 'create' ? 'Create' : 'Edit Client ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        {{ $type == 'create' ? 'Create Client' : 'Edit Client ' . $client->title }}
                    </h4>
                    <form wire:submit.prevent="save" class="needs-validation" wire:ignore.self>
                        <div class="row mb-4">
                            <label for="name" class="col-form-label col-lg-2">Name</label>
                            <div class="col-lg-10">
                                <input id="name" name="name" wire:model="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter Name...">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="email" class="col-form-label col-lg-2">Email</label>
                            <div class="col-lg-10">
                                <input id="email" name="email" wire:model="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Enter Email...">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="phone" class="col-form-label col-lg-2">Phone</label>
                            <div class="col-lg-10">
                                <input id="phone" name="phone" wire:model="phone" type="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="Enter Phone...">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <label for="address" class="col-form-label col-lg-2">Address</label>
                            <div class="col-lg-10">
                                <input id="address" name="address" wire:model="address" type="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Enter address...">

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="contact Person" class="col-form-label col-lg-2">Contact Person</label>
                            <div class="col-lg-10">
                                <input id="contact Person" name="contact Person" wire:model="contact Person" type="contact Person"
                                    class="form-control @error('contact Person') is-invalid @enderror"
                                    placeholder="Enter contact Person...">

                                @error('contact Person')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
