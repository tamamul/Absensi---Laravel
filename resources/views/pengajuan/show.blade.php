@extends('layouts.master')
@section('title', 'Detail Pengajuan')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center border-0" style="border-radius: 0.5rem 0.5rem 0 0;">
                    <h3 class="mb-0" style="color: #1976d2; font-weight: 600;">Detail Pengajuan</h3>
                    <a href="{{ route('pengajuan.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-secondary mb-2">Informasi Satpam</h6>
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td width="130">Nama</td>
                                        <td>: {{ $pengajuan->datasatpam->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>NIP</td>
                                        <td>: {{ $pengajuan->datasatpam->nip }}</td>
                                    </tr>
                                    <tr>
                                        <td>Lokasi Kerja</td>
                                        <td>: {{ $pengajuan->datasatpam->lokasikerja->nama_lokasikerja }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-secondary mb-2">Detail Pengajuan</h6>
                                <table class="table table-borderless table-sm mb-0">
                                    <tr>
                                        <td width="130">Jenis</td>
                                        <td>
                                            <span class="badge bg-info text-white" style="font-size: 14px;">{{ ucfirst($pengajuan->jenis_pengajuan) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tgl Pengajuan</td>
                                        <td>: {{ date('d/m/Y H:i', strtotime($pengajuan->tanggal_pengajuan)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            @if($pengajuan->status == 'pending')
                                                <span class="badge bg-warning text-dark" style="font-size: 14px;">Pending</span>
                                            @elseif($pengajuan->status == 'disetujui')
                                                <span class="badge bg-success" style="font-size: 14px;">Disetujui</span>
                                            @else
                                                <span class="badge bg-danger" style="font-size: 14px;">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-secondary mb-2">Periode</h6>
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td width="130">Tanggal Mulai</td>
                                    <td>: {{ date('d/m/Y', strtotime($pengajuan->tanggal_mulai)) }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Selesai</td>
                                    <td>: {{ date('d/m/Y', strtotime($pengajuan->tanggal_selesai)) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-secondary mb-2">Alasan</h6>
                            <div class="bg-light rounded p-2">{{ $pengajuan->alasan }}</div>
                        </div>
                    </div>

                    @if($pengajuan->bukti_foto)
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="text-secondary mb-2">Bukti Pendukung</h6>
                            <div class="text-center">
                                <img src="{{ $pengajuan->bukti_foto }}" class="img-fluid rounded shadow-sm" style="max-height: 250px" alt="Bukti">
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($pengajuan->status != 'pending')
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="alert {{ $pengajuan->status == 'disetujui' ? 'alert-success' : 'alert-danger' }}">
                                <h6 class="mb-1">Catatan Admin:</h6>
                                <p class="mb-0">{{ $pengajuan->catatan_admin }}</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row mb-2">
                        <div class="col-md-12 text-center">
                            <button type="button" class="btn btn-success me-2" onclick="showApprovalModal({{ $pengajuan->id }}, 'disetujui')">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                            <button type="button" class="btn btn-danger" onclick="showApprovalModal({{ $pengajuan->id }}, 'ditolak')">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approval -->
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="approvalForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Update Status Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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