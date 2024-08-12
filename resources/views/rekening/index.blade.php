@extends('layouts.main')
@section('title', 'Rekening')
@section('rekening', 'active text-white')

@section('content')
    <div class="container container-fluid">
        <table class="table" id="tableRekening">
            <thead>
                @if (session('role') != 'supervisor')
                    <div class="d-flex justify-content-end mt-3">
                        <button data-bs-target="#formModal" data-bs-toggle="modal" class="btn btn-primary addRekening">Add
                            Rekening</button>
                    </div>
                @endif
                <div class="text-center w-25 mx-auto my-3 d-flex align-items-center">
                    <label for="status_data" class="form-label m-0">Status:&nbsp;</label>
                    <select class="form-select" name="status_data" id="status_data">
                        <option value="">All</option>
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <tr>
                    <th class="text-center align-middle" scope="col">No</th>
                    <th class="text-center align-middle" scope="col">Nama</th>
                    <th class="text-center align-middle" scope="col">Tempat Lahir</th>
                    <th class="text-center align-middle" scope="col">Tgl Lahir</th>
                    <th class="text-center align-middle" scope="col">JK</th>
                    <th class="text-center align-middle" scope="col">Pekerjaan</th>
                    <th class="text-center align-middle" scope="col">Nominal</th>
                    <th class="text-center align-middle" scope="col">Updated At</th>
                    <th class="text-center align-middle" scope="col">Status</th>
                    <th class="text-center align-middle" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    {{-- FORM MODAL --}}
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-light">
                @include('rekening.form')
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $table = $('#tableRekening').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [7, 'desc']
            ],
            ajax: {
                url: "{{ route('data-rekening') }}",
                type: 'GET',
                data: function(d) {
                    // Tambahan data lain yang ingin Anda kirim ke server
                    d.status = $('#status_data').val();
                },
                dataSrc: function(response) {
                    console.log(response);
                    response.recordsTotal = response.total;
                    response.recordsFiltered = response.total;

                    return response.data;
                },
                error: function(xhr, error, thrown) {
                    // window.location.reload();
                }
            },
            columns: [{
                    data: 'id',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nama_lengkap',
                    render: function(data, type, row, meta) {
                        return data;
                    }
                },
                {
                    data: 'tempat_lahir',
                    render: function(data, type, row, meta) {
                        return data;
                    }
                },
                {
                    data: 'tgl_lahir',
                    render: function(data, type, row, meta) {
                        return data;
                    }
                },
                {
                    data: 'jk',
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return data;
                    }
                },
                {
                    data: 'pekerjaan',
                    render: function(data, type, row, meta) {
                        return data;
                    }
                },
                {
                    data: 'nominal',
                    render: function(data, type, row, meta) {
                        return formatNominal(data);
                    }
                },
                {
                    data: 'updated_at',
                    render: function(data, type, row, meta) {
                        const updatedAt = data.split('T');
                        return updatedAt[0];
                    }
                },
                {
                    data: 'status',
                    render: function(data, type, row, meta) {
                        if (data == 'approved') {
                            return '<span class="badge bg-success">Approved</span>';
                        } else {
                            return '<span class="badge bg-warning">Pending</span>';
                        }
                    }
                },
                {
                    data: 'id',
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        // console.log(row, "{{ session('role') }}");
                        const role = "{{ session('role') }}";
                        let button =
                            `<a attr-id="${data}" data-bs-toggle="modal" data-bs-target="#formModal" class="mx-1 btn btn-sm btn-primary editRekening">${role == 'supervisor' ? 'Detail' : 'Edit'}</a>`;

                        return button;
                    }
                },
            ]
        })

        $('#status_data').on('change', function() {
            $table.draw();
        });
    </script>
@endpush
