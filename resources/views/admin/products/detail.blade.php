@extends('admin.master')

@section('title', 'Chi tiết sản phẩm')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Chi tiết sản phẩm</div>
                            {{-- <a href="{{ route('products.edit', $product->id) }}" class="btn btn-rounded btn-warning">Chỉnh sửa</a> --}}
                            <a href="{{ route('products.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Trở về
                            </a>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Tên sản phẩm -->
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm</label>
                                    <p class="form-control">{{ $product->name }}</p>

                                </div>

                                <!-- Thương hiệu -->
                                <div class="form-group">
                                    <label for="brand_id">Thương hiệu</label>
                                    <p class="form-control">{{ $product->brand ? $product->brand->name : 'Không có' }}</p>
                                </div>

                                <!-- Danh mục -->
                                <div class="form-group">
                                    <label for="catalogue_id">Danh mục</label>
                                    <p class="form-control">
                                        {{ $product->catalogue ? $product->catalogue->name : 'Không có' }}
                                    </p>
                                </div>

                                <!-- Hình ảnh sản phẩm -->
                                <div class="form-group">
                                    <label for="image_url">Hình ảnh</label>
                                    <br>
                                    @if ($product->image_url && \Storage::exists($product->image_url))
                                        <img src="{{ \Storage::url($product->image_url) }}" alt="{{ $product->name }}"
                                            style="max-width: 100px; height: auto;">
                                    @else
                                        <p>Không có ảnh</p>
                                    @endif
                                </div>

                                <label for="image_url">Gallery</label>
                                <br>
                                <div class="image-gallery d-flex flex-wrap">
                                    @foreach ($product->galleries as $gallery)
                                        <div class="image-item me-2 mb-2">
                                            <img src="{{ Storage::url($gallery->image_url) }}" alt="Hình ảnh"
                                                class="img-thumbnail" style="width: 100px;">
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Trạng thái hoạt động -->
                                <div class="form-group">
                                    <label for="is_active">Trạng thái hoạt động</label>
                                    <p class="form-control">{{ $product->is_active ? 'Hoạt động' : 'Không hoạt động' }}</p>
                                </div>

                                <!-- Giá sản phẩm -->
                                <div class="form-group">
                                    <label for="price">Giá sản phẩm</label>
                                    <p class="form-control">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                                </div>

                                <!-- Giá khuyến mãi -->
                                @if ($product->discount_price)
                                    <div class="form-group">
                                        <label for="discount_price">Giá khuyến mãi</label>
                                        <p class="form-control">
                                            {{ number_format($product->discount_price, 0, ',', '.') }}đ</p>
                                    </div>
                                @endif

                                <!-- Slug -->
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <p class="form-control">{{ $product->slug }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- SKU -->
                                <div class="form-group">
                                    <label for="sku">SKU (Mã sản phẩm)</label>
                                    <p class="form-control">{{ $product->sku }}</p>
                                </div>

                                <div class="mb-3">
                                    <label for="stock" class="form-label">Số Lượng</label>
                                    <p class="form-control">{{ $product->stock }}</p>
                                </div>

                                <div class="mb-3">
                                    <label for="is_featured" class="form-label">Nổi bật</label>
                                    <input type="checkbox" id="is_featured" name="is_featured"
                                        {{ $product->is_featured ? 'checked' : '' }} disabled>
                                    <small class="form-text text-muted">Sản phẩm này
                                        {{ $product->is_featured ? 'được' : 'không được' }} đánh dấu là nổi bật.</small>
                                </div>

                                <div class="mb-3">
                                    <label for="condition" class="form-label">Tình trạng</label>
                                    <select class="form-select" id="condition" name="condition" disabled>
                                        <option value="new" {{ $product->condition == 'new' ? 'selected' : '' }}>Mới
                                        </option>
                                        <option value="used" {{ $product->condition == 'used' ? 'selected' : '' }}>Đã qua
                                            sử
                                            dụng</option>
                                        <option value="refurbished"
                                            {{ $product->condition == 'refurbished' ? 'selected' : '' }}>Tái chế</option>
                                    </select>
                                </div>

                                <!-- Tóm tắt sản phẩm -->
                                <div class="form-group mb-3">
                                    <label for="tomtat">Tóm tắt</label>
                                    <p>{!! $product->tomtat !!}</p>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tomtat">Lượt xem</label>
                                    <p>Lượt xem: {{ $product->views }}</p>
                                </div>

                                <!-- Mô tả sản phẩm -->
                                <div class="form-group mb-4">
                                    <label for="description">Mô tả sản phẩm</label>

                                    <!-- Modal Dark -->
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#modalFullScreen">
                                        Xem Ngay
                                    </button>

                                    <!-- Modal Fade -->
                                    <div class="modal fade" id="modalFullScreen" tabindex="-1"
                                        aria-labelledby="modalFullScreenLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-fullscreen">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalFullScreenLabel">Mô Tả Sản Phẩm</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body mx-auto">
                                                    {!! $product->description !!}
                                                </div>

                                                <style>
                                                    .modal-body img {
                                                        max-width: 70%;
                                                        height: auto;
                                                        display: block;
                                                        margin: 0 auto;
                                                    }
                                                </style>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-dark"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Thông số k�� thuật -->
                                <div class="form-group mb-4">
                                    <label for="specifications">Thông số kĩ thuật</label>

                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#modalDark">
                                        Xem Ngay
                                    </button>

                                    <!-- Modal Fade -->
                                    <div class="modal fade" id="modalDark" tabindex="-1"
                                        aria-labelledby="modalDarkLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalDarkLabel">Thông số kĩ thuật</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {!! $product->specifications !!}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-dark"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
