<form action="" class="article-create-form col-md-12 m-auto border rounded form-group p-3">
    <h3 class="text-center">發表文章</h3>
        <div class='p-2'>
            <label for="">標題：</label>
            <input type="text" name='title' id='title' class="article-title-input form-control">
        </div>
        <div class='p-2'>
            <label for="">文章內容：</label>
            <textarea name="content" id="post" class="article-content-input form-control" style="height:300px"></textarea>
        </div>
        <div class="text-center p-2">
            <button class="article-submit-button btn btn-primary" type='button' onclick='send()'>發佈</button>
        </div>
    </form>

    <script>
        function send(){
            let article={
                'title':$("#title").val(),
                'content':$("#post").val()
            }
           // console.log(article)
            $.post("./api/add_article.php",article,function(res){
               // console.log(res)
                if(parseInt(res)){
                    alert("發表成功")
                    loadpage(`./front/article.php?id=${res}`);
                    //loadpage('/front/article.php?id='+res);
                }else{
                    alert("發表失敗")
                }
            })


        }
    </script>