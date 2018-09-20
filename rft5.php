<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7, IE=9" />
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1 " />
<style>
#foot {
position:fixed;
z-index:0;
height:24px;
border-bottom: solid 1px #f2f3f4 ;
   background-color: rgba(254, 254, 254, 1);
   left:0px;
margin:0;
padding:0px 0px;
font-size: 18px;
width:100%;
}
html,body,div,span,applet,object,iframe,h1,h2,
h3,h4,h5,h6,p,blockquote,a,abbr,acronym,address,
big,cite,del,dfn,em,img,ins,kbd,q,s,samp,small,
strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,
dd,ol,ul,li,fieldset,form,label,legend,table,caption,
tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,
embed,figure,figcaption,footer,header,hgroup,input,menu,
nav,output,ruby,section,summary,time,mark,audio,video {
bborder: 0;
margin: 0;

padding: 0px 0px;
vertical-align: baseline;

}
small { 
    font-size: 10px;
}
body {
	margin-left:10px;
	
}
table a,a:visited,a:hover  {text-decoration: none; color: black;}
	table td,th {color:grey;}
</style>
<style>
table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 0px solid #ddd;
}

th, td {
    text-align: left;
    padding: 1px;
}

tr:nth-child(even) {
    background-color: #f2f2f2
}

	/* Define the hover highlight color for the table row */
    .hoverTable tr:hover {
          background-color: #ffff99;
    }
</style>
<?php
//error_reporting(E_ALL);
// Turn off all error reporting
error_reporting(0);
/*
v.131 zip/font/chmod 0777 after mkdir //add upload 1 file
**Not merge with picture viewer yet check in see in www.datayoung.com
V.012.1-tassany -compatible rows -firefox strlen
V.012 Add Edit/Save file
-smooth Edit/Save
-add mode a,b for edit file
V.011 Sort into array
-Link fixed a lot ,need to clean up soon
-sperate upload to another program
V.01 Add sort get for all as can possible
*/


if(isset($_FILES['image'])){		
		$file_name = $_FILES['image']['name'];$fn= $file_name ;				
		$file_size =$_FILES['image']['size'];
		$file_tmp =$_FILES['image']['tmp_name'];
		$file_type=$_FILES['image']['type'];   
		$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));		
		$expensions= array("jpeg","jpg","png"); 				
			echo "<small>";			
			move_uploaded_file($file_tmp,"".$file_name);				
			$ks=number_format($file_size/1024,2)." Kb";
			$ns=number_format($file_size);
			$p=getcwd();
			echo "Moved: $fn:$ks ($ns) : $file_tmp >>> $p : Success";
			echo "</small>";
	}
