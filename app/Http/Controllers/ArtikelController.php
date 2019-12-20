<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use \App\artikel;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index(Request $request){
        if(Auth::user()){
            if ($request->has('cari')){
                $artikel = new artikel;
                $artikel = artikel::where('judul','LIKE','%'.$request->cari.'%')->orderby('judul','desc');
            }else{
                $artikel = artikel::orderby('judul','desc');
            }
            $dataartikel = artikel::paginate(3);
             return view("artikel", compact("dataartikel"));
        }else{
            return redirect('login');
        }

    }

    // tambah artikel
    public function tambah(Request $req){

        $this->validate($req, [
            'judul'=>'required',
            'isi'=>'required',
            'kategori'=>'required',
            'image'=>'required|image:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($req->file('image')){
            $image = $req->file('image'); //mengambil file image yang diupload
            $imagename = time().'.'.$image->getClientOriginalExtension(); //ubah naa file dg fungsi time
            $destinationPath=public_path('/img'); //set folder penyimpanan file dg nama folder 'img'
            $image->move($destinationPath,$imagename);
        }else{
            $imagename = "sample.png";
        }

        $slug = Str::slug($req["judul"],'-');

        $artikel = new artikel;
        $artikel->judul = $req['judul'];
        $artikel->isi = $req['isi'];
        $artikel->kategori = $req['kategori'];
        $artikel->video = $req['video'];
        $artikel->user_id = Auth::user()->id;
        $artikel->slug = $slug;
        $artikel->img = $imagename;


        $artikel->save();
        return redirect('artikel');
    }

    // edit artikel
    public function edit(Request $req){
        $this->validate($req, [
            'judul'=>'required',
            'isi'=>'required',
            'kategori'=>'required',
        ]);

        $artikel = artikel::find($req['id']);

        if($req->file('image')){
            $this->validate($req, [
                'image'=>'required|image:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = $req->file('image'); //mengambil file image yang diupload
            $imagename = time().'.'.$image->getClientOriginalExtension(); //ubah naa file dg fungsi time
            $destinationPath=public_path('/img'); //set folder penyimpanan file dg nama folder 'img'
            $image->move($destinationPath,$imagename);
            //di set jika ada request image
            $artikel->img = $imagename;
        }

        $slug = Str::slug($req["judul"],'-');



        $artikel->judul = $req['judul'];
        $artikel->isi = $req['isi'];
        $artikel->kategori = $req['kategori'];
        $artikel->video = $req['video'];
        $artikel->user_id = Auth::user()->id;
        $artikel->slug = $slug;


        $artikel->save();
        return redirect('artikel');
    }

    // delete artikel
    public function delete(Request $req){


        $artikel = artikel::find($req['id']);

        $artikel->delete();
        return redirect('artikel');
    }

    // single page artikel
    public function singleArtikel($slug){
        $artikel = artikel::where("slug",$slug)->first();

        return view("frontend.single-blog",compact("artikel"));
    }

    //kategoriArtikel
    public function kategoriArtikel($slug){
        $artikels = artikel::where("kategori",$slug)->paginate(2);

        return view("frontend.kategori",compact("artikels"));
    }

    //searchArtikel
    public function searchArtikel($search){
        $artikels = artikel::where("judul","like","%".$search."%")
                            ->orWhere("kategori","like","%".$search."%")
                            ->paginate(2);

        return view("frontend.kategori",compact("artikels"));
    }
}
