@section('title', 'Detail Project')
@extends('layouts.backend.app')
<style>
    #changeImg {
        position: absolute;
        opacity: 0;
    }
    #imgPict{
        height: 180px;
        width: 180px;
        background-color: #fff;
        margin-top: -35px;
    }
    .data-name {
        text-transform: capitalize;
    }
</style>
@section('content')
@include('admin-views.project.view._headerPage', [
'title' => __('Hello') . ' '. $data->name,
'description' => __('This is your profile page. You can see the progress you\'ve made with your work and manage your
projects or assigned tasks'),
'class' => 'col-lg-7'
])

<div class="container-fluid mt--7 mb-7">
    <div class="row justify-content-center">
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-body">
                    <form method="post" action="{{ route('admin.adminInfo') }}" autocomplete="off">
                        @csrf
                        @method('put')
                        <h6 class="heading-small text-muted mb-4">{{ __($data->name) }}</h6>
                        @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Nilai_proyek') }}</label>
                                <input type="text" readonly name="name" id="input-name"
                                    class="form-control form-control-alternative"
                                    value="{{ old('name', $data->nilai_project) }}">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Total_kasbon') }}</label>
                                <input type="text" readonly class="form-control form-control-alternative"
                                    value="{{ old('name', $data->total_cashbon) }}">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Pekerja') }}</label>
                                <div class="row row-json">
                                    <div class="col-6">
                                        <label for="form-control-label">Nama Pekerja</label>
                                    </div>
                                    <div class="col-md-5 col-6">
                                        <label for="form-control-label">No. Handphone</label>
                                    </div>
                                    @foreach (json_decode($data->pekerja) as $p)
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" readonly class="form-control" value="{{ $p->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-6">
                                            <div class="form-group">
                                                <input type="text" readonly class="form-control" value="{{ $p->phone }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Approver') }}</label>
                                <div class="row row-json">
                                    <div class="col-6">
                                        <label for="form-control-label">Nama Approver</label>
                                    </div>
                                    <div class="col-md-5 col-6">
                                        <label for="form-control-label">No. Handphone</label>
                                    </div>
                                    @foreach (json_decode($data->approver) as $p)
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" readonly class="form-control" value="{{ $p->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-6">
                                            <div class="form-group">
                                                <input type="text" readonly class="form-control" value="{{ $p->phone }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
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
