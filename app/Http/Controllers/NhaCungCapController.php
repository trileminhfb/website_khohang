<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\NhaCungCap;
use App\Models\ChiTietHangHoa;
use App\Models\TrangThai;
use Illuminate\Http\Request;

class NhaCungCapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nha_cung_cap = NhaCungCap::get();

        return view('nhacungcap.index', compact('nha_cung_cap'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trang_thai = TrangThai::get();
        $nha_cung_cap = NhaCungCap::get();

        return view('nhacungcap.create', compact('trang_thai', 'nha_cung_cap'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ma_ncc' => 'required|unique:nha_cung_cap,ma_ncc',
            'ten_ncc' => 'required|max:255',
            'id_trang_thai' => 'required|integer',
            'sdt' => 'required|regex:/^(0)[0-9]{9}$/',
            'dia_chi' => 'string|max:255',
        ]);

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;

        $nha_cung_cap = NhaCungCap::create([
            'ma_ncc' => $data['ma_ncc'],
            'ten_ncc' => $data['ten_ncc'],
            'dia_chi' => $data['dia_chi'],
            'sdt' => $data['sdt'],
            'id_trang_thai' => $data['id_trang_thai'] ?? 3,
            'mo_ta' => strlen($mo_ta) == 0 ? 'Không có mô tả cụ thể!' : $mo_ta
        ]);

        if ($nha_cung_cap) {
            Alert::success('Thành công', 'Thêm mới nhà cung cấp thành công!');
            return redirect()->route('nha-cung-cap.index');
        } else {
            Alert::error('Thất bại', 'Thêm mới thất bại do đã tồn tại nhà cung cấp từ trước hoặc do lỗi!')->autoClose(5000);
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $nha_cung_cap = NhaCungCap::where('ma_ncc', $code)->first();
        $chi_tiet_hang_hoa = ChiTietHangHoa::where('ma_ncc', $code)->paginate(10);

        $tong = $chi_tiet_hang_hoa->sum(function($h) {
            return $h->so_luong_goc * $h->gia_nhap;
        });

        $nha_cung_cap->tong = $tong;

        if ($nha_cung_cap) {
            return view('nhacungcap.show', compact('nha_cung_cap', 'chi_tiet_hang_hoa'));
        } else {
            Alert::error('Thất bại', 'Không tìm thấy nhà cung cấp, xin vui lòng thử lại sau!')->autoClose(5000);
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code)
    {
        $nha_cung_cap = NhaCungCap::where('ma_ncc', $code)->first();
        $trang_thai = TrangThai::get();

        if ($nha_cung_cap) {
            return view('nhacungcap.edit', compact('nha_cung_cap', 'trang_thai'));
        } else {
            Alert::error('Thất bại', 'Không tìm thấy nhà cung cấp, xin vui lòng thử lại sau!')->autoClose(5000);
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $code)
    {
        $request->validate([
            'ma_ncc' => 'required|max:50',
            'ten_ncc' => 'required|max:255',
            'id_trang_thai' => 'required|integer',
            'dia_chi' => 'string|max:255',
            'sdt' => 'required|regex:/^(0)[0-9]{9}$/'
        ], [
            'sdt.required' => 'Bạn cần thêm số điện thoại!',
            'sdt.regex' => 'Định dạng số điện thoại không đúng.'
        ]);

        $data = $request->all();

        $nha_cung_cap = NhaCungCap::where('ma_ncc', $code)->first();

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;

        $status = $nha_cung_cap->update([
            'ma_ncc' => $data['ma_ncc'],
            'ten_ncc' => $data['ten_ncc'],
            'dia_chi' => $data['dia_chi'],
            'sdt' => $data['sdt'],
            'id_trang_thai' => $data['id_trang_thai'],
            'mo_ta' => strlen($mo_ta) == 0 ? 'Không có mô tả cụ thể!' : $mo_ta
        ]);

        if ($status) {
            Alert::success('Thành công', 'Sửa thông tin nhà cung cấp thành công!');
            return redirect()->route('nha-cung-cap.index');
        } else {
            Alert::error('Thất bại', 'Có lỗi trong quá trình chỉnh sửa. Xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = NhaCungCap::destroy($id);

        if ($status) {
            Alert::success('Thành công', 'Xóa thông tin nhà cung cấp thành công!');
            return redirect()->route('nha-cung-cap.index');
        } else{
            Alert::error('Thất bại', 'Có lỗi trong quá trình xóa. Xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }
}
