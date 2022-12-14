@extends('layouts.master')

@section('title', 'Barang APD')

@section('content')

    <section class="section">
        <div class="section-header">
            <div class="section-header-back d-md-none">
                <a href="{{ route('panel') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1 class="d-xl-none d-md-none">Barang APD</h1>
            <div class="section-header-breadcrumb ml-md-0 d-none d-md-flex">
                <div class="breadcrumb-item active"><a href="{{ route('panel') }}">Home</a></div>
                <div class="breadcrumb-item">Barang APD</div>
                {{-- <div class="breadcrumb-item">Pinjam</div> --}}
            </div>
        </div>

        @component('components.subnav.barang_pinjam')
            @slot('active')
            data
            @endslot
        @endcomponent

        @if ( $errors->any() )
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
                Gagal menambahkan data!
            </div>
        </div>
        @elseif( Session::has('alert') )
        <div class="alert alert-{{ Session::get('alert.0') }} alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
                {{ Session::get('alert.1') }}
            </div>
        </div>
        @endif

        <div class="section-body">
            <div class="row">

                <div class="col-md-12">
                    <form action="{{ route('barang.pinjam.index') }}">
                        <div class="card">
                            <div class="card-header">
                                <h4>Filter</h4>
                                <div class="card-header-action">
                                    <a data-collapse="#mycard-collapse" class="btn btn-custom btn-icon btn-primary" href="#"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="collapse" id="mycard-collapse">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-8">
                                            <label for="">Cari</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="search" value="{{ request()->get('search') }}" placeholder="Cari Barang">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label for="">Kategori</label>
                                            <select class="form-control" name="category">
                                                <option value="">Semua</option>
                                                @foreach($category as $kategori)
                                                <option {{ request()->get('category') == $kategori->id ? 'selected' : '' }} value="{{ $kategori->id }}">{{$kategori->category}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-12">
                    <div class="grid-custom">
                        {{-- <div class="grid-header">
                            <h4>Data Barang Pinjam</h4>
                        </div> --}}

                        <div class="grid-body">

                            @forelse ($items as $item)
                                <a href="{{ route('barang.pinjam.show', ['id' => $item->id]) }}" class="grid-card">
                                    <img src="{{ Storage::url($item->image) }}" alt="">
                                    <h4>{{ $item->name }}</h4>
                                    <p>{{ $item->category->category }}</p>
                                    <p class="grid-badge"><span class="badge badge-primary mr-2">{{ $item->items_count }}</span> Unit</p>
                                </a>
                            @empty
                                <p class="text-center">Tidak ada data barang!</p>
                            @endforelse

                        </div>

                        @if( $items->hasPages() )
                            <div class="grid-footer">
                                {{
                                    $items->appends([
                                        'search' => request()->get('search'),
                                        'category' => request()->get('category')
                                    ])->links() 
                                }}
                            </div>
                        @endif
                        
                    </div>

                </div>
            </div>
        </div>

    </section>

@endsection


@section('script')

<script>

    $(document).ready(function() {
        horiscroll($('.scroller'));
    })

    function alertDelete(e, type = false) {
        let setup = {
            title: 'Kamu yakin mau hapus barang ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak'
        }
        if (type) {
            setup.text = 'Data yang sudah dihapus permanen akan hilang selamanya!';
        }
        Swal.fire(setup)
            .then((result) => {
                console.log(result)
                if (result.value) {
                    e.submit();
            }
        });
    }
</script>

@endsection