<!DOCTYPE html>
<meta charset="utf-8">
<link rel="stylesheet" href="css/index.css" type="text/css">
<title>BBS-Sample</title>
<!-- bbs top page -->
<?php
	ini_set("display_errors",1);
	define('FILE_PATH',"/app/logs/messages.txt");
	if(!empty($_POST)){
		
		$user_name = htmlspecialchars($_POST["user_name"]);
		$message = htmlspecialchars($_POST["message"]);
		$submit_date =  date("y/n/d H:i:s");
		
		//ログファイルに書き込み
		file_put_contents(FILE_PATH,"START_MSG\n",FILE_APPEND);//メッセージの開始
		file_put_contents(FILE_PATH,"userName:".$user_name."\n",FILE_APPEND);
		file_put_contents(FILE_PATH,"message:".$message."\n",FILE_APPEND);
		file_put_contents(FILE_PATH,"submit_date:".$submit_date."\n",FILE_APPEND);
		file_put_contents(FILE_PATH,"END_MSG\n",FILE_APPEND);//メッセージの終了
	}
	
	
?>


<?php
	$logs = fopen(FILE_PATH,"r");
	if($logs){
		while($line = fgets($logs)){
			
			
			if($line == "START_MSG"){
					echo "<div>";
				}
			//userName行の場合
			if(strpos($line,"userName:") === 0){
					echo "<p class = \"username_view\">".substr($line,9,strlen($line) - 9)."</p>";//先頭9文字（userName:）を削除して表示
				}
			
			//message行の場合
			if(strpos($line,"message:") === 0){
					echo "<p class = \"message_view\">".substr($line,8,strlen($line) - 8)."</p>";//先頭8文字（message:）を削除して表示
				}
				
			//submit_date行の場合
			if(strpos($line,"submit_date:") === 0){
					echo "<p class = \"date_view\">".substr($line,12,strlen($line) - 12)."</p>";//先頭11文字（submite_date:）を削除して表示
				}
				
			if($line == "END_MSG"){
					echo "</div>";
				}
		}
	}
	fclose($logs);
?>


<!--
<div>
	<p class="username_view">名無しさん＠デフォルトメッセージ</p>
	<p class="message_view">メッセージの表示テスト</p>
	<p class="date_view"><?php echo  date("y/n/d H:i:s");?></p>
</div>
-->
<form action="index.php" method="post">
	<p>名前:<br><input type="text" value="名無しさん@テスト中" name="user_name"></p>
	<p><br><textarea required name="message"></textarea></p>
	<input type="submit" value="送信">
</form>
