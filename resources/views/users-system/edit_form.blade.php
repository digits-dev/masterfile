<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')

    @if(g('return_url'))
        <p><a title='Return' href='{{g("return_url")}}' class="noprint"><i class='fa fa-chevron-circle-left'></i>
        &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
    @else
        <p><a title='Main Module' href='{{CRUDBooster::mainpath()}}' class="noprint"><i class='fa fa-chevron-circle-left'></i>
        &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
    @endif
  <!-- Your html goes here -->
  <div class='panel panel-default'>
    <div class='panel-heading'>Edit User</div>
    <div class='panel-body'>
    <form method='post' action="{{CRUDBooster::mainpath('edit-save/'.$row->id)}}" autocomplete="off" role="form" enctype="multipart/form-data">
        <input type="hidden" name="_token" id="token" value="{{csrf_token()}}" >
        <div class="col-md-3"></div>
        <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width: 25%">
                                    <b>First Name</b>
                                </td>
                                <td>
                                    <input class="form-control" type="text" style="width:100%" name="first_name" id="first_name" value="{{ $row->first_name }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%">
                                    <b>Last Name</b>
                                </td>
                                <td>
                                    <input class="form-control" type="text" style="width:100%" name="last_name" id="last_name" value="{{ $row->last_name }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%">
                                    <b>Email</b>
                                </td>
                                <td>
                                    <input class="form-control" type="email" style="width:100%" name="email" id="email" value="{{ $row->email }}" required>
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 25%">
                                    <b>Systems</b>
                                </td>
                                <td>
                                    <select name='system[]' id="system" style="width: 100%" class='form-control' multiple='multiple' required>
                                        
                                        @foreach ($systems as $system)
                                            <option {{  in_array($system->system_code,explode(",",$row->system)) ? "selected" : "" }} value="{{ $system->system_code }}">{{ strtoupper($system->system_code) }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        
      
    </div>
    <div class='panel-footer'>
        <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">Go Back</a>
      <input type='submit' class='btn btn-primary pull-right' value='Save changes'/>
    </div>
    </form>
  </div>
@endsection

@push('bottom')

<script type="text/javascript">
$(document).ready(function() {

    $(function(){
        $('body').addClass("sidebar-collapse");
    });

    $('#system').select2();
});
</script>

@endpush