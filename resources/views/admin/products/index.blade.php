@extends('admin.master')

@section('title', 'Danh sách sản phẩm')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh Sách Sản Phẩm</div>
                            <div>
                                <a href="{{ route('products.create') }}"
                                    class="btn btn-primary btn-sm btn-rounded d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="card-body">
                        
                            <!-- Form tìm kiếm sản phẩm -->
                            <form method="GET" action="{{ route('products.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <!-- Tìm kiếm theo tên sản phẩm -->
                                    <div class="col-auto">
                                        <input type="text" name="search" class="form-control form-control-sm"
                                            placeholder="Tìm kiếm sản phẩm" value="{{ request()->search }}">
                                    </div>
                                    <!-- Lọc theo trạng thái kích hoạt -->
                                    <div class="col-auto">
                                        <select name="is_active" class="form-select form-select-sm">
                                            <option value="">Trạng thái kích hoạt</option>
                                            <option value="1" {{ request()->is_active === '1' ? 'selected' : '' }}>Kích
                                                hoạt</option>
                                            <option value="0" {{ request()->is_active === '0' ? 'selected' : '' }}>
                                                Không kích hoạt</option>
                                        </select>
                                    </div>
                                    <!-- Lọc theo sản phẩm nổi bật -->
                                    <div class="col-auto">
                                        <select name="is_featured" class="form-select form-select-sm">
                                            <option value="">Sản phẩm nổi bật</option>
                                            <option value="1" {{ request()->is_featured === '1' ? 'selected' : '' }}>
                                                Nổi bật</option>
                                            <option value="0" {{ request()->is_featured === '0' ? 'selected' : '' }}>
                                                Không nổi bật</option>
                                        </select>
                                    </div>
                                    <!-- Lọc theo tình trạng sản phẩm -->
                                    <div class="col-auto">
                                        <select name="condition" class="form-select form-select-sm">
                                            <option value="">Tình trạng</option>
                                            <option value="new" {{ request()->condition === 'new' ? 'selected' : '' }}>
                                                Mới</option>
                                            <option value="used" {{ request()->condition === 'used' ? 'selected' : '' }}>
                                                Đã qua sử dụng</option>
                                            <option value="refurbished"
                                                {{ request()->condition === 'refurbished' ? 'selected' : '' }}>Tái chế
                                            </option>
                                        </select>
                                    </div>
                                    <!-- Lọc theo ngày tạo -->
                                    <div class="col-auto">
                                        <input type="date" name="created_at" class="form-control form-control-sm"
                                            value="{{ request()->created_at }}">
                                    </div>
                                    <!-- Nút tìm kiếm và reset -->
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <!-- Bảng danh sách sản phẩm -->
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Thương hiệu</th>
                                        <th>Danh mục</th>
                                        <th>Giá</th>
                                        <th>Số Lượng</th>
                                        <th>Lượt xem</th>
                                        <th>Trạng thái</th>
                                        <th>Nổi bật</th>
                                        <th>Tình trạng</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $index => $product)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if ($product->image_url && \Storage::exists($product->image_url))
                                                    <img src="{{ \Storage::url($product->image_url) }}"
                                                        alt="{{ $product->name }}" style="max-width: 100px; height: auto;">
                                                @else
                                                    Không có ảnh
                                                @endif
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->brand ? $product->brand->name : 'Không có' }}</td>
                                            <td>{{ $product->catalogue ? $product->catalogue->name : 'Không có' }}</td>
                                            <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>{{ $product->views }}</td>
                                            <td>
                                                @if ($product->is_active)
                                                    <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">Không kích hoạt</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($product->is_featured)
                                                    <span class="badge rounded-pill bg-warning">Nổi bật</span>
                                                @else
                                                    <span class="badge rounded-pill bg-secondary">Không nổi bật</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($product->condition == 'new')
                                                    <span class="badge rounded-pill bg-success">Mới</span>
                                                @elseif ($product->condition == 'used')
                                                    <span class="badge rounded-pill bg-warning">Đã qua sử dụng</span>
                                                @elseif ($product->condition == 'refurbished')
                                                    <span class="badge rounded-pill bg-info">Tái chế</span>
                                                @else
                                                    <span class="badge rounded-pill bg-secondary">Không xác định</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}" class="editRow"
                                                    title="Sửa" style="margin-right: 10px;">
                                                    <i class="bi bi-pencil-square text-warning"
                                                        style="font-size: 1.8em;"></i>
                                                </a>
                                                <a href="{{ route('products.show', $product->id) }}" class="editRow"
                                                    title="Chi tiết" style="margin-right: 10px;">
                                                    <i class="bi bi-info-circle text-info" style="font-size: 1.8em;"></i>
                                                </a>

                                                @php
                                                    $hasVariants = $product->variants->isNotEmpty();
                                                @endphp

                                                @if ($hasVariants)
                                                    <a href="{{ route('products.variants.index', $product->id) }}"
                                                        class="editRow" title="Quản lý Biến Thể"
                                                        style="margin-right: 10px;">
                                                        <i class="bi bi-gear text-success" style="font-size: 1.8em;"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('products.variants.create', $product->id) }}"
                                                        class="editRow" title="Thêm Biến Thể">
                                                        <i class="bi bi-plus-circle text-primary"
                                                            style="font-size: 1.8em;"></i>
                                                    </a>
                                                @endif
                                            </td>

                                            <style>
                                                .action-btn {
                                                    display: flex;
                                                    /* Sử dụng flexbox để căn chỉnh nội dung */
                                                    align-items: center;
                                                    /* Căn giữa nội dung theo chiều dọc */
                                                    justify-content: center;
                                                    /* Căn giữa nội dung theo chiều ngang */
                                                    width: 150px;
                                                    /* Đặt chiều rộng cố định */
                                                    height: 40px;
                                                    /* Đặt chiều cao cố định */
                                                    overflow: hidden;
                                                    /* Ẩn phần nội dung thừa */
                                                    white-space: nowrap;
                                                    /* Không cho chữ xuống dòng */
                                                }

                                                .action-btn .btn-text {
                                                    margin-left: 5px;
                                                    /* Khoảng cách giữa biểu tượng và chữ */
                                                }

                                                @media (max-width: 768px) {
                                                    .action-btn {
                                                        width: 100px;
                                                        /* Điều chỉnh kích thước cho màn hình nhỏ hơn */
                                                        height: 35px;
                                                    }
                                                }
                                            </style>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11">Không có Sản Phẩm nào được tìm thấy.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <div class="mt-3">
                                    {{ $products->links() }}
                                </div>
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
                const formId = `delete-form-${this.dataset.id}`;
                const form = document.getElementById(formId);
                Swal.fire({
                    position: 'top',
                    title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    toast: true,
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timer: 3500
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Gửi form để xóa sản phẩm
                    }
                });
            });
        });

        @if (session('success'))
            Swal.fire({
                position: "top",
                icon: "success",
                toast: true,
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3500
            });
        @endif
    </script>
@endsection
