

<table style="border: 1px solid #000000;width: 600" align="center">
	<tr>
		<td style="font-family: 'Times New Roman', Times, serif;font-size: 17pt;text-align: center;width: 174px; color: #2214B9;border-style: solid;border-width: 1px;">
		<strong>List</strong></td>
		<td style="font-family: 'Times New Roman', Times, serif;font-size: 17pt;text-align: center;color: #2214B9;border-style: solid;border-width: 1px;">
			<strong>Edit</strong></td>
	</tr>
	<tr>
		<td style="width: 174px; border-style: solid;border-width: 1px;text-align: left; height: 39px; font-size: 14pt;">
<?php
$self=$_SERVER['PHP_SELF'];
if (isset($_POST['save'])) {
  $file = stripslashes($_POST['save']);
  $handle = fopen($_GET['open'],'w');
  fwrite($handle, $file)or die ('Saving was unsuccessful');
  $op=$_GET['open'];
  echo "Successfully wrote to $op<br>";
}

if (isset($_GET['dir'])&&$_GET['dir']!="") {
	$i=strpos($_GET['dir'],'/');
	$up=substr($_GET['dir'],0,$i);
	echo "<a href=$self?dir=$up>[DIR]<i>->UP<-</i></a><br>";
	list_files("./$_GET[dir]");
}else {
	echo "<a href=$self?dir=..>[DIR]<i>->UP<-</i></a><br>";
	list_files("./");
}

?>
	</td>
	<td style="border-style: solid;border-width: 1px; height: 39px;padding-left: 8px"><?php 
if (isset($_GET['open'])){
  echo "<h3>".$_GET['open']."</h3>";
  echo "<br>";
  if (isset($_GET['dir'])) $dir='dir='.$_GET['dir&']; else $dir='';
  echo "<form name='save' method='post' action='$self?".$dir."open=".$_GET['open']."'>";
  echo "<textarea rows=20 cols=50px name='save'>".htmlspecialchars(file_get_contents($_GET['open']))."</textarea>";
  echo "<br><input type='Submit' value='Save'><br>";
}
?>	
</td>
	</tr>
</table>
<div style="text-align: center">
<?php
function list_files($dir){
global $self;
if (!is_dir($dir)) return false;
$handle = opendir($dir)or die('Can not Open the dir');
while($file = readdir($handle))
	if ($file!='.' && $file!= '..'){
		if (isset($_GET['dir'])){ 
			$file=$_GET['dir']."/$file";
			$file2=$_GET['dir']."/$file&dir=".$_GET['dir'];
		}
			$file2=urlencode($file);
			@$h=opendir($file) ;
			if (!$h) 
				echo "<a href=$self?open=$file2>[FILE] $file</a><br>";	
			else
				echo "<a href=$self?dir=$file2>[DIR] $file</a><br>";
	}
}
?>

</div>
