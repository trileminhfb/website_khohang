@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Thông tin</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('xuat-kho.index') }}">Quản lý xuất kho</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $phieu_xuat->ma_phieu_xuat }}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <div class="nk-invoice">
                                <div class="nk-invoice-head flex-column flex-sm-row">
                                    <div class="nk-invoice-head-item mb-3 mb-sm-0">
                                        <div class="h4">Chi tiết</div>
                                        <ul>
                                            <li>Nhân viên: {{ $phieu_xuat->getUsers->name }}</li>
                                            <li>Khách hàng: {{ $phieu_xuat->khach_hang }}</li>
                                            <li>Địa chỉ: {{ $phieu_xuat->dia_chi }}</li>
                                            <li>Lý do: {{ $phieu_xuat->mo_ta }}</li>
                                        </ul>
                                    </div>
                                    <div class="nk-invoice-head-item text-sm-end">
                                        <div class="h3">Mã phiếu xuất: {{ $phieu_xuat->ma_phieu_xuat }}</div>
                                        <ul>
                                            <li>Ngày xuất: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $phieu_xuat->ngay_xuat)->format('d-m-Y') }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="nk-invoice-body">
                                    <div class="table-responsive">
                                        <table class="table nk-invoice-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="tb-col"><span class="overline-title">STT</span></th>
                                                    <th class="tb-col"><span class="overline-title">Mã hàng hóa</span></th>
                                                    <th class="tb-col"><span class="overline-title">Tên hàng hóa</span></th>
                                                    <th class="tb-col"><span class="overline-title">NSX</span></th>
                                                    <th class="tb-col"><span class="overline-title">Bảo quản(tháng)</span></th>
                                                    <th class="tb-col"><span class="overline-title">Số lượng</span></th>
                                                    <th class="tb-col"><span class="overline-title">Giá xuất</span></th>
                                                    <th class="tb-col tb-col-end"><span class="overline-title">Thành tiền</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $result = 0;
                                                @endphp

                                                @foreach ($chi_tiet_phieu_xuat as $key => $chi_tiet)
                                                    @php
                                                        $price = $chi_tiet->so_luong * $chi_tiet->gia_xuat;
                                                        $result += $price;
                                                    @endphp
                                                    <tr>
                                                        <td class="tb-col">
                                                            <span>{{ $key + 1 }}</span>
                                                        </td>
                                                        <td class="tb-col">
                                                            <span>{{ $chi_tiet->getChiTiet->getHangHoa->ma_hang_hoa }}</span>
                                                        </td>
                                                        <td class="tb-col">
                                                            <span>{{ $chi_tiet->getChiTiet->getHangHoa->ten_hang_hoa }}</span>
                                                        </td>
                                                        <td class="tb-col">
                                                            <span>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $chi_tiet->getChiTiet->ngay_san_xuat)->format('m/d/Y') }}</span>
                                                        </td>
                                                        <td class="tb-col"><span>{{ $chi_tiet->getChiTiet->tg_bao_quan }}</span></td>
                                                        <td class="tb-col"><span>{{ $chi_tiet->so_luong }}</span></td>
                                                        <td class="tb-col"><span>{{ number_format($chi_tiet->gia_xuat, 0, '', '.') }} VNĐ</span></td>
                                                        <td class="tb-col tb-col-end"><span>{{ number_format($price, 0, '', '.') }} VNĐ</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td colspan="">Tổng:</td>
                                                    <td class="tb-col tb-col-end">{{ number_format($result, 0, '', ',') }} VNĐ</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                @include('parts.paginate', ['paginator' => $chi_tiet_phieu_xuat])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
