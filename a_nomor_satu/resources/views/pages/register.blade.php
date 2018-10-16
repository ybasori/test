@extends('layouts.basic')

@section('title', 'Register')


@section('content')
<div class="row">
    <div class="col-md-5">
        <form id="form">
            <div class="form-group row">
                <label for="" class="control-label col-md-3">Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="control-label col-md-3">E-mail</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="email">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="control-label col-md-3">Password</label>
                <div class="col-md-9">
                    <input type="password" class="form-control" name="password">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="control-label col-md-3">Phone</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="phone">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="control-label col-md-3">Gender</label>
                <div class="col-md-9">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="L" name="gender">
                        <label class="form-check-label" for="">
                            Male
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" value="P"  name="gender">
                        <label class="form-check-label" for="">
                            Female
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="control-label col-md-3">Nationality</label>
                <div class="col-md-9">
                    <select id="nation" class="form-control" name="nationality"></select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-9 offset-md-3">
                <button type="submit" class="btn btn-success">Register</button>
                </div>
            </div>
        </form>
        <div id="result"></div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
    $(document).ready(function(){
        $.ajax({
            url: "https://restcountries.eu/rest/v2/all",
            type: "GET",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function(){
                
            },
            success: function(data){
                var array=[];
                for(var i=0;i<data.length;i++){
                    array.push({
                        id:data[i].name,
                        text:data[i].name
                    });
                }

                $("#nation").select2({
                    data: array,
                    placeholder: {
                        id: '-1',
                        text: 'Select an option'
                    }
                });
                $("#nation").select2("val","-1");
            },
            error: function(){
                
            }
        });
        $("#form").on("submit", function(e){
                var formdata=new FormData(this);
                formdata.append('_token','{{csrf_token()}}');
                e.preventDefault();
				$.ajax({
					url: "{{url('/register')}}",
					type: "POST",
					data: formdata,
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function(){
						$("#result").html("<div class='alert alert-info'>Loading</div>");
					},
					success: function(data){
						$("#result").html("<div class='alert alert-success'>Successfully Registered</div>");
					},
					error: function(xhr, ajaxOptions, thrownError){
                        if(xhr!=null){
                            if(xhr.responseJSON!=null){
                                var errors=xhr.responseJSON;
                                var html="";
                                for(var key in errors){
                                    for(var i=0;i<errors[key].length;i++){
                                        html=html+`<li>${errors[key][i]}</li>`;
                                    }
                                }
                                
                                $("#result").html("<div class='alert alert-danger'><ul>"+html+"</ul></div>");
                            }
                            else{
						        $("#result").html(xhr.responseText);
                            }
                        }
                        else{
                            $("#result").html("<div class='alert alert-danger'>"+thrownError+"</div>");
                        }
					}
				});
        });
    });
    
    </script>
@endpush