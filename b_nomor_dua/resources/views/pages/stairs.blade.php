@extends('layouts.basic')

@section('title', 'Soal Nomor 2')


@section('content')
<div class="row">
    <div class="col-md-5">
        <form id="form">
            <div class="form-group row">
                <label for="" class="control-label col-md-3">N</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="n">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-9 offset-md-3">
                <button type="submit" class="btn btn-success">Submit</button>
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
        $("#form").on("submit", function(e){
                var formdata=new FormData(this);
                formdata.append('_token','{{csrf_token()}}');
                e.preventDefault();
				$.ajax({
					url: "{{url('/possibility')}}",
					type: "POST",
					data: formdata,
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function(){
						$("#result").html("<div class='alert alert-info'>Loading</div>");
					},
					success: function(data){
						$("#result").html(data);
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