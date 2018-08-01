
<?php
  header('content-type:text/html;charset=utf-8');
  include './tools/tools.php';
  // 查询分类数据
  // 渲染页面
  $cateData = my_SELECT("select * from categories");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="./css/post.css" rel="stylesheet">
    <script src="./js/jquery-1.7.1.min.js"></script>
</head>
<body>
    <section id="NavBox" class="navbox">
		<nav>
			<a  class="logo" href="index.php"><h2><strong class="htxt">DMTiming</strong></h2></a>
			<ul class="navmain" id="navMenu">
                <li><a href="index.php">HOME</a></li>
                <?php for($i=0;$i<count($cateData);$i++): ?>
                    <li typeId="<?php echo $cateData[$i][0]; ?>"><a href="index.php?typeId=<?php echo $cateData[$i][0]; ?>"><?php echo $cateData[$i][1]; ?></a></li>
                <?php endfor; ?>
			</ul>
        </nav>
        <p class="weixin">微信公众号</p>
		<img class="qrcode" src="images/qrcode.jpg" width="100" height="100">
		<aside class="links">
			<h2 class="friendlink">友情链接</h2>
			<ul class="navfri">
				<li><a href="#" target="_blank">Tencent CDC</a></li>
				<li><a href="#" target="_blank">Tencent ISUX</a></li>
			</ul>
            <aside>
            </aside>
        </aside>
    </section>
    <div class="main">
        <a href="index.php" class="close" onclick=""></a>
        <section class="content">
            <header class="hd">
                <h2>标题标题标题标题标题标题标题标题</h2>
                <p>类型<span class="type">项目</span>时间 <span class="time">2018-6-7</span></p>
            </header>
            <section class="bh"></section>
        </section>
        <footer class="footer">
            <p></p>
            <p>Copyright © 2017-2018 yundoma 版权所有.<a style="color:#7B7B7B;" href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备17157498号</a></p>
        </footer>
    </div>
</body>
</html>
<script>
     var getId=window.location.search.split("=")[1];
    if(getId){
        $.ajax({
            url:'http://localhost:4560/hm/baixiu/admin/API/13.getPostById.php',
            data:{
            id:getId
            },
            type:"post",
            success:function(backData){
                console.log(backData);
                $(".hd h2").html(backData.data[0][2]);
                $(".hd .type").html(backData.data[0][21]);
                $(".hd .time").html(backData.data[0][4]);
                $(".bh").html(backData.data[0][5]);
                //$('#title').val(backData.data[0][2]);
                //editor2.txt.html(backData.data[0][5]);
            //     $('#slug').val(backData.data[0][1]);
            //     $('#category').val(backData.data[0][10]);
            //     $('#status').val(backData.data[0][8]);
                
            //     $('.help-block').attr('src',".."+backData.data[0][3]).show();
            }
        });
    }
</script>