
<?php
  header('content-type:text/html;charset=utf-8');
  include './tools/tools.php';
  $sql="select * from posts where status='published' order by id desc limit 16";
  $data=my_SELECT($sql);
  //var_dump($data);

  // 查询轮播图的数据
  //$slideDataJSON=my_SELECT("select * from options where id=10")[0][2];
  //$slideData=json_decode($slideDataJSON,true);

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
    <link href="./css/index.css" rel="stylesheet">
    <script src="./js/jquery-1.7.1.min.js"></script>
</head>
<body>
    <section id="NavBox" class="navbox">
		<nav>
			<a  class="logo" href="index.php"><h2><strong class="htxt">DMTiming</strong></h2></a>
			<ul class="navmain" id="navMenu">
                <li><a href="index.php">HOME</a></li>
                <?php for($i=0;$i<count($cateData);$i++): ?>
                    <li typeId="<?php echo $cateData[$i][0]; ?>"><a href="javascript:;"><?php echo $cateData[$i][1]; ?></a></li>
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
    <section class="main">
        <nav>
            <ul class="nav clearfix">
                <li typeId="" id="navfirstli"><a class="item active" href="javascript:void(0)"><span class="active">全部</span></a></li>
                <?php for($i=0;$i<count($cateData);$i++): ?>
                    <li typeId="<?php echo $cateData[$i][0]; ?>"><a class="item" href="javascript:void(0)"><span><?php echo $cateData[$i][2]; ?></span></a></li>
                <?php endfor; ?>
            </ul>
        </nav>
        <section>
            <ul class="items clearfix" id="itemsList">
            </ul>

        </section>
        <nav class="clearfix">
            <ul class="pager">
                <li class="pagerlist">
                    <a href="javascript:void(0)" class="pagerlink pagePrev" id="pagePrev">
                        <span class="hidden">上一页</span>
                    </a>
                </li>
                <li class="pagerlist">
                    <a href="javascript:void(0)" class="pagerlink pageNext" id="pageNext">
                        <span class="hidden">下一页</span>
                    </a>
                </li>
            </ul>
        </nav>
        <footer class="footer">
            <p></p>
            <p>Copyright © 2017-2018 yundoma 版权所有.<a style="color:#7B7B7B;" href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备17157498号</a></p>

        </footer>
    </section>
</body>
</html>
<script src="./assets/vendors/template-web/template-web.js"></script>
<script type="text/html" id="liTem">
    {{each items}}
    <li postId="{{$value[0]}}" class="itemslist fl">
        <a class="itemsa" target="_blank" href="post.php?postId={{$value[0]}}">
            <span class="img-box"><img src=".{{$value[6]}}"></span>
            <div class="itemstxt">		
                <h2 class="itemstitle">{{$value[1]}}</h2>
                <p class="itemsintro"></p>
            </div>
            <div class="itemsbox">
                <p class="itemsinfo">
                    <strong class="time">TYPE<span>{{$value[3]}}</span></strong>
                </p>
            </div>
        </a>
    </li>
    {{/each}}
</script>
<script>
$(function(){
    var totalPage;
    var cur=1;
    //点击对应的分类
    $(".nav").on("click","li",function(){
        $(this).siblings().children("a").removeClass("active").children("span").removeClass("active");
        $(this).children("a").addClass("active").children("span").addClass("active");
        var category_id=$(this).attr("typeId");
        getData(1,category_id);
        cur=1;
    });
    //点击全部 隐藏其他
    $("#navfirstli").click(function () {
        $(this).siblings().children("a").removeClass("active").children("span").removeClass("active");
        $(this).children("a").addClass("active").children("span").addClass("active");
        
    });

    //获取数据
    function getData(pageNum,category_id) {
        $.ajax({
            url:'http://localhost:4560/hm/baixiu/admin/API/11.getPosts.php',
            data:{
                pageNum:pageNum,
                pageSize:18,
                category_id:category_id,
                status:''
            },
            type:"post",
            success:function(backData){
                console.log(backData);
                var result=template("liTem",backData);
                $(".main section .items").html(result);
                totalPage=backData.totalPage;
                if(category_id==""){
                    var $lif=$('<li class="firstlist fl" id="hotGg"><a target="_blank" href="#"><img src="images/163671425257536.png"><span class="h-close spr" onclick="tg.closeHotGg()"></span></a></li>');
                    $(".main section .items").prepend($lif);
                }
            }
        });
    }

    // function getFirData(pageNum) { 
    //     $.ajax({
    //         url:'http://localhost:4560/hm/baixiu/admin/API/11.getPosts.php',
    //         data:{
    //             pageNum:pageNum,
    //             pageSize:24,
    //             category_id:"",
    //             status:''
    //         },
    //         type:"post",
    //         success:function(backData){
    //             console.log(backData);
    //             var result=template("liTem",backData);
    //             $(".main section .items").html(result);
    //             var $lif=$('<li class="firstlist fl" id="hotGg"><a target="_blank" href="#"><img src="163671425257536.png"><span class="h-close spr" onclick="tg.closeHotGg()"></span></a></li>');
                
    //         }
    //     });
    // }
    getData(1,"");
    

    //点击上一页
    $("#pagePrev").click(function(){     
        var typeId=$(".nav li a.active").parent("li").attr("typeId");
        cur--;
        if(cur==0){
            alert("已经是最前面了");
            //$("#pagePrev").removeClass("active");
            cur=1;
            return;
        }        
        getData(cur,typeId);
    });
    //点击下一页
    $("#pageNext").click(function(){
        var typeId=$(".nav li a.active").parent("li").attr("typeId");
        cur++;
        if(cur>totalPage){
            alert("已经是最后面了");
            cur=totalPage
            return;
        }
        getData(cur,typeId);
    });

    //如果url上存在typeId
    var typeId=window.location.search.split("=")[1];
    if(typeId){
        console.log(typeId);
        console.log($("#navfirstli").next().attr("typeId"));
        
        $("#navfirstli~li").each(function(){
            if($(this).attr("typeId")==typeId){
                $(this).siblings().children("a").removeClass("active").children("span").removeClass("active");
                $(this).children("a").addClass("active").children("span").addClass("active");
                getData(1,typeId);
            }
        })
    }

    //边侧菜单栏
    $("#navMenu").on("click","li",function(){
        var typeId=$(this).attr("typeid");
        $("#navfirstli~li").each(function(){
            if($(this).attr("typeId")==typeId){
                $(this).siblings().children("a").removeClass("active").children("span").removeClass("active");
                $(this).children("a").addClass("active").children("span").addClass("active");
                getData(1,typeId);
            }
        })
    });




    
});
</script>