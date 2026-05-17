<div id="friends-page">
    <div class="friend-search-section border rounded p-3 ">
        <form action="" class="friend-search-form form-group d-flex align-items-center">
            <label for="" class='mx-2'>搜尋使用者</label>
            <input type="text" class="search-input form-control col-md-7">
            <button class="search-submit-button btn btn-primary mx-2">尋找</button>
        </form>
        <div class="search-result-list my-2">
            <div class="search-result-item d-flex justify-content-between my-1 col-md-10">
                <div class="result-username">好友名稱</div>
                <a href="" class="view-profile-link">查看個人頁面</a>
            </div>
            <div class="search-result-item d-flex justify-content-between my-1 col-md-10">
                <div class="result-username">好友名稱</div>
                <a href="" class="view-profile-link">查看個人頁面</a>
            </div>
        </div>
    </div>
    <div class="friend-list-section w-100 border rounded p-3 my-2">
        <h3 class="section-title text-center">好友列表</h3>
        <div class="d-flex flex-wrap p-3">
            <?php for($i=0;$i<5;$i++):;?>
            <div class="friend-item col-md-3 p-2 text-center" onclick="loadpage('./front/friend-profile-page.php')">
                <img src="./img/user_01.jpg" style="width:64px;" class="friend-avatar">
                <div class="friend-name mx-3">username</div>
            </div>
            <?php endfor ;?>
        </div>
    </div>
    <div class="incoming-requests-section border rounded p-3 my-2 ">
        <h3 class="section-title text-center">收到的好友申請</h3>
        <div class="d-flex flex-wrap p-3">
            <?php for($i=0;$i<5;$i++):;?>
            <div class="request-item col-md-3 p-2 text-center">
                <img src="./img/user_02.jpg" style="width:64px;" class="request-avatar">
                <div class="request-username">username</div>
                <div>
                    <button class="accept-request-button btn btn-success btn-sm">接受好友</button>
                    <button class="reject-request-button btn btn-warning btn-sm">拒絕好友</button>
                </div>
            </div>
            <?php endfor;?>
        </div>
    </div>
    <div class="sent-requests-section border rounded p-3 my-2">
        <h3 class="section-title text-center">發送的好友申請</h3>
        <div class="d-flex flex-wrap p-3">
            <?php for($i=0;$i<5;$i++):;?>
            <div class="request-item col-md-3 p-2 text-center">
                <img src="./img/user_03.jpg" style="width:64px" class="request-avatar">
                <div class="request-username">username</div>
                <button class="cancel-request-button btn btn-warning btn-sm">取消申請</button>
            </div>
            <?php endfor;?>
        </div>
    </div>
    
</div>