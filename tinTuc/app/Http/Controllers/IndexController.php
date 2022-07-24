<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PropertiCategory;
use App\Models\Tintuc;
use App\Models\User;
use App\Models\Binhluan;
use Carbon\Carbon;
use  App\Models\Like;

use Auth;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index()
    {

        $bongda_vn = Category::where('slug', 'bong-da-viet-nam')->first();
        $bongda_tg = Category::where('slug', 'bong-da-quoc-te')->first();
        $the_thao = Category::where('slug', 'the-thao')->first();
        $chuyen_nhuong = Category::where('slug', 'chuyen-nhuong')->first();
        $es_ports = Category::where('slug', 'esports')->first();
        $x_e = Category::where('slug', 'xe')->first();
        $v_o = Category::where('slug', 'vo')->first();
        $khoe_vadep = Category::where('slug', 'khoe-va-dep')->first();

        $duyet = 1;
        $bongdavietnam = 1;
        $nghethuat = 5;
        $category = Category::all();
        $properti = PropertiCategory::all();
        $tintuc = Tintuc::all();
        $user = User::all();

        $f_f_e = Tintuc::orderBy('created_at', 'DESC')->where('trangthai', $duyet)->take(2)->get();
        $t_s_f = Tintuc::where('id_properticategory', $bongdavietnam)
            ->orderBy('created_at', 'DESC')
            ->where('trangthai', $duyet)->take(1)->get();

        $e_t_z = Tintuc::where('id_properticategory', $nghethuat)
            ->orderBy('created_at', 'DESC')
            ->where('trangthai', $duyet)->take(1)->get();


        $bongdavn = Tintuc::where('id_category', $bongda_vn->id)->where('trangthai', $duyet)->orderBy('luotxem', 'DESC')->take(1)->get();
        $bongdavn2 = Tintuc::where('id_category', $bongda_vn->id)->where('trangthai', $duyet)->orderBy('created_at', 'DESC')->take(2)->get();
        $bongdavn3 = Tintuc::where('id_category', $bongda_vn->id)->where('trangthai', $duyet)->orderBy('created_at', 'ASC')->take(2)->get();


        $bongdatg = Tintuc::where('id_category', $bongda_tg->id)->where('trangthai', $duyet)->orderBy('luotxem', 'DESC')->take(1)->get();
        $bongdatg2 = Tintuc::where('id_category', $bongda_tg->id)->where('trangthai', $duyet)->orderBy('created_at', 'DESC')->take(4)->get();

        $thethao = Tintuc::where('id_category', $the_thao->id)->where('trangthai', $duyet)->orderBy('luotxem', 'DESC')->take(1)->get();
        $thethao2 = Tintuc::where('id_category', $the_thao->id)->where('trangthai', $duyet)->orderBy('created_at', 'DESC')->take(2)->get();
        $thethao3 = Tintuc::where('id_category', $the_thao->id)->where('trangthai', $duyet)->orderBy('created_at', 'ASC')->take(2)->get();


        $chuyennhuong = Tintuc::where('id_category', $chuyen_nhuong->id)->where('trangthai', $duyet)->orderBy('luotxem', 'DESC')->take(1)->get();
        $chuyennhuong2 = Tintuc::where('id_category', $chuyen_nhuong->id)->where('trangthai', $duyet)->orderBy('created_at', 'DESC')->take(2)->get();
        $chuyennhuong3 = Tintuc::where('id_category', $chuyen_nhuong->id)->where('trangthai', $duyet)->orderBy('created_at', 'DESC')->take(2)->get();
        $vo = Tintuc::where('id_category', $v_o->id)->where('trangthai', $duyet)->orderBy('luotxem', 'DESC')->take(1)->get();
        $vo2 = Tintuc::where('id_category', $v_o->id)->where('trangthai', $duyet)->orderBy('created_at', 'DESC')->take(4)->get();



        $khoevadep = Tintuc::where('id_category', $khoe_vadep->id)->where('trangthai', $duyet)->orderBy('luotxem', 'DESC')->take(1)->get();
        $khoevadep2 = Tintuc::where('id_category', $khoe_vadep->id)->where('trangthai', $duyet)->orderBy('created_at', 'DESC')->take(2)->get();
        $khoevadep3 = Tintuc::where('id_category', $khoe_vadep->id)->where('trangthai', $duyet)->orderBy('created_at', 'DESC')->take(2)->get();

        $video  = Tintuc::where('video', '!=', 'null')->where('trangthai', $duyet)->orderBy('luotxem', 'DESC')->take(1)->get();
        $video2  = Tintuc::where('video', '!=', 'null')->where('trangthai', $duyet)->orderBy('created_at', 'DESC')->take(4)->get();

        return view('index', compact(
            'video2',
            'video',
            'khoevadep3',
            'khoevadep2',
            'khoevadep',
            'vo2',
            'vo',
            'chuyennhuong3',
            'chuyennhuong2',
            'chuyennhuong',
            'thethao3',
            'thethao2',
            'thethao',
            'bongdatg2',
            'bongdatg',
            'bongdavn3',
            'bongdavn2',
            'bongdavn',
            'e_t_z',
            't_s_f',
            'f_f_e',
            'category',
            'properti',
            'user'
        ));
    }

    public function properti($pro)
    {
        $proper = PropertiCategory::where('slug', $pro)->first();
        $loc = Tintuc::where('trangthai', '1')->where('id_properticategory', $proper->id)->paginate(10);

        $title =  $proper->title;
        return view('frontend.pages.loc.loc', compact('loc', 'title'));
    }

    public function category($cat)
    {
        $cat = Category::where('slug', $cat)->first();
        $loc = Tintuc::where('trangthai', '1')->where('id_category', $cat->id)->paginate(10);

        $title =  $cat->title;
        return view('frontend.pages.loc.loc', compact('loc', 'title'));
    }

    public function tag($tag)
    {
        $loc = Tintuc::where('trangthai', '1')->where('tag', $tag)->paginate(10);

        $title =  'tag';
        return view('frontend.pages.loc.loc', compact('loc', 'title'));
    }

    public function search(Request $request)
    {
        $key = $request->search;
        $cat = Category::where('title', 'like', '%' . $key . '%')->first();
        $pro = Category::where('title', 'like', '%' . $key . '%')->first();

        $tintuc = Tintuc::where('trangthai', '1')->where('title', 'like', '%' . $key . '%')->get();
        $tintuc_t = Tintuc::where('trangthai', '1')->where('tag', 'like', '%' . $key . '%')->get();

        $title = 'kết quả tìm kiếm';
        $title_t = 'kết quả tìm kiếm theo';
        $s = '(0,36 giây) ';
        return view('frontend.pages.loc.search', compact('tintuc', 'tintuc_t', 'title', 's'));
    }

    public function danhmuc($slug)
    {
        $category = Category::where('slug', $slug)->first();

        $duyet = 1;
        $title = Category::where('slug', $slug)->first();

        $xemnhieunhat = Tintuc::where('id_category', $category->id)->orderBy('luotxem', 'DESC')->first();


        $tintuc1 = Tintuc::where('id_category', $category->id)->orderBy('created_at', 'DESC')->where('trangthai', $duyet)->take(2)->get();
        $tintuc2 = Tintuc::where('id_category', $category->id)->orderBy('created_at', 'ASC')->where('trangthai', $duyet)->take(2)->get();

        $pro = PropertiCategory::where('id_category', $category->id)->orderBy('id', 'DESC')->get();

        $c1 =  PropertiCategory::where('id_category', $category->id)->first();
        $w1 = Tintuc::where('id_properticategory', $c1->id)->where('trangthai', $duyet)->take(2)->get();

        $c2 =  PropertiCategory::where('id_category', $category->id)->orderBy('created_at', 'DESC')->first();
        $w2 = Tintuc::where('id_properticategory', $c2->id)->where('trangthai', $duyet)->orderBy('luotxem', 'DESC')->take(1)->get();
        $w3 = Tintuc::where('id_properticategory', $c2->id)->where('trangthai', $duyet)->take(4)->get();

        $c3 = PropertiCategory::where('id_category', $category->id)->orderBy('created_at', 'ASC')->first();


        //2 row
        $w4 = Tintuc::where('id_category', $category->id)->where('trangthai', $duyet)->orderby('created_at', 'DESC')->first();
        // Kiem tra w4 == null -> xu ly nhu nao ?
        // try catch phan query nay de bat loi.
        $w5 = Tintuc::where('id_properticategory', $w4->tintucProperti->id)->where('trangthai', $duyet)->orderby('luotxem', 'ASC')->take(4)->get();


        $w6 = Tintuc::where('id_category', $category->id)->where('trangthai', $duyet)->orderby('created_at', 'ASC')->first();
        $w7 = Tintuc::where('id_properticategory', $w6->tintucProperti->id)->where('trangthai', $duyet)->orderby('created_at', 'ASC')->get();


        $w8 = Tintuc::where('id_category', $category->id)->where('trangthai', $duyet)->orderby('luotxem', 'DESC')->first();
        $w9 = Tintuc::where('id_properticategory', $w8->tintucProperti->id)->where('trangthai', $duyet)->get();
        //video
        $w10 = Tintuc::where('id_category', $category->id)->where('video', '!=', 'null')->where('trangthai', $duyet)->orderBy('luotxem', 'DESC')->take(1)->get();;
        $w11 = Tintuc::where('id_category', $category->id)->where('video', '!=', 'null')->where('trangthai', $duyet)->orderBy('luotxem', 'ASC')->take(4)->get();
        //after video
        $w12 = Tintuc::where('id_category', $category->id)->where('trangthai', $duyet)->orderBy('luotxem', 'DESC')->orderBy('created_at', 'ASC')->first();
        $w13 = Tintuc::where('id_category', $category->id)->where('trangthai', $duyet)->orderBy('luotxem', 'DESC')->orderBy('created_at', 'ASC')->take(3)->get();

        //foot
        $w16 = Tintuc::where('id_category', $category->id)->where('trangthai', $duyet)->orderBy('luotxem', 'ASC')->orderBy('created_at', 'DESC')->first();
        $w17 = Tintuc::where('id_category', $category->id)->where('trangthai', $duyet)->orderBy('luotxem', 'ASC')->orderBy('created_at', 'DESC')->take(3)->get();

        return view('frontend.pages.danhmuc.index', compact('category', 'title', 'xemnhieunhat', 'tintuc1', 'tintuc2', 'w1', 'c1', 'w2', 'c2', 'w3', 'c3', 'w4', 'w5', 'w6', 'w7', 'w8', 'w9', 'w10', 'w11', 'w12', 'w13', 'w16', 'w17'));
    }


    public function ero()
    {
        return view('frontend.pages.404');
    }

    public function coming()
    {
        return view('frontend.pages.coming');
    }

    public function about()
    {
        return view('frontend.pages.about');
    }

    public function detail($slug)
    {
        $tin = Tintuc::where('slug', $slug)->first();
        $tin->increment('luotxem');
        $user = User::all();
        $checkbinhluan = Binhluan::where('id_tintuc', $tin->id)->first();
        $xuhuong = Tintuc::orderBy('created_at', 'ASC')->take(4)->get();
        $binhluan = Binhluan::where('id_tintuc', $tin->id)->where('trangthai', '<>', 0)->get();
        $binhluansibar = Binhluan::orderBy('created_at', 'DESC')->take(4)->get();
        $ketiep = Tintuc::where('id_category', $tin->id_category)->take(2)->get();
        $luachon = Tintuc::orderBy('luotxem', 'ASC')->take(4)->get();
        $like = Tintuc::where('id_properticategory', $tin->id_properticategory)->orderBy('luotxem', 'DESC')->take(2)->get();
        if (Auth::check()) {
            $likes = Like::where('id_user', Auth::user()->id)->where('id_tintuc', $tin->id)->where('like', '1')->first();
            return view('frontend.pages.detail.index', compact('likes', 'luachon', 'checkbinhluan', 'binhluan', 'like', 'ketiep', 'slug', 'tin', 'user', 'xuhuong', 'binhluansibar'));
        }
        return view('frontend.pages.detail.index', compact('like', 'luachon', 'checkbinhluan', 'binhluan', 'like', 'ketiep', 'slug', 'tin', 'user', 'xuhuong', 'binhluansibar'));
    }

    public function binhluan(Request $request, $tin, $user)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $binhluan = new Binhluan();

        $binhluan->noidung = $request->comment;
        $binhluan->id_user = $user;
        $binhluan->id_tintuc = $tin;
        $binhluan->ngaydang = $now;
        $binhluan->trangthai = 0;
        $binhluan->save();

        return redirect()->back();
    }

    public function like(Request $request)
    {
        $check = Like::where('id_tintuc', $request->tin)->where('id_user', $request->user)->first();
        if (isset($check)) {
            if ($check->like == 0) {
                $val = Like::where('id_tintuc', $request->tin)->where('id_user', $request->user)->first();
                $val->like = 1;
                $val->id_user = $request->user;
                $val->id_tintuc =  $request->tin;
                $val->save();
            } else {
                $val = Like::where('id_tintuc', $request->tin)->where('id_user', $request->user)->first();
                $val->like = 0;
                $val->id_user = $request->user;
                $val->id_tintuc =  $request->tin;
                $val->save();
            }
        } else {
            $val = new Like();
            $val->like = 1;
            $val->id_user = $request->user;
            $val->id_tintuc =  $request->tin;
            $val->save();
        }
        return redirect()->back();
    }
    public function report($id)
    {
        $binhluan = Binhluan::where('id', $id)->first();
        $binhluan->trangthai = '2';
        $binhluan->save();

        return redirect()->back();
    }
}
