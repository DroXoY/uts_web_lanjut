<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Supplier</title>
    <!-- Offline CSS & JS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/karyawan') }}">UTS Web Lanjut</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/karyawan') }}">Menu Karyawan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="{{ url('/supplier') }}">Menu Supplier</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0 text-primary fw-bold">Tambah Data Supplier</h4>
                    </div>
                    <div class="card-body p-4">
                        <div id="alertContainer"></div>

                        <form id="formTambah">
                            <div class="mb-3">
                                <label for="kode" class="form-label fw-bold">Kode Supplier</label>
                                <input type="text" class="form-control" id="kode" name="kode" maxlength="5" placeholder="Contoh: S001" required>
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-label fw-bold">Nama Supplier</label>
                                <input type="text" class="form-control" id="nama" name="nama" maxlength="50" placeholder="Masukkan nama supplier" required>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label fw-bold">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" maxlength="100" placeholder="Masukkan alamat lengkap" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="telp" class="form-label fw-bold">No. Telepon</label>
                                <input type="text" class="form-control" id="telp" name="telp" maxlength="15" placeholder="Contoh: 08123456789" required>
                            </div>

                            <div class="mb-3">
                                <label for="perusahaan" class="form-label fw-bold">Perusahaan</label>
                                <input type="text" class="form-control" id="perusahaan" name="perusahaan" maxlength="50" placeholder="Contoh: PT Sumber Makmur" required>
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" maxlength="100" placeholder="Contoh: Distributor Bahan Baku" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ url('/supplier') }}" class="btn btn-secondary">Kembali</a>
                                <button type="button" class="btn btn-primary px-4" id="btnSimpan">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // CREATE: Simpan Data Baru via FormData & AJAX
        $('#btnSimpan').on("click", function() {
            var formData = new FormData();
            let kode = $("#kode").val();
            let nama = $("#nama").val();
            let alamat = $("#alamat").val();
            let telp = $("#telp").val();
            let perusahaan = $("#perusahaan").val();
            let keterangan = $("#keterangan").val();

            formData.append('kode', kode);
            formData.append('nama', nama);
            formData.append('alamat', alamat);
            formData.append('telp', telp);
            formData.append('perusahaan', perusahaan);
            formData.append('keterangan', keterangan);

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            formData.append('_token', csrfToken);

            $.ajax({
                type: 'POST',
                url: "{{ url('/supplier') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log('Sukses:', response);
                    alert(response.message || 'Data berhasil dikirim!');
                    window.location.href = "{{ url('/supplier') }}";
                },
                error: function (xhr, status, error) {
                    console.error('Gagal:', error);
                    let errHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, val) {
                            errHtml += '<li>' + val[0] + '</li>';
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errHtml += '<li>' + xhr.responseJSON.message + '</li>';
                    } else {
                        errHtml += '<li>Terjadi kesalahan pada server.</li>';
                    }
                    errHtml += '</ul></div>';
                    $('#alertContainer').html(errHtml);
                }
            });
        });
    </script>
</body>
</html>
