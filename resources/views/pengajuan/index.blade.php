@extends('layouts.master')
@section('title', 'Pengajuan')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0" style="border-radius: 0.5rem 0.5rem 0 0;">
                    <h3 class="mb-0" style="color: #1976d2; font-weight: 600;">Daftar Pengajuan</h3>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="mb-4 bg-light p-3 rounded">
                        <form action="{{ route('pengajuan.filter') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="disetujui">Disetujui</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jenis Pengajuan</label>
                                <select name="jenis_pengajuan" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    <option value="izin">Izin</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="cuti">Cuti</option>
                                    <option value="pulang_cepat">Pulang Cepat</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('pengajuan.export') }}" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Table Section -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Satpam</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuans as $index => $pengajuan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pengajuan->datasatpam->nama }}</td>
                                    <td>
                                        <span class="badge bg-info text-white" style="font-size: 14px;">{{ ucfirst($pengajuan->jenis_pengajuan) }}</span>
                                    </td>
                                    <td>
                                        {{ date('d/m/Y', strtotime($pengajuan->tanggal_mulai)) }} s/d {{ date('d/m/Y', strtotime($pengajuan->tanggal_selesai)) }}
                                    </td>
                                    <td>
                                        @if($pengajuan->status == 'pending')
                                            <span class="badge bg-warning text-dark" style="font-size: 14px;">Pending</span>
                                        @elseif($pengajuan->status == 'disetujui')
                                            <span class="badge bg-success" style="font-size: 14px;">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger" style="font-size: 14px;">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pengajuan.show', $pengajuan->id) }}" class="btn btn-info btn-sm me-1" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($pengajuan->status == 'pending')
                                            <button type="button" class="btn btn-success btn-sm me-1" onclick="showApprovalModal({{ $pengajuan->id }}, 'disetujui')" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm me-1" onclick="showApprovalModal({{ $pengajuan->id }}, 'ditolak')" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            @endif
                                            <form action="{{ route('pengajuan.destroy', $pengajuan->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data pengajuan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approval -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="approvalForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalModalLabel">Update Status Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea name="catatan_admin" class="form-control" required></textarea>
                    </div>
                    <input type="hidden" name="status" id="statusInput">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showApprovalModal(id, status) {
    const modal = new bootstrap.Modal(document.getElementById('approvalModal'));
    const form = document.getElementById('approvalForm');
    const statusInput = document.getElementById('statusInput');
    form.action = `/pengajuan/${id}/status`;
    statusInput.value = status;
    modal.show();
}
</script>
@endpush

@endsection 