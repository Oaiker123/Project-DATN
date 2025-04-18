@extends('admin.master')

@section('title', 'Danh Sách Danh Mục')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh Sách Danh Mục</div>
                            <div>
                                <a href="{{ route('categories.create') }}"
                                    class="btn btn-primary btn-rounded d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a>
                                <a href="{{ route('categories.trash') }}"
                                    class="btn btn-primary btn-rounded d-flex align-items-center mt-3">
                                    <i class="bi bi-trash me-2"></i> Thùng Rác
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="GET" action="{{ route('categories.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="search" name="search" class="form-control form-control-sm" placeholder="Tìm kiếm danh mục" value="{{ request()->search }}">
                                    </div>
                                    <div class="col-auto">
                                        <input type="date" name="created_at" class="form-control form-control-sm" value="{{ request()->created_at }}">
                                    </div>
                                    <div class="col-auto">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="">Tất cả trạng thái</option>
                                            <option value="active" {{ request()->status === 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                            <option value="inactive" {{ request()->status === 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                    </div>
                                    <div class="col-auto">
                                        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-secondary">Xóa lọc</a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table v-middle m-0">
                                    <thead>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Tên</th>
                                            <th>Danh mục cha</th>
                                            <th>Mô tả</th>
                                            <th>Trạng thái</th>
                                            {{-- <th>Hình ảnh</th> --}}
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $index => $category)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $category->name }}</td>
                                                {{-- <td>{{ $category->description }}</td> --}}
                                                <td>{{ $category->parent ? $category->parent->name : 'None' }}</td>
                                                <td>{{ $category->description }}</td>
                                                <td>
                                                    @if ($category->status === 'active')
                                                        <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                                    @elseif ($category->status === 'inactive')
                                                        <span class="badge rounded-pill bg-secondary">Không kích hoạt</span>
                                                    @endif
                                                </td>

                                                <td>{{ $category->created_at ? $category->created_at->format('d-m-Y') : 'Chưa có' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('categories.edit', $category) }}" class="editRow"
                                                        title="Sửa" style="margin-right: 15px;">
                                                        <i class="bi bi-pencil-square text-warning"
                                                            style="font-size: 1.8em;"></i>
                                                    </a>

                                                    <form action="{{ route('categories.destroy', $category) }}"
                                                        method="POST" style="display:inline;" class="delete-form"
                                                        onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này không?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="delete-btn"
                                                            style="background: none; border: none; padding: 0;"
                                                            title="Xóa">
                                                            <i class="bi bi-trash text-danger"
                                                                style="font-size: 1.8em;"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Không có danh mục nào được tìm thấy.
                                                </td> <!-- Cập nhật số cột -->
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $categories->links() }}
                            </div>
                        </div>
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
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.delete-form');
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc chắn muốn xóa danh mục này?',
                    icon: 'warning',
                    showCancelButton: true,
                    toast: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timer: 3500,
                    timerProgressBar: true,
                }).then((result) => {
                    // Kiểm tra nếu không nhấn vào nút "Hủy" và timer đã hết
                    if (result.isConfirmed) {
                        form.submit();
                    } else if (result.dismiss === Swal.DismissReason.timer) {
                        // Thông báo tự động đóng
                        Swal.fire('Đã hủy', 'Hành động đã bị hủy.', 'info');
                    }
                });
            });
        });
    </script>

    @if (session()->has('deleteCategory'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                toast: true,
                title: "{{ session('deleteCategory') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        </script>
    @endif

    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                toast: true,
                title: "{{ session('success') }}",
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
