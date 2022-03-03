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
                        <div class="field-group mb-3">
                            <span class="field-title">Dalam project :</span>
                            <h4 class="field-content capitalize ml-3">{{ $user->project->name }}</h4>
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
                                                        @foreach (json_decode($user->project->approver) as $a)
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
                                    <span class="status-approver ml-2">Status :</span> <span class="value-status capitalize @if ($p->status == 'menunggu') badge badge-secondary
                                    @endif @if ($p->status == 'diterima') badge badge-success @endif @if ($p->status == 'ditolak')
                                    badge badge-danger @endif">{{ $p->status }}</span>
                                </div>
                                <div class="col ml-3">
                                    <span class="stattus-approver ml-2">Diterima :</span> <span class="value-status">@currency($p->accepted)</span>
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
