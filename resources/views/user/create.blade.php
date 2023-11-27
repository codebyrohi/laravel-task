<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>User Create Form</h4>
                </div>
                <div class="card-body">
                <form id="frm_create_user" enctype="multipart/form-data" method="post" action="{{ $module_url_path.'/store' }}">
                      {{ csrf_field() }}
                        <div class="form-group">
                            <label for="username">Name</label>
                            <input type="text" placeholder="Enter your name" name="name" id="name" data-rule-required="true" data-rule-maxlength="255" data-rule-lettersonly="true" class="form-control">
                            <div class="authError">{{ $errors->first('name') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" placeholder="Enter your email" name="email" id="email" data-rule-required="true" data-rule-email="true" class="form-control">
                            <div class="authError">{{ $errors->first('email') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="mobile_no">Mobile No</label>
                            <input type="number" placeholder="Enter your mobile no" name="mobile_no" id="mobile_no" data-rule-maxlength="10" data-rule-minlength="10" data-rule-required="true"  class="form-control">
                            <div class="authError">{{ $errors->first('mobile_no') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                           <input type="password"  placeholder="Enter Password"  name="password" data-rule-required="true" data-rule-min="6" id="password" class="form-control">
                          <div class="authError">{{ $errors->first('password') }}</div>
                        </div>
                        <div class="form-group">
                        <label for="file">Profile Image</label>
                        <div class="col-sm-6">
                          <input type="file" data-rule-required="true" name="image" class="form-control">
                            <div class="authError">{{ $errors->first('image') }}</div>
                        </div>
                      </div>
                        <button type="submit" id="btnAppSubmit" class="btn btn-primary btn-block">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 <script type="text/javascript">
if (jQuery().validate) {
    var $validator = $('#frm_create_user').validate({
        errorClass: "authError",
        ignore: [],
        errorElement: 'div',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error)
          } else {
            error.insertAfter(element);
          }
        }
    });
} 
/*$('#frm_create_user').on("submit",function(e){
   
    if(!$("#frm_create_user").valid())
    {
      return false;
    }
    else 
    {
          e.preventDefault();
          var formData = new FormData(this);
          $.ajax({
                  type: "POST",
                  url: "{{ $module_url_path }}/ajaxStore",
                  data:formData,
                  success: function(response){
                    Swal.fire({
                        icon: response.status,
                        title: response.status,
                        text: response.msg,
                      })
                      if(response.status == "success")
                      {
                            setTimeout(function () {
                            location.reload(true);
                          }, 3000);
                      }
                  },
                  cache: false,
                  contentType: false,
                  processData: false
          }); 
    }
    return true;
});*/

</script> 
