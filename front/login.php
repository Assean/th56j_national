<div class="row justify-content-center mt-5">
  <div class="col-md-5 col-sm-8">
    <div class="card shadow border-0">
      <div class="card-body p-4">
        <h4 class="text-center font-weight-bold mb-4">🔐 會員登入</h4>
        <form class="login-form">
          <div class="form-group"><label>帳號</label><input type="text" class="username-input form-control" placeholder="請輸入帳號"></div>
          <div class="form-group"><label>密碼</label><input type="password" class="password-input form-control" placeholder="請輸入密碼"></div>
          <button type="button" class="login-submit-button btn btn-primary btn-block mt-3">登入</button>
        </form>
        <p class="text-center mt-3 mb-0 small text-muted">還沒有帳號？<a href="javascript:loadpage('front/register.php')">立即註冊</a></p>
      </div>
    </div>
  </div>
</div>
<script>
$(".login-submit-button").on("click",function(){
  $.post("api/login.php",{username:$(".username-input").val(),password:$(".password-input").val()},function(r){
    if(parseInt(r))location.reload();
    else{alert("帳號或密碼錯誤，請重新登入");$(".username-input,.password-input").val("");}
  });
});
</script>
