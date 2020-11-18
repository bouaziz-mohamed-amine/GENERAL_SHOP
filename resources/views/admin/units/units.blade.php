@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Units</div>

                <div class="card-body">

                    <form action="{{route('units.store')}}"  method="POST" class="row">
                            @csrf
                           <div class="form-group col-md-6">
                               <label for="unit_name">UNIT NAME</label>
                               <input type="text" class="form-control" id="unit_name" name="unit_name" placeholder="unit name">
                           </div>

                            <div class="form-group col-md-6">
                                <label for="unit_code">UNIT CODE</label>
                                <input type="text" class="form-control" id="unit_code" name="unit_code" placeholder="unit code" required>
                            </div>
                                <div class="form-group col-md-10" >
                                    <input type="submit" class="btn btn-primary" value="save new unit"  required>
                                </div>
                    </form>
                    <div class="row">
                        @foreach($units as $unit)
                            <div class="col-md-3">
                                <div class="alert alert-primary" role="alert">
                                     <span class="buttons-span">
                                        <span><a class="edit-unit" href="#"
                                                 data-unitname="{{$unit->unit_name}}"
                                                 data-unitcode="{{$unit->unit_code}}"
                                                 data-unitid="{{$unit->id}}"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                                    <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                                                </svg></a></span>
                                       <span><a href="#" class="delete-unit"
                                                data-unitname="{{$unit->unit_name}}"
                                                data-unitcode="{{$unit->unit_code}}"
                                                data-unitid="{{$unit->id}}">
                                               <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                      <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg></a></span>

                                   </span>
                                    <p>{{$unit->unit_name}},{{$unit->unit_code }}</p>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--   if !is_null($showLinks)  && $showLinks ==true do go to  $units link  or if $show==false   $units=search($units) -->
                    <!--  {{($showLinks ) ? $units->links():'' }}-->
                    {{(! is_null($showLinks) && $showLinks) ? $units->links():'' }}
                    <form action="{{route('units.search')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 ">
                                <input type="text" class="form-control" id="unit_search" name="unit_search"
                                       placeholder="Search Unit" required >
                            </div>
                            <div class="form-group col-md-6 ">
                                <button type="submit" class="btn btn-primary">SEARCH</button>

                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="modal delete-window" tabindex="-1" role="dialog" id="delete-window">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('units.destroy',['unit'=>$unit->id])}}" method="post">

                    <div class="modal-body">
                        <p id="delete-message"></p>
                        @csrf
                        <input type="hidden" name="_method" value="delete"/>
                        <input type="hidden" name="unit_id" value="" id="unit_id">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-primary">DELETE</button>
                    </div>
                </form>

            </div>


        </div>
    </div>
    <form action="{{route('units.update',['unit'=>$unit->id])}}" method="post" class="row">

        <div class="modal edit-window" tabindex="-1" role="dialog" id="edit-window">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Unit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        @csrf
                        <div class="form-group col-md-6 ">
                            <label for="edit_unit_name">Unit Name</label>
                            <input type="text" class="form-control" id="edit_unit_name" name="unit_name"
                                   placeholder="Unit Name" required>
                        </div>
                        <div class="form-group col-md-6 ">
                            <label for="edit_unit_code">Unit Code</label>
                            <input type="text" class="form-control" id="edit_unit_code" name="unit_code"
                                   placeholder="Unit Code" required>
                        </div>

                        <input type="hidden" name="unit_id" id="edit_unit_id">
                        <input type="hidden" name="_method" value="put"/>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
    @if (Session::has('status'))
        <div class="toast" style="position: absolute;z-index:99999;top:5%;right: 5%;" role="alert" aria-live="assertive"
             aria-atomic="true">
            <div class="toast-header">
                <strong class="mr-auto">Unit</strong>
                <span aria-hidden="true">&times;</span>
            </div>
            <div class="toast-body">

                {{Session::get('status')}}
            </div>
        </div>
    @endif

@endsection()

@section('scripts')
    <script>
        $(document).ready(function () {
            var $deleteUnit = $('.delete-unit');
            var $deletewindow = $('#delete-window');
            var $unitId = $('#unit_id');
            var $deleteMessage = $('#delete-message');
            $deleteUnit.on('click', function (element) {
                element.preventDefault();
                var unit_id = $(this).data('unitid');
                var unitName = $(this).data('unitname');
                var unitCode = $(this).data('unitcode');
                $unitId.val(unit_id);
                $deleteMessage.text('Are you sure you want to delete ' + unitName + ' with code ' + unitCode + "?");
                $deletewindow.modal('show');
            })

            var $editUnit = $('.edit-unit');
            var $editWindow = $('#edit-window');
            var $edit_unit_name = $('#edit_unit_name');
            var $edit_unit_code = $('#edit_unit_code');
            var $edit_unit_id = $('#edit_unit_id');
            $editUnit.on('click', function (element) {
                element.preventDefault();
                var unitName = $(this).data('unitname');
                var unitCode = $(this).data('unitcode');
                var unit_id = $(this).data('unitid');

                $edit_unit_code.val(unitCode);
                $edit_unit_id.val(unit_id);
                $edit_unit_name.val(unitName);

                $editWindow.modal('show');
            })
        });
    </script>

    <script >
        $(document).ready(function () {
            /*var $toast = $('.toast').toast({
                autohide: false
            });*/
            var $toast = $('.toast').toast({
                autohide:false
            });

            $toast.toast('show');

        });

    </script>

@endsection