function bf($dir){
$ar=[];
    $ffs = scandir($dir);	
    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    // prevent empty ordered elements
    if (count($ffs) < 1)
        return;
	//if (count($ffs) > 30)
        //return;
	//echo $ffs;
    foreach($ffs as $ff){
		//$ar[]=$ff;
		//$fd="<li>$ff</li>";
		if(is_dir($dir.'/'.$ff)) {
			
		//if (listFolderFiles($dir.'/'.$ff)) $ar["D"][$ff][]=listFolderFiles($dir.'/'.$ff);	else $ar["D"][$ff]=$ff;	
		$ft="D:$ff";
		if (bf($dir.'/'.$ff)) $ar[$ft]=bf($dir.'/'.$ff);	else $ar[$ft]=$ff;	
		if ($dir) $f=($dir.'/'.$ff); else $f=($ff);
		echo "REEE $f ";
rmdir($f);
		}
		else{
			$ft="F:$ff";
			$ar[$ft]=$ff;
			$f=($dir.'/'.$ff);
			if ($dir) $f=($dir.'/'.$ff); else $f=($ff);
			echo $f;
			unlink($f);
		}
		
		//sort($ar["D"][$ff]);
	}
		ksort ($ar);
			return $ar;
}
function showdir(){
$dir=".";
 $fred = disk_free_space(".");
	$total = disk_total_space(".");
    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
    $base = 1024;
    $class = min((int)log($fred , $base) , count($si_prefix) - 1);
	$class2 = min((int)log($total , $base) , count($si_prefix) - 1);
    $freedisk= sprintf('%1.2f' , $fred / pow($base,$class)) . ' ' . $si_prefix[$class] ;
	$fk= sprintf('1' , $freedisk / pow($base,$class)) . ' ' . $si_prefix[$class] ;
	$totaldisk= sprintf('%1.2f' , $total / pow($base,$class2)) . ' ' . $si_prefix[$class2] ;
	$dk= sprintf('/2f' , $total / pow($base,$class)) . ' ' . $si_prefix[$class] ;

// If the user request a directory above the location of File Thingie we deny it to him.
if (IsSet($_GET["subdir"])) {
	$subdir = $_GET["subdir"];
	if (strstr($subdir, "..")) {
		UnSet($subdir);
	}
}
// We make sure the user can't delete/rename files outside File Thingie.
if (IsSet($_GET["file"])) {
	if (strstr($_GET["file"], "..")) {
		$_GET["file"] = str_replace("..", "", $_GET["file"]);
	}
}
if (IsSet($_POST["do"])) {
	$action = $_POST["do"];
	} else {
	$action = $_GET["do"];
}
if (IsSet($_GET["skey"])) $skey= $_GET["skey"];else $skey="name";
if ($action == "logout") {
	session_unset();
	session_destroy();
	header($location);
	exit;
}

	if (IsSet($subdir)) {
	// If we are in a subdirectory the action value for forms are changed and the link to move one directory up is defined.
		$originaldir = $dir;
		$dir = "{$dir}/{$subdir}";
		if (strstr($subdir, "/")) 
			{
			$uplink = substr($subdir, 0, strrpos($subdir, "/"));
			$uplink = "?do=list&amp;subdir={$uplink}&skey=$ssort";
			} else {
			$uplink = "?do=list&$skey=$skey";
			}
		$uplink = "<b>^</><a href=\"{$self}{$uplink}\">"."Parent Dir <br>"."</a>";
		} else {
			$formaction = $self;
			$uplink = "";	
			$subdirlink = "";
		}
	if ($dirlink = @opendir($dir)) {
		while (($file = readdir($dirlink)) !== false) 	{
			$where="{$dir}/{$file}";
			$Size = filesize($where);
			$currentFileSize=number_format($Size/1024,2)." Kb";
			$fdatetime=date ("d/m/Y H:i",filemtime($where)); //"d/m/Y H:i:s
			$adatetime=filemtime($where);
			if ($Size <=1024) $currentFileSize=number_format($Size)." Bytes";
			if ($Size >=1000000) $currentFileSize=number_format($Size)." Mb";
			if ($file != "." && $file != "..") 	{
			if ($skey=="name") $sortkey=$file;
			if ($skey=="date") $sortkey=$adatetime;
			if ($skey=="size") $sortkey=$Size;		
		if (is_dir("$where")) {
					$subdirs[] = $file;
					$subdirsdatelist[$file] = $fdatetime;
			$adir[$dircount]=array($sortkey,urlencode ($file),$fdatetime,$Size,$adatetime,$file);	
					$dircount++;
					} else {		
			$afile[$filecount]=array($sortkey,rawurlencode ($file),$fdatetime,$currentFileSize,$adatetime,$file);	
					$datelist[$file] = $fdatetime;
					$sizelist[$file] = $currentFileSize;
					$totalsize = $totalsize + $Size;
					$filecount++;
						}}}
		closedir($dirlink);
	}
	if ($dircount>=1) sort($adir);
	if ($filecount>=1) sort($afile);
$subdirr=urlencode($_GET['subdir']);
if (!($_GET['subdir'])) $llink="";else $llink="&subdir=$subdirr";

if (!($_GET['mode']=="d")) {
echo "<center><div id=foot><a name=Top></a><a href=?>[H]</a> <a href=#bottom>Bot</a>|[$subdir] | <a href=basic.html?dir=$dir>UP</a> | <a href=?mode=a$llink>Ed</a> | <a href=?mode=d&$llink>Mg</a>";
}
echo " |D:$dircount f:$filecount";
echo " </div>";
echo"</center><br><table class=hoverTable >";

echo "<tr><td width=45%><a href=?skey=name$llink>Name</a></td><td width=35%><a href=?skey=date$llink>Last modified</a></td><td width=20%><div align=center><a href=?skey=size$llink>Size</a></div></td></tr>";
echo "<tr><td>$uplink</td></tr>";

for ($i=0;$i<count($adir);$i++)
{
if (!IsSet($subdir))
	{
	$mode=$_GET['mode'];
	$dl="\"?skey=$skey&mode=$mode&subdir=".$adir[$i][1];
	if ($mode=="a") $fll="?mode=b&file=".$fl;
	if ($mode=="c") {$fll="?mode=d&file=".$fl;}
	if (!$_GET['mode']) $dl=$dl;
	echo "<tr><td><a href=".$dl."\">".$adir[$i][5]."</a>/</td><td><small>".$adir[$i][2]."</small></td></tr>";
	}
	else 
	{
	$mode=$_GET['mode'];
	$dl="\"?skey=$skey&mode=$mode&subdir=$subdir/".$adir[$i][1];
	if ($_GET['mode']=="a") $fll="?mode=b&file=".$fl;
	if ($_GET['mode']=="c") {$fll="?mode=d&file=".$fl;}
	if (!$_GET['mode']) $dl=$dl;
	echo "<tr><td><a href=".$dl."\">".$adir[$i][1]."</a>/</td><td><small>".$adir[$i][2]."</small></td></tr>";	
	}
}
//echo "<tr><td colspan=3><hr></td></tr>";
for ($i=0;$i<count($afile);$i++)
{
if (!IsSet($subdir))
	{
	$fl=$afile[$i][1]; //urencode
	$fls=$afile[$i][5]; //human look file name
	if ($_GET['mode']=="a") $fll="?mode=b&file=".$fl;
	if ($_GET['mode']=="c") {$fll="?mode=d&file=".$fl;}
	if ($_GET['mode']=="d") {$fll="?mode=d&file=".$fl;}
	if (!$_GET['mode']) $fll=$fl;
	echo "<tr><td><a href=".$fll.">".$fls."</a></td><td><small>".$afile[$i][2]."</small></td><td><div align=right><small>".$afile[$i][3]."</small></div></td></tr>";
	}
	else 
	{
	$fl=$afile[$i][1];
	$fls=$afile[$i][5];
	$flss="\"$subdir/".$fl."\"";
	if ($_GET['mode']=="a") $flss="?subdir=$subdir&mode=b&file=".$fl;
	if ($_GET['mode']=="c") {$flss="?subdir=$dir&mode=d&file=".$fl;}
		if ($_GET['mode']=="d") {$flss="?subdir=$subdir&mode=d&file=".$fl;}
		//if (!$_GET['mode']) {$flss="?subdir=$subdir&mode=&file=".$fl;}
	if (!$_GET['mode']) $flss=$flss;
	echo "<tr><td><a href=".$flss.">".$fls."</a></td><td><small>".$afile[$i][2]."</small></td><td><div align=right><small>".$afile[$i][3]."</small></div></td></tr>";	
	}
}
echo "</table><hr>";
echo "<center><a name=bottom></a>";
echo "[<a href=#top>Top</a>][<a href=basic.html?dir=$subdir>Up</a>]";
echo "| $modd:$freedisk/$totaldisk";
?>
<form action="" method="POST" enctype="multipart/form-data">
<input type="file" name="image" />
<input type="submit" value="UPLOAD"/>
</form></center>
<?php
}

