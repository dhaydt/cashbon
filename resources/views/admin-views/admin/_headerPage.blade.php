<div class="header bg-primary pb-8 pt-3 pt-md-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    {{-- <h6 class="h2 text-white d-inline-block mb-0">Tables</h6> --}}
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="javascript:">User Section</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Admin</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <button type="button" class="btn btn-sm btn-neutral" data-toggle="modal"
                        data-target="#modal-form">Add Admin</button>
                    {{-- <a href="#" class="btn btn-sm btn-neutral">Filters</a> --}}
                    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
                        aria-hidden="true">
                        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content">

                                <div class="modal-body p-0">
                                    <div class="card bg-secondary border-0 mb-0">
                                        <div class="card-body px-lg-5 py-lg-5">
                                            <div class="text-center text-muted mb-4">
                                                <small>Add Admin</small>
                                            </div>
                                            <form class="js-validate" role="form" method="POST" action="{{route('admin.userAdminAdd')}}">
                                                @csrf
                                                <div class="form-group mb-3">
                                                    <div class="input-group input-group-merge input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ni ni-single-02"></i></span>
                                                        </div>
                                                        <input class="pl-2 form-control" name="name" placeholder="Name" type="text">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <div class="input-group input-group-merge input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ni ni-mobile-button"></i></span>
                                                        </div>
                                                        <input class="pl-2 form-control" name="phone" placeholder="Phone" type="number">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <div class="input-group input-group-merge input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ni ni-email-83"></i></span>
                                                        </div>
                                                        <input class="pl-2 form-control" name="email" placeholder="Email" type="email">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group input-group-merge input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ni ni-lock-circle-open"></i></span>
                                                        </div>
                                                        <input class="pl-2 form-control" name="password" placeholder="Password"
                                                            type="password">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group input-group-merge input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ni ni-lock-circle-open"></i></span>
                                                        </div>
                                                        <input class="pl-2 form-control" name="c_password" placeholder="Confirm Password"
                                                            type="password">
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary my-4">Add Admin</button>
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
        </div>
    </div>
</div>
