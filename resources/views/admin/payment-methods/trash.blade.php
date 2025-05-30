@extends('admin.master')

@section('title', 'Thùng Rác Phương Thức Thanh Toán')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper p-4">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 rounded shadow-sm">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-3">Thùng Rác Phương Thức Thanh Toán</div>
                    <a href="{{ route('payment-methods.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Tên</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày xóa</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paymentMethods as $index => $paymentMethod)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $paymentMethod->name }}</td>
                                        <td>{{ $paymentMethod->description ?? 'Không có mô tả' }}</td>
                                        <td>
                                            <span
                                                class="badge
                                                {{ $paymentMethod->status === 'active' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst($paymentMethod->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $paymentMethod->deleted_at ? $paymentMethod->deleted_at->format('d-m-Y') : 'Chưa xóa' }}
                                        </td>
                                        <td>
                                            <form action="{{ route('payment-methods.restore', $paymentMethod->id) }}"
                                                method="POST" style="display:inline;" class="restore-form">
                                                @csrf
                                                <button type="submit" class="restore-btn"
                                                    style="background: none; border: none; padding: 0; margin-right: 15px;"
                                                    title="Khôi phục">
                                                    <i class="bi bi-arrow-repeat text-success"
                                                        style="font-size: 1.8em;"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('payment-methods.forceDelete', $paymentMethod->id) }}"
                                                method="POST" style="display:inline;" class="force-delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="force-delete-btn"
                                                    style="background: none; border: none; padding: 0;" title="Xóa cứng">
                                                    <i class="bi bi-trash text-danger" style="font-size: 1.8em;"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có phương thức thanh toán nào trong
                                            thùng rác.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        document.querySelectorAll('.force-delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.force-delete-form');
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc chắn muốn xóa cứng không?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    toast: true,
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timerProgressBar: true,
                    timer: 3500
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        document.querySelectorAll('.restore-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.restore-form');
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc muốn khôi phục lại phương thức thanh toán?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    toast: true,
                    cancelButtonText: 'Hủy',
                    timerProgressBar: true,
                    timer: 3500
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    @if (session()->has('restorePaymentMethod'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "Khôi phục phương thức thanh toán thành công",
                showConfirmButton: false,
                toast: true,
                timerProgressBar: true,
                timer: 3500
            });
        </script>
    @endif

    @if (session()->has('forceDeletePaymentMethod'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                toast: true,
                title: "Xóa cứng phương thức thanh toán thành công",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Swal.fire({
                position: "top",
                icon: "error",
                toast: true,
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        </script>
    @endif
@endsection
