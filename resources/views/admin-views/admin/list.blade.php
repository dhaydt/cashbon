@extends('layouts.backend.app')
@section('title', 'Admin List')
@section('content')
@include('admin-views.admin._headerPage')
<style>
    .sort {
        text-align: center;
    }
</style>
<div class="container-fluid mt--8">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                {{-- <div class="card-header border-0">
                    <h3 class="mb-0">Admin table</h3>
                </div> --}}
                <!-- Light table -->
                {{-- {{ var_dump($admin) }} --}}
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">No</th>
                                <th scope="col" class="sort" data-sort="budget">Name</th>
                                <th scope="col" class="sort" data-sort="status">Phone</th>
                                <th scope="col" class="sort" data-sort="status">Role</th>
                                <th scope="col" class="sort" data-sort="completion">Action</th>
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
                                    <span class="capitalize">
                                        {{ $ad['name'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="status">{{ $ad['phone'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success">
                                        <span class="capitalize text-success">{{ $ad['role'] }}</span>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-evenly">
                                        {{-- <a href="{{ route('admin.userCustomerView', ['id' => $ad['id']]) }}"
                                            class="viewUser">
                                            <i class="far fa-eye"></i>
                                        </a> --}}
                                        <a type="button" class="viewUser" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $ad['id'] }}">
                                            <i class="fas fa-edit text-info"></i>
                                        </a>
                                        <a href="{{ route('admin.deleteAdmin', ['id' => $ad['id']]) }}"
                                            class="viewUser">
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
                                    <form action="{{ route('admin.updateAdmin', ['id' => $ad['id']]) }}"
                                        method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $ad['id'] }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEdit{{ $ad['id'] }}Label">Ubah Admin {{
                                                    $ad['name'] }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama</label>
                                                    <input type="text" value="{{ $ad['name'] }}" class="form-control"
                                                        id="name" aria-describedby="name" name="name">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">No. Handphone</label>
                                                    <input type="text" value="{{ $ad['phone'] }}" class="form-control"
                                                        id="phone" aria-describedby="name" name="phone">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Role</label>
                                                    <select name="role" class="form-control">
                                                        <option value="admin" {{ $ad['role'] == 'admin'? 'selected' : '' }}>Admin</option>
                                                        <option value="staff" {{ $ad['role'] == 'staff'? 'selected' : '' }}>Staff</option>
                                                    </select>
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
