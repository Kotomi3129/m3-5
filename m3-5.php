<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>misson_3-5</title>
</head>
<body>
    <h1 class="midashi_1"> いまハマってることを教えて～ </h1> 
    ※投稿を編集するとき、名前とコメントだけでなくパスワードも編集できるようになってます<br>
    <br>
    <?php
     $filename = "mission_3-5.txt";
//フォーム内が空でない場合に以下を実行する
     if (!empty($_POST["name"]) && !empty($_POST["comment"])) {
      $name = $_POST["name"];//入力データの受け取りを変数に代入
      $comment = $_POST["comment"];
      $date = date("Y年m月d日 H時i分s秒");//日付データを取得して変数に代入
      $password1 = $_POST["password1"];//投稿のパスワードを取得

 // editNOがないときは新規投稿、ある場合は編集 ***ここで判断
       if (empty($_POST["editNo"])) {//editNoがないなら
 // 以下、新規投稿機能
        if (file_exists($filename)) { //ファイルの存在がある場合は投稿番号+1、なかったら1を指定する
         $num = count(file($filename)) + 1;
      } else {
         $num = 1;
      }
        $newdata = $num . "<>" . $name . "<>" . $comment . "<>" . $date . "<>". $password1;//書き込む文字列を組み合わせた変数
        $fp = fopen($filename, "a");//ファイルを追記保存モードでオープンする
        fwrite($fp, $newdata . "\n");//入力データのファイル書き込み
        fclose($fp);
    }  else {
        
 // 以下編集機能
       $editNo = $_POST["editNo"];//入力データの受け取りを変数に代入
       $ret_array = file($filename);//読み込んだファイルの中身を配列に格納する
       $fp = fopen($filename, "w"); //ファイルを書き込みモードでオープン、中身を空に
       foreach ($ret_array as $line) { //配列の数だけループさせる
        $data = explode("<>", $line);//explode関数でそれぞれの値を取得
        if ($data[0] == $editNo) {//投稿番号と編集番号が一致したら
         fwrite($fp, $editNo . "<>" . $name . "<>" . $comment . "<>" . $date . "<>". $password1 . "\n");//編集のフォームから送信された値と差し替えて上書き
      } else {
         fwrite($fp, $line);//一致しなかったところはそのまま書き込む
        }
      }
         fclose($fp);
    }
  }
  
//以下はコメントを削除するコード
    elseif(!empty($_POST)&&!empty($_POST["password2"])&&$_POST["delete"]!==""){//削除フォームが空でなくフォームが送信されていれば
     $dfilename = "mission_3-5.txt";//コメントの保存されているテキストファイルを
     $password2 = $_POST["password2"];
     $delcoms = file ($dfilename,FILE_IGNORE_NEW_LINES);//配列形式で$delcomsに代入
     foreach ($delcoms as $delcom){//配列形式のコメントを一行ずつ$delcomに代入
      $del = explode ("<>", $delcom);//フォーマットを<>で分割、$delという変数に配列形式で代入
      if ($del[4] == $password2){//もしパスワード2が、投稿した時のパスワード（パスワード1）と一致するならば
     $fpw = fopen ($dfilename, "w");//テキストファイルを一度上書きすることで中身をなくしている。元々入っている内容は$delcomsに代入してあるので上書きしても大丈夫
     fclose ($fpw);//いったん閉じる
     foreach ($delcoms as $delcom){//配列形式のコメントを一行ずつ$delcomに代入
      $del = explode ("<>", $delcom);//フォーマットを<>で分割、$delという変数に配列形式で代入
      $delnum = $_POST["delete"];//削除したい投稿番号をフォームから取得して$delnumに代入
      if ($del[0] != $delnum){//$del[0]、分割したときに一番最初に出てくる要素である投稿番号が、$delnumと一致しなければ
       $ndel = implode ("<>", $del);//$delを<>で結合
       $fpa = fopen ($dfilename, "a");//さっき空にしたテキストファイルを追記モードで開いて
       fwrite ($fpa, $ndel . PHP_EOL);//削除しないコメントを書き込んでいく
       fclose ($fpa);//書き込んだら閉じる
      }//これで削除番号と一致していない投稿だけを書き込みなおすことができた
     }
    }    
   }
    }
    
//以下はコメントを編集するコード

    elseif(!empty($_POST)&&!empty($_POST["password3"])&&$_POST["edit"]!==""){//編集フォーム、パスワードが空でなくフォームが送信されていれば
     $editfilename = "mission_3-5.txt";//コメントの保存されているテキストファイル
       $password3 = $_POST["password3"];//パスワード3（編集機能のフォームに設置
       $edicoms = file ($editfilename,  FILE_IGNORE_NEW_LINES);//配列形式で$edicomsに代入
       foreach ($edicoms as $edicom){//配列形式のコメントを一行ずつ$edicomに代入
       $edi = explode ("<>", $edicom);//フォーマットを<>で分割、$ediという変数に配列形式で代入
       $edinum = $_POST["edit"];//編集したい投稿番号をフォームから取得して$edinumに代入
        if ($edi[0]== $edinum){//$edi[0]、分割したときに一番最初に出てくる要素である投稿番号が、$edinumと一致するならば
        if ($edi[4] == $password3){//もしパスワード3が、投稿したときのパスワード（パスワード1）と一致しているならば
        $editnumber = $edi[0];
        $editname = $edi[1];
        $editcomment = $edi [2];
        $editpassword = $edi [4];
            //既存の投稿フォームに、上記で取得した「名前」と「コメント」の内容が既に入っている状態で表示させる
        }    //formのvalue属性で対応
        }
        }
     }
    ?>
    
 <form action = "" method = "post">
        <label for="name">名前</label>
        <input type = "text" name = "name"  value="<?php echo $editname ?? ''; ?>"> 
        <label for="comment">コメント</label>
        <input type = "text" name = "comment" value="<?php echo $editcomment ?? ''; ?>">
        <input type="hidden" name="editNo" value="<?php if(isset($editnumber)) {echo $editnumber;} ?>">
        <label for = "password">パスワード</label>
        <input type = "text" name = "password1">
        <input type = "submit" name = "submit"> <br>
        
        <label for="delete">削除</label>
        <input type = "text" name = "delete" placeholder = "削除対象番号">
        <label for = "password2">パスワード</label>  
        <input type = "text" name = "password2"> 
        <input type = "submit"  value = "削除"><br>
        
        <label for="edit">編集</label>
        <input type = "text" name = "edit" placeholder = "編集対象番号">
        <label for = "password3">パスワード</label>
        <input type = "text" name = "password3">
        <input type = "submit" value = "編集">
    </form>
    
<?php
      $filemei = "mission_3-5.txt";
//表示機能
      if (file_exists($filemei)) {//ファイルの存在がある場合だけ行う
          $array = file($filemei);//読み込んだファイルの中身を配列に格納する
          foreach ($array as $word) {//取得したファイルデータをすべて表示する
                $getdata = explode("<>",$word);//explode関数でそれぞれの値を取得
                echo $getdata[0] . " " . $getdata[1] . " " . $getdata[2] . " " . $getdata[3] . "<br>";//取得した値を表示
          }
      }
    ?>

  </body>
</html>