<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Sign Up</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input id="email" placeholder="User Email" class="form-control" type="email"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="firstName" placeholder="First Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastName" placeholder="Last Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control" type="password"/>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onRegistration()" class="btn mt-3 w-100  bg-gradient-primary">Complete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


  async function onRegistration() {
    let Email = document.getElementById('email').value;
    let FirstName =document.getElementById('firstName').value;
    let LastName =document.getElementById('lastName').value;
    let Password =document.getElementById('password').value;
    let Mobile =document.getElementById('mobile').value;

    if(Email.length===0){
        errorToast('Email is required')
    }else if(FirstName.length===0){
        errorToast('First Name is required')
    }else if(LastName.length===0){
        errorToast('Last Name is required')
    }else if(
        Password.length===0){
        errorToast('Password is required')
    }else if(Mobile.length===0){
        errorToast('Mobile No is required')
    }else{
        showLoader();
        let res = await axios.post("/user-registration",{
             email:Email,
             firstName:FirstName,
             lastName:LastName,
             password:Password,
             mobile:Mobile
            });
            hideLoader(); //ajax request ses hoye gele loader ta hide hoye jabe
        if(res.status===200 && res.data['status']==='Success')   {
            successToast(res.data['messege']);
            //window.location.href="/user-login";
            setTimeout(function(){
                window.location.href="/userLogin"
            },2000)
        } else{
            errorToast(res.data['messege']);
        }
    }
  }
      
</script>
