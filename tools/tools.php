<?php
    // 执行查询语句
    function my_SELECT($sql){
        // 连接数据库
        $link = mysqli_connect('127.0.0.1','root','123','baixiu');
        // sql语句
        // $sql = 
        // 执行sql语句
        $result = mysqli_query($link,$sql);
        // 解析结果
        $data = mysqli_fetch_all($result);
        // 关闭连接
        mysqli_close($link);
        return $data;
    }
    // var_dump(my_SELECT("select * from manyHero"));


    // 执行增删改语句
     function my_ZSG($sql){
        // 连接数据库
        $link = mysqli_connect('127.0.0.1','root','123','baixiu');
        // sql语句
        // $sql = 
        // 执行sql语句
       mysqli_query($link,$sql);
        // 获取行数
        $rowNum = mysqli_affected_rows($link);
        // 关闭连接
        mysqli_close($link);
        return $rowNum;
    }

    //把上传的临时文件 保存 到 $path里面。
    //返回 文件名字（不含路径）
    function my_move_upload_file($key,$path){//第一个参数：表单name的值。第二个参数：新路径/
        $fileName_GBK = iconv('utf-8','gbk',$_FILES[$key]['name']);
        move_uploaded_file($_FILES[$key]['tmp_name'],$path.$fileName_GBK);
                           //第一个参数：临时名字      //第二个参数：有新路径+文件名

        // 返回文件名
        // gbk的名字
        // utf-8的名字
        return $_FILES[$key]['name'];
    }

?>
