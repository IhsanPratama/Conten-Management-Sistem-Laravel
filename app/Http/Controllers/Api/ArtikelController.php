<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Auth;

use App\artikel;


class ArtikelController extends Controller
{
    public function getArtikels(){
        return artikel::orderBy("created_at","DESC")->paginate(15);
    }
    
    // Get Single Artikel
    public function getArtikel($slug){
        return artikel::where("slug",$slug)->first();
    }

    // tambah artikel
    public function tambahArtikel(Request $req){
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
        return $artikel;
    }

    // edit artikel
    public function editArtikel(Request $req){
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
            
            
            $artikel->update();
            return $artikel;
    }

    // hapus artikel
    public function hapusArtikel($id){
        $artikel = artikel::find($id);
       
        $artikel->delete();
        return $artikel;
    }

}
