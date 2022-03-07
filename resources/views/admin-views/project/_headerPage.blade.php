<div class="header bg-primary pb-8 pt-3 pt-md-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4 mb-4">
                <div class="col-lg-6 col-7">
                    {{-- <h6 class="h2 text-white d-inline-block mb-0">Tables</h6> --}}
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Proyek</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">
                        Tambahkan proyek
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.project.store') }}" method="post">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Proyek</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama project</label>
                                            <input type="text" class="form-control" id="name" aria-describedby="name"
                                                name="name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Jenis pekeerjaan</label>
                                            <input type="text" class="form-control" id="jenis" aria-describedby="jenis"
                                                name="jenis">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nilai" class="form-label">Nilai project</label>
                                            <input type="number" class="form-control" id="nilai" name="nilai">
                                        </div>
                                        <div class="mb-3">
                                            <label for="nomor" class="form-label">Nomor kontrak <small>(Opsional)</small></label>
                                            <input type="text" class="form-control" id="nomor" name="nomor">
                                        </div>
                                        <div class="mb-3">
                                            <label for="desc" class="form-label w-100">Supplier</label>
                                            <select class="js-example-basic-multiple form-control w-100" name="pekerja[]" multiple="multiple">
                                                @foreach ($worker as $w)
                                                <option value="{{ $w['id'] }}">{{ $w['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="desc" class="form-label w-100">Approver</label>
                                            <select class="js-example-basic-multiple2 form-control w-100" name="approver[]" multiple="multiple">
                                                @foreach ($app as $a)
                                                <option value="{{ $a['id'] }}">{{ $a['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            $('.js-example-basic-multiple2').select2();
        });
    </script>
@endpush
