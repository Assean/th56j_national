<header class="d-flex justify-content-between p-4 border">
        <div>
            <img style='width:35px' src=".//icon/logo.png" alt="">
           <a href="index.php">FunTech社群網站</a>
        </div>
        <div>
            <a href="admin.php">系統管理</a>
            <a href="api/logout.php" class="ml-3">登出</a> 
        </div>
    </header>
    <nav class="d-flex justify-content-start p-3">
        <span class="m-btn btn btn-light m-2 p-2" data-btn="routes" onclick="loadpage(this)">路線管理</span>
        <span class="m-btn btn btn-light m-2 p-2" data-btn="buses" onclick="loadpage(this)">車輛管理</span>
        <span class="m-btn btn btn-light m-2 p-2" data-btn="stations" onclick="loadpage(this)">站點管理</span>
        <span class="m-btn btn btn-light m-2 p-2" data-btn="forms" onclick="loadpage(this)">表單管理</span>
    </nav>
    <script>
        $(function() {
            loadpage($("span[data-btn='routes']")[0]);
        });
        function loadpage(dom){
            if(!dom) return; 

            let btn = $(dom).data('btn');
            let page = "back/" + btn + "_manage.php";
            
            $.get(page, function(r){
                $("#PageContent").html(r);
                $(".m-btn").removeClass("active");
                $(dom).addClass('active');
            });
        }
    </script>