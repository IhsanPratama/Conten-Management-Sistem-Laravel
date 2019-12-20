@extends('layouts.admin')
@section('title')
    Artikel
@endsection

@push('js-after')
    <!-- include summernote css/js -->

@endpush

@section('content')
 <!-- Nav Item - Search Dropdown (Visible Only XS) -->


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Artikel</div>
                {{-- fitur search --}}
                <div class="input-group md-form form-sm mt-3 form-1 pl-0" style="width:30%">
                <form action="/artikel" method="GET">
                <div class="input-group-prepend">
                    <span class="input-group-text purple lighten-3" id="basic-text1"><i class="fas fa-search text-white"
                        aria-hidden="true"></i></span>
                </div>
                <input class="form-control my-0 py-1" type="text" placeholder="Search" aria-label="Search" name="cari">
                </form>
                </div>

                    {{-- CRUD data artikel --}}
                    @include('artikel.tambah')
                    @include('artikel.edit')
                    @include('artikel.delete')

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                 @foreach ($errors->all() as $error)
                                     <li>{{ $error }}</li>
                                 @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- menampilkan tabel data artikel --}}
                    <table class="table">
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Action</th>

                        </tr>
                        <?php $no=0 ?>
                        @foreach ($dataartikel as $artikel)
                        <?php $no++ ?>
                        <tr>
                            <td>{{$no}}</td>
                            <td>
                                <img src="/img/{{ $artikel->img }}" width="50px">
                            </td>
                            <td> {{ $artikel->judul }} </td>
                            <td> {{ $artikel->kategori }} </td>

                            <td class="text-left">
                                {{-- button edit --}}
                                <button class="btn btn-primary btn-sm" onclick = "editartikel({{$artikel}})">Edit</button>

                                {{-- button delete --}}
                                <button class="btn btn-danger btn-sm" onclick = "deleteartikel({{$artikel}})">Delete</button>

                                {{-- javascript --}}
                                    <script>
                                        function editartikel(artikel){
                                            $("#imgedit").html(`
                                             <img src="/img/${artikel.img}" width="100px">
                                             `)
                                            $("#edit-id").val(artikel.id)
                                            $("#edit-judul").val(artikel.judul)
                                            $("#edit-kategori").val(artikel.kategori)
                                            $("#edit-isi").val(artikel.isi)

                                            $("#modal-editartikel").modal("show");
                                        }
                                        function deleteartikel(artikel){
                                            $("#delete-id").val(artikel.id)
                                            $("#modal-deleteartikel").modal("show");
                                        }
                                    </script>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    {{$dataartikel->links()}}




                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
