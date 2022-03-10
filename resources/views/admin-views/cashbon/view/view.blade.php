@section('title', 'Deatils Customer')
@extends('layouts.backend.app')
<style>
    #changeImg {
        position: absolute;
        opacity: 0;
    }

    #imgPict {
        height: 180px;
        width: 180px;
        background-color: #fff;
        margin-top: -35px;
    }

    .user-name {
        text-transform: capitalize;
    }
</style>
@section('content')
@include('admin-views.cashbon.view._headerPage', [
'title' => __('Hello') . ' '. $user->pekerja->name,
'description' => __('This is your profile page. You can see the progress you\'ve made with your work and manage your
projects or assigned tasks'),
'class' => 'col-lg-7'
])

<div class="container-fluid mt--7">
    <div class="row justify-content-center">
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="heading-small text-muted mb-4">{{ __('detail pengajuan kasbon dari
                                ').$user->pekerja->name }}</h6>
                        </div>
                        <div class="col-md-4 text-end">
                            @if ($user->admin_status == 'menunggu')
                            <span class="badge badge-secondary badge-status">{{ $user->admin_status }}</span>
                            @endif
                            @if ($user->admin_status == 'diproses')
                            <span class="badge badge-info badge-status">{{ $user->admin_status }}</span>
                            @endif
                            @if ($user->admin_status == 'diterima')
                            <span class="badge badge-success badge-status">{{ $user->admin_status }}</span>
                            @endif
                            @if ($user->admin_status == 'ditolak')
                            <span class="badge badge-danger badge-status">{{ $user->admin_status }}</span>
                            @endif
                        </div>
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="pl-lg-4">
                        <div class="field-group mb-3">
                            <span class="field-title">Nama pemohon :</span>
                            <h4 class="field-content capitalize ml-3">{{ $user->pekerja->name }}</h4>
                        </div>
                        <div class="field-group mb-3">
                            <span class="field-title">Pengajuan Kasbon :</span><br>
                            <h4 class="field-content badge badge-info capitalize ml-3 mt-2">@currency($user->pengajuan)
                            </h4>
                        </div>
                        @if ($user->admin_status == 'diterima')
                        <div class="field-group mb-3">
                            <span class="field-title">Diterima Admin :</span><br>
                            <h4 class="field-content badge badge-success capitalize ml-3 mt-2">@currency($user->dipinjamkan)
                            </h4>
                        </div>
                        <div class="field-group mb-3">
                            <span class="field-title">Tanggal diterima :</span><br>
                            <h4 class="field-content badge badge-warning capitalize ml-3 mt-2">{{ date_format(date_create($user->diterima_pada), "d - M - Y") }}
                            </h4>
                        </div>
                        <div class="field-group mb-3">
                            <span class="field-title">Tipe</span><br>
                            <h4 class="field-content capitalize ml-3 mt-2">{{ $user->type }}
                            </h4>
                        </div>
                        <div class="field-group mb-3">
                            <span class="field-title">Nomor Nota</span><br>
                            <h4 class="field-content capitalize ml-3 mt-2">{{ $user->no_nota }}
                            </h4>
                        </div>
                        @endif
                        <div class="field-group mb-3">
                            <span class="field-title">Dalam project :</span>
                            <h4 class="field-content capitalize ml-3">{{ $user->project->name }}</h4>
                        </div>
                        <div class="field-group mb-3">
                            <span class="field-title">Nilai project :</span> <br>
                            <h4 class="field-content badge badge-warning capitalize ml-3 mt-2">@currency($user->project->nilai_project)
                            </h4>
                        </div>
                        <div class="field-group mb-3">
                            <span class="field-title">Total Kasbon :</span><br>
                            <h4 class="field-content badge badge-info capitalize ml-3 mt-2">@currency($user->project->total_cashbon)</h4>
                        </div>
                        <div class="field-group mb-3">
                            <span class="field-title">Sisa :</span><br>
                            <h4 class="field-content capitalize badge badge-info ml-3 mt-2">@currency($user->project->sisa)</h4>
                        </div>
                        <div class="field-group mb-3">
                            <span class="field-title">Keperluan :</span>
                            <h4 class="field-content capitalize ml-3">{{ $user->keperluan }}</h4>
                        </div>
                        <div class="field-group mb-3">
                            <span class="field-title">Approver :</span>
                            @if ($user->approver == '[]')
                            <div class="row ml-1 mt-1">
                                <div class="col-6">
                                    <span class="badge badge-danger capitalize">belum dipilih</span>
                                </div>
                                <div class="col-6 text-end">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop">Pilih approver</button>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Pilih Approver</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.cashbon.approver') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="cashbon_id" value="{{ $user->id }}">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="desc" class="form-label w-100">Approver</label>
                                                    <select class="js-example-basic-multiple2 form-control w-100"
                                                        name="approver[]" multiple="multiple">
                                                        @foreach ($approver as $a)
                                                        <option value="{{ $a->id }}">{{ $a->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Tambahkan
                                                    approver</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                            @foreach (json_decode($user->approver_status) as $p)
                            <h4 class="field-content capitalize ml-3 mb-0">{{ App\CPU\Helpers::getApprover($p->id)->name
                                }}</h4>
                            <div class="row">
                                <div class="col ml-3">
                                    <span class="status-approver ml-2">Status :</span>
                                    <span id="status{{ $p->id }}" class="value-status capitalize @if ($p->status == 'menunggu') badge badge-secondary
                                    @endif @if ($p->status == 'diterima') badge badge-success @endif @if ($p->status == 'ditolak')
                                    badge badge-danger @endif">{{ $p->status }}</span>
                                </div>
                                <div class="col">
                                    <span class="stattus-approver ml-2">Diterima :</span>
                                    <span id="value{{ $p->id }}" class="value-status">@currency($p->accepted)</span>
                                </div>
                                <div class="col text-end">
                                    @if ($p->status != 'menunggu' && $user->admin_status != 'diterima')
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop{{ $p->id }}">Proses</button>
                                    @endif
                                    @if (auth('admin')->user()->role == 'admin')
                                        @if ($p->status != 'menunggu')
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop{{ $p->id }}">Proses</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="modal fade" id="staticBackdrop{{ $p->id }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Proses kasbon</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.cashbon.adminUpdate') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="cashbon_id" value="{{ $user->id }}">
                                            <div class="modal-body">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Tipe</span>
                                                    <input type="text" class="form-control pl-2" name="type" value="{{ $user->type }}">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">No. Nota</span>
                                                    <input type="text" class="form-control pl-2" name="nota" value="{{ $user->no_nota }}">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">Status</span>
                                                    <select name="status" class="form-control pl-2" id="basic-addon1">
                                                        <option value="diterima" {{ $p->status == 'diterima' ?
                                                            'selected' : '' }}>Terima</option>
                                                        <option value="ditolak" {{ $p->status == 'ditolak' ? 'selected'
                                                            : '' }}>Tolak</option>
                                                    </select>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon2">Nilai</span>
                                                    <input type="text" class="form-control pl-2" name="nilai"
                                                        value="{{ $user->dipinjamkan ? $user->dipinjamkan : $p->accepted }}" aria-label="nilai"
                                                        aria-describedby="basic-addon2">
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Proses</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    $(document).ready(function() {
            $('.js-example-basic-multiple2').select2();
        });
</script>
@endpush
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    function changeImgs() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("changeImg").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("imgPict").src = oFREvent.target.result;
            var formData = new FormData(document.getElementById('imgForm'));
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.adminPict')}}',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('product updated successfully!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#product_form').submit();
                    }
                }
            });
        };
    };
</script>
