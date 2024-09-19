<div class="account-pages d-flex align-items-center" style="min-height: calc(100vh - 40px); background-color: #2e3033;" ">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="card overflow-hidden">
                    <div class="row g-0">

                        <div class="col-md-5 d-none d-md-flex justify-content-center align-items-center"
                            style="background-color: #0a0b0b;">
                            <img src="{{ asset('images/logo-imajiwa.png') }}" alt="Imajiwa Logo"
                                class="img-fluid p-4" style="max-width: 80%; height: auto;">
                        </div>

                        <div class="col-12 col-md-7 p-4 d-flex flex-column justify-content-center">
                            <h4 class="text-white text-center text-md-start mt-3">IMAJIWA Creative Studio</h4>
                            <div class="p-2 mt-3">
                                <form class="form-horizontal" wire:submit="login">

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username"
                                            placeholder="Enter username" wire:model="username" autocomplete="username">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="Enter password"
                                                aria-label="Password" aria-describedby="password-addon"
                                                wire:model="password" autocomplete="current-password">
                                            <button class="btn btn-light" type="button" id="password-addon"><i
                                                    class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember-check"
                                            wire:model="remember">
                                        <label class="form-check-label" for="remember-check">
                                            Remember me
                                        </label>
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <a href="#" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot
                                            your password?</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
