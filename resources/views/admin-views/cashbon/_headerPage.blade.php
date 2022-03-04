<style>
    .dated{
        width: 230px;
    }
</style>
<div class="header bg-primary pb-8 pt-3 pt-md-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4 mb-4">
                <div class="col-lg-5 col-md-8 col-7 mb-3">
                    {{-- <h6 class="h2 text-white d-inline-block mb-0">Tables</h6> --}}
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="javascript:">Manajemen Kasbon</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kasbon masuk</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-7 col-md-12 col-12 d-flex justify-content-end mb-3">
                        {{-- <form action="{{ url()->current() }}" id="sort-range" method="GET" class="d-flex"> --}}
                            {{-- @csrf --}}
                        <form action="{{ route('admin.export') }}" method="GET" class="d-flex">
                            <div class="input-group dated mr-2">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Mulai</span>
                                </div>
                                <input type="date" autocomplete="off" name="start-date" required class="pl-2 form-control" id="start-date" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group dated mr-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2">Akhir</span>
                                </div>
                                <input type="date" autocomplete="off" name="end-date" required class="pl-2 form-control" id="end-date" aria-describedby="basic-addon2">
                            </div>
                            {{-- <button class="btn btn-primary btn-sm mx-3" type="submit">Filter</button> --}}
                        {{-- </form> --}}

                            {{-- <input type="hidden" name="start-date" id="start-export">
                            <input type="hidden" name="end-date" id="end-export"> --}}
                            <button class="btn btn-primary btn-sm" type="submit">Cetak</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