if ($_GET['mode']=="b")
{
//if ($_GET['subdir']) $editfile = "{$subdir}/{$_GET["file"]}"; else $editfile = $_GET["file"];
$subdir=$_GET['subdir'];
if ($subdir) $editfile = "{$subdir}/{$_GET["file"]}"; else $editfile = $_GET["file"];
//echo $subdir.$editfile;
		if (file_exists($editfile)) {
		
			$filecontent = file_get_contents($editfile);
			//$filecontent = htmlspecialchars($filecontent);
			//$filecontent = implode ("", file($editfile));
			//$filecontent = htmlentities($filecontent);
			if ($converttabs == TRUE) {
				$filecontent = str_replace("\t", "    ", $filecontent);
			}
		//	$filecontent = str_replace("\", "\\", $filecontent);
if ($_GET['subdir']!="") $dir = "{$subdir}"; else $dir = ".";
?>
<form action="?" method="post">
	<fieldset>
	<textarea rows="30" style="width:100%" name="filecontent"><?php echo htmlspecialchars($filecontent);?></textarea><br>
	<input type="hidden" name="editfile" value="<?php echo $editfile;?>" />
	<input type="hidden" name="action" value="savefile" />
	<input type="submit" value="save" name="submittype" />
	<input type="reset" name="Reset" value="Reset" />
	<input type="submit" value="cancel" name="submittypecancel" />
	</fieldset>
</form>
<?php
echo "Edit file:".$editfile;
if(!is_writeable($editfile)) echo "[Read only file] ]strlen]";
echo strlen($filecontent);
		} else {
			echo " File $editfile not existing ---error---";
		}

}elseif ($_POST['action']=='savefile')
	{
		// Save a file that has been edited.
		$editfile = stripslashes($_POST["editfile"]);
		if ($_POST["submittype"] != "") {
			//$filecontent = stripslashes($_POST["filecontent"]);
			$filecontent = $_POST["filecontent"];
				if (is_writeable("{$editfile}")) {
					$fp = fopen("{$editfile}", "wb");
				//	$filecontent = htmlspecialchars($filecontent);
			//$filecontent = implode ("", file($editfile));
			//$filecontent = htmlentities($filecontent);
					fputs ($fp, $filecontent);					
					fclose($fp);					
					//showdir();
				} else {
					echo "Error";
				}			
		}
	}
