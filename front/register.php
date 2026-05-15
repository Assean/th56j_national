<form action="" class="register-form form-group">
     <h2 class='text-center'>會員註冊</h2>
    <div class='my-2'>
        <label for="">帳號</label>    
        <input type="text" name="username" id="username" class="form-control username-input">
    </div>
    <div class='my-2'>
        <label for="">電子郵件</label>    
        <input type="email" name="email" id="email" class="form-control email-input">
    </div>
    <div class='my-2'>
        <label for="">密碼</label>    
        <input type="password" name="password" id="password" class="form-control password-input">
    </div>
    <div class='my-2'>
        <label for="">確認密碼</label>    
        <input type="password" name="chkpassword" id="chkpassword" class="form-control password-confirm-input">
    </div>
    <div class="text-center my-1">

        <button type='button' class="register-submit btn btn-primary" >註冊</button>
    </div>
</form>

<script>
$(".register-submit").on("click",function(){
    if($("#password").val()===$("#chkpassword").val()){
        $.post("./api/register.php",
            {'username':$("#username").val(),
             'password':$("#password").val(),
             'email':$("#email").val()
            },
        function(res){
            console.log(res)
            if(parseInt(res)){
                loadpage("./front/login.php");
            }else{
                alert("註冊失敗,請重新註冊")
            }
        })
    }else{
        alert("密碼不正確,請重新輸入");
    }

})
</script>