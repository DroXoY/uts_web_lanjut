<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Karyawan</title>
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
                        <a class="nav-link active fw-bold" href="{{ url('/karyawan') }}">Menu Karyawan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/supplier') }}">Menu Supplier</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-3 mb-5">
        <h2>Data Karyawan</h2>

        <a href="{{ url('/karyawan/create') }}" class="btn btn-primary mb-3">
            Tambah Karyawan
        </a>

        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablekaryawan">
                <thead class="table-primary">
                    <tr>
                        <th style="width: 170px;">Action</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telp</th>
                        <th>Tanggal Lahir</th>
                        <th>Pendidikan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawan as $x)
                    <tr>
                        <td>
                            <a href="{{ url('/karyawan/' . $x->kode . '/edit') }}" class="btn btn-warning btn-sm me-1">
                                Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapusData('{{ $x->kode }}')">
                                Hapus
                            </button>
                        </td>
                        <td>{{ $x->kode }}</td>
                        <td>{{ $x->nama }}</td>
                        <td>{{ $x->alamat }}</td>
                        <td>{{ $x->telp }}</td>
                        <td>{{ date('d-m-Y', strtotime($x->tanggal_lahir)) }}</td>
                        <td>{{ $x->pendidikan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data karyawan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // DELETE: Hapus Data via type: 'DELETE' dengan URL bersih TANPA + kode
        function hapusData(kode) {
            if (!confirm('Yakin ingin menghapus data dengan kode ' + kode + '?')) {
                return;
            }

            var formData = new FormData();
            formData.append('kode', kode); // 1. Masukkan kode ke dalam formData

            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            formData.append('_token', csrfToken);

            $.ajax({
                type: 'DELETE',
                url: "{{ url('/karyawan') }}", // 2. URL bersih TANPA + kode (Sesuai Hal 13 PDF)
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Sukses:', response);
                    alert(response.message || 'Data berhasil dihapus!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Gagal:', error);
                    let errMessage = 'Terjadi kesalahan!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMessage = xhr.responseJSON.message;
                    }
                    alert(errMessage);
                }
            });
        }
    </script>
</body>
</html>
