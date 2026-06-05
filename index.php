<?php include_once "api/db.php"; ?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FunTech</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="./assets/css/index.css">
</head>
<body>
<div id="app">
  <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm sticky-top">
    <a class="navbar-brand d-flex align-items-center" href="#" @click.prevent="go('home')">
      <img src="./assets/img/logo.png" alt="FunTech" width="36" height="36" class="rounded-circle mr-2" style="object-fit:cover">
      <span class="font-weight-bold">FunTech</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="#" @click.prevent="go('home')">🏠 首頁</a></li>
        <li class="nav-item"><a class="nav-link" href="#" @click.prevent="go('games')">🎮 遊戲</a></li>
        <li class="nav-item"><a class="nav-link" href="#" @click.prevent="go('friends')">👥 好友</a></li>
      </ul>
      <div class="d-flex">
        <?php if (!isset($_SESSION['user'])): ?>
          <a href="#" class="btn btn-outline-light btn-sm mr-2" @click.prevent="go('login')">登入</a>
          <a href="#" class="btn btn-success btn-sm" @click.prevent="go('register')">註冊</a>
        <?php else: ?>
          <a href="#" class="btn btn-outline-light btn-sm mr-2" @click.prevent="go('profile')">個人頁面</a>
          <a href="./api/logout.php" class="btn btn-danger btn-sm">登出</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <div id="home" class="container-fluid px-0">
    <div class="p-3">

      <!-- 首頁 -->
      <template v-if="page==='home'">
        <ul class="nav nav-tabs mb-3" id="homeTabs">
          <li class="nav-item"><a class="nav-link" :class="{active:tab==='articles'}" href="#" @click.prevent="tab='articles'">📰 文章</a></li>
          <li class="nav-item"><a class="nav-link" :class="{active:tab==='notifications'}" href="#" @click.prevent="tab='notifications'">📢 公告</a></li>
        </ul>
        <section v-show="tab==='articles'">
          <h4 class="mb-3">文章列表</h4>
          <template v-if="articles.length">
            <div v-for="a in articles" :key="a.id" class="card mb-3 article-item border-0 shadow-sm">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-1">
                  <h6 class="card-title font-weight-bold mb-0">{{a.title}}</h6>
                  <small class="text-muted ml-2 text-nowrap">{{a.created_at}}</small>
                </div>
                <p class="card-text text-muted small mb-2">{{a.content.slice(0,60)}}...</p>
                <div class="d-flex justify-content-between align-items-center">
                  <small class="text-secondary">by {{a.username||'未知作者'}}</small>
                  <a href="#" class="btn btn-outline-primary btn-sm" @click.prevent="go('article',{id:a.id})">閱讀更多</a>
                </div>
              </div>
            </div>
          </template>
          <div v-else class="text-center text-muted py-5"><i class="h4">📭</i><p>目前尚無文章</p></div>
        </section>
        <section v-show="tab==='notifications'">
          <h4 class="mb-3">公告事項</h4>
          <div v-for="i in 5" :key="i" class="card mb-2 border-left border-warning" style="border-left-width:4px!important">
            <div class="card-body py-2">
              <div class="d-flex justify-content-between align-items-center">
                <span class="font-weight-bold">📌 公告事項 {{i}}</span>
                <small class="text-muted">{{now}}</small>
              </div>
            </div>
          </div>
        </section>
      </template>

      <!-- 文章詳情 -->
      <template v-else-if="page==='article'">
        <div class="row justify-content-center mt-4">
          <div class="col-md-8">
            <div class="card shadow border-0">
              <div class="card-body p-4" v-if="article">
                <h3 class="font-weight-bold text-center mb-2">{{article.title}}</h3>
                <p class="text-right text-muted small border-bottom pb-2">發文日期：{{article.created_at}}</p>
                <div class="article-body mt-3" style="line-height:1.8" v-html="nl2br(article.content)"></div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- 發文 -->
      <template v-else-if="page==='add-article'">
        <div class="row justify-content-center mt-4">
          <div class="col-md-8">
            <div class="card shadow border-0">
              <div class="card-header bg-white border-bottom"><h5 class="mb-0 font-weight-bold">✏️ 發表文章</h5></div>
              <div class="card-body p-4">
                <div class="form-group">
                  <label class="font-weight-bold">標題</label>
                  <input type="text" v-model="form.title" class="form-control" placeholder="請輸入文章標題">
                </div>
                <div class="form-group">
                  <label class="font-weight-bold">文章內容</label>
                  <textarea v-model="form.content" class="form-control" style="height:280px" placeholder="請輸入文章內容..."></textarea>
                </div>
                <div class="text-right">
                  <button class="btn btn-secondary mr-2" @click="go('profile')">取消</button>
                  <button class="btn btn-primary" @click="addArticle">🚀 發佈</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- 登入 -->
      <template v-else-if="page==='login'">
        <div class="row justify-content-center mt-5">
          <div class="col-md-5 col-sm-8">
            <div class="card shadow border-0">
              <div class="card-body p-4">
                <h4 class="text-center font-weight-bold mb-4">🔐 會員登入</h4>
                <div class="form-group"><label>帳號</label><input type="text" v-model="form.username" class="form-control" placeholder="請輸入帳號"></div>
                <div class="form-group"><label>密碼</label><input type="password" v-model="form.password" class="form-control" placeholder="請輸入密碼"></div>
                <button class="login-submit-button btn btn-primary btn-block mt-3" @click="login">登入</button>
                <p class="text-center mt-3 mb-0 small text-muted">還沒有帳號？<a href="#" @click.prevent="go('register')">立即註冊</a></p>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- 註冊 -->
      <template v-else-if="page==='register'">
        <div class="row justify-content-center mt-4">
          <div class="col-md-5 col-sm-8">
            <div class="card shadow border-0">
              <div class="card-body p-4">
                <h4 class="text-center font-weight-bold mb-4">📝 會員註冊</h4>
                <div class="form-group"><label>帳號</label><input type="text" v-model="form.username" class="form-control" placeholder="請輸入帳號"></div>
                <div class="form-group"><label>電子郵件</label><input type="email" v-model="form.email" class="form-control" placeholder="請輸入 Email"></div>
                <div class="form-group"><label>密碼</label><input type="password" v-model="form.password" class="form-control" placeholder="請輸入密碼"></div>
                <div class="form-group"><label>確認密碼</label><input type="password" v-model="form.chkpassword" class="form-control" placeholder="再次輸入密碼"></div>
                <button class="register-submit btn btn-success btn-block mt-3" @click="register">註冊</button>
                <p class="text-center mt-3 mb-0 small text-muted">已有帳號？<a href="#" @click.prevent="go('login')">立即登入</a></p>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- 個人頁面 -->
      <template v-else-if="page==='profile'">
        <div class="row justify-content-center mt-4">
          <div class="col-md-8">
            <div class="card shadow border-0 mb-4">
              <div class="card-body text-center p-4">
                <label for="header" style="cursor:pointer" title="點擊更換頭像">
                  <img :src="profileUser.header?'./img/'+profileUser.header:'./img/default_header.jpg'" class="profile-avatar mb-2" style="width:100px;height:100px">
                  <div class="small text-muted">點擊更換頭像</div>
                  <input type="file" id="header" style="display:none" @change="uploadAvatar">
                </label>
                <h5 class="font-weight-bold mt-2">{{profileUser.username}}</h5>
                <div class="d-inline-block bg-info text-white rounded px-3 py-2 mt-1" style="cursor:pointer" @click="editingBio=true" v-if="!editingBio">
                  {{profileUser.bio||'尚未填寫自我介紹'}}
                </div>
                <input v-if="editingBio" type="text" v-model="form.bio" class="form-control w-50 mx-auto mt-1" @keydown.enter="saveBio" @blur="editingBio=false">
                <div class="small text-muted mt-1">點擊簡介可編輯，按 Enter 儲存</div>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="font-weight-bold mb-0">📝 我的文章</h5>
              <a href="#" class="btn btn-primary btn-sm" @click.prevent="go('add-article')">✏️ 發表文章</a>
            </div>
            <template v-if="myArticles.length">
              <div v-for="a in myArticles" :key="a.id" class="card mb-2 border-0 shadow-sm article-item">
                <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                  <div><span class="font-weight-bold">{{a.title}}</span><small class="text-muted ml-2">{{a.created_at}}</small></div>
                  <a href="#" class="btn btn-outline-secondary btn-sm" @click.prevent="go('article',{id:a.id})">閱讀</a>
                </div>
              </div>
            </template>
            <div v-else class="text-center text-muted py-4">目前尚無文章，快來發表第一篇吧！</div>
          </div>
        </div>
      </template>

      <!-- 遊戲列表 -->
      <template v-else-if="page==='games'">
        <div class="py-4">
          <h4 class="text-center font-weight-bold mb-4">🎮 遊戲列表</h4>
          <div class="row px-2">
            <div v-for="g in games" :key="g.id" class="col-12 col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm border-0">
                <img :src="g.cover" :alt="g.title" class="card-img-top" style="object-fit:cover;aspect-ratio:16/9">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title font-weight-bold text-center">{{g.title}}</h5>
                  <p class="card-text text-muted small flex-grow-1">{{g.description}}</p>
                  <a href="#" class="btn btn-success btn-block mt-2" @click.prevent="go('game-play',{id:g.id})">▶ 開始遊戲</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- 遊戲進行 -->
      <template v-else-if="page==='game-play'">
        <div class="py-4" v-if="currentGame">
          <h4 class="text-center font-weight-bold mb-4">🕹️ {{currentGame.title}}</h4>
          <div class="card shadow border-0 rounded-lg overflow-hidden mx-auto mb-4" style="max-width:800px">
            <div class="card-body p-0 bg-dark">
              <iframe :src="currentGame.entryUrl" frameborder="0" scrolling="no" class="d-block w-100" style="height:600px;overflow:hidden"></iframe>
            </div>
          </div>
          <div class="card shadow border-0 rounded-lg mx-auto" style="max-width:800px">
            <div class="card-header bg-primary text-white text-center py-3">
              <h5 class="m-0 font-weight-bold">🏆 {{currentGame.title}} 排行榜</h5>
            </div>
            <div class="card-body p-0">
              <div class="row text-center bg-light text-muted font-weight-bold py-2 border-bottom mx-0">
                <div class="col-3">排名</div><div class="col-6">玩家</div><div class="col-3">分數</div>
              </div>
              <template v-if="leaderboard.length">
                <div v-for="(item,idx) in leaderboard" :key="idx" class="row text-center align-items-center py-3 border-bottom mx-0">
                  <div class="col-3"><span :class="'badge badge-pill badge-'+(idx===0?'warning':idx===1?'light border':idx===2?'danger':'secondary')+' px-3 py-2'">{{idx+1}}</span></div>
                  <div class="col-6 font-weight-bold">{{item['玩家名稱']}}</div>
                  <div class="col-3 text-primary font-weight-bold">{{item['分數']}}</div>
                </div>
              </template>
              <div v-else class="text-center py-5 text-muted"><p class="mb-1 h5">目前尚無分數紀錄</p><small>快來成為第一名！</small></div>
            </div>
          </div>
        </div>
      </template>

      <!-- 好友頁面 -->
      <template v-else-if="page==='friends'">
        <div class="py-4">
          <div class="card shadow border-0 mb-4">
            <div class="card-body">
              <h5 class="font-weight-bold mb-3">🔍 搜尋使用者</h5>
              <div class="input-group">
                <input type="text" v-model="form.search" class="form-control" placeholder="輸入帳號或名稱搜尋...">
                <div class="input-group-append"><button class="search-submit-button btn btn-primary" @click="searchUsers">搜尋</button></div>
              </div>
              <div class="mt-3">
                <div v-for="u in searchResults" :key="u.id" class="search-result-item d-flex justify-content-between my-1 col-md-10">
                  <div class="result-username">{{u.username}}</div>
                  <a href="#" class="view-profile-link" @click.prevent="go('friend-profile',{id:u.id})">查看個人頁面</a>
                </div>
                <div v-if="searchResults.length===0&&searched" class="search-result-item d-flex justify-content-between my-1 col-md-10">
                  <div class="result-username">查無符合的好友名單</div>
                </div>
              </div>
            </div>
          </div>
          <div class="card shadow border-0 mb-4">
            <div class="card-header bg-white border-bottom"><h5 class="mb-0 font-weight-bold">👥 好友列表</h5></div>
            <div class="card-body"><div class="row">
              <div v-for="f in friends" :key="f.id" class="col-6 col-md-3 mb-3 text-center" style="cursor:pointer" @click="go('friend-profile',{id:f.id})">
                <img :src="'./img/'+f.header" class="friend-avatar mb-1" style="width:64px;height:64px">
                <div class="small font-weight-bold">{{f.username}}</div>
              </div>
            </div></div>
          </div>
          <div class="card shadow border-0 mb-4">
            <div class="card-header bg-white border-bottom"><h5 class="mb-0 font-weight-bold">📥 收到的好友申請</h5></div>
            <div class="card-body"><div class="row">
              <div v-for="r in incomingRequests" :key="r.id" class="col-6 col-md-3 mb-3 text-center">
                <img :src="'./img/'+r.header" class="request-avatar mb-1" style="width:64px;height:64px">
                <div class="small font-weight-bold mb-1">{{r.username}}</div>
                <button class="btn btn-success btn-sm mr-1" @click="setFriend('accept',r.id)">接受</button>
                <button class="btn btn-outline-warning btn-sm" @click="setFriend('reject',r.id)">拒絕</button>
              </div>
            </div></div>
          </div>
          <div class="card shadow border-0">
            <div class="card-header bg-white border-bottom"><h5 class="mb-0 font-weight-bold">📤 發送的好友申請</h5></div>
            <div class="card-body"><div class="row">
              <div v-for="r in outgoingRequests" :key="r.id" class="col-6 col-md-3 mb-3 text-center">
                <img :src="'./img/'+r.header" class="request-avatar mb-1" style="width:64px;height:64px">
                <div class="small font-weight-bold mb-1">{{r.username}}</div>
                <button class="btn btn-outline-danger btn-sm" @click="setFriend('cancel',r.id)">取消申請</button>
              </div>
            </div></div>
          </div>
        </div>
      </template>

      <!-- 好友個人頁面 -->
      <template v-else-if="page==='friend-profile'">
        <div class="row justify-content-center mt-4" v-if="friendUser">
          <div class="col-md-8">
            <div class="card shadow border-0 mb-4">
              <div class="card-body text-center p-4">
                <img :src="friendUser.header?'./img/'+friendUser.header:'./img/default_header.jpg'" class="profile-avatar mb-2" style="width:100px;height:100px">
                <h5 class="font-weight-bold mt-2">{{friendUser.username}}</h5>
                <div class="badge badge-info p-2 mt-1">{{friendUser.bio||'尚未填寫自我介紹'}}</div>
                <div class="mt-3">
                  <template v-if="!friendRelation.exists">
                    <button class="btn btn-primary" @click="setFriend('apply',friendUser.id)">＋ 申請好友</button>
                  </template>
                  <template v-else-if="friendRelation.isRequester">
                    <button class="btn btn-outline-secondary" @click="setFriend('cancel',friendUser.id)">取消申請</button>
                  </template>
                  <template v-else-if="friendRelation.isAddressee">
                    <button class="btn btn-success mr-2" @click="setFriend('accept',friendUser.id)">接受好友</button>
                    <button class="btn btn-outline-warning" @click="setFriend('reject',friendUser.id)">拒絕</button>
                  </template>
                  <template v-else-if="friendRelation.isFriend">
                    <span class="badge badge-success p-2 mr-2">✓ 已是好友</span>
                    <button class="btn btn-outline-danger btn-sm" @click="setFriend('remove',friendUser.id)">取消好友</button>
                  </template>
                </div>
              </div>
            </div>
            <h5 class="font-weight-bold mb-3">📝 TA 的文章</h5>
            <template v-if="friendArticles.length">
              <div v-for="a in friendArticles" :key="a.id" class="card mb-2 border-0 shadow-sm article-item">
                <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                  <div><span class="font-weight-bold">{{a.title}}</span><small class="text-muted ml-2">{{a.created_at}}</small></div>
                  <a href="#" class="btn btn-outline-secondary btn-sm" @click.prevent="go('article',{id:a.id})">閱讀</a>
                </div>
              </div>
            </template>
            <div v-else class="text-center text-muted py-4">目前尚無文章</div>
          </div>
        </div>
      </template>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const {createApp,ref,reactive,computed,onMounted,watch}=Vue;
