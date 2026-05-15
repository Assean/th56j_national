<form action="" class="login-form form-group w-50 m-auto">
    <h2 class="text-center">會員登入</h2>
    <div class='my-2'>
        <label for="">帳號：</label>
        <input type="text" name='username' id='username' class="form-control username-input">
    </div>
    <div class='my-2'>
        <label for="">密碼：</label>
        <input type="password" name="password" id="password" class="form-control password-input">
    </div>
    <div class='my-2 text-center'>
        <button type='button' class="login-submit-button btn btn-primary btn-lg">登入</button>
    </div>
</form>

<script>
$(".login-submit-button").on("click",function(){
    
 $.post("./api/login.php",{
    'username':$("#username").val(),
    'password':$("#password").val()
 },function(res){
    //console.log(res)
     if(parseInt(res)){
         //loadpage('./front/main.php')
         location.reload();
     }else{
         alert("帳號或密碼錯誤,請重新登入");
         $("#username,#password").val("")
         
     }
 })
})
</script>