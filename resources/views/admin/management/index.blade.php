@extends('admin.layouts.main')
@section('container')
    {{-- {{ dd($admins) }} --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show alert-notification" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session()->has('failed'))
        <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
            {{ session('failed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        {!! implode(
            '',
            $errors->all(
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">:message<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
            ),
        ) !!}
    @endif
    <div class="alert-notification-wrapper" id="alert-notification-wrapper">
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Manajemen Admin</h1>
        <a class="btn btn-danger fs-14 add-merk-btn" href="{{ route('management.create') }}">
            <i class="bi bi-plus-lg"></i> Tambah Admin
        </a>
    </div>
    <div class="container p-0 mb-5">
        <div class="card admin-card-dashboard border-radius-1-5rem fs-14">
            <div class="card-body p-5 pt-4">
                <table id="admin-management"
                    class="table hover fs-14 nowrap table-borderless table-hover cell-border order-column" style="width:100%">
                    <thead>
                        <tr>
                            <th class="min-mobile">No</th>
                            <th class="min-mobile">Username</th>
                            <th class="min-mobile">Nama Depan</th>
                            <th class="min-mobile">Nama Belakang</th>
                            <th class="min-mobile">Tipe</th>
                            <th class="min-mobile">Perusahaan</th>
                            <th class="min-mobile">No Telp</th>
                            <th class="min-mobile">Email</th>
                            <th class="min-mobile">Sender Address</th>
                            <th class="not-mobile">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr class="py-5">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $admin->username }}
                                </td>
                                <td>
                                    {{ $admin->firstname }}
                                </td>
                                <td>
                                    {{ $admin->lastname }}
                                </td>
                                <td>
                                    {{ $admin->admintype->admin_type }}
                                </td>
                                <td>
                                    @if (!empty($admin->company))
                                        {{ $admin->company->name }}
                                    @endif
                                </td>
                                <td>
                                    {{ $admin->telp_no }}
                                </td>
                                <td>
                                    {{ $admin->email }}
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($admin->adminsenderaddress as $senderAddress)
                                            <li>
                                                <p class="fw-600 m-0">
                                                    {{ $senderAddress->senderaddress->name }}
                                                </p>
                                                <p class="m-0">
                                                    {{ $senderAddress->senderaddress->address }}
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <a href="{{ route('management.edit', $admin) }}"
                                        class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Edit info admin">
                                        <i class="bi bi-pen"></i>
                                    </a>
                                    <a href="{{ route('management.show', $admin) }}"
                                        class="link-dark text-decoration-none mx-1" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Detail admin">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            // $('#admin-management').DataTable({
            //     // select: true
            //     fixedHeader: true,
            // });
            $('#admin-management').DataTable({
                responsive: true,
                aLengthMenu: [
                    [10, 25, 50, 100, 200, -1],
                    [10, 25, 50, 100, 200, "All"]
                ],
                iDisplayLength: 10
            });
            // var table = $('#product').DataTable({
            //     // fixedHeader: true,
            //     responsive: true,
            //     // lengthChange: false,
            //     // buttons: ['colvis'],
            //     columnDefs: [
            //         // {
            //         //     "targets": 0, // your case first column
            //         //     "className": "text-center",
            //         //     // "width": "4%"
            //         // },
            //         //     "targets": 5,
            //         //     "className": "text-center",
            //         //     "width": "8%"
            //         // }
            //     ],
            // });

            // table.buttons().container().appendTo('#product_wrapper .col-md-6:eq(0)');

            // new $.fn.dataTable.FixedHeader( table );
        });
    </script>
@endsection
