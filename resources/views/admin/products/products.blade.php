@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p>Products</p>
                    <a class="btn btn-success mt-2" href="{{route('products.create')}}">  new Product</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-4">
                                <div class="alert alert-primary" role="alert">
                                    <h5>{{$product->title}}</h5>
                                    <p>Category:{{(is_object($product->category)) ? $product->category->name:''}}</p>
                                    <p>Category:{{$product->category->name}}</p>
                                    <p>Category:{{$product->id}}</p>
                                    {!!  (count($product->images) >0)? '<img class="img-thumbnail card-img" src="'.$product->images[0]->url.'">': ''!!}
                                    <a class="btn btn-success mt-2" href="{{route('products.show',['product'=>$product->id])}}"> Update Product</a>
                                    <a class="btn btn-danger mt-2 delete-product" href="#"> DELETE </a>
                                </div>

                            </div>
                        @endforeach
                            {{$products->links()}}
                    </div>

                </div>
            </div>
        </div>
    </div>


<!--delete product-->
    <div class="modal" tabindex="-1" id="options-window">
        <form action="{{route('products.destroy',['product'=> $product->id ] ) }}" method="post">
            @csrf
            @method('delete')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="product-text">Are you sure you want to delete {{$product->title}}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">DELETE </button>
                    </div>
                </div>
            </div>
        </form>
    </div>



@endsection

@if (Session::has('message'))
    <div class="toast" style="position: absolute;z-index:99999;top:5%;right: 5%;" role="alert" aria-live="assertive"
         aria-atomic="true">
        <div class="toast-header">
            <strong class="mr-auto">Products</strong>
            <span aria-hidden="true">&times;</span>
        </div>
        <div class="toast-body">

            {{Session::get('message')}}
        </div>
    </div>
@endif
@section('scripts')

    @if(Session::has('message'))
        <script>
            $(document).ready(function () {
                var $toast = $('.toast').toast({
                    autohide: false
                });

                $toast.toast('show');


            });


        </script>
    @endif
    <script>
        $(document).ready(function () {
               let  $deleteproduct=$('.delete-product');
               let $optionswindow=$('#options-window') ;
             //  let $producttext=$('#product-text');
               $deleteproduct.on('click',function (e) {
                        e.preventDefault();
                   $optionswindow.modal('show');

                   }
               )
        })
    </script>
@endsection
