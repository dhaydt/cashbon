@extends('layouts.backend.app')
@section('title', 'Admin List')
@section('content')
@include('admin-views.admin._headerPage')
<style>
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
                <!-- Card header -->
                {{-- <div class="card-header border-0">
                    <h3 class="mb-0">Admin table</h3>
                </div> --}}
                <!-- Light table -->
                {{-- {{ var_dump($admin) }} --}}
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" >
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">ID</th>
                                <th scope="col" class="sort" data-sort="budget">Name</th>
                                <th scope="col" class="sort" data-sort="status">Email</th>
                                <th scope="col" class="sort" data-sort="status">Phone</th>
                                <th scope="col">Profile Image</th>
                                <th scope="col" class="sort" data-sort="completion">Action</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($admin as $ad)
                            <tr>
                                <th scope="row">
                                    <div class="media align-items-center">
                                        {{-- <a href="#" class="avatar rounded-circle mr-3">
                                            <img alt="Image placeholder" src="../assets/img/theme/bootstrap.jpg">
                                        </a> --}}
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{ $ad['id'] }}</span>
                                        </div>
                                    </div>
                                </th>
                                <td class="budget">
                                    {{ $ad['name'] }}
                                </td>
                                <td>
                                    <span class="badge badge-dot mr-4">
                                        {{-- <i class="bg-warning"></i> --}}
                                        <span class="status">{{ $ad['email'] }}</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-dot mr-4">
                                        {{-- <i class="bg-warning"></i> --}}
                                        <span class="status">{{ $ad['phone'] }}</span>
                                    </span>
                                </td>
                                <td>
                                    <div class="avatar-group">
                                        <a href="javascript:" class="avatar avatar-sm rounded-circle" data-toggle="tooltip"
                                            data-original-title="Ryan Tompson">
                                            <img alt="Image placeholder" src="{{ asset('storage/profile/'.$ad['image']) }}">
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="completion mr-2">60%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                    style="width: 60%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
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
