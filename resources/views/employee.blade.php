@extends('layouts.myapp')

@section('content')
<section class="content">

   @if(session('message'))
        <div class="alert alert-success" role="alert">
    {{session('message')}}
    </div>
    @endif
    
<div class="card">
   <div class="card-header">
    <h2 class="card-title">Employees</h2>
    <div class="card-tools">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#empModal" data-action="cre">Create Employee</button>
    </div>
    </div>
        <div class="card-body">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th> Employee Id</th>
                    <th> Employee Name</th>
                    <th>Designation</th>
                    <th>Wired Date</th>
                    <th>Action</th>
                 </tr>
            </thead>
                <tbody>
                @foreach($employee  as $emp)
                <tr>
                    <td>{{$emp->id}}</td>
                    <td>{{$emp->first_name}} {{$emp->middle_name}} {{$emp->last_name}} </td>
                    <td>{{$emp->desiganation}}</td>
                    <td>{{$emp->date_of_joining}}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="#" class="btn btn-primary btn-sm" data-toggle='modal'data-target='#empModal' data-action="Show" data-emp="{{$emp}}">
                            <i class="fa fa-search" data-toggle='tooltip'></i>
                            </a>
                             <a href="#" class="btn btn-secondary btn-sm" data-toggle='modal'data-target='#empModal' data-action="Edit" data-emp="{{$emp}}">
                            <i class="fa fa-edit" data-toggle='tooltip'></i>
                            </a>
                            <form class="form-inline" method="post" action="{{route('employee.destroy',$emp)}}" onsubmit="return confirm('Are you sure to delete the Employee ?')"> 
                            
                            <input type="hidden" name="_method" value="delete">
                              <input type="hidden" name="_token" value="{{csrf_token()}}">

                              <button type="submit" class="btn btn-danger btn-sm">
                              <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            </div>
                    </td>
                </tr>
                @endforeach
               </tbody>                
        </table>
    </div>
</div>
<!-- New Employee Modal Window -->
<div class="modal fade" id="empModal" tableindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-tittle">Create Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
             <form id="employeeform" role="form">
                <div class="modal-body">
                        {{ csrf_field() }}

                        <input type="hidden" class="form-control" id="actionType" Name="action type">
                        <div class="form-group">
                        <label for="id">Employee Id:</label>
                        <input type="hidden" class="form-control" Id="id" Name="id">
                        <span class="text-danger"><strong Id="empno"></strong></span>
                      </div>
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" class="form-control" Id="first_name" Name="first_name">
                        <span class="text-danger"><strong Id="first_name-error"></strong></span>
                      </div>
                    <div class="form-group">
                        <label for="middle_name">Middle Name:</label>
                        <input type="text" class="form-control" Id="middle_name" Name="middle_name">
                         <span class="text-danger"><strong Id="middle_name-error"></strong></span>
                  
                        </div><div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" class="form-control" Id="last_name" Name="last_name">
                         <span class="text-danger"><strong Id="last_name-error"></strong></span>
                  
                        </div>
                    <div class="form-group">
                        <label for="desiganation">Desiganation:</label>
                        <input type="text" class="form-control" Id="desiganation" Name="desiganation">
                         <span class="text-danger"><strong Id="desiganation-error"></strong></span>
                  
                        </div>
                    <div class="form-group">
                        <label for="date_of_joining">Wired Date:</label>
                        <input type="date" class="form-control" Id="date_of_joining" Name="date_of_joining">
                         <span class="text-danger"><strong Id="date_of_joining-error"></strong></span>
                  
                        </div>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" Id="submitForm">Save</button>
                 </div>   
             </form>
           
            
        </div> 
    </div>
</div>
</section>
@endsection

@section('script')
<script>

$('#empModal').on('show.bs.modal',function(e){
     var actionButton = $(e.relatedTarget)
     var actionType=actionButton.data('action')
     var id= document.getElementById("id")
     var first_name=document.getElementById("first_name")
     var middle_name=document.getElementById("middle_name")
     var last_name=document.getElementById("last_name")
     var desiganation=document.getElementById("desiganation")
     var date_of_joining=document.getElementById("date_of_joining")

        $('#empno').html("");
        $('#first_name-error').html("");
        $('#middle_name-error').html("");
        $('#last_name-error').html("");
        $('#desiganation-error').html("");
        $('#date_of_joining-error').html("");

    var modal=$(this)
    modal.find('.modal-tittle').text(actionType + 'Employee')
    submitForm.style.display="block"
   document.getElementById("actionType").value=actionType
    if(actionType == 'Edit' || actionType == 'Show'){

     var emp=actionButton.data('emp')
     id.value=emp.id
     first_name.value=emp.first_name
     middle_name.value=emp.middle_name
     last_name.value=emp.last_name
     desiganation.value=emp.desiganation
     date_of_joining.value=emp.date_of_joining

     $('#empno').html(emp.id)
    }
    else{

    id.value=null;
    document.getElementById('employeeform').reset()
    }
    if( actionType == 'Show'){
        submitForm.style.display="none"
    }
      
})

/* submit button here */

$('body').on('click','#submitForm',function(e){
    e.preventDefault();
    var employeeForm =$("#employeeform");
    var formData= employeeForm.serialize();
    $('#first_name-error').html("");
    $('#middle_name-error').html("");
    $('#last_name-error').html("");
    $('#desiganation-error').html("");
    $('#date_of_joining-error').html("");
    $.ajax({
        url:'/employee',
        type:'post',
        data:formData,
        success: function(data){
            console.log(data);
            $('#empModal').modal('hide');
            window.location.href='/employee';
        },
        error: function(jqXHR,textStatus,errorThrown){
            console.log(jqXHR.status);
            data=jqXHR.responseJSON;
            if(data.errors){
                if(data.errors.first_name){
                    $('#first_name-error').html(data.errors.first_name[0]);
                }if(data.errors.middle_name){
                    $('#middle_name-error').html(data.errors.middle_name[0]);
                }if(data.errors.last_name){
                    $('#last_name-error').html(data.errors.last_name[0]);
                }if(data.errors.desiganation){
                    $('#desiganation-error').html(data.errors.desiganation[0]);
                }if(data.errors.date_of_joining){
                    $('#date_of_joining-error').html(data.errors.date_of_joining[0]);
                }
            }
        }

    });
});
</script>
@endsection