createApp({
  setup(){
    const page=ref('home'),tab=ref('articles');
    const form=reactive({title:'',content:'',username:'',password:'',email:'',chkpassword:'',search:'',bio:''});
    const articles=ref([]),myArticles=ref([]),article=ref(null);
    const games=ref([]),currentGame=ref(null),leaderboard=ref([]);
    const profileUser=ref({}),editingBio=ref(false);
    const friends=ref([]),incomingRequests=ref([]),outgoingRequests=ref([]);
    const friendUser=ref(null),friendRelation=reactive({}),friendArticles=ref([]);
    const searchResults=ref([]),searched=ref(false);
    const now=new Date().toLocaleString('zh-TW');

    function api(url,data,method='GET'){
      if(method==='POST'){
        const body=new URLSearchParams(data);
        return fetch(url,{method:'POST',body}).then(r=>r.text());
      }
      const q=data?'?'+new URLSearchParams(data):'';
      return fetch(url+q).then(r=>r.json()).catch(()=>fetch(url+q).then(r=>r.text()));
    }

    async function go(p,params={}){
      page.value=p;
      Object.assign(form,{title:'',content:'',username:'',password:'',email:'',chkpassword:'',search:'',bio:''});
      searched.value=false; searchResults.value=[];
      if(p==='home') await loadArticles();
      if(p==='article'){ const res=await fetch('./api/get_article.php?id='+params.id).then(r=>r.json()); article.value=res; }
      if(p==='games') await loadGames();
      if(p==='game-play') await loadGame(params.id);
      if(p==='profile') await loadProfile();
      if(p==='friends') await loadFriends();
      if(p==='friend-profile') await loadFriendProfile(params.id);
    }

    async function loadArticles(){
      articles.value=await fetch('./api/get_articles.php').then(r=>r.json());
    }
    async function loadGames(){
      games.value=await fetch('./api/get_games.php').then(r=>r.json());
    }
    async function loadGame(id){
      const [game,ranks]=await Promise.all([
        fetch('./api/get_game.php?id='+id).then(r=>r.json()),
        fetch('./api/get_game.php?id='+id).then(r=>r.json()).then(g=>fetch(g.pullUrl).then(r=>r.json()).catch(()=>[]))
      ]);
      currentGame.value=game;
      const lb=await fetch(game.pullUrl).then(r=>r.json()).catch(()=>[]);
      leaderboard.value=lb;
    }
    async function loadProfile(){
      profileUser.value=await fetch('./api/get_profile.php').then(r=>r.json());
      myArticles.value=await fetch('./api/get_my_articles.php').then(r=>r.json());
      form.bio=profileUser.value.bio||'';
    }
    async function loadFriends(){
      const data=await fetch('./api/get_friends.php').then(r=>r.json());
      friends.value=data.friends||[];
      incomingRequests.value=data.incoming||[];
      outgoingRequests.value=data.outgoing||[];
    }
    async function loadFriendProfile(id){
      const data=await fetch('./api/get_friend_profile.php?id='+id).then(r=>r.json());
      friendUser.value=data.user;
      Object.assign(friendRelation,data.relation);
      friendArticles.value=data.articles;
    }

    async function login(){
      const res=await api('./api/login.php',{username:form.username,password:form.password},'POST');
      if(parseInt(res)) location.reload();
      else{ alert('帳號或密碼錯誤，請重新登入'); form.username=form.password=''; }
    }
    async function register(){
      if(form.password!==form.chkpassword){ alert('兩次密碼不一致，請重新輸入'); return; }
      const res=await api('./api/register.php',{username:form.username,password:form.password,email:form.email},'POST');
      if(parseInt(res)) go('login'); else alert('註冊失敗，請重新嘗試');
    }
    async function addArticle(){
      const res=await api('./api/add_article.php',{title:form.title,content:form.content},'POST');
      if(parseInt(res)){ alert('發表成功'); go('article',{id:res}); } else alert('發表失敗');
    }
    async function saveBio(){
      const res=await api('./api/update_bio.php',{text:form.bio},'POST');
      if(parseInt(res)){ profileUser.value.bio=form.bio; editingBio.value=false; } else alert('簡介更新失敗');
    }
    async function uploadAvatar(e){
      const file=e.target.files[0]; if(!file) return;
      const reader=new FileReader();
      reader.onload=async ev=>{
        const res=await api('./api/update_avatar.php',{imgString:ev.target.result},'POST');
        if(parseInt(res)) profileUser.value.header=profileUser.value.username+(file.name.match(/\.\w+$/) || ['.jpg'])[0];
        else alert('頭像上傳失敗');
      };
      reader.readAsDataURL(file);
    }
    async function searchUsers(){
      searched.value=true;
      searchResults.value=await fetch('./api/search_users.php?search='+form.search).then(r=>r.json());
    }
    async function setFriend(action,friend_id){
      const res=await fetch('./api/set_friend.php?action='+action+'&friend_id='+friend_id).then(r=>r.json());
      if(res.success){
        alert(res.message);
        if(page.value==='friends') await loadFriends();
        if(page.value==='friend-profile') await loadFriendProfile(friend_id);
      } else alert('操作失敗');
    }
    function nl2br(str){ return str?str.replace(/\n/g,'<br>'):'' }

    onMounted(()=>go('home'));
    return {page,tab,form,articles,myArticles,article,games,currentGame,leaderboard,
            profileUser,editingBio,friends,incomingRequests,outgoingRequests,
            friendUser,friendRelation,friendArticles,searchResults,searched,now,
            go,login,register,addArticle,saveBio,uploadAvatar,searchUsers,setFriend,nl2br};
  }
}).mount('#app');
</script>
</body>
</html>
