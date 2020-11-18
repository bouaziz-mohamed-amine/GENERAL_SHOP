@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {!! !is_null($product) ? 'Update Product <span class="product-header-title">'.$product->title.'</span>' :' New Product' !!}
                </div>
                <div class="card-body">
                    <form action="{{(!is_null($product))? route('products.update',['product'=>$product->id]):route('products.store')}}" enctype="multipart/form-data" method="post" class="row">
                        @csrf

                        @if(!is_null($product)  )
                            <input type="hidden" name="_method" value="PUT"/>
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                        @endif
                        <div class="form-group col-md-12 ">
                            <label for="product_title">Product Title</label>
                            <input type="text" class="form-control" id="product_title" name="product_title"
                                   placeholder="Product title" required
                                   value="{{(!is_null($product)) ? $product->title : '' }}">
                        </div>
                        <div class="form-group col-md-12 ">
                            <label for="product_description">Product Description</label>
                            <textarea placeholder="Product Description" required class="form-control"
                                      name="product_description" id="product_description" cols="30"
                                      rows="10">
                                {{(! is_null($product))? $product->description :''}}
                            </textarea>
                        </div>

                        <div class="form-group col-md-12 ">
                            <label for="product_category">Product Category</label>
                            <select class="form-control" name="product_category" id="product_category" required>
                                <option value="">Select Category</option>

                                @foreach( $categories as  $category)

                                    <option
                                        value="{{$category->id}}" {{(! is_null($product) && $product->category->id===$category->id ) ? 'selected' :''}}>{{$category->name}}
                                    </option>

                                @endforeach


                            </select>
                        </div>

                        <div class="form-group col-md-12 ">
                            <label for="product_unit">Product Unit</label>
                            <select class="form-control" name="product_unit" id="product_unit" required>
                                <option>Select Unit</option>
                                @foreach($units as $unit)
                                    <option value="{{$unit->id}}"
                                      {{(!is_null($product) && $product->hasUnit->id===$unit->id )?'selected':''}} >
                                        {{$unit->unit_name}}-{{$unit->unit_code}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6 ">
                            <label for="product_price">Product Price</label>
                            <input type="number" class="form-control" id="product_price" name="product_price" step="any"
                                   placeholder="Product price" required
                                   value="{{(!is_null($product)) ? $product->price : '' }}">
                        </div>

                        <div class="form-group col-md-6 ">
                            <label for="product_total">Product Total</label>
                            <input type="number" class="form-control" id="product_total" name="product_total" step="any"
                                   placeholder="Product total" required
                                   value="{{(!is_null($product)) ? $product->total : '' }}">
                        </div>

                                                    <!--option  -->

                        <table id="options-table" class="table table-striped">

                        </table>

                                <div class="form-group col-md-6  ">
                            <a class="btn btn-outline-dark add-option-btn" href="#">
                                Add Options
                            </a>
                                </div>
                                                    <!--end_option-->

                        <!--images-->
                        <div class="form-group col-md-12">
                            <div class="row">
                                @for( $i=0; $i<6 ; $i++)
                                   <div class="col-md-4 col-sm-12 mb-4">
                                                <div class="card image-card-upload" >
                                                    <a href="" class="remove-image-upload"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                            <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                        </svg></a>
                                                    <a href="#" class="activate-image-upload" data-fileid="image-{{$i}}">
                                                        <div class="card-body" style="text-align: center">
                                                            @if(! is_null($product->images) && count($product->images)>0)
                                                                @if(isset($product->images[$i])&& !is_null($product->images[$i]) &&  !empty($product->images[$i]))
                                                                    <a href="#" class="remove-image-upload" data-imgid="{{$product->images[$i]->id}}"
                                                                       data-removeimg="removeimg-{{$i}}" data-fileid="image-{{$i}}">
                                                                        <i
                                                                            class="fas fa-minus-circle" style="display: none"></i></a>
                                                                @else
                                                                    <a href="#" class="activate-image-upload"
                                                                       data-fileid="image-{{$i}}" id="removeimg-{{$i}}"><i
                                                                            class="fas fa-minus-circle" style="display: none"></i></a>

                                                                @endif
                                                            @endif


                                                            @if(! is_null($product->images) && count($product->images)>0)
                                                                @if(isset($product->images[$i])&& !is_null($product->images[$i]) &&  !empty($product->images[$i]))

                                                                    <img id="{{'iimage-'. $i}}"
                                                                         src="{{asset($product->images[$i]->url)}}"
                                                                         class="card-img-top" alt="">
                                                                @endif
                                                            @endif
                                                    </div>
                                                    </a>
                                                    <input name="product_images[]" type="file" class="form-control-file image-file-upload" id="image-{{$i}}">

                                                </div>
                                   </div>
                                @endfor
                            </div>
                        </div>
                        <!--end_images-->
                        <div class="form-group col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-primary btn-block ">SAVE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--model-->
    <div class="modal options-window" tabindex="-1" role="dialog" id="options-window">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Option</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body row">

                    <div class="form-group col-md-6 ">
                        <label for="option_name">Option Name</label>
                        <input type="text" class="form-control" id="option_name" name="option_name"
                               placeholder="option Name" required>
                    </div>
                    <div class="form-group col-md-6 ">
                        <label for="option_value">Option Value</label>
                        <input type="text" class="form-control" id="option_value" name="option_value"
                               placeholder="Option value" required>
                    </div>

                    <input type="hidden" name="unit_id" id="edit_unit_id">
                    <input type="hidden" name="_method" value="put"/>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-primary add-option-button">ADD OPTION</button>
                </div>

            </div>
        </div>
    </div>
    <!--end_model-->
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            var $optionWindow = $('#options-window');
            var addOptionBtn = $('.add-option-btn');
            var $optionsTable = $('#options-table');
            addOptionBtn.on('click', function (e) {
                e.preventDefault();
                $optionWindow.modal('show');

            });
            $(document).on('click', '.remove-option', function (e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });

            $(document).on('click', '.add-option-button', function (e) {
                e.preventDefault();
                var $optionName = $('#option_name');
                if ($optionName.val() === '') {
                    alert('Option Name is required');

                }

                var $optionValue = $('#option_value');
                if ($optionValue.val() === '') {
                    alert('Option Value is required');

                }
                var optionRow = `
            <tr>
                <td>
                    ` + $optionName.val() + `
                </td>
                <td>
                    ` + $optionValue.val() + `
                </td>
<td>
                        <a href="" class="remove-option">delete</a>
                        <input type="hidden" name="\` + $optionName.val() + \`[]" value="\` + $optionValue.val() + \`">
                </td>
            </tr>
            `;
                $optionsTable.append(optionRow);
                $optionValue.val("");
                $optionName.val("");
            });

            <!--image_upload-->
            function readUrl(input, imageID) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#' + imageID).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function resetFileUpload(fileUploadID, imageID, $eI, $eD) {

                $('#' + imageID).attr('src', '');
                $eI.fadeIn();
                $eD.fadeOut();
                $('#' + fileUploadID).val('');
            }

            var $activateImageUpload = $('.activate-image-upload');
            $activateImageUpload.on('click', function (e) {
                e.preventDefault();
                var fileUploadID = $(this).data('fileid');
                var me = $(this);
                $('#' + fileUploadID).trigger('click');
                var imagetag = '<img id="i' + fileUploadID + '" src="" class="card-img-top" >';
                $(this).append(imagetag);
                $('#' + fileUploadID).on('change', function (e) {
                    readUrl(this, 'i' + fileUploadID);
                    me.find('i').fadeOut();
                    var $removeThisImage = me.parent().find('.remove-image-upload');

                    $removeThisImage.fadeIn();
                    $removeThisImage.on('click', function (e) {
                        e.preventDefault();
                        resetFileUpload('#' + $fileUploadID, 'i' + $fileUploadID, me.find('i'), $removeThisImage);

                    })
                });
            });
        });
    </script>
@endsection
