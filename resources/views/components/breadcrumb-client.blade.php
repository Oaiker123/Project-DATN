@php
    $currentRoute = request()->route()->getName();
    $breadcrumbs = [['name' => 'Trang Chủ', 'url' => route('client.index')]];

    switch ($currentRoute) {
        case 'client.products.index':
            $breadcrumbs[] = ['name' => 'Sản Phẩm', 'url' => ''];
            break;

        case 'client.productByCatalogues':
            $breadcrumbs[] = ['name' => 'Sản Phẩm', 'url' => ''];
            break;

        case 'client.posts.index':
            $breadcrumbs[] = ['name' => 'Bài Viết', 'url' => ''];
            break;

        case 'search':
            $breadcrumbs[] = ['name' => 'Bài Viết', 'url' => ''];
            break;

        case 'post.show':
            $breadcrumbs[] = ['name' => 'Bài Viết', 'url' => route('client.posts.index')];
            $breadcrumbs[] = ['name' => 'Chi Tiết Bài Viết', 'url' => ''];
            break;

        case 'contact.index':
            $breadcrumbs[] = ['name' => 'Liên Hệ', 'url' => ''];
            break;

        case 'privacy.policy':
            $breadcrumbs[] = ['name' => 'Chính Sách Bảo Mật', 'url' => ''];
            break;

        case 'login':
            $breadcrumbs[] = ['name' => 'Đăng Nhập', 'url' => ''];
            break;

        case 'cart.view':
            $breadcrumbs[] = ['name' => 'Giỏ Hàng', 'url' => ''];
            break;

        case 'client.about.index': // Cập nhật cho trang About
            $breadcrumbs[] = ['name' => 'About', 'url' => ''];
            break;

        case 'client.products.product-detail':
            $breadcrumbs[] = ['name' => 'Sản Phẩm', 'url' => route('client.products.index')];
            $breadcrumbs[] = ['name' => 'Chi Tiết Sản Phẩm', 'url' => ''];
            break;

        case 'profile.show':
            $breadcrumbs[] = ['name' => 'Thông Tin tài Khoản', 'url' => ''];
            break;

        case 'profile.edit':
            $breadcrumbs[] = ['name' => 'Thông Tin tài Khoản', 'url' => route('profile.show')];
            $breadcrumbs[] = ['name' => 'Chỉnh Sửa Hồ Sơ', 'url' => ''];
            break;

        case 'profile.edit-password':
            $breadcrumbs[] = ['name' => 'Thông Tin tài Khoản', 'url' => route('profile.show')];
            $breadcrumbs[] = ['name' => 'Thay Đổi Mật Khẩu', 'url' => ''];
            break;

        case 'client.listProductFavorites':
            $breadcrumbs[] = ['name' => 'Sản Phẩm Yêu Thích', 'url' => ''];
            break;

        case 'order.history':
            $breadcrumbs[] = ['name' => 'Lịch Sử Đơn Hàng', 'url' => ''];
            break;
    }
@endphp

@php
    use App\Models\Advertisement;
    $advertisements = Advertisement::all();
    $validAdvertisements = $advertisements->filter(function ($advertisement) {
        return $advertisement->image &&
            $advertisement->title &&
            $advertisement->description &&
            $advertisement->button_link &&
            $advertisement->button_text &&
            $advertisement->position == 5;
    });
@endphp

<div class="banner-wrapper has_background">
    @if ($validAdvertisements->count() > 0)
        @foreach ($validAdvertisements as $advertisement)
            <img src="{{ asset('storage/' . $advertisement->image) }}"
                class="img-responsive attachment-1920x447 size-1920x447" alt="img">
            <div class="banner-wrapper-inner">
                <h1 class="page-title container">{{ end($breadcrumbs)['name'] }}</h1>
                <div role="navigation" aria-label="Breadcrumbs" class="breadcrumb-trail breadcrumbs container">
                    <ul class="trail-items breadcrumb">
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="trail-item {{ $loop->last ? 'trail-end active' : '' }}">
                                @if ($breadcrumb['url'])
                                    <a href="{{ $breadcrumb['url'] }}"><span>{{ $breadcrumb['name'] }}</span></a>
                                @else
                                    <span>{{ $breadcrumb['name'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    @endif
</div>
