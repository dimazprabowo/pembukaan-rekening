<div class="row" id="add">
    <div class="container container-fluid">
        <div class="d-flex justify-content-between p-3">
            <h5><b>Form Rekening</b></h5>
            <button type="button" class="close btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">
                <span inert>&times;</span>
            </button>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card rounded-0 rounded-bottom card-outline card-primary">
            <div>
                <form enctype="multipart/form-data" id="rekening_form">
                    @csrf
                    <div class="card-body form-group">
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                    placeholder="Nama Lengkap Sesuai KTP" @if (session('role') == 'supervisor') disabled @endif>
                                <br>
                                <label for="tempat_lahir">Tempat Lahir<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                    placeholder="Tempat Lahir" placeholder="Nama Lengkap"
                                    @if (session('role') == 'supervisor') disabled @endif>
                                <br>
                                <label for="tgl_lahir">Tanggal Lahir (yyyy-mm-dd) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control date-picker" id="tgl_lahir" name="tgl_lahir"
                                    placeholder="Tanggal Lahir" placeholder="Nama Lengkap"
                                    @if (session('role') == 'supervisor') disabled @endif>
                                <br>
                                <label for="jk">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jk" class="form-select" id="jk" placeholder="Nama Lengkap"
                                    @if (session('role') == 'supervisor') disabled @endif>
                                    <option value="" selected disabled>- Pilih Jenis Kelamin -</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <br>
                                <label for="pekerjaan">Pekerjaan <span class="text-danger">*</span></label>
                                <input name="pekerjaan" class="form-control" id="pekerjaan" placeholder="Pekerjaan"
                                    placeholder="Nama Lengkap" @if (session('role') == 'supervisor') disabled @endif>
                                <br>
                                <label for="nominal">Nominal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nominal" name="nominal"
                                    oninput="this.value = formatNominal(this.value)" placeholder="Nominal"
                                    @if (session('role') == 'supervisor') disabled @endif>
                                <br>
                                <div class="text-center" id="statusRek">

                                </div>
                            </div>
                        </div>

                        <div class="card-body mt-2">
                            <div class="d-flex justify-content-center">
                                <button type="button" id="button-close-modal" class="btn btn-secondary col-md-5 mx-1"
                                    data-bs-dismiss="modal">Close</button>
                                @if (session('role') == 'supervisor')
                                    <button id="approveButton" class="btn btn-primary col-md-5 mx-1">Approve</button>
                                @else
                                    <button type="submit" id="saveButton"
                                        class="btn btn-primary col-md-5 mx-1">Save</button>
                                @endif
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script')
    {{-- CHANGE FORMAT NOMINAL --}}
    <script>
        function formatNominal(value) {
            const nominalVal = value.toString().replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return `Rp ${nominalVal}`;
        }
    </script>
    {{-- END CHANGE FORMAT NOMINAL --}}

    {{-- ADD & UPDATE DATA --}}
    <script>
        const form = document.getElementById('rekening_form');
        let isUpdate = false;
        let idData = null;

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            isUpdate ? disableButtonWithLoading('Update', 'saveButton') : disableButtonWithLoading('Saving',
                'saveButton');

            const data = $(this).serializeArray();
            const formData = new FormData();
            data.forEach(item => {
                if (item.name == 'nominal') {
                    const nominal = item.value.replace(/[^0-9]/g, '');
                    formData.append('nominal', nominal);
                } else {
                    formData.append(item.name, item.value);
                }
            });

            isUpdate ? formData.append('id', idData) : ''; // tambahkan ID jika ingin mengupdate

            // Cek data dari form
            // formData.forEach((value, key) => {
            //     console.log(`${key}: ${value}`);
            // });


            $.ajax({
                type: 'POST',
                url: isUpdate ? "{{ url('rekening-update') }}" : "{{ url('rekening') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                    'HTTP_X_REQUESTED_WITH': 'XMLHttpRequest'
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {

                    $table.draw();
                    enableButton('saveButton');
                    removeErrors();
                    Swal.fire({
                        icon: data.original.status,
                        title: data.original.status.toUpperCase(),
                        text: data.original.message,
                    }).then(() => {
                        $('#formModal').modal('hide');
                    });
                },
                error: function(xhr, error, thrown) {
                    enableButton('saveButton');
                    removeErrors();
                    // Handle the error response
                    var log = JSON.parse(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: `Gagal Saat ${isUpdate ? 'Update' : 'Simpan'} Data`,
                        text: log.message,
                    });

                    for (let key in log.errors) {
                        if (log.errors.hasOwnProperty(key)) {
                            const value = log.errors[key][0];
                            // console.log(`${key}: ${value}`);
                            $('form').find(`#${key}`).addClass('is-invalid');

                            // Create and append the error message element
                            const errorElement = document.createElement('div');
                            errorElement.style.position = 'absolute';
                            errorElement.textContent = value;
                            errorElement.style.fontSize = '12px';
                            errorElement.className = 'error-message text-danger fst-italic';

                            let inputElement = document.querySelector(`#${key}`);
                            inputElement.insertAdjacentElement('afterend', errorElement);
                        }
                    }
                }

            })

        })
    </script>
    {{-- END ADD & UPDATE DATA --}}

    {{-- APPROVE REKENING --}}
    <script>
        $(document).on('click', '#approveButton', function() {
            disableButtonWithLoading('Approve', 'approveButton');
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data yang telah di approve tidak dapat diubah kembali!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('rekening-approve') }}",
                        data: {
                            id: idData
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json',
                            'HTTP_X_REQUESTED_WITH': 'XMLHttpRequest'
                        },
                        success: function(data) {

                            enableButton('approveButton');
                            removeErrors();
                            $table.draw();
                            Swal.fire({
                                icon: data.original.status,
                                title: data.original.status.toUpperCase(),
                                text: data.original.message,
                            }).then(() => {
                                $('#formModal').modal('hide');
                            })
                        },
                        error: function(xhr, error, thrown) {
                            // Handle the error response
                            var log = JSON.parse(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Approve Data',
                                text: log.message,
                            });
                        }
                    })
                } else {
                    enableButton('approveButton');
                }
            })
        });
    </script>
    {{-- END APPROVE REKENING --}}

    {{-- MANIPULATE FORM MODAL --}}
    <script>
        $(document).on('click', '.addRekening', function() {
            isUpdate = false;
            idData = null;
            resetForm();
            removeErrors();
        });

        $(document).on('click', '.editRekening', function() {
            isUpdate = true;
            resetForm();
            removeErrors();
            const id = $(this).attr('attr-id');
            idData = id;

            $.ajax({
                type: 'GET',
                url: "{{ url('rekening') }}/" + id + "/edit",
                success: function(data) {
                    $.map(data, function(elementOrValue, indexOrKey) {
                        $(`#${indexOrKey}`).val(elementOrValue);

                        if (indexOrKey == 'status') {
                            const statusType = elementOrValue == 'approved' ? 'success' :
                                'warning';
                            $(`#statusRek`).html(
                                `<div class="border p-3 rounded w-25 text-center mx-auto border-${statusType}">${elementOrValue}</div>`
                            );
                        }

                        if (indexOrKey == 'nominal') {
                            $(`#nominal`).val(formatNominal(elementOrValue));
                        }
                    });
                }
            })
        });
    </script>
    {{-- END MANIPULATE FORM MODAL --}}

    {{-- MANIPULATE BUTTON & FORM --}}
    <script>
        function disableButtonWithLoading(text, id) {
            $(`#${id}`).prop('disabled', true);
            $(`#${id}`).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            ${text}...
          `);
        }

        function enableButton(id) {
            $(`#${id}`).prop('disabled', false);
            id == 'approveButton' ? $(`#${id}`).text('Approve') : $(`#${id}`).text('Save');
        }


        function resetForm() {
            document.getElementById('rekening_form').reset();
            $('#statusRek').html("");

        }

        function removeErrors() {
            $('.error-message').remove();
            $('.form-control, .form-select').removeClass('is-invalid');
        }
    </script>
    {{-- END MANIPULATE BUTTON & FORM --}}

    {{-- DATEPICKER --}}
    <script>
        $('.date-picker').datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            showButtonPanel: true,
            showTodayButton: true
        }).on('changeDate', function(e) {
            console.log('Date changed:', e.date);
        });
    </script>
    {{-- END DATEPICKER --}}
@endpush
