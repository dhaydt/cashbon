@extends('layouts.backend.app')
@section('title', 'Daftar Approver')
@section('content')
@include('admin-views.approver._headerPage')
<style>
    .viewUser {
        font-size: 22px;
        color: #5e72e4;
    }
    .card-footer {
        /* background-color: grey; */
    }
    .card-footer .row.justify-content-center .col-sm-auto .d-flex nav .flex {
        display: none;
    }
    .card-footer > div > div > div > nav > div.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between > div:nth-child(1) > p {
        display: none;
    }
    .card-footer > div > div > div > nav > div.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between > div:nth-child(2) > span {
        display: flex;
    }

    .card-footer > div > div > div > nav > div.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between > div:nth-child(2) > span span:first-child span svg
    {
        margin-right: 15px;
    }
    .card-footer > div > div > div > nav > div.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between > div:nth-child(2) > span > a:first-child svg{

    }

</style>
<div class="container-fluid mt--8">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="table-responsive" style="overflow: hidden">
                    <table class="table align-items-center table-flush" >
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th scope="col" class="sort" data-sort="name">No</th>
                                <th scope="col" class="sort" data-sort="budget">Nama</th>
                                <th scope="col" class="sort" data-sort="budget">No. Handphone</th>
                                <th scope="col" class="sort" data-sort="status">Proyek</th>
                                <th scope="col" class="sort" data-sort="completion">Aksi</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @php($no = 1)
                            @foreach ($admin as $ad)
                            <tr>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body text-center">
                                            <span class="name mb-0 text-sm">{{ $no++ }}</span>
                                        </div>
                                    </div>
                                </th>
                                <td class="budget text-center">
                                    {{ $ad['name'] }}
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-dot mr-4">
                                        {{-- <i class="bg-warning"></i> --}}
                                        <span class="status">{{ $ad['phone'] }}</span>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-dot mr-4">
                                        @foreach (json_decode($ad['project']) as $p)
                                        <span class="status">{{ $p }}</span>
                                        @endforeach
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-evenly">
                                        {{-- <a href="{{ route('admin.userCustomerView', ['id' => $ad['id']]) }}" class="viewUser">
                                            <i class="far fa-eye"></i>
                                        </a> --}}
                                        <a type="button" class="viewUser" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $ad['id'] }}">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                        <a href="{{ route('admin.approver.delete', ['id' => $ad['id']]) }}" class="viewUser">
                                            <i class="fas fa-trash text-danger"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="modalEdit{{ $ad['id'] }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEdit{{ $ad['id'] }}Label"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('admin.approver.update', ['id' => $ad['id']]) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $ad['id'] }}">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEdit{{ $ad['id'] }}Label">Ubah approver {{ $ad['name'] }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama</label>
                                                <input type="text" value="{{ $ad['name'] }}" class="form-control" id="name" aria-describedby="name"
                                                    name="name">
                                            </div>
                                            <div class="mb-3">
                                                <label for="name" class="form-label">No. Handphone</label>
                                                <input type="text" value="{{ $ad['phone'] }}" class="form-control" id="phone" aria-describedby="name"
                                                    name="phone">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Keluar</button>
                                            <button type="submit" class="btn btn-primary">Simpan perubahan</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- Card footer -->
                <div class="card-footer">
                    {{-- <nav aria-label="...">
                        <ul class="pagination justify-content-end mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">
                                    <i class="fas fa-angle-left"></i>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="fas fa-angle-right"></i>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav> --}}
                    <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                        <div class="col-sm-auto">
                            <div class="d-flex justify-content-center justify-content-sm-end">
                                <!-- Pagination -->
                                {!! $admin->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