if ($_GET['mode']=="d")
{
	$ctype=$_POST['submittype1'];
	$mmfile=$_POST['mmfile'];
	if ($_POST["submittype"] != "") {
		if ($mmfile!="") {		
		header("Location:?mode=b&subdir=$subdir&file=$mmfile",  true,  301 );  //exit;
		//header("location:?mode=b",  true,  301 );  exit;
		//phpinfo();
		echo "edit $mmfile ++";
		}
	}
	//if ($_POST['Mkdir']=='submittype1') //
	if ($_POST["submittype1"] != "") {
		if ($mmfile!="") {
		echo "Made $mmfile ++";
		mkdir($mmfile);
		chmod($mmfile, 0777);
		}
	}
	if ($_POST["submittype2"] != "") {
		$path=".";
		if ($mmfile!="") {
			echo "made File $mmfile ++";
			touch($mmfile);
		}
	//open($path.$file, 'w');
	}
	if ($_POST["submittype3"] != "") {
		
		if ($mmfile!="") {
			echo "rm File $mmfile ++";
			unlink($mmfile);
		}
	//open($path.$file, 'w');
	}
	if ($_POST["submittype4"] != "") {
		
		if ($mmfile!="") {
			
			$s=bf($mmfile);
			var_dump ($s);
			echo "rm D $mmfile ++";
			rmdir($mmfile);
			echo "rm enD $mmfile ++";
			//showdir();
		}
	//open($path.$file, 'w');
	}
	if ($_POST["submittype5"] != "") {
		
		if ($mmfile!="") {
			
			$s=bf($mmfile);
				$zip = new ZipArchive();
				$zip->open($mmfile.'.zip', ZipArchive::CREATE);
			echo "ZIP  $mmfile ++";
			$zip->addFile($mmfile);
			$zip->close();
			echo "Ziped  $mmfile ++";
			//showdir();
		}
	//open($path.$file, 'w');
	}
	if ($_POST["submittype6"] != "") {
		
		
					$zip = new ZipArchive();
					$zip->open('rft5.zip', ZipArchive::CREATE);
					//$zip->addFile('zip.php');
					$zip->addFile('rft5.php');
					//$zip->addFile('some-file.pdf', 'subdir/filename.pdf');
					//$zip->addFile('another-file.xlxs', 'filename.xlxs');
					$zip->close();
				//	window.location.replace("rft5.php?");
		}
			if ($_POST["aboutbut"] != "") {
		?><script>d = new Date();alert("hello <@srv><? echo date("Y-m-d H:i:s");?><;your@>"+d);</script><?
		}

$dir=$_GET['subdir'];
$file=$_GET['file'];
if ($dir && !$file) $dir=$dir; 
if ($dir && $file) $dir=$dir."/".$file; 
if (!$dir && $file) $dir=$file; 
//else $dir=$file;
?>

<form action="?mode=d" method="post">
	<fieldset><a href=?>Home</a>
	<input type="text" name="mmfile" value="<?php echo $dir;?>" />
	<input type="hidden" name="action" value="mfile" />
	<input type="submit" value="about" name="aboutbut" />
	<input type="submit" value="mkdir" name="submittype1" />
	<input type="submit" value="mkf" name="submittype2" />
	<input type="submit" value="rmf" name="submittype3" />
	<input type="submit" value="rmd" name="submittype4" />
	<input type="submit" value="zipit" name="submittype5" />
	<input type="submit" value="zipme" name="submittype6" />
	<input type="submit" value="cancel" name="submittypecancel" />
	</fieldset>
</form><?php
//echo "EDIT $dir on file $file";
}
//else
//{
//if ($mode!="b") showdir();
if (($_GET['mode']!="b") || ($_GET['mode']=="d") ) showdir();
// }
?>