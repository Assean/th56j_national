<div class="row justify-content-center mt-4">
  <div class="col-md-5 col-sm-8">
    <div class="card shadow border-0">
      <div class="card-body p-4">
        <h4 class="text-center font-weight-bold mb-4">📝 會員註冊</h4>
        <form class="register-form">
          <div class="form-group"><label>帳號</label><input type="text" class="username-input form-control" placeholder="請輸入帳號"></div>
          <div class="form-group"><label>電子郵件</label><input type="email" class="email-input form-control" placeholder="請輸入 Email"></div>
          <div class="form-group"><label>密碼</label><input type="password" class="password-input form-control" placeholder="請輸入密碼"></div>
          <div class="form-group"><label>確認密碼</label><input type="password" class="password-confirm-input form-control" placeholder="再次輸入密碼"></div>
          <button type="button" class="register-submit btn btn-success btn-block mt-3">註冊</button>
        </form>
        <p class="text-center mt-3 mb-0 small text-muted">已有帳號？<a href="javascript:loadpage('front/login.php')">立即登入</a></p>
      </div>
    </div>
  </div>
</div>
<script>
$(".register-submit").on("click",function(){
  if($(".password-input").val()===$(".password-confirm-input").val()){
    $.post("api/register.php",{username:$(".username-input").val(),password:$(".password-input").val(),email:$(".email-input").val()},function(r){
      if(parseInt(r))loadpage("front/login.php");
      else alert("註冊失敗，請重新嘗試");
    });
  }else alert("兩次密碼不一致，請重新輸入");
});
</script>
